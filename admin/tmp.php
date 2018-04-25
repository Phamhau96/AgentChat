<%--
Document   : AgentChat
Created on : May 9, 2017, 8:47:16 AM
Author     : hieuhd
--%>

<%@page import="java.util.List"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<script src="chat/controller/chat/AgentChatController.js" type="text/javascript"></script>
<script src="chat/service/chat/AgentChatService.js" type="text/javascript"></script>
<script src="chat/service/MyProfile_Service.js" type="text/javascript"></script>
<script src="chat/service/chat/DistributeQueueService.js" type="text/javascript"></script>
<script src="chat/service/chat/HistoryMessageService.js" type="text/javascript"></script>
<script src="static/css/datetimepicker-master/build/jquery.datetimepicker.full.min.js"></script>
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


    /* Modal Content (image) */
    .modal-contentimg {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content, #caption {    
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: red;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }


    ul {
        list-style-type: none;
    }
    li {
        list-style-type: none;
    }
    .message-bar {
        background: wheat;
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
    .endchat{
        padding: 0 10px;
        vertical-align: middle;
        margin-top: 12px;
    }
    .tab-pane.ng-scope:first-child{
        background: rgba(230, 229, 229, 0.43);
    }
</style>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>Agent</title>
        <link href="chat/css/Agent.css" rel="stylesheet" type="text/css"/>
        <script src="static/js/service/fileUpload_Service.js" type="text/javascript"></script>
        <script src="static/js/service/Administrartors/quickAnswer/TemplateAnswerService.js" type="text/javascript"></script>
    </head>
    <body style="height: 2000px;" >
        <div ct-fullheight data-ct-fullheight-exclusion="header, footer">
            <div class ="col-md-12" id="inbox" style="height: 100%;padding-top: 31px;padding-bottom: 15px;" ng-controller="AgentChatCtrl">
                <div class="col-md-3 wrap-list border-right" style ="background:#ffffff;height:100%">
                    <ul style ="padding-top: 20px;padding-left: 20px;">
                        <li style="text-align: center;">
                            <a>
                                <span class="title"><i class="fa fa-user-md text-large"></i> Khách hàng</span>
                                <span class="badge pull-right" id="badgedanger">{{numberCustomer}}</span>
                            </a>
                        </li>
                        <hr>
                    </ul>
                    <!--                    <ul class="sidebar-menu" id="ulId" style ="margin-top: -20px;">
                                            <a>
                                            <li class="messages-item {{message.id}} border-bottom" ng-click="onclickMsg(message.id, message.from, message.subject, message.customerId)" ng-class="{starred: message.starred}" ng-repeat="message in messages| orderBy: 'date':true | filter:filters | filter:inbox.search"  >
                                                <a message-item="{{message.id}}">
                                                    <i class=" menu-icon fa fa-user bg-green text-green img-circle img-responsive" style="line-height:3;text-align: center;width:40px"></i>
                                                    <span class="messages-item-from">{{ message.from| limitTo:15}}{{message.from.length>15 ? '...':''}}</span>
                                                                                    <div class="messages-item-time">
                                                                                        <span class="text">{{ message.date | date: "MM/dd/yyyy h:mm:ss" }}</span>
                                                                                    </div>
                                                    <div class="messages-item-content" style="margin-left: 45px;">{{ message.content | htmlToPlaintext | words:15 :true |limitTo:25}}{{message.content.length>25 ? '...':''}}</div>
                                                </a>
                                            </li>
                                            </a>
                                        </ul>-->
                    <ul class="customernumber" id="listCustomerChat" style="padding-left: 0;
                        list-style: none;" >
                        <li  id="{{item.id}}" class="{{item.id}}"  ng-repeat="item in items" class="media border-bottom" style ="display: block;height: 90px; background-color: {{item.isselected == true ? '#e1e6f4' : item.isread == true ? '#ffcccc' : '#fff' }}" ng-click="openSessionChat(item)" ct-toggle="on" target="users">
                            <!--<i class="fa fa-circle status-online"></i>-->
                            <!--<img alt="..." src="static/images/avatar-2.jpg" class="media-object img-circle">-->
                            <div style="position: relative;">
                                <!--<p style="float: right; margin-right: 5px; color: black;">{{item.date}}</p>-->
                                <a>
                                    <i class=" menu-icon fa fa-user bg-green text-green img-circle img-responsive media-object" style="line-height:3;text-align: center;width:40px;margin-top: 21px;"></i>
                                    <div class="media-body" style ="position: absolute; top: 15px;left: 50px;">
                                        <h5 class="media-heading" ng-bind="item.from | limitTo:15" ng-bind="item.from.length > 15 ? '...':''"></h5>
                                        <h6 class="media-heading">Nhóm: {{item.queuename}}</h6>
                                        <span ng-bind="item.typemessage == 3 ? 'đã gửi 1 file' : item.typemessage == 2 ? 'đã gửi 1 ảnh' : item.content | limitTo:25" ng-bind="item.content.length > 25 ? '...':''" ></span>
                                        <p  style="color:red; display: none;">Phiên chat đã kết thúc!</p>
                                    </div>  
                                </a>
                            </div>
                        </li>
                    </ul>

                </div>

                <div  class="row col-md-9" style="height: 100%;">
                    <div class="panel panel-white no-radius" >
                        <div class="panel-body">
                            <uib-tabset class="tabbable" active="activeTab">
                                <div class="chat-action-container">
                                    <!--ui-->
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
                                        <i class="fa fa-weixin text-green" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">{{emailCustomer}}</span>
                                    </uib-tab-heading>
                                    <div id="users"  toggleable active-class="chat-open" ng-controller="AgentChatCtrlChild">
                                        <div class="user-chat" style ="height:483px;overflow: auto;" toggleable active-class="chat-open"  >
                                            <div id="chatchatchat" class="chat-content" sessionId>
                                                <!--<a class="sidebar-back pull-left" href="#" ct-toggle="off" target="users"><i class="ti-angle-left"></i> <span translate="offsidebar.chat.BACK">Back</span></a>-->
                                                <div class="sidebar-content" id="off-chat" >
                                                    <clip-chat messages="chat" id-self="selfIdUser" id-other="otherIdUser"></clip-chat>
                                                </div>                                               
                                            </div>
                                        </div>
                                        <!--<chat-submit class="margin-top-10" submit-function="sendMessage" ng-model="chatMessage" scroll-element="#off-chat"></chat-submit>-->


                                        <div ng-submit="submitChatform()" class="margin-top-10 ng-valid ng-isolate-scope ng-dirty ng-submitted ng-empty" submit-function="sendMessage" ng-model="chatMessage" scroll-element="#off-chat" style="" id="submitchat">
                                            <div class="message-bar" >
                                                <div class="message-inner">
                                                    <div style="display: table-row-group;">
                                                        <input type="file" id="file1" name="image" accept=".rar,.xlsx,.xls,.gif,.png,.jpg,.jpeg,.doc, .docx,.ppt, .pptx,.txt,.pdf,.xlsb" file-model="myFile"  ng-file-select="upload($files)"  style="display:none" >
                                                        <a class="link icon-only" title="đính kèm file"><i class="fa fa-paperclip" id="upfile1" style="cursor:pointer"></i></a>
                                                        <a class="link icon-only" title="ticket">
                                                            <i ng-click="openCrm()"  class="fa fa-pencil-square" style="cursor:pointer"
                                                               ></i>
                                                        </a>
                                                        <div style="display: -webkit-box">
                                                            <%
                                                            List lstPerCodeAgentChat = (List) session.getAttribute("lstPerCodeAgentChat");
                                                            if (lstPerCodeAgentChat != null && lstPerCodeAgentChat.size() > 0 && lstPerCodeAgentChat.contains("KTC")) {
                                                            %>
                                                            <a class="link icon-only endchat" ng-click="agentEndChat()" title="kết thúc chat"><i class="fa fa-close"  style="cursor:pointer"></i></a>
                                                            <%                                            }
                                                            if (lstPerCodeAgentChat != null && lstPerCodeAgentChat.size() > 0 && lstPerCodeAgentChat.contains("TRANC")) {
                                                            %>
                                                            <li title="Chuyển chat" style="
                                                                color: #8e8e93;
                                                                font-size: 20px;
                                                                margin: 0;
                                                                margin-right: 8px;
                                                                padding: 0 10px;
                                                                line-height: 44px;
                                                                position: relative;
                                                                display: table-cell;
                                                                width: 30px;
                                                                vertical-align: middle;
                                                                "class="dropup">
                                                                <span class="tranferchat" ng-click="tranferchatbyAgent()" data-toggle="dropdown">
                                                                    <i class="fa fa-share-square-o" ></i></span>
                                                                <div class="dropdown-menu dropdown-menu-left" style="width: auto">
                                                                    <uib-tabset class="tranfer-tabed" active="activeTab">
                                                                        <uib-tab>
                                                                            <uib-tab-heading>
                                                                                <i class="fa fa-user text-red" aria-hidden="true"></i>
                                                                                <span class="hidden-xs hidden-sm"> Agent</span>
                                                                            </uib-tab-heading>

                                                                            <div class="table-responsive">
                                                                                <table class="table table-bordered table-hover agent-transfer-table" id="sample-table-1">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <td>STT</td>
                                                                                            <td>Agent ID</td>
                                                                                            <td>Name</td>
                                                                                            <td>Status</td>
                                                                                            <td>Queue</td>
                                                                                            <td>Lựa chọn</td>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr ng-repeat="x in listAgentDisplay" >    
                                                                                            <td>{{$index + 1}} </td>
                                                                                            <td>{{x.agentId}}</td>
                                                                                            <td>{{x.userName}}</td>
                                                                                            <td>{{x.aiStatus}}</td>
                                                                                            <td>{{x.queueName}}</td>
                                                                                            <td class="text-center">
                                                                                                <input type="radio" name = "chooseAgent" ng-click ="sendAgentIdTranfer(x.agentId)" ng-model="agentIdTranfer" value ="agentIdTranfer" style="height: 25px">
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <label>
                                                                                Ghi chú cho agent
                                                                            </label>
                                                                            <div class="form-group">
                                                                                <textarea class="form-control note-transfer-agent"  cols="10" rows="5"></textarea>
                                                                            </div>
                                                                            <div class="form-group margin-bottom-0">
                                                                                <button class="btn btn-o btn-primary radio-transfer-agent"  ng-click="tranferChatAsk(agentIdTranfer)">
                                                                                    Đồng ý
                                                                                </button>
                                                                                <button class="btn btn-sm btn-default btn-squared"  type="reset">
                                                                                    Hủy
                                                                                </button>
                                                                            </div>
                                                                        </uib-tab>
                                                                    </uib-tabset>
                                                                </div>
                                                            </li>
                                                            <%                                            }
                                                            %>
                                                        </div>
                                                        <div  class="linksend ng-scope">

                                                            <span  class="dropup" title="mẫu hỏi nhanh"   style="margin-right: 3px; font-size: 20px;">
                                                                <span ng-click="quickquestions()" data-toggle="dropdown" ><i class="fa fa-question" style="cursor:pointer"></i></span>

                                                                <div class="dropdown-menu">


                                                                    <table class="table" id="tablequickreply">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Tiêu đề</th>
                                                                                <th>Nội dung</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr ng-repeat="quickReply in quickReplys" ng-click="opencontent(quickReply.content)">
                                                                                <td>{{quickReply.title}}</td>
                                                                                <td>{{quickReply.content}}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                            </span>

                                                            <!--                                                            <a  translate="offsidebar.chat.SEND" href="#" style="display: none;"  ng-click="submitChat()">Send</a>-->
                                                        </div>
                                                    </div>
                                                    <form>
                                                        <div class="message-area">
                                                            <textarea rows="1"
                                                                      ng-disabled="{{isdisabled}}"
                                                                      id="inputmessage" placeholder="Nhập tin nhắn" ng-model="chatMessage" ng-keyup="$event.keyCode === 13 && submitChat()"  class="ng-valid ng-dirty ng-empty ng-touched" style=""></textarea>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </uib-tab>
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
                                <!--                                <uib-tab>
                                                                    <uib-tab-heading>
                                                                        <i class="fa fa-ticket text-yellow" aria-hidden="true"></i>
                                                                        <span class="hidden-xs hidden-sm"> Tạo ticket</span>
                                                                    </uib-tab-heading>
                                                                    <p>
                                                                        <strong> Đang cập nhật...^_^ </strong>
                                                                    </p>
                                                                </uib-tab>-->

                            </uib-tabset>
                        </div>
                    </div>
                </div>



                <div class="col col-md-3 border-left" style ="background:#ffffff;height: 100%; display: none " >
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
                </div>
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
        <!-- end: MESSAGES -->

    </body>
</html>
