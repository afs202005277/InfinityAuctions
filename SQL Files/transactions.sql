-- TRANSACTION 1
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;

SELECT * FROM auction_category;
  
-- Insert Auction
INSERT INTO auction (id, name, description, base_price, start_date, end_date, buy_now, state, auction_owner_id )
VALUES ($name, $description, $base_price, $start_date, $end_date, $buy_now, $state, $auction_owner_id);

-- Insert Auction Category
INSERT INTO auction_category (category_id, auction_id)
VALUES ($category_id, $auction_id); 


END TRANSACTION;


-- TRANSACTION 2
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;

UPDATE auction SET state = "Ended"
    WHERE id = $auction_id;

-- Add funds to auction owner
UPDATE user SET credits = credits + (SELECT value from bid WHERE id = $bid_id)
    WHERE id = $auction_owner_id;

-- Remove funds from winning bidder
UPDATE user SET credits = credits - (SELECT value from bid WHERE id = $bid_id)
    WHERE user = (SELECT user_id from bid WHERE id = $bid_id);

END TRANSACTION; 

-- TRANSACTION 3
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;

-- Auction Started
UPDATE auction SET state = "Running"
    WHERE id = $auction_id;

-- Find the Users that should be receiving the notification
SELECT id FROM users WHERE $auction_title = ANY(wishlist);

-- Issue the notification
INSERT INTO notification (id, date, type, user_id, auction_id, report_id)
VALUES ($date, $type, $user_id, $auction_id, NULL);

END TRANSACTION;