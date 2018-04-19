app.controller('loginCtrl', function ($scope, $timeout, mainService) {
    var uri = "login.php";
    var vm = this;
    vm.data = {};
    vm.username;
    vm.password;
    vm.login = login;
//    $scope.data = {};

    function login() {
//        var data = getRequestObject('login');
        var data = {
            "mode": "login",
            "username": vm.username,
            "password": vm.password
        };
        console.log(data);
        mainService.doAction(data, uri).then(function (response) {
            debugger;
            if (response.data.status == true) {
                show_notify('Thông báo', 'Bạn đã đăng nhập thành công', "success");
                $timeout(function () {
                    window.location.href = "/admin/";
                }, 1000);
            } else {
                debugger;
                var msg = response.data.message || "Sai tài khoản hoặc mật khẩu";
                show_notify('Thông báo', msg, "error");
            }
        });
    }
    ;

    $scope.socialLogin = function (agent) {
        show_notify('Thông báo', 'Tính năng đang được phát triển');
    };

    $scope.logout = function () {
        var data = getRequestObject('logout');
        mainService.doAction(data, uri).then(function (response) {
            if (response.data.status === true) {
                show_notify('Thông báo', 'Bạn đã đăng xuất thành công', "success");
                $timeout(function () {
                    window.location.href = "/admin/login.php";
                }, 1000);
            } else {
                show_notify('Thông báo', "Có lỗi xảy ra", "error");
            }
        });
    };

    $scope.forgotPassword = function () {
        show_notify('Thông báo', 'Vui lòng liên hệ quản trị viên');
    };

    $scope.register = function () {
        show_notify('Thông báo', 'Hệ thống chưa cho phép đăng kí. Vui lòng liên hệ quản trị viên để tạo tài khoản');
    };
});