app.controller('menuCtrl', function ($scope, mainService) {
    var uri = "menu.php";
    $scope.data = [];
    $scope.parent_menu = [];

    $scope.is_parent = false;
    $scope.delete_message = '';
    $scope.selected_menu = {};
    $scope.selected_parent = {
        "id": 0
    };
    $scope.edit_model = {};
    $scope.add_model = {};

    $scope.getData = function () {
        $scope.data = [];
        $scope.parent_menu = [];

        $scope.is_parent = false;
        $scope.selected_menu = {};
        $scope.selected_parent = {
            "id": 0
        };
        $scope.edit_model = {};
        $scope.add_model = {};

        var data = {
            "mode": "get_data"
        };
        mainService.doAction(data, uri).then(function (response) {
            $scope.data = response.data.data;
            $scope.parent_menu = response.data.parent_menu;
            console.log(response.data);
        });
    };

    $scope.addData = function () {
        show_notify('Thong bao', "Thêm mới dữ liệu");
        var data = {
            "mode": "add_data",
            "parent_id": $scope.is_parent ? -1 : $scope.selected_menu.menu_id,
            "name": $scope.add_model.name,
            "fa_icon": $scope.add_model.fa_icon,
            "url": $scope.add_model.url
        };
        mainService.doAction(data, uri).then(function (response) {
            if (response.data.status) {
                show_notify('Thông báo', 'Thêm mới dữ liệu thành công', 'success');

                $scope.getData();
                reGetMenu();
            } else {
                show_notify('Thông báo', 'Thêm mới dữ liệu không thành công', 'error');
            }

            $("#modalAdd").modal("hide");
        });
    };

    $scope.updateData = function () {
        var data = {
            "mode": "update_data",
            "id": $scope.edit_model.menu_id,
            "parent_id": $scope.selected_parent.id || $scope.edit_model.parent_id,
            "name": $scope.edit_model.menu_name,
            "fa_icon": $scope.edit_model.fa_icon,
            "url": $scope.edit_model.url
        };

        mainService.doAction(data, uri).then(function (response) {
            if (response.data.status) {
                show_notify('Thông báo', 'Cập nhật dữ liệu thành công', 'success');
                $scope.getData();
                reGetMenu();
            } else {
                show_notify('Thông báo', 'Cập nhật dữ liệu không thành công', 'error');
            }

            $scope.selected_parent = {};
            $("#modalEdit").modal("hide");
        });

    };

    $scope.removeData = function () {
        var data = {
            "mode": "remove_data",
            "id": $scope.edit_model.menu_id
        };
        mainService.doAction(data, uri).then(function (response) {
            if (response.data.status) {
                show_notify('Thông báo', 'Xóa dữ liệu thành công', 'success');
                $scope.getData();
                reGetMenu();
            } else {
                show_notify('Thông báo', 'Xóa dữ liệu không thành công', 'error');
            }

            $("#modalRemove").modal("hide");
        });
        console.log(data);
    };
    $scope.setSelectedMenu = function (menu) {
        $scope.selected_menu = menu;
    };

    $scope.setEditData = function (model) {
        $scope.edit_model = angular.copy(model);
        $scope.selected_parent = {};
        $scope.delete_message = 'Bạn có thật sự muốn xóa menu ' + model.menu_name;
    };

    $scope.setParent = function (status) {
        $scope.is_parent = status;
        if (!($scope.selected_menu.menu_id || $scope.is_parent)) {
            show_notify('Thông báo', 'Vui lòng chọn danh mục cha trước');

            return;
        }
        $("#modalAdd").modal("show");
    };

    function reGetMenu() {
        var data = {
            "mode": "re_get_menu"
        };
        var rg_uri = "login.php";
        mainService.doAction(data, rg_uri).then(function (response) {
            if(response.data.status){
                show_notify('Thông báo', 'Reload lại trang để cập nhật menu');
            } else {
                show_notify('Thông báo', 'Login lại để cập nhật menu');
            }
        });
    }

    $scope.getData();
});