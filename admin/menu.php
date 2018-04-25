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
        <script src="/admin/app/controller/MenuController.js" type="text/javascript"></script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini" ng-controller="menuCtrl">
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
                        <li>Menu</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!--Start parent menu-->
                    <div class="col-md-6">
                        <h3 class="text-center text-danger">Menu cha</h3>
                        <div class="alert alert-info">
                            <p>Danh mục đang chọn: {{currentParent.name}}</p>
                            <p>Tiêu chí SX: {{ parentCategorySortType}}</p>
                            <p>Xếp theo   : {{ parentCategorySortReverse == true ? 'A -> Z' : 'Z -> A'}}</p>
                            <p>DL tìm kiếm: {{ parentCategorySortSearchQuery}}</p>
                        </div>
                        <form>
                            <button ng-click="setParent(true)" style="margin-bottom: 10px" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                                Thêm mới
                            </button>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                    <input type="text" class="form-control" placeholder="Nhập dữ liệu cần tìm kiếm" ng-model="parentCategorySortSearchQuery">
                                </div>      
                            </div>
                        </form>
                        <table class="table table-bordered table-hover" style=" cursor: pointer; ">
                            <thead>
                                <tr>
                                    <th><a href="">#</a></th>
                                    <th>
                                        <a href="" ng-click="parentCategorySortType = 'menu_name'; parentCategorySortReverse = !parentCategorySortReverse">
                                            Tên menu
                                            <span ng-show="parentCategorySortType == 'menu_name' && !parentCategorySortReverse" class="fa fa-caret-down"></span>
                                            <span ng-show="parentCategorySortType == 'menu_name' && parentCategorySortReverse" class="fa fa-caret-up"></span>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="" ng-click="parentCategorySortType = 'fa_icon'; parentCategorySortReverse = !parentCategorySortReverse">
                                            Icon
                                            <span ng-show="parentCategorySortType == 'fa_icon' && !parentCategorySortReverse" class="fa fa-caret-down"></span>
                                            <span ng-show="parentCategorySortType == 'fa_icon' && parentCategorySortReverse" class="fa fa-caret-up"></span>
                                        </a>
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in data| orderBy:parentCategorySortType:parentCategorySortReverse | filter:parentCategorySortSearchQuery" ng-click="setSelectedMenu(item)">
                                    <td>{{$index + 1}}</td>
                                    <td>{{item.menu_name}}</td>
                                    <td>{{item.fa_icon}}</td>
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
                    </div>
                    <!--End parent menu-->

                    <!--Start child menu-->
                    <div class="col-md-6">
                        <h3 class="text-center text-danger">Menu con</h3>
                        <div class="alert alert-info">
                            <p>Danh mục đang chọn: {{currentChild.name}}</p>
                            <p>Tiêu chí SX: {{ childCategorySortType}}</p>
                            <p>Xếp theo   : {{ childCategorySortReverse == true ? 'A -> Z' : 'Z -> A'}}</p>
                            <p>DL tìm kiếm: {{ childCategorySortSearchQuery}}</p>
                        </div>
                        <form>
                            <button ng-click="setParent(false)" style="margin-bottom: 10px" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                                Thêm mới
                            </button>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                    <input type="text" class="form-control" placeholder="Nhập dữ liệu cần tìm kiếm" ng-model="childCategorySortSearchQuery">
                                </div>      
                            </div>
                        </form>
                        <table class="table table-bordered table-hover table-responsive"  ng-show="selected_menu.child_menu.length > 0">
                            <thead>
                                <tr>
                                    <th><a href="#">#</a></th>
                                    <!--<th>Mã danh mục</th>-->
                                    <th><a href="" ng-click="childCategorySortType = 'name'; childCategorySortReverse = !childCategorySortReverse">
                                            Tên menu
                                            <span ng-show="childCategorySortType == 'name' && !childCategorySortReverse" class="fa fa-caret-down"></span>
                                            <span ng-show="childCategorySortType == 'name' && childCategorySortReverse" class="fa fa-caret-up"></span>
                                        </a></th>
                                    <th style="width: 40%"><a href="" ng-click="childCategorySortType = 'note'; childCategorySortReverse = !childCategorySortReverse">
                                            fa icon
                                            <span ng-show="childCategorySortType == 'note' && !childCategorySortReverse" class="fa fa-caret-down"></span>
                                            <span ng-show="childCategorySortType == 'note' && childCategorySortReverse" class="fa fa-caret-up"></span>
                                        </a></th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in selected_menu.child_menu| orderBy:childCategorySortType:childCategorySortReverse | filter:childCategorySortSearchQuery" ng-if="item.is_deleted != 1">
                                    <td>{{$index + 1}}</td>
                                    <!--<td>{{item.id}}</td>-->
                                    <td>{{item.menu_name}}</td>
                                    <td>{{item.fa_icon}}</td>
                                    <td>
                                        <button  ng-click="setEditData(item)"  class="btn btn-circle btn-warning"  data-toggle="modal" data-target="#modalEdit" >
                                            <i class="fa fa-pencil" data-toggle="tooltip" title="Sửa"></i>
                                        </button>
                                        <button ng-click="setEditData(item)" class="btn btn-circle btn-danger"  data-toggle="modal" data-target="#modalRemove">
                                            <i class="fa fa-trash" data-toggle="tooltip" title="Xóa"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3 ng-if="selected_menu.child_menu.length == 0" class="text-center">Chưa có menu con</h3>
                    </div>
                    <!--End child menu-->
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
                            <h4 class="modal-title">Thêm mới dữ liệu</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="addForm" ng-submit="addData()">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Tên menu</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Nhập tên menu" ng-model="add_model.name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">fa icon</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Nhập kí hiệu fa icon của menu" ng-model="add_model.fa_icon" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">URL</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Nhập url menu" ng-model="add_model.url">
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
            <!--End modal add-->

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
                                    <label class="control-label col-sm-3">Tên menu</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control"  placeholder="Nhập tên menu" ng-model="edit_model.menu_name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">fa icon</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control"  placeholder="Nhập kí hiệu fa icon của menu" ng-model="edit_model.fa_icon" required>
                                    </div>
                                </div>
                                <div class="form-group" ng-if="!edit_model.child_menu">
                                    <label class="control-label col-sm-3">Danh mục cha</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" ng-model="selected_parent.id" ng-options="item.menu_id as item.menu_name for item in parent_menu" required> 
                                            <!--<option ng-repeat="item in parent_menu" value="{{item}}">{{item.menu_name}}</option>-->
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">URL</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Nhập url menu" ng-model="edit_model.url" required>
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
