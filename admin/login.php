<?php
    session_start();
    if(isset($_SESSION['is_logined'])){
        header("Location: /admin/");
    }
?>

<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dashboard - HT CRM</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php
        include './include/partial/header.php';
        ?>
        <script src="app/controller/LoginCtrl.js" type="text/javascript"></script>
    </head>
    <body class="hold-transition login-page" ng-controller="loginCtrl as log">
        <div class="login-box">
            <div class="login-logo">
                <a href="/admin/"><b>HT</b>GROUP</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Đăng nhập vào hệ thống</p>

                <form ng-submit="log.login()">
                    <div class="form-group has-feedback">
                        <input ng-model="log.username" required autofocus type="text" class="form-control" placeholder="Nhập username">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input ng-model="log.password" required type="password" class="form-control" placeholder="Nhập password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox"> Ghi nhớ
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

<!--                <div class="social-auth-links text-center">
                    <p>- Hoặc -</p>
                    <a href="" ng-click="socialLogin('facebook')" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i>Đăng nhập bằng Facebook</a>
                    <a href="" ng-click="socialLogin('google')" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i>Đăng nhập bằng Google+</a>
                </div>-->
                <!-- /.social-auth-links -->

                <a href="" ng-click="forgotPassword()">Quên mật khẩu</a><br>
                <a href="" ng-click="register()" class="text-center">Đăng kí tài khoản</a>

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <script>
                    $(function () {
                        $('input').iCheck({
                            checkboxClass: 'icheckbox_square-blue',
                            radioClass: 'iradio_square-blue',
                            increaseArea: '20%' // optional
                        });
                    });
        </script>

        <?php
        include './include/partial/footer_script.php';
        ?>

    </body>
</html>
