CREATE TYPE notification_type AS ENUM ('Outbid', 'New Auction', 'Report', 'Wishlist Targeted', 'Auction Ending', 'New Bid', 'Auction Ended', 'Auction Won', 'Auction Canceled');
CREATE TYPE state AS ENUM ('Cancelled', 'Running', 'To be started', 'Ended');
CREATE TYPE penalty AS ENUM ('3 day ban', '5 day ban', '10 day ban', '1 month ban', 'Banned for life');

CREATE TABLE IF NOT EXISTS general_user (
	id SERIAL PRIMARY KEY,
	name varchar(30) NOT NULL,
	cellphone char(9) UNIQUE,
	email varchar(320) UNIQUE,
	address varchar(255) UNIQUE,
	password VARCHAR NOT NULL,
	rate REAL,
	credits REAL,
	wishlist TEXT [],
	is_admin BOOLEAN NOT NULL,
	CONSTRAINT valid_rate CHECK (rate >= 0 AND rate <= 5)
);

CREATE TABLE IF NOT EXISTS auction (
	id SERIAL PRIMARY KEY,
	name TEXT NOT NULL,
	description TEXT NOT NULL,
	base_price REAL NOT NULL,
	start_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
	end_date TIMESTAMP WITH TIME ZONE NOT NULL,
	buy_now REAL,
	TYPE state NOT NULL,
	auction_owner_id INTEGER REFERENCES general_user NOT NULL,
	CONSTRAINT valid_dates CHECK (start_date < end_date)
);

CREATE TABLE IF NOT EXISTS bid (
	id SERIAL PRIMARY KEY,
	date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
 	amount REAL NOT NULL,
	user_id INTEGER REFERENCES general_user NOT NULL,
	auction_id INTEGER REFERENCES auction NOT NULL
);

CREATE TABLE IF NOT EXISTS report (
	id SERIAL PRIMARY KEY,
	date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
	TYPE penalty,
	reported_user INTEGER REFERENCES general_user,
	reporter INTEGER REFERENCES general_user NOT NULL,
	auction_reported INTEGER REFERENCES auction,
	admin_id INTEGER REFERENCES general_user,
	CONSTRAINT no_self_reports CHECK (reported_user != reporter)
);

CREATE TABLE IF NOT EXISTS notification (
	id SERIAL PRIMARY KEY,
	date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
	TYPE notification_type NOT NULL,
	user_id INTEGER REFERENCES general_user NOT NULL,
	auction_id INTEGER REFERENCES auction,
	report_id INTEGER REFERENCES report
);

CREATE TABLE IF NOT EXISTS category(
	id SERIAL PRIMARY KEY,
	name TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS auction_category(
	category_id INTEGER REFERENCES category,
	auction_id INTEGER REFERENCES auction,
	PRIMARY KEY (category_id, auction_id)
);

CREATE TABLE IF NOT EXISTS following (
	user_id INTEGER REFERENCES general_user,
	auction_id INTEGER REFERENCES auction,
	PRIMARY KEY (user_id, auction_id)
);

CREATE TABLE IF NOT EXISTS report_option (
	id SERIAL PRIMARY KEY,
	name TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS report_reasons (
	id_report_option INTEGER REFERENCES report_option,
	id_report INTEGER REFERENCES report,
	PRIMARY KEY (id_report_option, id_report)
);