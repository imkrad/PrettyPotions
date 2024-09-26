<!DOCTYPE html>
<html data-bs-theme="light" data-sidebar="dark" data-sidebar-image="img-3" data-layout-style="default" data-layout-position="fixed" data-sidebar-size="lg" data-topbar="light" data-layout-width="fluid" data-layout="semibox" data-sidebar-visibility="show" data-preloader="disable">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title inertia>Pretty Potions</title>
        <meta name="description" content="Pretty Potions">
        <meta name="keywords"content="Pretty Potions">
        <meta name="author" content="Pretty Potions">
        <meta property="og:title" content="Pretty Potions">
        <meta property="og:description" content="Pretty Potions">
        <meta property="og:image" content="URL to the template's logo or featured image">
        <meta property="og:url" content="URL to the template's webpage">
        <meta name="twitter:card" content="summary_large_image">
        <link rel="shortcut icon" href="{{ URL::asset('sei.ico') }}">
        <link href="{{ mix('/css/bootstrap.css') }}" rel="stylesheet" />
        <link href="{{ mix('/css/icons.css') }}" rel="stylesheet" />
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        <script src="{{ mix('/js/manifest.js') }}" defer></script>
        <script src="{{ mix('/js/vendor.js') }}" defer></script>
        <script src="{{ mix('/js/app.js') }}" defer></script>
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
</html>
