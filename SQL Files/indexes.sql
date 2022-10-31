CREATE INDEX IF NOT EXISTS notification_user_id ON notification USING hash(user_id);

CREATE INDEX IF NOT EXISTS bid_auction_id_amount ON bid USING BTREE(auction_id, amount);

CREATE INDEX IF NOT EXISTS user_wishlist ON general_user USING GIN(wishlist);