@extends('auth.layouts.auth')

@section('customBodyClass', 'reset hold-transition register-page')
@section('customBodyMethod', 'reset')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('admin.dashboard.index') }}">{!! setting_value('application', 'name') !!}</a>
    </div>
    <!-- /.login-logo -->

    <div class="login-box-body">
        <p class="login-box-msg">Reset Password</p>
        <form role="form" method="POST" action="{{ url('/password/reset') }}">
            {!! csrf_field() !!}

            <input type="hidden" name="token" value="{{ $token or '' }}">

            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <p class="help-block">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>
            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" placeholder="Password" name="password" value="{{ old('password') }}">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <p class="help-block">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>
            <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input type="password" class="form-control" placeholder="Confirm password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                @if ($errors->has('password_confirmation'))
                    <p class="help-block">
                        {{ $errors->first('password_confirmation') }}
                    </p>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8 col-xs-offset-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
