@extends('front.layouts.front')

@section('metatag')
    @if(!empty($seosetting))
    <title>{{$seosetting->meta_title}}</title>
    <meta name="title" content="{{$seosetting->meta_title}}">
    <meta name="description" content="{{$seosetting->meta_description}}">
    <meta name="keywords" content="{{$seosetting->meta_keyword}}">
    <meta name="robots" content="{{$seosetting->meta_robot}}">
    @else
    <title>Posting Guidelines</title>
    @endif
@endsection

@section('content')
    <section class="content-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm col-md-9 col-lg-8 col-xxl-7">
                    <div class="content-area">
                        <h3>Posting Guidelines & Site Code of Conduct</h3>
                        <p>Our goal is to create a fun, safe place for people to interact with each other and explore their
                            sexuality. We strive to make this site an open-minded community where members feel comfortable
                            and are not judged by physical appearance, sexual orientation, or disability.</p>
                        <p>While we strive to create an open community for sharing and exploration, we will not let this
                            interfere with the safety of our community, its members, or anyone else. We believe in the power
                            of openness, but just a few bad-intentioned people could put our community in jeopardy, so we
                            must monitor the site for unsafe and illegal behavior. While we encourage members to explore
                            their fantasies and sexuality, we must note that some fantasies and sexual content may be deemed
                            illegal or libelous if they are put into writing. If we find content that alludes to or
                            explicitly states illegal conduct, we will remove your from our community.</p>
                        <p>Please <a href="{{ url('/service') }}">click here</a> to read our TOS</p>
                        <p>In order to ensure the community remains a safe space, we have outlined a set of rules and
                            guidelines that must be followed in order to use our service. Please read the rules and
                            guidelines in full, as you must agree to wholly abide by them before you post on our site.
                            Violating any of the following terms and conditions will result in you being banned from our
                            site:</p>
                        <span>MINORS & CHILDREN</span>
                        <p>We have a zero-tolerance policy for any and all content alluding to or specifically discussing
                            minors and children. This means that fantasies or role-playing scenarios involving minors
                            (including but not limited to daddy-daughter / mother-son fantasies) are strictly not allowed.
                            We will ban you from the site for any reference to minors and we will report serious violations
                            to the appropriate authorities.</p>
                        <p>If you encounter any references to minors, children, or young adults on the site, please report
                            the violation to the site admins immediately by emailing the ad id and sending it to
                            report@kinkyads.org</p>
                        <span>SCAT</span>
                        <p>Unfortunately, we can't allow people to publicly share any pictures or videos where scat play is
                            involved whether it's: visible poop or diarrhea real or fake (simulated) smeared or otherwise
                            coming out of the body or already out If this is your kink we want to make it clear that this is
                            not a judgment on your kink or because it might make some people uncomfortable. This is due to
                            regulations outside of our control. Important: Scat play does not include diaper play, anal
                            play, or enemas.</p>
                        <span>INCEST</span>
                        <p>Alluding to or explicitly mentioning incest is strictly prohibited on the site. This includes
                            roleplaying scenarios and any posting referencing minors.</p>
                        <span>BEASTIALITY AND ANIMAL CRUELTY</span>
                        <p>Content that alludes to or explicitly mentions bestiality, sexual encounters with an animal,
                            and/or animal cruelty is strictly prohibited. We will report serious violations to the
                            appropriate authorities.</p>
                        <span>VIOLENT OR ABUSIVE BEHAVIOR</span>
                        <p>Content that alludes to or explicitly mentions violent, abusive, hurtful offensive, or illegal
                            behavior to yourself or anyone else is strictly not allowed. While we understand that this type
                            of behavior may be a sexual turn-on for some people, our community does not tolerate that
                            behavior and violators will be banned from the site.</p>
                        <span>ILLEGAL DRUGS</span>
                        <p>Sharing, selling, and/or distributing any form of illegal drugs (including poppers) through our
                            site is strictly prohibited.</p>
                        <span>SOLICITING, ADVERTISING, AND TRANSACTING OF SEXUAL SERVICES</span>
                        <p>Advertising such as onlyfriends.com, soliciting, and transacting sexual services of any kind
                            (including but not limited to prostitution and escorting) are strictly prohibited on our site.
                            Please note that this includes directly asking for money, but it also includes alluding to a
                            transaction, using code words, attempting to sell services outside of the site, and attempting
                            to manipulate the site. Our community is a place for sexual exploration not a place for sex
                            work, escorting, or work of any kind.</p>
                        <span>PERSONAL CONTACT INFORMATION</span>
                        <p>Posting personal contact information such as addresses, exact locations, and or phone numbers is
                            strictly prohibited. This is for the protection of all members of our community.</p>
                        <p>Members are allowed to post things such as Kik, skype, messenger, etc info for communication in
                            their ads. </p>
                        <span>NON-LOCAL POSTINGS</span>
                        <p>Our site is meant to feature local postings. If you post in an area outside of your local area,
                            your post maybe rejected. Additionally, if you post in multiple cities at once we may ban you
                            from the site.</p>
                        <p>Thank you for reading our rules and regulations. We are excited to welcome you to Kinkyads. While
                            we do our best to protect all members of our online community, please remember that you are
                            interacting with strangers so you should be cautious at all times.</p>
                        <p>Additionally, please do not share any personal or financial data to protect yourself from being
                            scammed.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('page-scripts')
@endsection
