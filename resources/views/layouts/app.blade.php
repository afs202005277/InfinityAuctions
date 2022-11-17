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
    <link href="{{ asset('css/auction.css') }}" rel="stylesheet">
    <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/faq.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/faq.js') }} defer></script>
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

            @if (Auth::check())
                <a class="sell" href="{{ url('/sell') }}">Sell</a>
                <img class= "notifications" src={{ asset('img/notificationbell.svg') }} alt="Notifications">
                <a class="user" href="{{ url('/user/' . Auth::user()->id) }}"><img src={{ asset('img/usericon.svg') }} alt="User"></a>
            @else
                <a class="log-in" href="{{ url('/login') }}">Log In</a>
                <a class="sign-up" href="{{ url('/signup') }}">Sign Up</a>
            @endif
        </header>
      
      <section id="content">
        @yield('content')
    </section>
</main>
</body>
</html>
