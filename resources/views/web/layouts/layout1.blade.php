<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="robots" content="noindex">

    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>1st Car Recovery - Home</title>

    @vite([
        'resources/scss/web/app.scss',
        'resources/js/Web/app.js'
    ])

</head>
<body>
<div class="bg-fixed-full blur-xs-and-brighten xs:hidden" style="background-image: url('/assets/images/1st-car-recovery-bg.webp');"></div>
<div class="bg-fixed-full blur-xs-and-brighten md:hidden" style="background-image: url('/assets/images/1-st-car-recovery-mobile-bg.webp');"></div>

@include('web.partials.header')

@yield('content')

@include('web.partials.footer')

</body>
</html>
