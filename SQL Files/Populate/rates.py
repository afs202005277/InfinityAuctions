import random

usedValues = []
with open("rates.sql",'w',encoding = 'utf-8') as f:
    for numRates in range(10000):
        seller_id = random.randint(1, 1000)
        bidder_id = random.randint(1, 1000)
        while (seller_id == bidder_id or ((seller_id, bidder_id) in usedValues)):
            seller_id = random.randint(1,1000)
            bidder_id = random.randint(1, 1000)
        usedValues += [(seller_id, bidder_id)]
        f.write(f"INSERT INTO rates(id_bidder, id_seller, rate) VALUES ({bidder_id}, {seller_id}, {random.randint(10, 50)/10});\n")
    f.close()    
