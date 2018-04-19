<?php
session_start();
if (!isset($_SESSION['is_logined'])) {
    $_SESSION['login_message'] = "Bạn cần phải đăng nhập trước";
    header("Location: login.php");
    die();
}
$currentURL = $_SERVER['REQUEST_URI'];
$staff_name = isset($_SESSION["staff_name"]) ? $_SESSION["staff_name"] : "HT_Group";
$username = isset($_SESSION["staff_username"]) ? $_SESSION["staff_username"] : "htaccount";
$slogan = isset($_SESSION["staff_slogan"]) ? $_SESSION['staff_slogan'] : "Hoang Thinh Group";
$menu = isset($_SESSION['menu']) ? $_SESSION['menu'] : [];
$can_access_url = isset($_SESSION["can_access_url"]) ? $_SESSION['can_access_url'] : "login.php";
?>
<header class="main-header">
    <!-- Logo -->
    <a href="/admin/" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>HT</b>CRM</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>HT</b> Group</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Tính năng đang được phát triển</li>
                        <!--                        <li>
                                                     inner menu: contains the actual data 
                                                    <ul class="menu">
                                                        <li> start message 
                                                            <a href="#">
                                                                <div class="pull-left">
                                                                    <img src="<?php // echo $resourcePath;  ?>include/template/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                                                </div>
                                                                <h4>
                                                                    Support Team
                                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                                </h4>
                                                                <p>Why not buy a new awesome theme?</p>
                                                            </a>
                                                        </li>
                                                         end message 
                                                    </ul>
                                                </li>-->
                        <li class="footer"><a href="#">--</a></li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Đang phát triển</li>
                        <!--                        <li>
                                                     inner menu: contains the actual data 
                                                    <ul class="menu">
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="footer"><a href="#">View all</a></li>-->
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Design some buttons
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/admin/include/images/profile/<?php echo $_SESSION['staff_profile_image'] ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"> <?php echo $_SESSION['staff_name'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/admin/include/images/profile/<?php echo $_SESSION['staff_profile_image'] ?>" class="img-circle" alt="User Image">

                            <p>
                                <?php echo $_SESSION['staff_name'] ?>
                                <small><?php echo $_SESSION['staff_slogan'] ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">-</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">-</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">-</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer" ng-controller="loginCtrl">
                            <div class="pull-left">
                                <a href="/admin/profile.php" class="btn btn-default btn-flat">Trang cá nhân</a>
                            </div>
                            <div class="pull-right" ng-click="logout()">
                                <a href="#" class="btn btn-default btn-flat">Đăng xuất</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>