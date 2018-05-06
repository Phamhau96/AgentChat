app.controller('chatCtrl', function ($scope, $rootScope, $timeout, mainService) {
    var url = 'chat.php';
    var vm = this;
    vm.numberCustomer = 1;
    vm.items = [];     //hien thi các conversation
    vm.messages = [];
    vm.hide = true;
    vm.sessionId;
    vm.openSessionChat = openSessionChat;
    vm.doAnswer = doAnswer;
    vm.upLoad = upLoad;
    vm.endChat = endChat;
    var tmp = document.cookie.split('id=')[1];
    vm.id = tmp.split(';')[0];

    function openSessionChat(item) {
        for (var i = 0; i < vm.items.length; i++) {
            if (item.sessionId !== vm.items[i].sessionId) {
                vm.items[i].isselected = false;
            }
        }
        vm.hide = false;
        item.isread = false;
        item.isselected = true;
        vm.sessionId = item.sessionId;
        getMessage();
        conversationIsRead();
        scrollToBottom();
//        $scope.$apply();
    }
    ;
    function getMessage() {
        debugger;
        var msg = {
            'action': 'GetMessage',
            'sessionId': vm.sessionId
        };
        if ($rootScope.wsChat
                && $rootScope.wsChat.readyState === WebSocket.OPEN) {
            $rootScope.wsChat.send(JSON.stringify(msg));
        } else {
            $rootScope.wsChat = new WebSocket('ws://localhost:8080');
            $rootScope.wsChat.send(JSON.stringify(msg));
        }
    }

    function conversationIsRead() {
        var msg = {
            'action': 'ConversationIsRead',
            'sessionId': vm.sessionId
        };
        if ($rootScope.wsChat.readyState !== WebSocket.OPEN) {
            $rootScope.wsChat = new WebSocket('ws://localhost:8080');
        }
        $rootScope.wsChat.send(JSON.stringify(msg));
    }

    function doAnswer(e) {
        if (e.keyCode === 13) {
            e.stopPropagation();
            var message = $("#txtChat").val();
            if ('' !== message.trim('')) {
                var msg = {
                    'action': 'SendChat',
                    'name': 'hau',
                    'msg': message,
                    'clientType': 'agent',
                    'sessionId': vm.sessionId
                };
            }
            $rootScope.wsChat.send(JSON.stringify(msg));

            getMessage();

            $("#txtChat").val('');
            e.preventDefault();
            scrollToBottom();
        }
    }

    function endChat() {
        var msg = {
            action: 'EndChat',
            sessionId: vm.sessionId,
            clientType: 'agent',
            id: vm.id
        };
        vm.sessionId = null;
        $rootScope.wsChat.send(JSON.stringify(msg));
    }
    $rootScope.$on('SEND_CHAT_EVENT', function (event, data) {
        var dataChat = data.value;
        var msg = {
            "sessionId": dataChat.sessionId,
            "from": dataChat.customerId,
            "content": dataChat.msgClient,
            "isread": dataChat.isRead,
            "isselected": false
        };

        for (var i = 0; i < vm.items.length; i++) {
            if (vm.items[i].sessionId === msg.sessionId) {
                vm.items[i].content = msg.content;
                vm.items[i].isread = dataChat.isRead;
            }
        }

        $scope.$apply();
        if (vm.sessionId) {
            conversationIsRead();
            getMessage();
            console.log("Chat session" + vm.sessionId);
        }
        scrollToBottom();
    });

    $rootScope.$on('ACCEPT_CHAT', function (event, data) {
        debugger;
        var dataChat = data.value;
        var item = {
            "sessionId": dataChat.sessionId,
            "from": dataChat.customerId,
            "content": dataChat.msgClient,
            "isread": true,
            "isselected": false
        };
        vm.items.push(item);
        
    });

    $rootScope.$on('GET_CONVERSATION_AGENT_EVENT', function (event, data) {
        vm.items = [];
        for (var i = 0; i < data.length; i++) {
            var item = {
                "sessionId": data[i].sessionId,
                "from": data[i].customerId,
                "content": data[i].msgClient,
                "isread": data[i].isRead,
                "isselected": false
            };
            vm.items.push(item);
        }
        $scope.$apply();
    });

    $rootScope.$on('GET_MESSAGE_EVENT', function (event, data) {
        vm.messages = [];
        for (var i = 0; i < data.length; i++) {
            var msg = {
                agentId: data[i].agentId,
                customerId: data[i].customerId,
                msg: data[i].msgClient,
                sessionId: data[i].sessionId,
                clientType: data[i].clientType
            };
            vm.messages.push(msg);
        }
        $scope.$apply();
        scrollToBottom();
    });

    $rootScope.$on('END_CHAT', function (event, data) {
        var sessionId = data.sessionId;
//        $('.customernumber .' + sessionId).attr('ss-end', 'yes');
        $('.customernumber .' + sessionId + ' a .media-body p').show();
        //cập nhật số lượng khách hàng
//        $('.customernumber .' + sessionId).attr('ss-end', 'yes');
//        $('.customernumber .' + sessionId).click();
    });

    function scrollToBottom() {
//        $timeout(function () {
//            $('#chat_area').scrollTop($('#chat_area')[0].scrollHeight);
//        }, 1000);
        $("#chat_area").stop().animate({scrollTop: $("#chat_area")[0].scrollHeight}, 1000);
    }

    function upLoad() {
        $("#inputfileclient").trigger("click");
    }
    $(document).delegate("#inputfileclient", "change", function (e) {

        var x = $.ajax({
            url: "./service/chat.php",
            type: 'POST',
            success: function (data, textStatus, jqXHR) {

            }
        });
    });
});