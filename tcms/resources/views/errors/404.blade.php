<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <div class="text-8xl font-black text-gray-200 mb-4">404</div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Page Not Found</h1>
        <p class="text-gray-500 mb-8 max-w-md">Sorry, the page you are looking for could not be found. It may have been moved or deleted.</p>
        <a href="{{ url('/') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-xl font-semibold transition shadow-sm inline-block">Go Home</a>
    </div>
</body>
</html>
