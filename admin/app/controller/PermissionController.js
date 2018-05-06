app.controller('permissionCtrl', function ($scope, mainService) {
    var uri = "permission.php";
    $scope.data = [];
    $scope.menu = [];

    $scope.add_model = {};
    $scope.edit_model = {};

    $scope.getData = function () {
        var data = {
            "mode": "get_data"
        };

        mainService.doAction(data, uri).then(function (response) {
            if (!response.data.status) {
                show_notify('Thông báo', 'Có lỗi xảy ra. Vui lòng thông báo với quản trị hệ thống', 'error');
                return;
            }
            $scope.data = response.data.data;
            $scope.menu = response.data.menu;

        });
    };

    $scope.addData = function () {
        var menu_id = [];
        // Validate atleast one checkbox is checked;
        for (var i = 0; i < $scope.menu.length; i++) {
            if ($scope.menu[i].selected) {
                menu_id.push($scope.menu[i].menu_id);
            }
        }

        if (menu_id.length == 0) {
            show_notify('Thông báo', 'Vui lòng chọn ít nhất 1 menu cho nhóm quyền');
            return;
        }
        // call service
        var data = {
            "mode": "add_data",
            "permission_name": $scope.add_model.permission_name,
            "menu_id_list": menu_id
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
        var menu_id = [];
        // Validate atleast one checkbox is checked;
        for (var i = 0; i < $scope.menu.length; i++) {
            if ($scope.menu[i].selected) {
                menu_id.push($scope.menu[i].menu_id);
            }
        }

        if (menu_id.length == 0) {
            show_notify('Thông báo', 'Vui lòng chọn ít nhất 1 menu cho nhóm quyền');
            return;
        }
        // call service
        var data = {
            "mode": "update_data",
            "id" : $scope.edit_model.permission_id,
            "permission_name": $scope.edit_model.permission_name,
            "menu_id_list": menu_id
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
            "id": $scope.edit_model.permission_id
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
        $scope.delete_message = 'Bạn có thật sự muốn xóa nhóm quyền ' + model.permission_name;
    };
    $scope.getData();
});