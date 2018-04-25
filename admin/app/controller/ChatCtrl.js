app.controller('chatCtrl', function ($scope, $rootScope, $timeout, mainService) {
    var vm = this;
    vm.numberCustomer = 1;
    vm.items = [];     //hien thi các conversation
    vm.listChat = [];
    vm.messages = [];
    vm.hide = true;
    vm.sessionId;
    vm.openSessionChat = openSessionChat;
    vm.doAnswer = doAnswer;

    function openSessionChat(item) {
        for (var i = 0; i < vm.items.length; i++) {
            if (item.id !== vm.items[i].id) {
                vm.items[i].isselected = false;
            }
        }
        vm.hide = false;
        item.isread = false;
        item.isselected = true;
        vm.sessionId = item.sessionId;
        getMessage();
        scrollToBottom();
    }
    ;
    function getMessage() {
        var msg = {
            'action': 'GetMessage',
            'sessionId': vm.sessionId
        };
        $rootScope.wsChat.send(JSON.stringify(msg));
    }
    function doAnswer(e) {
        debugger;
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
    $rootScope.$on('SEND_CHAT_EVENT', function (event, data) {
        debugger;
        var dataChat = data.value;
        var msg = {
            "sessionId": dataChat.sessionId,
            "from": dataChat.customerId,
            "content": dataChat.msgClient,
            "isread": true,
            "isselected": false
        };
        for (var i = 0; i < vm.listChat.length; i++) {
            if (vm.listChat[i].sessionId === msg.sessionId) {
                vm.listChat[i].listMsg.push(msg);
            }
        }

        for (var i = 0; i < vm.items.length; i++) {
            if (vm.items[i].sessionId === msg.sessionId) {
                vm.items[i].content = msg.content;
            }
        }

        $scope.$apply();
        getMessage();
        scrollToBottom();
    });

    $rootScope.$on('JOIN_EVENT', function (event, data) {
        debugger;
        var dataChat = data.value;
        var msg = {
            "sessionId": dataChat.sessionId,
            "listMsg": []
        };

        var item = {
            "sessionId": dataChat.sessionId,
            "from": dataChat.customerId,
            "content": dataChat.msgClient,
            "isread": true,
            "isselected": false
        };
        var yes = false;
        for (var i = 0; i < vm.items.length; i++) {
            if (vm.items[i].sessionId === msg.sessionId) {
                yes = true;
            }
        }
        if (!yes) {
            vm.items.push(item);
            vm.listChat.push(msg);
        }
    });

    $rootScope.$on('GET_CONVERSATION_AGENT_EVENT', function (event, data) {
        debugger;
        for (var i = 0; i < data.length; i++) {
            var item = {
                "sessionId": data[i].sessionId,
                "from": data[i].customerId,
                "content": data[i].msgClient,
                "isread": true,
                "isselected": false
            };
            vm.items.push(item);
        }
        $scope.$apply();
    });

    $rootScope.$on('GET_MESSAGE_EVENT', function (event, data) {
        debugger;
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

    function scrollToBottom() {
        debugger;
        $timeout(function () {
            $('#chat_area').scrollTop($('#chat_area')[0].scrollHeight);
        }, 1000);
    }
});