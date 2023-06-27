<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>RFC Repository Policies</title>

  <link rel="stylesheet" href="{{ URL::asset('login_assets/css/style.default.css') }}" />
  <!-- override css -->
  <link rel="stylesheet" href="{{ URL::asset('login_assets/css/override.css?v=1.3') }}" />
</head>

<body class="signin login-body">

<!-- Preloader -->
{{-- <div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div> --}}

<section>
  @yield('content')
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"></script>

</body>
</html>