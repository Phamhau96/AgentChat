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
        <script src="app/controller/Chat.js" type="text/javascript"></script>
    </head>
    <style>
        .notify-background {
            background-color:gold;
        }
        .notify-width {
            width:450px;
        }
        .clear{
            clear:both; 
        }
        .on_swicth, .off_swicth {font-size:30px;cursor:pointer;}
        i.on_swicth { color: #00d449}
        i.off_swicth {color: #d9534f}
        #queue_switch_true {
            float: right;margin-right: 150px;margin-top: -5px;
        }
        #queue_switch_false {
            float: right;margin-right: 150px;margin-top: -5px;
        }
        ul {
            list-style-type: none;
        }
        li {
            list-style-type: none;
        }
        .message-bar {
            height:60px;
        }
        .message-bar input {
            height:50px;
        }
        .panel-tabs, .tabbable {
            padding: 0px;
        }
        li.nextSame .message .message-text {
            float:right!important;
        }
        li.self .message .message-text {
            float:right!important;
        }
    </style>
    <body class="hold-transition skin-blue sidebar-mini" ng-controller="chatCtrl as chat" >
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
                <div class="col-md-3 wrap-list border-right" style ="background:#ffffff;height:100%">
                    <ul style ="padding-top: 20px;padding-left: 20px;">
                        <li style="text-align: center;">
                            <a>
                                <span class="title"><i class="fa fa-user-md text-large"></i> Khách hàng</span>
                                <span class="badge pull-right" id="badgedanger">{{chat.numberCustomer}}</span>
                            </a>
                        </li>
                        <hr>
                    </ul>
                    <ul class="media-list customernumber" id="listCustomerChat" >
                        <li  id="{{item.id}}" class="{{item.id}}"  ng-repeat="item in chat.items" class="media border-bottom" style ="position: relative;height: 80px; background-color: {{item.isselected == true ? '#e1e6f4' : item.isread == true ? '#ffcccc' : '#fff' }}" ng-click="chat.openSessionChat(item)" ct-toggle="on" target="users">
                            <a>
                                <i class=" menu-icon fa fa-user bg-green text-green img-circle img-responsive media-object" style="line-height:3;text-align: center;width:40px;margin-top: 14px;"></i>
                                <div class="media-body" style ="position: absolute; top: 15px;left: 50px;">
                                    <h5 class="media-heading" ng-bind="item.from| limitTo:15" ng-bind="item.from.length > 15 ? '...' : ''"></h5>
                                    <span ng-bind="item.content |limitTo:25" ng-bind="item.content.length > 25 ? '...' : ''"></span>
                                    <p  style="color:red; display: none;">Phiên chat đã kết thúc!</p>
                                </div>  
                            </a>
                        </li>
                    </ul>

                </div>

<!--                <div class="col col-md-3 border-left" style ="background:#ffffff;height: 100%; display: none " >
                    <div class="padding-15">
                        <button class="btn btn-primary btn-block margin-bottom-30">
                            Thông tin {{$scope.isLargeDevice}}
                        </button>
                    </div>
                    <div class="button-as-panel-title">
                        <div ng-repeat="x in ListQueue" class="margin-left-20" style ="margin-bottom: 20px;">
                            <span class="label label-warning">{{x.queueName}}</span>
                            <div id ="queue_switch_true" ng-if="x.chkQueue">
                                <i  class="fa fa-toggle-on on_swicth"  ng-click="lcQueue(x.queueId, x.queueName, x.chkQueue)"></i>
                            </div>
                            <div id ="queue_switch_false" ng-if="!x.chkQueue">
                                <i  class="fa fa-toggle-on fa-rotate-180 off_swicth" ng-click="lcQueue(x.queueId, x.queueName, x.chkQueue)"></i>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>

            <script type="text/ng-template" id ="show_history_message.html">
                <div class="modal-dialog" style ="margin-top:0px;margin-bottom:0px">
                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" ng-click="cancel()">&times;</button>
                <h3 class="modal-title text-center ">{{name_session}}</h3>
                </div>
                <div class="modal-body">
                <div class="row">
                <div class="col-md-12">
                <div class="panel">
                <div class="panel-body">
                <uib-tabset class="tranfer-tabed" active="activeTab">
                <uib-tab>
                <uib-tab-heading>
                <i class="fa fa-user text-red" aria-hidden="true"></i>
                <span class="hidden-xs hidden-sm"> Nội dung</span>
                </uib-tab-heading>
                <div ng-repeat ="message in arrlistMessage">
                <li class="left clearfix" ng-if="message.type === 'SUPERVIOR'" style ="list-style: none">
                <span class="chat-img pull-left">
                <img ng-src="{{message.url}}" alt="Agent Avatar" class="img-circle" style="width: 30px;height: 30px;text-align: center;vertical-align: middle;line-height: 30px;margin-right:5px"/>
                </span>
                <div class="chat-body clearfix">
                <div class="header">
                <strong class="primary-font">{{message.fromName}}</strong> 
                <small class="pull-right text-muted">
                <span class="glyphicon glyphicon-time"></span>{{message.date| date:'dd/MM/yyyy HH:mm:ss'}}
                </small>
                </div>
                <p class ="pull-left customer_chat">
                {{message.content}}
                </p>
                </div>
                </li>
                <li class="left clearfix" ng-if="message.type === 'agent'" style ="list-style: none">
                <span class="chat-img pull-left">
                <img  ng-src="{{message.url}}" alt="Agent Avatar" class="img-circle" style="width: 30px;height: 30px;text-align: center;vertical-align: middle;line-height: 30px;margin-right:5px"/>
                </span>
                <div class="chat-body clearfix">
                <div class="header">
                <strong class="primary-font">{{message.fromName}}</strong> 
                <small class="pull-right text-muted">
                <span class="glyphicon glyphicon-time"></span>{{message.date| date:'dd/MM/yyyy HH:mm:ss'}}
                </small>
                </div>
                <img ng-if="message.typeMessage == 2" style="width:150px;height:100px;" ng-src="{{message.content}}" />
                <p class ="pull-left customer_chat" ng-if="message.typeMessage == 0 || message.typeMessage == 1">
                {{message.content}}
                </p>
                <a ng-if="message.typeMessage == 3" href="{{message.content}}"><img style="width:50px;height:50px;" ng-src="images/users/file.png"></a>
                </div>
                </li>
                <li class="left clearfix" ng-if="message.type === 'customer'" style ="list-style: none">
                <span class="chat-img pull-left">
                <i class="fa fa-user bg-green img-circle" style="width: 30px;height: 30px;text-align: center;vertical-align: middle;line-height: 30px;margin-right:5px"></i>
                </span>
                <div class="chat-body clearfix">
                <div class="header">
                <strong class="primary-font">{{message.fromName}}</strong> 
                <small class="pull-right text-muted">
                <span class="glyphicon glyphicon-time"></span>{{message.date| date:'dd/MM/yyyy HH:mm:ss'}}
                </small>
                </div>
                <img ng-if="message.typeMessage == 2" style="width:150px;height:100px;" ng-src="{{message.content}}" />
                <p class ="pull-left customer_chat" ng-if="message.typeMessage == 0 || message.typeMessage == 1">
                {{message.content}}
                </p>
                <a ng-if="message.typeMessage == 3" href="{{message.content}}"><img style="width:50px;height:50px;" ng-src="images/users/file.png"></a>
                </div>
                </li>
                </div> 
                </div>  
                </div>
                </uib-tab>
                </uib-tabset>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
            </script>
                </div>
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
