
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $resourcePath; ?>include/template/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo $resourcePath; ?>include/template/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $resourcePath; ?>include/template/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $resourcePath; ?>include/template/AdminLTE/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $resourcePath; ?>include/template/AdminLTE/dist/js/demo.js"></script>
<script src="<?php echo $resourcePath; ?>include/template/AdminLTE/plugins/iCheck/icheck.min.js"></script>
<!--<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree();
        $('[data-toggle="tooltip"]').tooltip();
        var aList = $("ul.treeview-menu li a");
        var URL = window.location.href;
        for (var i = 0; i < aList.length; i++) {
            console.log($(aList[i]).attr("href"));
            if(URL.includes($(aList[i]).attr("href"))){
                $(aList[i]).closest("li").addClass("active");
                break;
            }
        }

    });
</script>-->

<!--Pnotify-->
<link href="<?php echo $resourcePath; ?>include/library/pnotify/pnotify.custom.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo $resourcePath; ?>include/library/pnotify/pnotify.custom.min.js" type="text/javascript"></script>