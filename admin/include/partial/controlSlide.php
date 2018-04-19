<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content" ng-controller="activityCtrl as activity">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                    <label> Chat</label>
                    <input type="checkbox" data-toggle="toggle" class="pull-right" ng-click="activity.openConnectionSocket()">
<!--                   <span class="setting-switch pull-right"> 
                        <span class="green switch green ng-empty ng-valid" 
                              checked
                              ng-model="cbSuccessChat" id="cbSuccessChat" 
                              >
                            <small></small>
                            <input type="checkbox" id="cbSuccessChat" 
                                   ng-model="cbSuccessChat" style="display:none" 
                                   class="ng-pristine ng-untouched ng-valid ng-empty">
                            <span class="switch-text"> </span></span> 
                    </span>-->
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->


            <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <!--<div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>-->
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->