@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>2257</title>
    @endif
@endsection


@section('content')
<section class="content-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm col-md-9 col-lg-8 col-xxl-7">
                <div class="content-area">
                    <h3>18 U.S.C. 2257 Record-Keeping Exemption Statement</h3>
                    <p>worldofkink.com is not the "Producer" (as per definitions in 18 U.S.C. 2257(h)(2)(B)(v) and regulations promulgated thereunder) of any depictions of actual or simulated sexually explicit conduct appearing on the World of Kink website as the activities of World of Kink are limited to the distribution, transmission, storage, retrieval and/or hosting of such depictions posted in areas of the website under the control of registered users or members of World of Kink. As such, World of Kink is exempt from the record-keeping requirements of 18 U.S.C. 2257. Its only obligation is to cooperate to immediately withdraw the content once the infraction of the site's rules are identified.</p>
                    <p>World of Kink is a "Provider of an Interactive Computer Service" (as per definitions in 47 U.S.C. 230(c) and regulations promulgated thereunder) and, as such, is not considered the publisher or speaker of any content posted in areas of the website under the control of registered users or members of World of Kink.</p>
                    <p>As regards the “Photos / Videos / Text Ads“ available to members of the World of Kink website, World of Kink is not involved in the production of material included in these additional services, and is involved merely in the distribution of links to this material, World of Kink is exempt from record keeping requirements based on limitations described in 28 C.F.R. 75.1(c)(4)(ii).</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('page-scripts')
@endsection
