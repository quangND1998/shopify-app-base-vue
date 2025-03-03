<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        <script>
            function ot_getUrlParam(paramName) {
                var match = window.location.search.match("[?&]" + paramName + "(?:&|$|=([^&]*))");
                return match ? (match[1] ? match[1] : "") : null;
            }
            window.sessionStorage.removeItem('omega-redirected');
            window.OT_REDIRECT_TAB = ot_getUrlParam('redirectTab');
            window.OT_SHOP = ot_getUrlParam('shop');
            window.OT_HMAC = ot_getUrlParam('hmac');
            window.OT_HOST = ot_getUrlParam('host');
            window.OT_MANAGER = ot_getUrlParam('forceRedirect');
            window.OT_FIRST_VISIT = ot_getUrlParam('firstVisit');
        </script>
    </head>
    <body class="font-sans antialiased">
        @inertia
        <input type="hidden" id="appEnv" value="{{env('APP_ENV')}}">
        <input type="hidden" id="apiKey" value="{{ env('SHOPIFY_API_KEY') }}">
        {{-- <input type="hidden" id="shopOrigin" value="{{$shop}}"> --}}
        <input type="hidden" id="appName" value="{{env('APP_NAME')}}">
    </body>
</html>
