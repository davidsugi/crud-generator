@extends('layouts.guest')
@section('content')
  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>Admin</b>{{ ENV('APP_NAME')}}</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <form action="{{ route('login') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
          <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>

          @if ($errors->has('email'))
          <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
          @endif
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">                                   
         <input id="password" placeholder="Password" type="password" class="form-control" name="password" required>
         @if ($errors->has('password'))
         <span class="help-block">
          <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
<!--             <label>
              <input type="checkbox"> Remember Me
            </label> -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
        <a class="btn btn-link" href="{{route('password.request')}}">
          Forgot Your Password?
        </a>
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
@endsection
