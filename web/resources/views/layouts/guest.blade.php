<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'EasyColoc') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>

    </head>
    <body class="font-sans text-gray-900 antialiased min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-purple-700 flex items-center justify-center p-4">
        {{ $slot }}
    </body>
</html>