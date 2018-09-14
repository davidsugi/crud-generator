<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  @include("layouts._head")

  @stack('styles')

</head>
<body class="hold-transition login-page">

  @yield('content')

  @stack('scripts')
</body>
</html>