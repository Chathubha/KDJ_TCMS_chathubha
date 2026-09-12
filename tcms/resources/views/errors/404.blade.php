<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $status }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-7xl font-bold text-gray-300">{{ $status }}</h1>
        <p class="text-xl text-gray-600 mt-4">
            @if($status == 404)
                Sorry, the page you are looking for could not be found.
            @elseif($status == 403)
                Sorry, you are not authorized to access this page.
            @else
                Sorry, something went wrong on our end.
            @endif
        </p>
        <a href="{{ url('/') }}" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">Go Home</a>
    </div>
</body>
</html>
