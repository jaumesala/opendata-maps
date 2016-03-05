@extends('auth.layouts.auth')

@section('customBodyClass', 'email hold-transition register-page')
@section('customBodyMethod', 'email')

<!-- Main Content -->
@section('content')

<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('admin.dashboard.index') }}"><b>Schiedam</b>Maps</a>
    </div>
    <!-- /.login-logo -->

    <div class="login-box-body">
        <p class="login-box-msg">Reset Password</p>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <form role="form" method="POST" action="{{ url('/password/email') }}">
            {!! csrf_field() !!}
            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <p class="help-block">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8 col-xs-offset-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Send Password Reset Link</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <div class="social-auth-links text-center">
        </div>

        <a href="{{ url('login') }}" class="text-center">I remember my password</a>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@endsection
