id=0
with open("images.sql", "w") as f:
    for auction_id in range(100):
            f.write(f"INSERT INTO image(id, path, auction_id) VALUES ({id}, 'AuctionImages/default_auction.png', {auction_id});\n")
            id+=1
            f.write(f"INSERT INTO image(id, path, auction_id) VALUES ({id}, 'AuctionImages/default_auction.png', {auction_id});\n")
            id+=1
            f.write(f"INSERT INTO image(id, path, auction_id) VALUES ({id}, 'AuctionImages/default_auction.png', {auction_id});\n")
            id+=1