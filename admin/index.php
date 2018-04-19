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
        <script src="app/controller/IndexController.js" type="text/javascript"></script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini" >
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
                        <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
                        <li><a href="#">Quản lý</a></li>
                        <li>Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <h1>Dashboard của quản trị viên</h1>
                    <h2>- Hiển thị số lượng đơn hàng| số lượng sản phẩm | Tổng khách truy cập | Khách đang online</h2>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

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
