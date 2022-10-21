--Trigger01
CREATE FUNCTION bid_owner() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM auction WHERE NEW.auction_id = id AND NEW.user_id = auction_owner_id) THEN
           RAISE EXCEPTION 'A user cannot bid on his own auction.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER bid_owner
        BEFORE INSERT ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE bid_owner();


-- Trigger02
CREATE FUNCTION bid_admin() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM general_user WHERE NEW.user_id = id AND is_admin = TRUE) THEN
           RAISE EXCEPTION 'An Admin cannot bid.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER bid_admin
        BEFORE INSERT ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE bid_admin();

-- Trigger03
CREATE FUNCTION bid_date() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM auction WHERE NEW.auction_id = id AND (NEW.date > end_date OR NEW.date < start_date)) THEN
           RAISE EXCEPTION 'Invalid Date.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER bid_date
        BEFORE INSERT ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE bid_date();
