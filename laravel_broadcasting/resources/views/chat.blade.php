<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Realtime Chat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>
<body class="bg-gray-100">
    <div id="app">
        <chat></chat>
    </div>
</body>
</html>