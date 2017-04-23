<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/gfx/ON-mapicon-Delve.png" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@section('meta-title'){{config('app.name', 'Laravel')}}@show</title>
    <meta name="description" content="@section('meta-description'){{config('app.description')}}@show">

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/spin.css" rel="stylesheet">
    <link href="/css/lib.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
@yield('stylesheet')
<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    @if(!empty(env('GOOGLE_TRACKING_ID')))
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', '{{env('GOOGLE_TRACKING_ID')}}', 'auto');
            ga('send', 'pageview');
        </script>
    @endif
</head>
<body class="sidebar-disabled navbar-fixed">
<div id="app" class="main-wrap full">
    @include('layouts.navigation')

    <div class="content">

        @hasSection('breadcrumbs')
        <div class="sub-navbar sub-navbar__header-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 sub-navbar-column">
                        <div class="sub-navbar-header">
                            <h3>Styleguide</h3>
                        </div>
                        <ol class="breadcrumb navbar-text navbar-right no-bg">
                            <li class="current-parent">
                                <a class="current-parent" href="../index.html">
                                    <i class="fa fa-fw fa-home"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0)">
                                    Styleguide
                                </a>
                            </li>
                            <li class="active">Styleguide</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @yield('content')
    </div>

    @include('layouts.footer')
</div>

<!-- Scripts -->
<script src="/js/app.js"></script>
<script src="/js/dropzone.js"></script>
<script src="/js/set-rows.js"></script>
<script src="/js/set.js"></script>
<script src="/js/items.js"></script>
@yield('javascript')

</body>
</html>
