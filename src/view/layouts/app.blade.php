<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  @include("layouts._head")
{{--    

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-material-datetimepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fullcalendar.print.css') }}" media="print">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">  --}}

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<style>
.navbar{
  background-color: :red;
}
.user-panel>.info>p {
    margin-bottom: 2px;
}
</style>
  @stack('styles')

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>
      window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), 'url' => url('/')]) !!};
  </script>
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>{{ env("APP_SHORT","ALT") }}</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ env("APP_SHORT","Admin") }}</b>{{ env("APP_SECONDARY","Lte") }}</span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          {{-- @include('layouts._notification') --}}
          
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="{{ asset('images/logo.jpg') }}" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="{{ asset('images/logo.jpg') }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->name }}

                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  {{--  <a href="{{route('users.show', Auth::user())}}" class="btn btn-default btn-flat">Profile</a>  --}}
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                      Sign out
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('images/logo.jpg') }}" class="img-circle sidebar-logo" alt="Diandra">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
        </div>
      </div>

      @include('layouts._sidebar_menu')
      
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row row-eq-height">
        <div class="col-md-8">
          <h1 class="title-header">
            @yield('title')
          </h1>
        </div>
            @yield('actionbtn')
      </div>
{{--       <ol class="breadcrumb">
        @yield('breadcrumb') --}}
        <!-- <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li> -->
      {{-- </ol> --}}
    </section>

    <!-- Main content -->
    <section class="content">
        @if (Session::has('toast'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Success!</h4>
          {!! session('toast') !!}
        </div>
        @endif
       @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-times"></i> Error!</h4>
          {!! session('error') !!}
        </div>
        @endif
      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('layouts._footer')
  @yield('aside')
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- Script -->
<!-- jQuery 2.2.3 -->
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('js/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/demo.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>
{{--  <script src="{{ asset('js/bootstrap-material-datetimepicker.js') }}"></script>  --}}
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>
<script src="{{asset('AdminLTE-2.4.2//bower_components/select2/dist/js/select2.full.min.js')}}"></script>

@yield('bottom')
<!-- page script -->
@stack('scripts')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
