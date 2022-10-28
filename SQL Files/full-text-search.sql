-- Add new column in auction for tsvectors
ALTER TABLE auction
ADD COLUMN auction_tokens TSVECTOR;

-- Update tsvectors in auction table
UPDATE auction d1  
SET auction_tokens = (setweight(to_tsvector('english', coalesce(d1.name, '')), 'A') || setweight(to_tsvector('english', coalesce(d1.description, '')), 'B'))
FROM auction d2;

-- Function to automatically update auction_tokens
CREATE FUNCTION auction_tokens_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.auction_tokens = (setweight(to_tsvector('english', coalesce(NEW.name, '')), 'A') || setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B'));
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.name <> OLD.title OR NEW.description <> OLD.description) THEN
            NEW.auction_tokens = (setweight(to_tsvector('english', coalesce(NEW.name, '')), 'A') || setweight(to_tsvector('english', coalesce(NEW.description, '')), 'B'));
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create trigger before insert or update on auction
CREATE TRIGGER auction_tokens_update
    BEFORE INSERT OR UPDATE ON auction
    FOR EACH ROW
    EXECUTE PROCEDURE auction_tokens_update();

-- Create an index on the ts_vectors.
CREATE INDEX idx_auctions ON auction USING GIN(auction_tokens);

-- Query
SELECT name, description, ts_rank(auction_tokens, query) AS rank
FROM auction, plainto_tsquery('english','ford') query
WHERE auction_tokens @@ query
ORDER BY rank DESC