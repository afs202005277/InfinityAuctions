<div>
  <input type="radio" id="order-relevance" name="order" value="1" @checked($order==1)>
  <label for="order-relevance">most relevant</label>
</div> 
<div>
  <input type="radio" id="baseprice-highest" name="order" value="2" @checked($order==2)>
  <label for="baseprice-highest">base price: highest</label>
</div> 
<div>
  <input type="radio" id="baseprice-Lowest" name="order" value="3" @checked($order==3)>
  <label for="baseprice-Lowest">base price: Lowest</label>
</div>
<div>
  <input type="radio" id="most-trusted" name="order" value="4" @checked($order==4)>
  <label for="most-trusted">most trusted</label>
</div>