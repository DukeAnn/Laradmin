/**
 * Auth ajax 验证
 * Created by 雷雷 on 2016/12/26.
 */
//提交登录表单
function submitLogin() {
    var email = $('#login-email').val();
    var password = $('#login-password').val();

    var settings = {
        type: "POST",
        data:{email: email, password: password},
        url: login_url,
        dataType: "json",
        success: function (data) {
            if (data.code == 0) {
                window.location.href = this_url;
            }
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest);
            $('#login-error').show();
            if (XMLHttpRequest.responseJSON.code == -1){
                $('#login-error-message').text(XMLHttpRequest.responseJSON.message);
            } else {
                $('#login-error-message').text("请填写邮箱和密码");
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    };
    $.ajax(settings)
}

//提交注册表单
function submitRegister() {
    var email = $('#signup-email').val();
    var password = $('#signup-password').val();
    var name = $('#signup-username').val();
    var password_confirmation = $('#signup-password_c').val();

    var settings = {
        type: "POST",
        data:{email: email, password: password, name: name, password_confirmation: password_confirmation},
        url: register_url,
        dataType: "json",
        success: function (data) {
            if (data.code == 0) {
                window.location.href = this_url;
            }
        },
        error: function (XMLHttpRequest) {
            $('#register-error').show();
            $('#register-error-message').text('');
            if (XMLHttpRequest.responseJSON.code == -1){
                $('#register-error-message').append('<li class="c-bg-before-red">'+XMLHttpRequest.responseJSON.message+'</li>');
            }
            if (XMLHttpRequest.responseJSON.email) {
                $('#register-error-message').append('<li class="c-bg-before-red">'+XMLHttpRequest.responseJSON.email[0]+'</li>');
            }
            if (XMLHttpRequest.responseJSON.name) {
                $('#register-error-message').append('<li class="c-bg-before-red">'+XMLHttpRequest.responseJSON.name[0]+'</li>');
            }
            if (XMLHttpRequest.responseJSON.password) {
                $('#register-error-message').append('<li class="c-bg-before-red">'+XMLHttpRequest.responseJSON.password[0]+'</li>');
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    };
    $.ajax(settings)
}

//提交重置密码
function submitForgetPassword() {
    var email = $('#forget-email').val();

    var settings = {
        type: "POST",
        data:{email: email},
        url: forget_url,
        dataType: "json",
        success: function (data) {
            if (data.code == 0) {
                $('#forget-error').hide();
                $('#forget-success').show();
                $('#forget-success-message').text(data.message);
            }
        },
        error: function (XMLHttpRequest) {
            $('#forget-success').hide();
            $('#forget-error').show();
            if (XMLHttpRequest.responseJSON.code == -1){
                $('#forget-error-message').text(XMLHttpRequest.responseJSON.message);
            } else {
                $('#forget-error-message').text("请填写邮箱，并检查地址");
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    };
    $.ajax(settings)
}