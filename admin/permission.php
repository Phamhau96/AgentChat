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
        <script src="app/controller/PermissionController.js" type="text/javascript"></script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini" ng-controller="permissionCtrl">
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
                        <i class="fa fa-refresh {{is_loading == true ? 'fa-spin' : ''}} fa-fw"></i>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Adminstrator menu</a></li>
                        <li><a href="#">Quản lý</a></li>
                        <li>Nhóm quyền</li>
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
                                <th>Tên nhóm</th>
                                <th>Menu hiển thị</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in data track by $index">
                                <td>{{$index + 1}}</td>
                                <td>{{item.permission_name}}</td>
                                <td>
                                    <ul ng-if="item.menu.length > 0">
                                        <li ng-repeat="menu in item.menu track by $index">
                                            <b>{{menu.menu_name}}</b>
                                            <ul>
                                                <li ng-repeat="child_menu in menu.child_menu track by $index">
                                                    {{child_menu.menu_name}}
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <p ng-if="item.menu.length == 0">Chưa có quyền trên menu nào</p>
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
                            <h4 class="modal-title">Thêm mới nhóm quyền</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="addForm" ng-submit="addData()">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Tên nhóm quyền</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Nhập tên nhóm quyền" ng-model="add_model.permission_name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Chọn menu</label>
                                    <div class="col-sm-9">
                                        <div class="checkbox" ng-repeat="item in menu track by $index">
                                            <label>
                                                <input type="checkbox" value="{{item.menu_id}}" ng-model="item.selected">
                                                {{item.menu_name}}
                                            </label>
                                        </div>
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
                            <form class="form-horizontal" id="editForm" ng-submit="updateData()">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Tên nhóm quyền</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Nhập tên nhóm quyền" ng-model="edit_model.permission_name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Chọn menu</label>
                                    <div class="col-sm-9">
                                        <div class="checkbox" ng-repeat="item in menu track by $index">
                                            <label>
                                                <input type="checkbox" value="{{item.menu_id}}" ng-model="item.selected">
                                                {{item.menu_name}}
                                            </label>
                                        </div>
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
