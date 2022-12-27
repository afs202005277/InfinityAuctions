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
                        <p> 01 </p>
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                        <p> Shipping </p>
                    </li>
                    <li>
                        <p> <strong> 02 </strong> </p>
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <p> <strong> Success </strong></p>
                    </li>
                </ul>
            </article>
            <article id="product" class="shadow"><img src="https://thinsoldier.com/wip/nike-grid/images/lunar2_full.jpg" alt="Lunar 2"></article>
            <article id="checkoutCard" class="shadow">
                <div id="details">
                    <dl class="">
                        <dt>Product</dt>
                        <dd> <img id="thumbnail" src="http://thinsoldier.com/wip/nike-grid/images/nike_luna_thumbnail.png" alt="Lunar 2"></dd>
                        <dt>Name</dt>
                        <dd><h5> {{$auction->name}} </h5></dd>
                        <dt>Price</dt>
                        <dd>{{$auction->getWinnerPrice()}}€</dd>
                    </dl>
                </div>
                <form action="">
                    <br>
                    <br>
                    <p> Your product is now being shipped and should arrive in less than <strong> 15 days </strong>! If you have any problem please contact the seller at <strong> {{$auction->owner()->value("cellphone")}} </strong> or our help center at +351 222 124 4352. </p>
                    <br>
                    <br>
                </form>
            </article>
        </section>
    </section>
@endsection
