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
                <!--                <div  class="row col-md-9" style="height: 100%;">
                                    <div class="panel panel-white no-radius" >
                                        <div class="panel-body">
                                            <uib-tabset class="tabbable" active="activeTab">
                                                <div class="chat-action-container">
                                                    ui
                                                    <div id="myModal" style="margin-top: 50px;  display: none; /* Hidden by default */
                                                         position: fixed; /* Stay in place */
                                                         z-index: 1; /* Sit on top */
                                                         padding-top: 100px; /* Location of the box */
                                                         left: 0;
                                                         top: 0;
                                                         width: 100%; /* Full width */
                                                         height: 100%; /* Full height */
                                                         overflow: auto; /* Enable scroll if needed */
                                                         background: wheat;
                                                         opacity: 0.9;" class="modal">
                                                        <span ng-click="closeimage()" class="close" style="font-size: 50px;">x</span>
                                                        <img class="modal-contentimg" id="img01">
                                                        <div id="caption"></div>
                                                    </div>
                                                </div>
                                                <uib-tab select="tabSelected(this)"  >
                                                    <uib-tab-heading>
                                                        <i class="fa fa-weixin text-green" aria-hidden="true">Truc Chat</i>
                                                        <span class="hidden-xs hidden-sm">{{emailCustomer}}</span>
                                                    </uib-tab-heading>
                                                    <div id="users"  toggleable active-class="chat-open" ng-controller="AgentChatCtrlChild">
                                                        <div class="user-chat" style ="height:483px;overflow: auto;" toggleable active-class="chat-open"  >
                                                            <div id="chatchatchat" class="chat-content" sessionId>
                                                                <div class="sidebar-content" id="off-chat" >
                                                                    <clip-chat messages="chat" id-self="selfIdUser" id-other="otherIdUser"></clip-chat>
                                                                </div>                                               
                                                            </div>
                                                        </div>
                                                        <div ng-submit="submitChatform()" class="margin-top-10 ng-valid ng-isolate-scope ng-dirty ng-submitted ng-empty" submit-function="sendMessage" ng-model="chatMessage" scroll-element="#off-chat" style="" id="submitchat">
                                                            <div class="message-bar" >
                                                                <div class="message-inner">
                                                                    <div style="display: table-row-group;">
                                                                        <input type="file" id="file1" name="image" accept=".rar,.xlsx,.xls,.gif,.png,.jpg,.jpeg,.doc, .docx,.ppt, .pptx,.txt,.pdf,.xlsb" file-model="myFile"  ng-file-select="upload($files)"  style="display:none" >
                                                                        <a class="link icon-only" title="đính kèm file"><i class="fa fa-paperclip" id="upfile1" style="cursor:pointer"></i></a>
                                                                        <div style="display: -webkit-box">
                                                                            <a class="link icon-only endchat" ng-click="agentEndChat()" title="kết thúc chat"><i class="fa fa-close"  style="cursor:pointer"></i></a>
                                                                        </div>
                                                                        <div  class="linksend ng-scope">
                                                                        </div>
                                                                    </div>
                                                                    <form>
                                                                        <div class="message-area">
                                                                            <textarea rows="1"
                                                                                      id="inputmessage" placeholder="Nhập tin nhắn" ng-model="chatMessage" ng-keyup="$event.keyCode === 13 && submitChat()"  class="ng-valid ng-dirty ng-empty ng-touched" style=""></textarea>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </uib-tab>
                                            </uib-tabset>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                <!-- start #panel-message-->
                <uib-tab>
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
                                                    <div class="chat_area margin-left-10">
                                                        <ul class="list-unstyled " >
                                                            <span
                                                                ng-repeat="item in chat.messages"> 
                                                                <li class="admin_chat" ng-if="item.clientType=='agent'">
                                                                    <div class="row fb-row">                                                       
                                                                        <div class="col-md-12">
                                                                            <div class="chat-body1 pull-right">
                                                                                <p>
                                                                                    {{item.msg}}
                                                                                </p> 
                                                                                <!--<img style="max-width: 250px" ng-src="{{item.attachments}}" class=" img-rounded" alt="">-->  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>  
                                                                <li class="customer_chat" ng-if="item.clientType=='customer'">
                                                                    <div class="row fb-row">                                                       
                                                                        <div class="col-md-12">
                                                                            <div class="chat-body1 pull-left">
                                                                                <p>
                                                                                    {{item.msg}}
                                                                                </p> 
                                                                                <!--<img style="max-width: 250px" ng-src="{{item.attachments}}" class=" img-rounded" alt="">-->  
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
                                                        <textarea 
                                                            id="txtChat"
                                                            class="form-control"
                                                            placeholder="Nhập nội dung" 
                                                            ng-keypress="chat.doAnswer($event)"
                                                            ng-disabled="chat.hide"
                                                            autofocus
                                                            ></textarea>   
                                                        <div class="chat_bottom dropup" >
                                                            <span style="margin-left: 40px "> 
                                                                <img  
                                                                    style="width:30px; height: 30px; margin-left: 3px" 
                                                                    ng-repeat="item in conversationCtrl.attachments" 
                                                                    ng-src="{{item.thumbnail}}"  
                                                                    ng-click="conversationCtrl.removeAttachment(item)">
                                                            </span>

                                                            <span style="margin-left: 40px "> 
                                                                <img  ng-repeat="item in attach_files" ng-src="{{item.icon}}"  style="width:30px; height: 30px; margin-left: 3px" ng-click="remove_file($index)">
                                                            </span>
                                                            <a 
                                                                href="#" class="pull-left upload_btn" 
                                                                ng-click="conversationCtrl.openModal('attach_image')">
                                                                <i class="fa fa-image" aria-hidden="true">
                                                                </i>
                                                                Hình ảnh
                                                            </a>    
                                                            <a 
                                                                href="#" class="pull-left upload_btn" 
                                                                ng-click="conversationCtrl.openModal('attach_file')">
                                                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                                                Tập tin
                                                            </a>                                                                    
                                                            <a 
                                                                href="#" class="pull-left upload_btn dropdown-toggle mp-can-disabled" 
                                                                ng-disabled="true"
                                                                data-toggle="dropdown">
                                                                <i class="fa fa-list" aria-hidden="true"></i>
                                                                Tin nhắn mẫu
                                                            </a> 
                                                            <ul id="haha" class="dropdown-menu">
                                                                <span ng-repeat="item in conversationCtrl.template_answer">
                                                                    <li 
                                                                        ng-click="conversationCtrl.appendTemplateAnswer(item)"
                                                                        style="padding: 10px">
                                                                        <a href="">{{item.content}}</a>
                                                                    </li>
                                                                    <li class="divider" ng-if="$index < conversationCtrl.template_answer.length - 1"></li>
                                                                </span>
                                                            </ul>
                                                        </div>   
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
