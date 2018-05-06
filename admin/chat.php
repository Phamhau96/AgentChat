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
        <link href="include/css/Agent.css" rel="stylesheet" type="text/css"/>
        <link href="include/css/Comment.css" rel="stylesheet" type="text/css"/>
        <link href="include/css/facebook.css" rel="stylesheet" type="text/css"/>
        <link href="include/css/Post.css" rel="stylesheet" type="text/css"/>
        <script src="app/controller/ChatCtrl.js" type="text/javascript"></script>
    </head>
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
                <!--start Panel Chat-->
                <div class="panel panel-white no-radius no-margin no-padding no-border col-md-3 " perfect-scrollbar wheel-propagation="true" suppress-scroll-x="true"style ="background:#ffffff; height: 500px!important">
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
                        <li  id="{{item.sessionId}}" class="{{item.sessionId}}" 
                             ng-repeat="item in chat.items" 
                             class="media border-bottom" 
                             style ="position: relative;height: 80px; background-color: {{item.isselected == true ? '#e1e6f4' : item.isread == true ? '#ffcccc' : '#fff' }}" 
                             ng-click="chat.openSessionChat(item)" ct-toggle="on" target="users">
                            <a>
                                <i class=" menu-icon fa fa-user bg-green text-green img-circle img-responsive media-object" style="line-height:3;text-align: center;width:40px;margin-top: 14px;"></i>
                                <div class="media-body" style ="position: absolute; top: 15px;left: 50px;">
                                    <h5 class="media-heading" ng-bind="item.from | limitTo:15" ng-bind="item.from.length > 15 ? '...' : ''"></h5>
                                    <span ng-bind="item.content | limitTo:25" ng-bind="item.content.length > 25 ? '...' : ''"></span>
                                    <p  style="color:red; display: none;">Phiên chat đã kết thúc!</p>
                                </div>  
                            </a>
                        </li>
                    </ul>

                </div>

                <uib-tabset class="tabbable" active="activeTab">
                    <!-- start #panel-message-->
                    <uib-tab select="tabSelected(this)">
                        <uib-tab-heading>
                            <i class="fa fa-weixin text-green" aria-hidden="true"></i>
                            <span class="hidden-xs hidden-sm">Cua so Chat</span>
                        </uib-tab-heading>
                        <div class="col-md-9 padding-left-0 padding-right-0 border-right fill-height"  id="panel-message">
                            <div id="message_list">            
                                <div class="fill-height">                
                                    <!--<div class="ng-scope padding-top-10">-->
                                    <div class="row">  
                                        <div  class="col-md-12">
                                            <div class="row" style="margin: 5px;">
                                                <div perfect-scrollbar  wheel-propagation="true" suppress-scroll-x="true"  class="col-md-12" id="chat_area">
                                                    <div class="chat_area margin-left-10" style="overflow-x: hidden; overflow-y: auto;">
                                                        <ul class="list-unstyled " >
                                                            <span
                                                                ng-repeat="item in chat.messages"> 
                                                                <li class="admin_chat" ng-if="item.clientType == 'agent'">
                                                                    <div class="row fb-row">                                                       
                                                                        <div class="col-md-12">
                                                                            <div class="chat-body1 pull-right">
                                                                                <p>
                                                                                    {{item.msg}}
                                                                                </p> 
                                                                                <img style="max-width: 250px" src="./images/agent.png" class="img-rounded">  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>  
                                                                <li class="customer_chat" ng-if="item.clientType == 'customer'">
                                                                    <div class="row fb-row">                                                       
                                                                        <div class="col-md-12">
                                                                            <div class="chat-body1 pull-left">
                                                                                <p>
                                                                                    {{item.msg}}
                                                                                </p> 
                                                                                <img style="max-width: 250px" src="./images/customer.png" class="img-rounded">  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>  
                                                            </span>
                                                        </ul>
                                                    </div>
                                                    <!--chat_area-->
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="message_write">
                                                        <div class="chat_bottom dropup" disabled>
                                                            <a 
                                                                href="#" class="pull-left upload_btn" 
                                                                ng-click="chat.upLoad()"
                                                                title="Upload file">
                                                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                                            </a>     
                                                            <input type="file" accept=".rar,.xlsx,.xls,.gif,.png,.jpg,.jpeg,.doc, .docx,.ppt, .pptx,.txt,.pdf,.xlsb" style="display:none;" id="inputfileclient" name="uploadfile">

                                                            <a 
                                                                href="#" class="pull-left upload_btn" 
                                                                ng-click="chat.endChat();"
                                                                title="End Chat">
                                                                <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                                                            </a> 
                                                        </div>
                                                        <textarea 
                                                            id="txtChat"
                                                            class="form-control"
                                                            placeholder="Nhập nội dung" 
                                                            ng-keypress="chat.doAnswer($event)"
                                                            ng-disabled="chat.hide"
                                                            autofocus
                                                            ></textarea>   
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                    <!--</div>-->
                                </div> 
                            </div>

                        </div>
                    </uib-tab>
                    <!-- end panel-message-->

                    <!-- start #panel-history-->
                    <uib-tab>
                        <uib-tab-heading>
                            <i class="fa fa-history text-red" aria-hidden="true"></i>
                            <span class="hidden-xs hidden-sm"> Lịch sử chat</span>
                        </uib-tab-heading>

                        <div class="form-group " >

                            <div class="form-group margin-top-10" style="display: inline-flex">
                                <input class="form-control width-180 " type="text" id="date_agent_value"
                                       ng-model="date_agent_value"/>
                                <div class="" style="margin-left: 2%">
                                    <button class="btn btn-primary radius-5" id="view_history" onclick="" ng-click="getHistoryChat();" type="button" style="width: 72px" tooltip-placement="top" uib-tooltip="Xem"> <i class="ti-search"></i> </button>
                                </div> 
                            </div>
                            <script>
                                        $.datetimepicker.setLocale('vi');
                                        $('#date_agent_value').datetimepicker({
                                            format: 'd/m/Y',
                                            timepicker: false
                                        });
                                        $('#date_agent_value').focus(function () {
                                            this.blur();
                                        });</script>                                   
                        </div>
                        <div class="clearfix"></div>

                        <div class="table-responsive" >
                            <table class="table table-bordered table-hover active"  ng-table="tableParams"  id="sample-table-1">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th><i class="fa fa-times-circle-o"></i> Thời gian </th>
                                        <th>Tên khách hàng</th>
                                        <th>Email</th>
                                        <th>Kênh hỗ trợ</th>
                                        <th>Trạng thái</th>
                                        <th>Xem lịch sử</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="hist in lstGetHistoryAgent">
                                        <td>{{hist.stt}}</td>
                                        <td>{{hist.startTimeStr}}</td>
                                        <td>{{hist.customerName}}</td>
                                        <td>{{hist.email}}</td>                                                
                                        <td>{{hist.queueName}}</td>
                                        <td>
                                            <span ng-if = "hist.status === 1 || hist.status === 2 || hist.status === 6">Không trả lời</span>
                                            <span ng-if = "hist.status === 3 || hist.status === 5">Trả lời</span>
                                        </td>
                                        <td>
                                            <span ng-if = "hist.status === 3 || hist.status === 5">
                                                <a class="fa fa-history text-red" aria-hidden="true" ng-click="getHistoryFromXml(hist.sessionId)"></a>
                                            </span> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div>
                                <font size="4px" color="red"><span ng-bind="messageNotSearch"></span></font>
                            </div>
                        </div>

                    </uib-tab>
                    <!-- end panel-history-->
                </uib-tabset>
            </div>
            <!-- /.content-wrapper -->
            <?php

            function upFile() {
                //duong dan tam cho file
                $file_path = $_FILES['uploadfile']['tmp_name'];
                //ten file
                $file_name = $_FILES['uploadfile']['name'];
                //kieu file
                $file_type = $_FILES['uploadfile']['type'];
                //kich thuoc file
                $file_size = $_FILES['uploadfile']['size'];
                //thong bao loi trong qua trinh upload
                $file_error = $_FILES['uploadfile']['error'];
                //new duong dan moi
                $file_new = "admin/upload/" . $file_name;

                move_uploaded_file($file_path, $file_new);

                return $file_name;
            }
            ?>

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
