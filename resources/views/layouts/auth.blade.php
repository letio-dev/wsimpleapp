<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/app.guest.js'])
    @stack('styles')
    <script>
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        fetch('/ping', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                z: Intl.DateTimeFormat().resolvedOptions().timeZone
            })
        });
    </script>
</head>

<body class="bg-gray-100 flex h-[90vh] items-center dark:bg-neutral-800">

    <!-- Content -->
    <div class="w-full max-w-md mx-auto p-6">
        @yield('content')
    </div>
    <!-- End Content -->

</body>

@stack('scripts')

</html>
