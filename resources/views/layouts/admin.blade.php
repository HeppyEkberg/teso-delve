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
<body>
<div class="main-wrap admin-wrap">
    @include('layouts.admin.navigation')

    <div class="content">
        @yield('content')
    </div>
</div>

<!-- Scripts -->
<script src="/js/app.js"></script>
<script src="/js/dropzone.js"></script>
<script src="/js/set-rows.js"></script>
<script src="/js/set.js"></script>
<script src="/js/items.js"></script>
<script src="/js/es6.js"></script>
@yield('javascript')

</body>
</html>
