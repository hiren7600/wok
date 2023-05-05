@extends('front.layouts.front')

@section('pagetitle', ' - 404')


@section('content')
    <section class="404-error-page">
        <div class="container">
            <div class="error-inner-box">
                <div class="error-heading">
                    <h2>Oops...</h2>
                    <p>The page you were looking for doesn't exist.</p>
                </div>
                <div class="error-media">
                    <img src="{{ asset_front('/images/404img.gif') }}" alt="error">
                </div>
                <div class="error-content-area">
                    <p>Sorry, the page you're looking for is no longer active.</p>
                    <span>What caused this error?</span>
                    <p>It could be for several, but some of the main ones are:</p>
                    <ul>
                        <li>The page was de-activated or removed;</li>
                        <li>The link was wrong, to begin with, i.e., someone mistyped it.</li>
                    </ul>
                    <span>Where to now?</span>
                    <p>Either click the back button on your browser to go back to where you were or click the link below
                        to
                        go to our home
                        page:</p>
                </div>
                <a href="{{ url('/') }}" class="take-me-home-btn">Take Me Home</a>
            </div>
        </div>
    </section>
@endsection


@section('page-scripts')
@endsection
