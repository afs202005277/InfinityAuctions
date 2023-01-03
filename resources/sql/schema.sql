DROP SCHEMA IF EXISTS lbaw2271 CASCADE;

DROP TABLE IF EXISTS auction_category;
DROP TABLE IF EXISTS bid;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS following;
DROP TABLE IF EXISTS notification;
DROP TABLE IF EXISTS report_reasons;
DROP TABLE IF EXISTS report;
DROP TABLE IF EXISTS report_option;
DROP TABLE IF EXISTS auction;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS users_wishlist;
DROP TABLE IF EXISTS wishlist;

DROP TYPE IF EXISTS notification_type;
DROP TYPE IF EXISTS penalty_type;
DROP TYPE IF EXISTS auction_possible_state;
DROP TYPE IF EXISTS gender_possible;

CREATE SCHEMA lbaw2271;
SET search_path TO lbaw2271;

CREATE TYPE notification_type AS ENUM ('Outbid', 'New Auction', 'Report', 'Wishlist Targeted', 'Auction Ending', 'New Bid', 'Auction Ended', 'Auction Won', 'Auction Canceled');
CREATE TYPE auction_possible_state AS ENUM ('Cancelled', 'Running', 'To be started', 'Ended');
CREATE TYPE penalty_type AS ENUM ('3 day ban', '5 day ban', '10 day ban', '1 month ban');
CREATE TYPE gender_possible AS ENUM ('M', 'F', 'NB', 'O');


CREATE TABLE IF NOT EXISTS image
(
    id   SERIAL PRIMARY KEY,
    path TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS users
(
    id            SERIAL PRIMARY KEY,
    name          VARCHAR(30),
    gender        gender_possible,
    cellphone     CHAR(9) UNIQUE,
    email         VARCHAR(320) UNIQUE,
    birth_date    DATE,
    address       VARCHAR(255) UNIQUE,
    password      VARCHAR NOT NULL,
    credits       REAL,
    is_admin      BOOLEAN NOT NULL,
    profile_image INTEGER REFERENCES image DEFAULT 1,
    CONSTRAINT valid_birth CHECK (birth_date between '1900-01-01' and now() - interval '18 years')
);

CREATE TABLE IF NOT EXISTS wishlist(
    id SERIAL PRIMARY KEY,
    name VARCHAR(30)
);

CREATE TABLE IF NOT EXISTS users_wishlist(
    users_id INTEGER,
    wishlist_id INTEGER,
    PRIMARY KEY (users_id, wishlist_id)
);

CREATE TABLE IF NOT EXISTS rates
(
    id_bidder INTEGER REFERENCES users,
    id_seller INTEGER REFERENCES users,
    PRIMARY KEY (id_bidder, id_seller),
    rate      REAL NOT NULL,
    CONSTRAINT valid_rate CHECK (rate >= 0.0 AND rate <= 5.0)
);


CREATE TABLE IF NOT EXISTS password_resets
(
    email      VARCHAR(320) NOT NULL,
    token      TEXT         NOT NULL,
    created_at timestamp
);

CREATE TABLE IF NOT EXISTS auction
(
    id               SERIAL PRIMARY KEY,
    name             TEXT                                       NOT NULL,
    description      TEXT                                       NOT NULL,
    base_price       REAL                                       NOT NULL,
    start_date       TIMESTAMP WITH TIME ZONE DEFAULT now()     NOT NULL,
    end_date         TIMESTAMP WITH TIME ZONE                   NOT NULL,
    buy_now          REAL,
    checkout BOOLEAN NOT NULL DEFAULT FALSE,
    state            auction_possible_state                     NOT NULL,
    auction_owner_id INTEGER REFERENCES users ON UPDATE CASCADE NOT NULL,
    CONSTRAINT valid_dates CHECK (start_date < end_date)
);

ALTER TABLE image
    ADD COLUMN auction_id INTEGER REFERENCES auction;

CREATE TABLE IF NOT EXISTS bid
(
    id         SERIAL PRIMARY KEY,
    date       TIMESTAMP WITH TIME ZONE DEFAULT now()::timestamp(0)           NOT NULL,
    amount     NUMERIC                                                           NOT NULL,
    user_id    INTEGER REFERENCES users ON UPDATE CASCADE                     NOT NULL,
    auction_id INTEGER REFERENCES auction ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);

CREATE TABLE IF NOT EXISTS report
(
    id               SERIAL PRIMARY KEY,
    date             TIMESTAMP WITH TIME ZONE DEFAULT now()     NOT NULL,
    penalty          penalty_type,
    reported_user    INTEGER REFERENCES users ON UPDATE CASCADE ON DELETE CASCADE,
    reporter         INTEGER REFERENCES users ON UPDATE CASCADE NOT NULL,
    auction_reported INTEGER REFERENCES auction ON UPDATE CASCADE,
    admin_id         INTEGER REFERENCES users ON UPDATE CASCADE,
    CONSTRAINT no_self_reports CHECK (reported_user != reporter)
);

CREATE TABLE IF NOT EXISTS notification
(
    id         SERIAL PRIMARY KEY,
    date       TIMESTAMP WITH TIME ZONE DEFAULT now()                       NOT NULL,
    TYPE       notification_type                                            NOT NULL,
    user_id    INTEGER REFERENCES users ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    auction_id INTEGER REFERENCES auction ON UPDATE CASCADE,
    report_id  INTEGER REFERENCES report ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS category
(
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS auction_category
(
    category_id INTEGER REFERENCES category ON UPDATE CASCADE,
    auction_id  INTEGER REFERENCES auction ON UPDATE CASCADE,
    PRIMARY KEY (category_id, auction_id)
);

CREATE TABLE IF NOT EXISTS following
(
    user_id    INTEGER REFERENCES users ON UPDATE CASCADE,
    auction_id INTEGER REFERENCES auction ON UPDATE CASCADE,
    PRIMARY KEY (user_id, auction_id)
);

CREATE TABLE IF NOT EXISTS report_option
(
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS report_reasons
(
    id_report_option INTEGER REFERENCES report_option ON UPDATE CASCADE,
    id_report        INTEGER REFERENCES report ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (id_report_option, id_report)
);
