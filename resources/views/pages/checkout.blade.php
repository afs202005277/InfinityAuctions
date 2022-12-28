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
                        <p><strong> 01 </strong></p>
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                        <p><strong> Shipping </strong></p>
                    </li>
                    <li>
                        <p>02</p>
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <p>Success</p>
                    </li>
                </ul>
            </article>
            <article id="product" class="shadow"><img src="https://thinsoldier.com/wip/nike-grid/images/lunar2_full.jpg"
                                                      alt="Lunar 2"></article>
            <article id="checkoutCard" class="shadow">
                <div id="details">
                    <dl class="">
                        <dt>Product</dt>
                        <dd><img id="thumbnail"
                                 src="http://thinsoldier.com/wip/nike-grid/images/nike_luna_thumbnail.png"
                                 alt="Lunar 2"></dd>
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
                        <input placeholder="First name" id="first_name" type="text" value="{{$firstName}}">
                        <input placeholder="Last name" id="last_name" type="text" value="{{$lastName}}">
                    </div>
                    <div id="adressInfo">
                        <label for="address">Address</label>
                        <input id="address" type="text" value="{{$address}}">
                    </div>
                    <div id="securityInfo">
                        <label for="city">City</label>
                        <label for="state">State</label>
                        <label for="zip">Zip</label>
                        <input id="city" type="text" placeholder="City">
                        <input id="state" type="text" placeholder="State">
                        <input id="zip" type="text" placeholder="XXXX-XXX">
                    </div>

                    <input type="submit" value="Check out" id="btnSubmit">
                </form>
            </article>
        </section>
    </section>
@endsection
