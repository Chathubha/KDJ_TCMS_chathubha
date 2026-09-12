<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $status ?? 500 }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-300">{{ $status ?? 500 }}</h1>
        <p class="text-xl text-gray-600 mt-4">
            @if($status == 404)
                Page Not Found
            @elseif($status == 403)
                Access Denied
            @else
                Server Error
            @endif
        </p>
        <p class="text-gray-500 mt-2">{{ $exception->getMessage() ?? 'Something went wrong.' }}</p>
        <a href="{{ route('dashboard') }}" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">Go to Dashboard</a>
    </div>
</body>
</html>
