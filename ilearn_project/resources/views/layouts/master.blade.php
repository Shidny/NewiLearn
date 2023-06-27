<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ilearn</title>
    <link rel="stylesheet" href="{{ URL::asset('login_assets/css/style.default.css') }}" />
  <!-- override css -->
  <link rel="stylesheet" href="{{ URL::asset('login_assets/css/override.css?v=1.3') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"></script>
</head>
<body class="signin login-body">
    @yield('content')
	<script src="vendor/jquery/jquery.min.js"></script>
</body>
    
</html>
