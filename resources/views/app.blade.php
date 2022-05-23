<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    @routes

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>

    @inertiaHead
</head>

<body class="h-full min-h-screen font-sans antialiased transition-all duration-200 bg-white text-gray-dark dark:text-gray-lightest dark:bg-gray-darkest">

    @inertia


</body>

</html>