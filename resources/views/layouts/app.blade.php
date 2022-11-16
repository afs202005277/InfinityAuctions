<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://use.typekit.net/ivx1jos.css">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auction.css') }}" rel="stylesheet">
    <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/faq.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
    <link href="{{ asset('css/search_users.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auction_card.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/faq.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/user_profile.js') }} defer></script>
  </head>
  <body>
    <main>
        <header>
            <a class="logo" href="{{ url('/') }}"><img src={{ asset('img/infinityauctions_logo.png') }} alt="InfinityAuctions logo"></a>
            <div class="categories">
                <div class="cat-button">
                  Categories<img src={{ asset('img/downarrow.svg')}}>
                </div>
                @include('partials.categories', ['categories' => $categories])
            </div>
            <input class="search" type="text" placeholder="Search..">
            <a class="faq" href="{{ url('/faq') }}">FAQ</a>
            <a class="faq" href="{{ url('/users') }}">Users</a>
            @if (Auth::check())
                <a class="sell" href="{{ url('/sell') }}">Sell</a>
                <img class= "notifications" src={{ asset('img/notificationbell.svg') }} alt="Notifications">
                <a class="user" href="{{ url('/users/' . Auth::user()->id) }}"><img src={{ asset('img/usericon.svg') }} alt="User"></a>
            @else
                <a class="log-in" href="{{ url('/login') }}">Log In</a>
                <a class="sign-up" href="{{ url('/register') }}">Sign Up</a>
            @endif
        </header>

      <section id="content">
        @yield('content')
      </section>
      <footer>
        <section class="left">
          <ul class="links">
            <h3>Links</h3>
            <li><a href="{{ url('/about-us') }}">About Us</a></li>
            <li><a href="{{ url('/faq') }}">FAQ</a></li>
            <li><a href="{{ url('/services') }}">Services</a></li>
            <li><a href="{{ url('/contact-us') }}">Contacts</a></li>
          </ul>
          <section class="socials">
            <h3>Our Socials</h3>
            <ul class="link">
              <li><a href="https://instagram.com"><img src={{ asset("img/instagram.svg") }}></a></li>
              <li><a href="https://facebook.com"><img src={{ asset("img/facebook.svg") }}></a></li>
              <li><a href="https://twitter.com"><img src={{ asset("img/twitter.svg") }}></a></li>
            </ul>
          </section>
        </section>
        <section class="right">
          <section class="sponsors">
            <h3>Our Sponsors</h3>
            <div class="images">
              <img src={{ asset('img/auction_tmp.png') }}>
              <img src={{ asset('img/auction_tmp.png') }}>
              <img src={{ asset('img/auction_tmp.png') }}>
              <img src={{ asset('img/auction_tmp.png') }}>
            </div>
          </section>
        </section>
      </footer>
    </main>
    <p class="copyright">InfinityAuctions ©</p>
  </body>
</html>
