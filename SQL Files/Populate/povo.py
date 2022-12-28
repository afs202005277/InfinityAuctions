import random
import pandas as pd
import string
import bcrypt
from datetime import date
from random import randrange
from datetime import timedelta
from datetime import datetime
import math

def random_date(start, end):
    """
    This function will return a random datetime between two datetime 
    objects.
    """
    delta = end - start
    int_delta = (delta.days * 24)
    random_day = randrange(int_delta)
    return (start + timedelta(hours=random_day)).strftime('%Y-%m-%d')

first_names = pd.read_csv("firstnames.csv")
last_names = pd.read_csv("lastnames.csv")
last_names = last_names['name'].map(lambda x: str(x).capitalize())
streets = pd.read_csv('streetnames.csv')
collections = ["vinyl", "records", "antique", "furniture", "antique furniture", "vinyl records", "comics", "comic", "comic book", "coin", "coins", "currency", "car", "cars", "classic", "classic cars", "cards", "trading cards", "pokemon", "baseball cards", "dolls", "toys", "doll", "toy", "stamps", "wine", "dom perignon", "art", "mozart", "jewelery", "collectible", "cheese", "watch", "watches", "rolex", "pens", "louis vitton", "sneakers", "nb550", "diamond", "diamonds", "emerald"]
auctions = pd.read_csv("auctions.csv")
auctions = auctions.sample(frac=1).reset_index(drop=True)
type_ban = ['3 day ban', '5 day ban', '10 day ban', '1 month ban']
notification_type = ['Outbid', 'New Auction', 'Report', 'Wishlist Targeted', 'Auction Ending', 'New Bid', 'Auction Ended', 'Auction Won', 'Auction Canceled']
categories = ["Panini", "Banknotes", "Fine Art", "Oil", "Wine", "Comic Books", "Fashion", "Watches", "Coins", "Stamps"]
report_option = ["Counterfeit", "Duplicate listings", "Fradulent", "Innapropriate Description", "Stolen property", "Adult material", "Wildlife", "Drugs, Alcohol or Tobacco", "Offensive and violent materials"]

user_id = 1
auction_id = 1
bid_id = 1
report_id = 1
category_id = 1
report_option_id = 1
notification_id = 1

cellphones_used = []
mails_used = []

def date_add(sd, sm, sy, am):
    ed = (int(sd) + int(am)) % 28 if (int(sd) + int(am)) % 28 != 0 else 1
    em = (int(sm) + int((int(sd) + int(am))/28)) % 12 if (int(sm) + int((int(sd) + int(am))/28)) % 12 != 0 else 1
    ey = (int(sy) + int((int(sm) + int((int(sd) + int(am))/28))/12))
    return str(ed), str(em), str(ey)

