<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="base-url" content="{{ url('/') }}" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

@yield('metatag')


<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset_front('/images/favicon.ico') }}" />


<!-- Plugins CSS File -->
<link rel="stylesheet" href="{{ asset_front('/css/combine.min.css?ver=' . mt_rand(1000, 9999)) }}">
<link rel="stylesheet" href="{{ asset_front('/css/style.css?ver=' . mt_rand(10000, 99999)) }}">
<link rel="stylesheet" href="{{ asset_front('/css/all.min.css?ver=' . mt_rand(1000, 9999)) }}">

<!-- Google Tag Manager -->
<script>
(
    function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js? id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-WVSG4TJ'
);
</script>
<!-- End Google Tag Manager —>
