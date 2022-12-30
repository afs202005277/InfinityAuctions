set search_path to lbaw2271;
ALTER TABLE users
    ADD COLUMN remember_token CHAR(100);

CREATE OR REPLACE FUNCTION to_seconds(t interval)
    RETURNS integer AS
$BODY$
DECLARE
    s  INTEGER;
BEGIN
    SELECT EXTRACT(epoch FROM t) INTO s;
    RETURN s;
END;
$BODY$
    LANGUAGE 'plpgsql';

CREATE INDEX IF NOT EXISTS notification_user_id ON notification USING hash (user_id);

CREATE INDEX IF NOT EXISTS bid_auction_id_amount ON bid USING BTREE (auction_id, amount);

-- CREATE INDEX IF NOT EXISTS wishlist ON wishlist USING GIN (wishlist_tokens);-- SET search_path TO lbaw2271;

-- Trigger01
CREATE OR REPLACE FUNCTION bid_owner() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS(
        SELECT *
        FROM auction
        WHERE NEW.auction_id = id
          AND NEW.user_id = auction_owner_id
        ) THEN
        RAISE EXCEPTION 'A user cannot bid on his own auction.';
    END IF;
    RETURN NEW;
END
$BODY$ LANGUAGE plpgsql;
DROP TRIGGER IF EXISTS bid_owner ON bid;
CREATE TRIGGER bid_owner
    BEFORE
        INSERT
    ON bid
    FOR EACH ROW
EXECUTE PROCEDURE bid_owner();
-- Trigger02
CREATE OR REPLACE FUNCTION bid_admin() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS(
        SELECT *
        FROM users
        WHERE NEW.user_id = id
          AND is_admin = TRUE
        ) THEN
        RAISE EXCEPTION 'An Admin cannot bid.';
    END IF;
    RETURN NEW;
END
$BODY$ LANGUAGE plpgsql;
DROP TRIGGER IF EXISTS bid_admin ON bid;
CREATE TRIGGER bid_admin
    BEFORE
        INSERT
    ON bid
    FOR EACH ROW
EXECUTE PROCEDURE bid_admin();
-- Trigger03
CREATE OR REPLACE FUNCTION bid_date() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS(
        SELECT *
        FROM auction
        WHERE NEW.auction_id = id
          AND (
                    NEW.date > end_date
                OR NEW.date < start_date
            )
        ) THEN
        RAISE EXCEPTION 'Invalid Date.';
    END IF;
    RETURN NEW;
END
$BODY$ LANGUAGE plpgsql;
DROP TRIGGER IF EXISTS bid_date ON bid;
CREATE TRIGGER bid_date
    BEFORE
        INSERT
    ON bid
    FOR EACH ROW
EXECUTE PROCEDURE bid_date();
-- Trigger04 / 05
CREATE OR REPLACE FUNCTION has_max_bid(ruser_id INTEGER) RETURNS VARCHAR LANGUAGE plpgsql AS
$BODY$
BEGIN
    IF EXISTS(
        SELECT *
        FROM auction,
             bid AS current_bid
        WHERE current_bid.auction_id = auction.id
          AND auction.state = 'Running'
          AND NOT EXISTS(
            SELECT bid.amount
            FROM bid
            where bid.amount > current_bid.amount AND bid.auction_id = current_bid.auction_id
            )
          AND current_bid.user_id = ruser_id
        ) THEN RETURN 'You can not delete your account while you have the highest bidding in an active auction.';
    ELSE
        RETURN NULL;
    END IF;
END
$BODY$;
DROP TRIGGER IF EXISTS delete_users ON users;
-- Trigger06
CREATE OR REPLACE FUNCTION check_max_bid() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS(
        SELECT *
        FROM bid
        WHERE bid.auction_id = NEW.auction_id
          AND bid.amount >= NEW.amount
        ) THEN
        RAISE EXCEPTION 'Your bid is lower than the highest bid.';
    END IF;
    IF ((SELECT base_price FROM auction WHERE auction.id = NEW.auction_id ) > NEW.amount)
        THEN RAISE EXCEPTION 'Your bid is lower than the starting price.';
    END IF;
    RETURN NEW;
END
$BODY$ LANGUAGE plpgsql;
DROP TRIGGER IF EXISTS bid_lower_than_max ON bid;
CREATE TRIGGER bid_lower_than_max
    BEFORE
        INSERT
    ON bid
    FOR EACH ROW
EXECUTE PROCEDURE check_max_bid();
-- Trigger07
CREATE OR REPLACE FUNCTION check_bid_user_exists() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS(
        SELECT *
        FROM users
        WHERE users.id = NEW.user_id
          AND email IS NOT NULL
        ) THEN
        RAISE EXCEPTION 'User not found.';
    END IF;
    RETURN NEW;
END
$BODY$ LANGUAGE plpgsql;
DROP TRIGGER IF EXISTS check_bid_user_exists ON bid;
CREATE TRIGGER check_bid_user_exists
    BEFORE
        INSERT
    ON bid
    FOR EACH ROW
EXECUTE PROCEDURE check_bid_user_exists();-- Add new column in auction for tsvectors

ALTER TABLE auction
    ADD COLUMN auction_tokens TSVECTOR;

-- Update tsvectors in auction table
UPDATE auction d1
SET auction_tokens = (setweight(to_tsvector('english', coalesce(d1.name, '')), 'A') ||
                      setweight(to_tsvector('english', coalesce(d1.description, '')), 'B'))
FROM auction d2;

-- Function to automatically update auction_tokens
CREATE OR REPLACE FUNCTION auction_tokens_update() RETURNS TRIGGER AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.auction_tokens = (setweight(to_tsvector('english', coalesce(NEW.name, '')), 'A') ||
                              setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B'));
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.name <> OLD.name OR NEW.description <> OLD.description) THEN
            NEW.auction_tokens = (setweight(to_tsvector('english', coalesce(NEW.name, '')), 'A') ||
                                  setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B'));
        END IF;
    END IF;
    RETURN NEW;
END
$$
    LANGUAGE plpgsql;

-- Create trigger before insert or update on auction
CREATE TRIGGER auction_tokens_update
    BEFORE INSERT OR UPDATE
    ON auction
    FOR EACH ROW
EXECUTE PROCEDURE auction_tokens_update();

-- Create an index on the ts_vectors.
CREATE INDEX idx_auctions ON auction USING GIN (auction_tokens);

CREATE OR REPLACE FUNCTION wishlist_targeted() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO notification(type, user_id, auction_id, report_id)
    SELECT 'Wishlist Targeted' as type, users_id as user_id, NEW.id as auction_id, NULL as report_id FROM
                    (SELECT *, ts_rank(NEW.auction_tokens, query) AS rank
                   FROM wishlist, plainto_tsquery('english',wishlist.name) query
                   WHERE NEW.auction_tokens @@ query
                   ORDER BY rank DESC LIMIT 1) as Tokens, users_wishlist
        WHERE users_wishlist.wishlist_id = Tokens.id;
    RETURN NEW;
END
$BODY$ LANGUAGE plpgsql;
DROP TRIGGER IF EXISTS check_wishlist ON auction;
CREATE TRIGGER check_wishlist
    AFTER
        INSERT
    ON auction
    FOR EACH ROW
EXECUTE PROCEDURE wishlist_targeted();

-- INSERT INTO users_wishlist(users_id, wishlist_id) values (1002, 42);
-- insert into auction(id, name, description, base_price, start_date, end_date, buy_now, state, auction_owner_id) values(101, 'emerald green', 'teste', 50, '2021-09-09', '2022-01-03', NULL, 'Ended', 268);