class User:
    def __init__(self, user_id):

        self.id = user_id

        fn_rand = random.randint(0, len(first_names)-1)
        first_name = first_names['name'][fn_rand]
        last_name = last_names[random.randint(0, len(last_names)-1)]
        self.name = first_name + " " + last_name

        if (random.random() < 0.008):
            self.gender = 'NB'
        elif (random.random() < 0.002):
            self.gender = 'O'
        else:
            self.gender = 'M' if first_names['sex'][fn_rand] == "boy" else 'F'
        
        cellphone = random.choice(['91', '92', '93', '96']) + f'{random.randint(1, 9999999):05d}'
        while cellphone in cellphones_used:
            cellphone = random.choice(['91', '92', '93', '96']) + f'{random.randint(1, 9999999):05d}'
        self.cellphone = cellphone
        cellphones_used.append(cellphone)

        birth_month = str(random.randint(1, 12))
        birth_day = str(random.randint(1, 28))
        self.birth_date = str(random.randint(1960, 2003)) + "-" + ("0" + birth_month if len(birth_month) == 1 else birth_month) + "-" + ("0" + birth_day if len(birth_day) == 1 else birth_day)
        
        mail = first_name.lower() + ["", ".", random.choice(string.ascii_lowercase)][random.randint(0, 1)] + last_name.lower() + "@" + ["gmail.com", "yahoo.com", "fe.up.pt", "icloud.com"][random.randint(0, 3)]
        while mail in mails_used:
            mail = first_name.lower() + ["", ".", random.choice(string.ascii_lowercase)][random.randint(0, 1)] + last_name.lower() + "@" + ["gmail.com", "yahoo.com", "fe.up.pt", "icloud.com"][random.randint(0, 3)]
        self.mail = mail
        mails_used.append(mail)

        self.password = bcrypt.hashpw((first_name + self.birth_date[0:4]).encode('utf8'), bcrypt.gensalt())
        
        self.address = str(random.randint(1, 750)) + " " + streets['FullStreetName'][random.randint(0, len(streets)-1)].capitalize()
        
        if random.random() < 0.10:
            self.rate = 5
        elif random.random() < 0.30:
            self.rate = 4 + round(random.random(), 1)
        elif random.random() < 0.50:
            self.rate = 3 + round(random.random(), 1)
        elif random.random() < 0.70:
            self.rate = 2 + round(random.random(), 1)
        elif random.random() < 0.90:
            self.rate = 1 + round(random.random(), 1)
        else:
            self.rate = round(random.random(), 1)
        
        self.credits = random.randint(0, 3942)

        self.is_admin = False

class Auction:
    def __init__(self, auction_id):

        self.id = auction_id

        self.name = auctions['DESCRIPTION LINE 1'][auction_id].replace("'", "")

        self.description = auctions['DESCRIPTION LINE 2'][auction_id].replace("'", "")

        self.base_price = (int(auctions['SALE PRICE'][auction_id]*random.random()*0.3) % 10) * 10

        self.start_month = str(random.randint(1, 12))
        self.start_day = str(random.randint(1, 28))
        self.start_year = str(random.randint(2021, 2022))
        self.start_date = self.start_year + "-" + ("0" + self.start_month if len(self.start_month) == 1 else self.start_month) + "-" + ("0" + self.start_day if len(self.start_day) == 1 else self.start_day)

        self.time_amount = random.randint(7, 90)
        end_day, end_month, end_year = date_add(self.start_day, self.start_month, self.start_year, self.time_amount)
        self.end_date = end_year + "-" + ("0" + end_month if len(end_month) == 1 else end_month) + "-" + ("0" + end_day if len(end_day) == 1 else end_day)

        self.buy_now = -1

        if (random.random() < 0.2):
            self.buy_now = (int(auctions['SALE PRICE'][auction_id]*(1+random.random())) % 10) * 10 * 100
        
        self.state = "Cancelled"

        if (random.random() < 0.95):
            if (str(date.today()) > self.end_date):
                self.state = "Ended"
            elif (str(date.today()) > self.start_date):
                self.state = "Running"
            else:
                self.state = "To be started"
        
        self.user_id = random.randint(1, user_id-1)

class Bid:
    def __init__(self, bid_id, auction, percent=0.2):

        self.id = bid_id

        day, month, year = date_add(auction.start_day, auction.start_month, auction.start_year, math.floor(auction.time_amount*percent))
        self.date = year + "-" + ("0" + month if len(month) == 1 else month) + "-" + ("0" + day if len(day) == 1 else day)

        self.amount = auctions['SALE PRICE'][auction.id]*percent

        self.user_id = random.randint(1, user_id-1)

        self.auction_id = auction.id

class Report:
    def __init__(self, report_id, auction):
        self.id = report_id

        self.reported_user = -1
        self.reported_auction = -1

        if (random.random() < 0.5):
            d1 = datetime.strptime('2021-01-01', '%Y-%m-%d')
            d2 = datetime.strptime('2022-12-03', '%Y-%m-%d')

            self.date = random_date(d1, d2)

            self.reported_user = random.randint(1, user_id-1)

            self.reporter = random.randint(1, user_id-1)
            while self.reported_user == self.reporter:
                self.reporter = random.randint(1, user_id-1)
        
        else:
            d1 = datetime.strptime('2021-01-01', '%Y-%m-%d')
            d2 = datetime.strptime(auction.end_date, '%Y-%m-%d')

            self.date = random_date(d1, d2)

            self.reported_auction = auction.id

            self.reported_user = auction.user_id

            self.reporter = random.randint(1, user_id-1)
        
        self.type_ban = random.choice(type_ban)


