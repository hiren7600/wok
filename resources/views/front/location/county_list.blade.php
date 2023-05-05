@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Country List</title>
    @endif
@endsection


@section('content')
<section class="change-citis-page">
    <div class="container-xxl">
        <div class="casualencounters-w-wrap">
            <div class="change-citis-inner-bg">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="citis-list-bg">
                            <div class="country-toggle state-view"><p>{{$united_states->countryname}}
                                <span class="country-user-list">
                                    <a href="{{url('/location/?country=United States')}}">(view all)
                                    </a>
                                </span>
                            </p>
                            </div>

                            <ul class="citis-list-group">
                                @foreach ($united_states->states as  $united_state )
                                    <li><a href="{{url('/selectcity/'.$united_state->statename)}}">{{$united_state->statename}}</a></li>
                                @endforeach


                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="citis-list-bg">
                            <button class="country-toggle">Canada</button>
                            <ul class="citis-list-group">
                                {{-- <li><a href="#">Alabama</a></li>
                                <li><a href="#">Alaska</a></li>
                                <li><a href="#">Arizona</a></li>
                                <li><a href="#">Arkansas</a></li>
                                <li><a href="#">California</a></li>
                                <li><a href="#">Colorado</a></li> --}}
                            </ul>
                        </div>
                        <div class="citis-list-bg">
                            <button class="country-toggle">Europe</button>
                            <ul class="citis-list-group">
                                {{-- <li><a href="#">Alabama</a></li>
                                <li><a href="#">Alaska</a></li>
                                <li><a href="#">Arizona</a></li>
                                <li><a href="#">Arkansas</a></li>
                                <li><a href="#">California</a></li>
                                <li><a href="#">Colorado</a></li>
                                <li><a href="#">Connecticut</a></li>
                                <li><a href="#">DC</a></li>
                                <li><a href="#">Delaware</a></li>
                                <li><a href="#">Georgia</a></li> --}}
                            </ul>
                        </div>
                        <div class="citis-list-bg">
                            <button class="country-toggle">Latin America and Caribbean</button>
                            <ul class="citis-list-group">
                                {{-- <li><a href="#">Alabama</a></li>
                                <li><a href="#">Alaska</a></li>
                                <li><a href="#">Arizona</a></li> --}}
                            </ul>
                        </div>
                        <div class="citis-list-bg">
                            <button class="country-toggle">Australia and Oceania</button>
                            <ul class="citis-list-group">
                                {{-- <li><a href="#">Alabama</a></li>
                                <li><a href="#">Alaska</a></li>
                                <li><a href="#">Arizona</a></li>
                                <li><a href="#">Arkansas</a></li>
                                <li><a href="#">California</a></li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('page-scripts')
<script>
    $('.country-toggle').click((e) => {
        $(e.currentTarget).parent().children('ul').toggleClass('show');
    });
</script>
@endsection
