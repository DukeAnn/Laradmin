<!DOCTYPE html>
<!--
Theme: JANGO - Ultimate Multipurpose HTML Theme Built With Twitter Bootstrap 3.3.7
Version: 1.4.1
Author: Themehats
Site: http://www.themehats.com
Purchase: http://themeforest.net/item/jango-responsive-multipurpose-html5-template/11987314?ref=themehats
Contact: support@themehats.com
Follow: http://www.twitter.com/themehats
-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>JANGO | Ultimate Multipurpose Bootstrap HTML Theme - Home Page - 6</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href='http://fonts.lug.ustc.edu.cn/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&amp;subset=all' rel='stylesheet' type='text/css'>
    <link href="{{ asset('assets/front/plugins/socicon/socicon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/plugins/bootstrap-social/bootstrap-social.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/plugins/animate/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN: BASE PLUGINS  -->
    <link href="{{ asset('assets/front/plugins/cubeportfolio/css/cubeportfolio.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/plugins/owl-carousel/assets/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/plugins/owl-carousel/assets/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/plugins/owl-carousel/assets/owl.transitions.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/plugins/slider-for-bootstrap/css/slider.css') }}" rel="stylesheet" type="text/css" />
    <!-- END: BASE PLUGINS -->
    <!-- BEGIN: PAGE STYLES -->
    @yield('styles')
    <!-- END: PAGE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{ asset('assets/front/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/css/themes/default.css') }}" rel="stylesheet" id="style_theme" type="text/css" />
    <link href="{{ asset('assets/front/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>

<body class="c-layout-header-fixed c-layout-header-mobile-fixed">
<!-- BEGIN: LAYOUT/HEADERS/HEADER-1 -->
<!-- BEGIN: HEADER -->
@include("layouts.main.header")
<!-- END: HEADER -->
<!-- END: LAYOUT/HEADERS/HEADER-1 -->
@include("layouts.main.auth")
<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    @include('layouts.main.breadcrumbs')
    @yield('content')
</div>
<!-- END: PAGE CONTAINER -->
<!-- BEGIN: LAYOUT/FOOTERS/FOOTER-8 -->
<a name="footer"></a>
@include("layouts.main.footer")
<!-- END: LAYOUT/FOOTERS/FOOTER-8 -->
<!-- BEGIN: LAYOUT/FOOTERS/GO2TOP -->
<div class="c-layout-go2top">
    <i class="icon-arrow-up"></i>
</div>
<!-- END: LAYOUT/FOOTERS/GO2TOP -->
<!-- BEGIN: LAYOUT/BASE/BOTTOM -->
<!-- BEGIN: CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ asset('assets/front/js/excanvas.min.js') }}" type="text/javascript"></script>
<![endif]-->
<script src="{{ asset('assets/front/js/jquery.min.js') }}" type="text/javascript"></script>
{{--<script src="{{ asset('assets/front/js/jquery-migrate.min.js') }}" type="text/javascript"></script>--}}
<script src="{{ asset('assets/front/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/front/js/jquery.easing.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/front/plugins/reveal-animate/wow.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/front/js/scripts/reveal-animate/reveal-animate.js') }}" type="text/javascript"></script>
<!-- END: CORE PLUGINS -->
<!-- BEGIN: LAYOUT PLUGINS -->
<script src="{{ asset('assets/front/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/front/plugins/owl-carousel/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/front/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/front/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/front/plugins/fancybox/jquery.fancybox.pack.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/front/plugins/smooth-scroll/jquery.smooth-scroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/front/plugins/slider-for-bootstrap/js/bootstrap-slider.js') }}" type="text/javascript"></script>
<!-- END: LAYOUT PLUGINS -->
<!-- BEGIN: THEME SCRIPTS -->
<script src="{{ asset('assets/front/js/components.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/front/js/components-shop.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/front/js/app.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function()
    {
        App.init(); // init core
    });
</script>
<!-- END: THEME SCRIPTS -->
<!-- BEGIN: PAGE SCRIPTS -->
<script src="{{ asset('assets/front/js/auth.js') }}"></script>
@yield('script')
<!-- END: PAGE SCRIPTS -->
<!-- END: LAYOUT/BASE/BOTTOM -->
</body>

</html>