class Notification:
    def __init__(self, notification_id):
        self.id = notification_id

        d1 = datetime.strptime('2021-01-01', '%Y-%m-%d')
        d2 = datetime.strptime('2022-12-03', '%Y-%m-%d')

        self.date = random_date(d1, d2)

        self.notification_type = random.choice(notification_type)

        self.user_id = random.randint(1, user_id-1)

        self.report_id = -1
        self.auction_id = -1

        if self.notification_type == "Report":
            self.report_id = random.randint(1, report_id-1)
        else:
            self.auction_id = random.randint(1, auction_id-1)

class Category:
    def __init__(self, category_id, name):
        self.id = category_id

        self.name = name

class AuctionCategory:
    def __init__(self, auction_id):
        self.auction_id = auction_id

        self.category = random.randint(1, category_id-1)

class Following:
    def __init__(self, user_id):
        self.user_id = user_id

        self.auction_id = random.randint(1, auction_id-1)

class ReportOption:
    def __init__(self, report_option_id, name):
        self.id = report_option_id

        self.name = name

class ReportReasons:
    def __init__(self, report_id):
        self.report_id = report_id

        self.report_option_id = random.randint(1, report_option_id-1)



am_users = 1000
am_auctions = 100
am_bids = 50
am_reports = 30
am_notifications = 300000
am_followings = 2000
maxWishlistItems = 2

def print_list(l):
    res = "["
    for i in l:
        res += "'" + str(i) + "'"
        res += ", "
    if len(res) != 1:
        res = res[:-2]
    res += "]"
    return res

