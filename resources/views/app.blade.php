<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="/favicon.png">

        <!-- Styles -->
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />

        <!-- Javascript -->
        <script src="{{ mix('/js/app.js') }}" defer></script>

        @routes
    </head>

    <body class="font-sans antialiased min-h-screen h-full text-gray-100 bg-black">
        @inertia
    </body>
</html>
