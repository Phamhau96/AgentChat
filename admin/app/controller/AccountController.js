app.controller('accountCtrl', function ($scope, mainService, $timeout) {
    var uri = "account.php";

    $scope.data = [];
    $scope.account_list = [];
    $scope.permission = [];

    $scope.is_error = false;
    $scope.is_loading = false;

    $scope.add_model = {};
    $scope.edit_model = {};

    $scope.getData = function () {
        // prevent user click continuously
        if ($scope.is_loading) {
            show_notify('Thông báo', 'Dữ liệu đang được tải. Vui lòng chờ trong giây lát', 'info');
            return;
        }

        $scope.is_loading = true;
        var data = {
            "mode": "get_data"
        };

        mainService.doAction(data, uri).then(function (response) {
            if (!response.data.status) {
                show_notify('Thông báo', 'Có lỗi xảy ra. Vui lòng thông báo với quản trị hệ thống', 'error');
                return;
            }
            $scope.data = response.data.data;
            $scope.permission = response.data.permission;

            $scope.filterData();
            $timeout(function () {
                $scope.is_loading = false;
            }, 1000);
        });
    };

    $scope.addData = function () {
        if ($scope.is_error) {
            return;
        }


        var data = {
            "mode": "add_data",
            "username": $scope.add_model.username,
            "name": $scope.add_model.name,
            "permission_id": $scope.add_model.permission_id,
            "is_active": $scope.add_model.is_active
        };

        mainService.doAction(data, uri).then(function (response) {
            if (response.data.status) {
                show_notify('Thông báo', 'Thêm mới dữ liệu thành công', 'success');
                $scope.getData();
            } else {
                show_notify('Thông báo', 'Thêm mới dữ liệu không thành công', 'error');
            }
            $("#modalAdd").modal("hide");
        });
    };

    $scope.updateData = function () {
        if ($scope.is_error) {
            return;
        }

        var data = {
            "mode": "update_data",
            "user_id": $scope.edit_model.user_id,
            "username": $scope.edit_model.username,
            "name": $scope.edit_model.name,
            "permission_id": $scope.edit_model.permission_id,
            "is_active": $scope.edit_model.is_active
        };

        mainService.doAction(data, uri).then(function (response) {
            if (response.data.status) {
                show_notify('Thông báo', 'Sửa dữ liệu thành công', 'success');
                $scope.getData();
            } else {
                show_notify('Thông báo', 'Sửa dữ liệu không thành công', 'error');
            }
            $("#modalEdit").modal("hide");
        });

    };

    $scope.removeData = function () {
        var data = {
            "mode": "remove_data",
            "user_id": $scope.edit_model.user_id
        };
        mainService.doAction(data, uri).then(function (response) {
            if (response.data.status) {
                show_notify('Thông báo', 'Xóa dữ liệu thành công', 'success');

                $scope.getData();
            } else {
                show_notify('Thông báo', 'Xóa dữ liệu không thành công', 'error');
            }

            $("#modalRemove").modal("hide");
        });
        console.log(data);
    };

    $scope.setEditData = function (model) {
        $scope.edit_model = angular.copy(model);
        $scope.selected_parent = {};
        $scope.delete_message = 'Bạn có thật sự muốn xóa tài khoản ' + model.username;
    };

    $scope.filterData = function () {
        $scope.account_list = [];
        for (var i = 0; i < $scope.data.length; i++) {
            $scope.account_list.push($scope.data[i].username);
        }
    };

    $scope.checkUsernameExist = function (mode) {
        switch (mode) {
            case 'add_account':
                var username = angular.copy($scope.add_model.username);
                if ($scope.account_list.indexOf(username) > -1) {
                    $scope.error_message = 'Tài khoản đã tồn tại';
                    $scope.is_error = true;
                } else {
                    $scope.error_message = '';
                    $scope.is_error = false;
                }
                break;
            case 'update_account':
                var username = angular.copy($scope.edit_model.username);
                if ($scope.account_list.indexOf(username) > -1) {
                    $scope.error_message = 'Tài khoản đã tồn tại';
                    $scope.is_error = true;
                } else {
                    $scope.error_message = '';
                    $scope.is_error = false;
                }
                break;
        }

    };
    $timeout(function () {
        $scope.getData();
    }, 1000);
});