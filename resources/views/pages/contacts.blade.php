@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

    <section id="contactarea">
        <h3>Let's Connect</h3>
        <section id="contact">
            <div class="rightside">
                <p>Send us a message with any doubts/feedbacks and we will get right back to you.</p>
                <a href="https://www.instagram.com">
                    <figure>
                        <img src="{{ asset('img/instagram.svg') }}" alt="instagram icon">
                        <figcaption>Instagram</figcaption>
                    </figure>
                </a>
                <a href="https://www.facebook.com">
                    <figure>
                        <img src="{{ asset('img/facebook.svg') }}" alt="facebook icon">
                        <figcaption>Facebook</figcaption>
                    </figure>
                </a>
                <a href="https://www.twitter.com">
                    <figure>
                        <img src="{{ asset('img/twitter.svg') }}" alt="twitter icon">
                        <figcaption>Twitter</figcaption>
                    </figure>
                </a>
            </div>
            <form action="/" method="POST">
                <label for="name" hidden>Name</label>
                <input id="name" name="Name" type="text" placeholder="Name"><br>
                <label for="email" hidden>Email</label>
                <input id="email" name="Email" type="email" placeholder="Email"><br>
                <label for="message" hidden> Message</label>
                <textarea id="message" name="Message" placeholder="Message" class="message" rows="5"></textarea>
                <br>
                <button type="submit" disabled>
                    Send Message
                    <img src="{{ asset('img/send-icon.svg') }}" alt="send icon">
                </button>
            </form>
        </section>
    </section>
@endsection
