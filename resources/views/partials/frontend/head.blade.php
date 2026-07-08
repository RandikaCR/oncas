<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('page_title') :: ONCAS CRICKET ACADEMY</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="{{ asset('assets/common/images/favicon.png') }}">
<link rel="apple-touch-icon-precomposed" href="{{ asset('assets/common/images/favicon.png') }}">

<meta property="title" content="ONCAS Cricket Academy Official Website." />
<meta name="description" content="The only place for all the beginners who's looking to empower their Cricket career.">
<meta name="keywords" content="Cricket, Sri Lanka, Sri Lanka Cricket, Cricket Academy, Colombo, Kolonnawa, Rajagiriya, Junior Cricket Academy, Sri Lanka Cricket Academy">
<meta name="author" content="www.oncas.lk">

<meta property="og:title" content="ONCAS Cricket Academy Official Website." />
<meta property="og:description" content="The only place for all the beginners who's looking to empower their Cricket career" />
<meta property="og:image" content="{{ asset('assets/common/images/meta-image.jpg') }}" />
<meta property="og:url" content="www.oncas.lk" />
<meta property="og:type" content="article" />
<meta property="og:site_name" content="ONCAS Cricket Academy Official Website." />

<!-- Font Awesome CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/feather.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/nice-select2.css') }}">
<link href="{{ asset('assets/frontend/css/jarallax.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/frontend/css/venobox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/frontend/css/animate.css') }}" rel="stylesheet">
<!-- Style css -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">

<link href="{{ asset('assets/backend/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

@yield('css')

@yield('style')

