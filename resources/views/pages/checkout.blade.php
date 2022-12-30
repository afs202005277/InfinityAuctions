@extends('layouts.app')

@section('title', 'About Page')

@section('content')
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/2d1c7583b1.js"></script>

    <section class="container">
        <section class="content">
            <article id="checkoutNav" class="shadow">
                <ul>
                    <li>
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                        <p><strong> Shipping </strong></p>
                    </li>
                    <li>
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <p>Success</p>
                    </li>
                </ul>
            </article>
            <article id="product" class="shadow"><img src="{{asset($auction->images[0]->path)}}"
                                                      alt="Auction image"></article>
            <article id="checkoutCard" class="shadow">
                <div id="details">
                    <dl>
                        <dt>Product</dt>
                        <dd><img id="thumbnail"
                                 src="{{asset($auction->images[0]->path)}}"
                                 alt="Auction image"></dd>
                        <dt>Name</dt>
                        <dd><h5> {{$auction->name}} </h5></dd>
                        <dt>Price</dt>
                        <dd>{{$auction->getWinnerPrice()}}€</dd>
                    </dl>
                </div>
                <form method="get" action="/auctions/checkout/{{$auction->id}}/success">
                    <div id="contactInfo">
                        <label for="first_name">First</label>
                        <label for="last_name">Last</label>
                        <input placeholder="First name" id="first_name" type="text" value="{{$firstName}}" required>
                        <input placeholder="Last name" id="last_name" type="text" value="{{$lastName}}" required>
                    </div>
                    <div id="adressInfo">
                        <label for="address">Address</label>
                        <input id="address" type="text" value="{{$address}}" required>
                    </div>
                    <div id="securityInfo">
                        <label for="city">City</label>
                        <label for="state">State</label>
                        <label for="zip">Zip</label>
                        <input id="city" type="text" placeholder="City" required>
                        <input id="state" type="text" placeholder="State" required>
                        <input id="zip" type="text" placeholder="XXXX-XXX" required>
                    </div>

                    <input type="submit" value="Check out" id="btnSubmit">
                </form>
            </article>
        </section>
    </section>
@endsection
