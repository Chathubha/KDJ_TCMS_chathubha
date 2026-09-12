<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-7xl font-bold text-gray-300">500</h1>
        <p class="text-xl text-gray-600 mt-4">Internal Server Error. Please try again later.</p>
        <a href="{{ url('/') }}" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">Go Home</a>
    </div>
</body>
</html>