with open("instructions.txt", "w") as instr:
    instr.write("INSERT INTO image(path, auction_id) VALUES ('UserImages/default_user.png', NULL);\n")
    for i in range(am_users):
        u = User(user_id)
        user_id += 1

        instr.write("insert into users(name, gender, cellphone, email, birth_date, address, password, credits, is_admin) values('" + u.name + "', '" + u.gender + "', '" + u.cellphone + "', '" + u.mail + "', '" + u.birth_date + "', '" + u.address + "', '" + str(u.password)[2:-1] + "', " + str(u.credits) + ", " + ("TRUE" if u.is_admin else "FALSE") + ");\n")

    instr.write("\n")

    max_wishlist_id = 0
    for i in range(len(collections)):
        instr.write(f"insert into wishlist(name) values ('{collections[i]}');\n")
        max_wishlist_id = i+1

    usedPairs_wishlist = []
    for i in range(am_users):
        numItems = random.randint(0, maxWishlistItems)
        for j in range(numItems):
            while True:
                cur_wishlist_id = random.randint(1, max_wishlist_id)
                if ((i+1, cur_wishlist_id) not in usedPairs_wishlist):
                    break
            usedPairs_wishlist += [(i+1, cur_wishlist_id)]
            instr.write(f"insert into users_wishlist(users_id, wishlist_id) values ({i+1}, {cur_wishlist_id});\n")

    instr.write("\n")
    acs = []
    for i in range(am_auctions):
        a = Auction(auction_id)
        acs.append(a)
        auction_id += 1

        instr.write("insert into auction(name, description, base_price, start_date, end_date, buy_now, state, auction_owner_id) values(" + "'" + a.name + "', '" + "".join(["'" + l if l == "'" else l for l in a.description]) + "', " + str(a.base_price) + ", '" + a.start_date + "', '" + a.end_date + "', " + (str(a.buy_now) if a.buy_now != -1 else "NULL") + ", '" + a.state + "', " + str(a.user_id) + ");\n")

    instr.write("\n")

    for a in acs:
        if (a.state != "To be started"):
            perc = 1/am_bids
            for i in range(am_bids):
                b = Bid(bid_id, a, perc)
                if (b.date < "2022-12-03"):
                    bid_id += 1
                    perc += 1/am_bids

                    instr.write("insert into bid(date, amount, user_id, auction_id) values(" + "'" + b.date + "', " + "{:.2f}".format(b.amount) + ", " + str(b.user_id) + ", " + str(b.auction_id) + ");\n")
    
    instr.write("\n")

    for i in range(am_reports):
        r = Report(report_id, random.choice(acs))
        report_id += 1

        instr.write("insert into report(date, penalty, reported_user, reporter, auction_reported, admin_id) values(" + "'" + r.date + "', '" + r.type_ban + "', " + (str(r.reported_user) if r.reported_user != -1 else "NULL") + ", " + str(r.reporter) + ", " + (str(r.reported_auction) if r.reported_auction != -1 else "NULL") + ", NULL);\n")

    instr.write("\n")

    for i in range(am_notifications):
        n = Notification(notification_id)
        notification_id += 1

        instr.write("insert into notification(date, TYPE, user_id, auction_id, report_id) values(" + "'" + n.date + "', '" + n.notification_type + "', " + str(n.user_id) + ", " + (str(n.auction_id) if n.auction_id != -1 else "NULL") + ", " + (str(n.report_id) if n.report_id != -1 else "NULL") + ");\n")

    instr.write("\n")

    for i in categories:
        c = Category(category_id, i)
        category_id += 1

        instr.write("insert into category(name) values(" + "'" + c.name + "');\n")

    instr.write("\n")

    used_categories = []

    for i in range(auction_id-1):
        for _ in range(random.randint(1, 2)):
            ac = AuctionCategory(i+1)

            if ((ac.category, ac.auction_id) not in used_categories):
                instr.write("insert into auction_category(category_id, auction_id) values(" + str(ac.category) + ", " + str(ac.auction_id) + ");\n")
                used_categories += [(ac.category, ac.auction_id)]
    
    instr.write("\n")

    used_pairs = []

    for i in range(am_followings):
        f = Following(random.randint(1, user_id-1))

        if ((f.user_id, f.auction_id) not in used_pairs):
            instr.write("insert into following(user_id, auction_id) values(" + str(f.user_id) + ", " + str(f.auction_id) + ");\n")
            used_pairs += [(f.user_id, f.auction_id)]

    
    instr.write("\n")

    for i in report_option:
        ro = ReportOption(report_option_id, i)
        report_option_id += 1

        instr.write("insert into report_option(name) values(" + "'" + ro.name + "');\n")
    
    instr.write("\n")

    for i in range(report_id-1):
        rr = ReportReasons(i+1)

        instr.write("insert into report_reasons(id_report_option, id_report) values(" + str(rr.report_option_id) + ", " + str(rr.report_id) + ");\n")

    instr.write("\n")
    usedValues = []
    for numRates in range(10000):
        seller_id = random.randint(1, am_users)
        bidder_id = random.randint(1, am_users)
        while (seller_id == bidder_id or ((seller_id, bidder_id) in usedValues)):
            seller_id = random.randint(1,am_users)
            bidder_id = random.randint(1, am_users)
        usedValues += [(seller_id, bidder_id)]
        instr.write(f"INSERT INTO rates(id_bidder, id_seller, rate) VALUES ({bidder_id}, {seller_id}, {random.randint(10, 50)/10});\n")
    
    instr.write("\n")
    for auction_id in range(100):
            instr.write(f"INSERT INTO image(path, auction_id) VALUES ('AuctionImages/default_auction.png', {auction_id});\n")
            instr.write(f"INSERT INTO image(path, auction_id) VALUES ('AuctionImages/default_auction.png', {auction_id});\n")
            instr.write(f"INSERT INTO image(path, auction_id) VALUES ('AuctionImages/default_auction.png', {auction_id});\n")
    
    

