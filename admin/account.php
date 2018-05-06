<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Quản lý tài khoản - 24hCode Team</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php
        include './include/partial/header.php';
        ?>
        <script src="app/controller/AccountController.js" type="text/javascript"></script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini" ng-controller="accountCtrl">
        <!-- Site wrapper -->
        <div class="wrapper">

            <?php
            include './include/partial/navbar.php';
            ?>

            <!-- =============================================== -->

            <?php
            include './include/partial/menu.php';
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 style="cursor: pointer" ng-click="getData()">
                        Dashboard
                        <i title="Click để tải lại dữ liệu" class="fa fa-refresh {{is_loading == true ? 'fa-spin' : ''}} fa-fw"></i>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Adminstrator menu</a></li>
                        <li><a href="#">Quản lý</a></li>
                        <li>Quản lý tài khoản</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modalAdd">
                        <i class="fa fa-edit"></i>
                        Thêm mới
                    </button>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên tài khoản</th>
                                <th>Tên giảng viên</th>
                                <th>Nhóm quyền</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in data track by $index">
                                <td>{{$index + 1}}</td>
                                <td>{{item.username}}</td>
                                <td>{{item.name}}</td>
                                <td><b>{{item.permission_name|| 'Chưa có nhóm'}}</b></td>
                                <td>
                                    {{item.is_active === "1" ? 'Hoạt động' : 'Bị khóa'}}
                                </td>
                                <td>
                                    <button  ng-click="setEditData(item)"  class="btn btn-circle btn-warning"  data-toggle="modal" data-target="#modalEdit" >
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button ng-click="setEditData(item)" class="btn btn-circle btn-danger"  data-toggle="modal" data-target="#modalRemove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Modal add -->
            <div class="modal fade" id="modalAdd" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal add content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Thêm mới tài khoản</h4>
                        </div>
                        <div class="modal-body">
                            <h3 class="text-center text-danger">Mật khẩu mặc định là 123@123a</h3>
                            <h3 class="text-center text-danger">{{error_message}}</h3>

                            <form class="form-horizontal" id="addForm" ng-submit="addData()">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Tên tài khoản</label>
                                    <div class="col-sm-9">
                                        <input ng-model="add_model.username"  ng-change="checkUsernameExist('add_account')"type="text" class="form-control" placeholder="Nhập tên tài khoản" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Tên giảng viên</label>
                                    <div class="col-sm-9">
                                        <input ng-model="add_model.name" type="text" class="form-control" placeholder="Nhập tên giảng viên">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">Chọn nhóm quyền</label>
                                    <div class="col-sm-9">
                                        <div class="radio" ng-repeat="item in permission track by $index" >
                                            <label>
                                                <input name="permission" type="radio" ng-model="add_model.permission_id"  value="{{item.id}}" required>
                                                {{item.name}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Trạng thái</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" ng-init="add_model.is_active = '0'" ng-model="add_model.is_active" required> 
                                            <!--<option ng-repeat="item in parent_menu" value="{{item}}">{{item.menu_name}}</option>-->
                                            <option value="0" selected="selected">Khóa</option>
                                            <option value="1">Hoạt động</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" value="submit" form="addForm" class="btn btn-success">
                                <i class="fa fa-check"></i>
                                Thêm
                            </button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <i class="fa fa-ban"></i>
                                Hủy
                            </button>
                        </div>
                    </div>

                </div>
            </div>


            <!-- Modal edit -->
            <div class="modal fade" id="modalEdit" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal edit content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Sửa dữ liệu</h4>
                        </div>
                        <div class="modal-body">
                            <h3 class="text-center text-danger">{{error_message}}</h3>

                            <form class="form-horizontal" id="editForm" ng-submit="updateData()">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Tên tài khoản</label>
                                    <div class="col-sm-9">
                                        <input ng-model="edit_model.username"  disabled type="text" class="form-control" placeholder="Tên tài khoản" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Tên giảng viên</label>
                                    <div class="col-sm-9">
                                        <input ng-model="edit_model.name" type="text" class="form-control" placeholder="Tên giảng viên">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">Chọn nhóm quyền</label>
                                    <div class="col-sm-9">
                                        <div class="radio" ng-repeat="item in permission track by $index" >
                                            <label>
                                                <input name="permission" type="radio" ng-model="edit_model.permission_id"  value="{{item.id}}" required>
                                                {{item.name}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Trạng thái</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" ng-model="edit_model.is_active" required> 
                                            <!--<option ng-repeat="item in parent_menu" value="{{item}}">{{item.menu_name}}</option>-->
                                            <option value="0" selected="selected">Khóa</option>
                                            <option value="1">Hoạt động</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="submit"  value="submit" form="editForm" class="btn btn-success">
                                <i class="fa fa-pencil"></i>
                                Cập nhật
                            </button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <i class="fa fa-ban"></i>
                                Hủy
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <!--End modal edit-->

            <!--Modal remove-->
            <div class="modal fade" id="modalRemove" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal add content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Xóa dữ liệu</h4>
                        </div>
                        <div class="modal-body">
                            <h3 class="text-center">{{delete_message}}</h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" ng-click="removeData()" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                                Xóa
                            </button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <i class="fa fa-ban"></i>
                                Hủy
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <!--End modal remove-->
            <?php
            include './include/partial/footer.php';
            ?>

            <?php
            include './include/partial/controlSlide.php';
            ?>
            <div class="control-sidebar-bg">

            </div>



        </div>
        <!-- ./wrapper -->



        <?php
        include './include/partial/footer_script.php';
        ?>

    </body>
</html>
