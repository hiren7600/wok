@extends('front.layouts.front')

@section('metatag')
<title>Dashboard</title>
@endsection


@section('content')
    <section class="main-section-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="text-content">
                        <h2>Welcome to A World of Kink!</h2>
                        <a href="{{ url('/logout') }}" class="btn-sign-up-btn">
                            Logout
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection


@section('page-scripts')
@endsection
