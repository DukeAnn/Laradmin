@extends('layouts.auth')

{{--标题--}}
@section('title', 'Page Title')

{{--页面内容--}}
@section('content')
    <div class="row bs-reset">
        <div class="col-md-6 bs-reset">
            <div class="login-bg">
                <input type="hidden" value="{{ asset('assets/auth/img/bg1.jpg') }}" id="login_right_img1">
                <input type="hidden" value="{{ asset('assets/auth/img/bg3.jpg') }}" id="login_right_img2">
                <input type="hidden" value="{{ asset('assets/auth/img/bg4.jpg') }}" id="login_right_img3">
            </div>
        </div>
        <div class="col-md-6 login-container bs-reset">
            <img class="login-logo login-6" src="{{ asset('assets/auth/img/login-invert.png') }}" />
            <div class="login-content">
                <h1>管理系统登录</h1>
                <p> 开启一篇新天地 </p>
                <form action="{{ url('login') }}" class="login-form" method="post">
                    {{ csrf_field() }}
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span>用户名或密码错误！</span>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif
                    @if ($errors->has('email'))
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button>
                            <span>{{ $errors->first('email') }}</span>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-xs-6">
                            <input class="form-control form-control-solid placeholder-no-fix form-group{{ $errors->has('email') ? ' has-error' : '' }}" type="email" autocomplete="off" placeholder="邮箱地址" name="email" required value="{{ old('email') }}"/> </div>
                        <div class="col-xs-6">
                            <input class="form-control form-control-solid placeholder-no-fix form-group{{ $errors->has('password') ? ' has-error' : '' }}" type="password" autocomplete="off" placeholder="{{ $errors->has('password') ? $errors->first('password') : '用户密码' }}" name="password" required/> </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="rememberme mt-checkbox mt-checkbox-outline">
                                <input type="checkbox" name="remember" value="1" /> 记住我
                                <span></span>
                            </label>
                        </div>
                        <div class="col-sm-8 text-right">
                            <div class="forgot-password">
                                <a href="javascript:;" id="forget-password" class="forget-password">忘记密码？</a>
                            </div>
                            <button class="btn blue" type="submit">登录</button>
                        </div>
                    </div>
                </form>
                <!-- BEGIN FORGOT PASSWORD FORM -->
                <form class="forget-form" action="{{ url('password/email') }}" method="post">
                    {{ csrf_field() }}
                    <h3>忘记密码了？</h3>
                    <p> 输入你注册的邮箱，我们将会发送一封重置密码的邮件。 </p>
                    <div class="form-group">
                        <input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="{{ old('email') }}" name="email" /> </div>
                    <div class="form-actions">
                        <button type="button" id="back-btn" class="btn blue btn-outline">返回</button>
                        <button type="submit" class="btn blue uppercase pull-right">发送</button>
                    </div>
                </form>
                <!-- END FORGOT PASSWORD FORM -->
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
    </div>
@endsection
