<?php
$tokens = explode('/', $currentURL);
$token = $tokens[sizeof($tokens) - 1];
if ($token != '' && (strpos($can_access_url, $token) == false)) {
//    echo '<meta http-equiv="refresh" content="0; URL=/admin/warning.php">';
//    die();
}
?>

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/admin/include/images/profile/<?php echo $_SESSION['staff_profile_image'] ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo "$staff_name($username)" ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">CRM</li>
            <!--            <li class="active">
                            <a href="index.php">
                                <i class="fa fa-circle-o text-success"></i>
            <?php
//                    echo $menu_parent['menu_name'];
            ?>
                            </a>
                        </li>-->
            <?php
            $active_parent = "";

            foreach ($menu as $menu_item) {
                ?>
                <li id="menu_<?php echo $menu_item['menu_id']; ?>" class="treeview">
                    <a href="#">
                        <i class="<?php echo $menu_item['fa_icon'] ?>"></i>
                        <span><?php echo $menu_item['menu_name']; ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul id="treeview-menu_<?php echo $menu_item['menu_id']; ?>" class="treeview-menu">
                        <?php
                        foreach ($menu_item['child_menu'] as $child_menu) {
                            if (strpos($currentURL, $child_menu['url']) != false) {
                                $class = ' class= "active" ';
                                $active_parent = $menu_item['menu_id'];
                            } else {
                                $class = '';
                            }
                            echo "<li $class ><a href=\"{$child_menu['url']}\"><i class=\"{$child_menu['fa_icon']}\"></i> {$child_menu['menu_name']}</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
            ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<script>
//Open parent menu
    $("#menu_<?php echo $active_parent ?>").addClass("menu-open");
    $("#treeview-menu_<?php echo $active_parent ?>").css("display", "block");
</script>

<!-- =============================================== -->