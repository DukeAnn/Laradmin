{{--登录注册--}}
<!-- BEGIN: CONTENT/USER/FORGET-PASSWORD-FORM -->
<div class="modal fade c-content-login-form" id="forget-password-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content c-square">
            <div class="modal-header c-no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="c-font-24 c-font-sbold">重置密码</h3>
                <p>请输入重置密码链接的接收邮箱</p>
                <div class="alert alert-danger alert-dismissible" role="alert" id="forget-error" style="display: none">
                    <span id="forget-error-message"></span>
                </div>
                <div class="alert alert-success" role="alert" id="forget-success" style="display: none">
                    <span id="forget-success-message"></span>
                </div>
                <form id="forget-form">
                    <div class="form-group">
                        <label for="forget-email" class="hide">Email</label>
                        <input type="email" class="form-control input-lg c-square" id="forget-email" name="email" placeholder="Email"> </div>
                    <div class="form-group">
                        <button type="button" onclick="submitForgetPassword()" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">确定</button>
                        <a href="javascript:;" class="c-btn-forgot" data-toggle="modal" data-target="#login-form" data-dismiss="modal">返回登录</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer c-no-border">
                <span class="c-text-account">还没有账户？</span>
                <a href="javascript:;" data-toggle="modal" data-target="#signup-form" data-dismiss="modal" class="btn c-btn-dark-1 btn c-btn-uppercase c-btn-bold c-btn-slim c-btn-border-2x c-btn-square c-btn-signup">马上注册</a>
            </div>
        </div>
    </div>
</div>
<!-- END: CONTENT/USER/FORGET-PASSWORD-FORM -->
<!-- BEGIN: CONTENT/USER/SIGNUP-FORM -->
<div class="modal fade c-content-login-form" id="signup-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content c-square">
            <div class="modal-header c-no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="c-font-24 c-font-sbold">注册账户</h3>
                <p>请填写如下必要信息</p>
                <div class="alert alert-danger alert-dismissible" role="alert" id="register-error" style="display: none">
                    <ul class="c-content-list-1 c-theme c-separator-dot" id="register-error-message">

                    </ul>
                </div>
                <form id="register-form">
                    <div class="form-group">
                        <label for="signup-email" class="hide">Email</label>
                        <input type="email" class="form-control input-lg c-square" id="signup-email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="signup-username" class="hide">用户名</label>
                        <input type="text" class="form-control input-lg c-square" id="signup-username" name="name" placeholder="用户名">
                    </div>
                    <div class="form-group">
                        <label for="signup-password" class="hide">密码</label>
                        <input type="password" class="form-control input-lg c-square" id="signup-password" name="password" placeholder="密码">
                    </div>
                    <div class="form-group">
                        <label for="signup-password_c" class="hide">确认密码</label>
                        <input type="password" class="form-control input-lg c-square" id="signup-password_c" name="password_confirmation" placeholder="确认密码">
                    </div>
                    {{--<div class="form-group">
                        <label for="signup-country" class="hide">国家</label>
                        <select class="form-control input-lg c-square" id="signup-country">
                            <option value="1">Country</option>
                        </select>
                    </div>--}}
                    <div class="form-group">
                        <button type="button" onclick="submitRegister()" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">注册</button>
                        <a href="javascript:;" class="c-btn-forgot" data-toggle="modal" data-target="#login-form" data-dismiss="modal">返回登录</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END: CONTENT/USER/SIGNUP-FORM -->
<!-- BEGIN: CONTENT/USER/LOGIN-FORM -->
<div class="modal fade c-content-login-form" id="login-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content c-square">
            <div class="modal-header c-no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="c-font-24 c-font-sbold">时光柔软了岁月</h3>
                <p>让我们今天变得更美好！</p>
                <div class="alert alert-danger alert-dismissible" role="alert" id="login-error" style="display: none">
                    <span id="login-error-message"></span>
                </div>
                <form id="login-form">
                    <div class="form-group">
                        <label for="login-email" class="hide">Email</label>
                        <input type="email" class="form-control input-lg c-square" id="login-email" name="email" placeholder="Email"> </div>
                    <div class="form-group">
                        <label for="login-password" class="hide">密码</label>
                        <input type="password" class="form-control input-lg c-square" id="login-password" name="password" placeholder="密码"> </div>
                    <div class="form-group">
                        <div class="c-checkbox">
                            <input type="checkbox" id="login-rememberme" class="c-check" name="remember">
                            <label for="login-rememberme" class="c-font-thin c-font-17">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> 记住我 </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="submitLogin()" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">登录</button>
                        <a href="javascript:;" data-toggle="modal" data-target="#forget-password-form" data-dismiss="modal" class="c-btn-forgot">忘记密码</a>
                    </div>
                    <div class="clearfix">
                        <div class="c-content-divider c-divider-sm c-icon-bg c-bg-grey c-margin-b-20">
                            <span>其他登录方式</span>
                        </div>
                        <ul class="c-content-list-adjusted">
                            <li>
                                <a class="btn btn-block c-btn-square btn-social btn-wechat">
                                    <i class="fa fa-wechat"></i> 微信登录 </a>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="modal-footer c-no-border">
                <span class="c-text-account"> 还没有账户？</span>
                <a href="javascript:;" data-toggle="modal" data-target="#signup-form" data-dismiss="modal" class="btn c-btn-dark-1 btn c-btn-uppercase c-btn-bold c-btn-slim c-btn-border-2x c-btn-square c-btn-signup">马上注册</a>
            </div>
        </div>
    </div>
</div>
<!-- END: CONTENT/USER/LOGIN-FORM -->
<script type="text/javascript">
var login_url = "{{ route('ajax.login') }}";
var forget_url = "{{ route('ajax.password.email') }}";
var register_url = "{{ route('ajax.register') }}";
/*当前页URL*/
var this_url = "{{ Request::url() }}"
</script>