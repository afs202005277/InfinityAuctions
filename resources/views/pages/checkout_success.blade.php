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
                        <p> Shipping </p>
                    </li>
                    <li>
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <p><strong> Success </strong></p>
                    </li>
                </ul>
            </article>
            <article id="product" class="shadow"><img src="{{asset($auction->images[0]->path)}}"
                                                      alt="Auction Image"></article>
            <article id="checkoutCard" class="shadow">
                <div id="details">
                    <dl class="">
                        <dt>Product</dt>
                        <dd><img id="thumbnail"
                                 src="{{asset($auction->images[0]->path)}}"
                                 alt="Auction Image"></dd>
                        <dt>Name</dt>
                        <dd><h5> {{$auction->name}} </h5></dd>
                        <dt>Price</dt>
                        <dd>{{$auction->getWinnerPrice()}}€</dd>
                    </dl>
                </div>
                <div>
                    <br>
                    <br>
                    <p> Your product is now being shipped and should arrive in less than <strong> 15 days </strong>! If
                        you have any problem please contact the seller at <strong> {{$cellphone}} </strong> or our help
                        center at +351 222 124 4352. </p>
                    <br>
                    <br>
                </div>
            </article>
        </section>
    </section>
@endsection
