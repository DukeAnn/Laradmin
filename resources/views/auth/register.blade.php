@extends('layouts.auth')

{{--标题--}}
@section('title', 'Page Title')

{{--页面内容--}}
@section('content')
    <div class="row bs-reset">
        <div class="col-md-6 login-container bs-reset">
            <img class="login-logo login-6" src="{{ asset('assets/auth/img/login-invert.png') }}" />
            <div class="login-content" style="margin-top: 20%">
                <h1>注册账号</h1>
                <p> 开启一篇新天地 </p>
                <form action="{{ url('register') }}" class="login-form" method="post">
                    {{ csrf_field() }}
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span>请填写全部信息，并保证格式正确</span>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-xs-8">
                            <input class="form-control form-control-solid placeholder-no-fix form-group{{ $errors->has('name') ? ' has-error' : '' }}" type="text" autocomplete="off" placeholder="{{ $errors->has('name') ? $errors->first('name') : '用户名' }}" name="name" required value="{{ old('name') }}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-xs-8">
                            <input class="form-control form-control-solid placeholder-no-fix form-group{{ $errors->has('email') ? ' has-error' : '' }}" type="email" autocomplete="off" placeholder="{{ $errors->has('email') ? $errors->first('email') : '邮箱地址' }}" name="email" required value="{{ old('email') }}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-xs-8">
                            <input class="form-control form-control-solid placeholder-no-fix form-group{{ $errors->has('password') ? ' has-error' : '' }}" type="password" autocomplete="off" placeholder="{{ $errors->has('password') ? $errors->first('password') : '用户密码' }}" name="password" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-xs-8">
                            <input class="form-control form-control-solid placeholder-no-fix form-group{{ $errors->has('password') ? ' has-error' : '' }}" type="password" autocomplete="off" placeholder="{{ $errors->has('password') ? $errors->first('password') : '确认密码' }}" name="password_confirmation" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8 text-right">
                            <button class="btn blue" type="submit">注册</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="login-footer">
                <div class="row bs-reset">
                    <div class="col-xs-5 bs-reset">
                        <ul class="login-social">
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-dribbble"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-7 bs-reset">
                        <div class="login-copyright text-right">
                            <p>Copyright &copy; Keenthemes 2015</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 bs-reset">
            <div class="login-bg">
                <input type="hidden" value="{{ asset('assets/auth/img/bg1.jpg') }}" id="login_right_img1">
                <input type="hidden" value="{{ asset('assets/auth/img/bg3.jpg') }}" id="login_right_img2">
                <input type="hidden" value="{{ asset('assets/auth/img/bg4.jpg') }}" id="login_right_img3">
            </div>
        </div>
    </div>
@endsection
