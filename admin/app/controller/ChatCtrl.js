app.controller('chatCtrl', function ($scope, $rootScope, $timeout, mainService) {
    var vm = this;
    vm.numberCustomer = 1;
    vm.items = [];
    vm.listChat = [];

    vm.openSessionChat = openSessionChat;

    function openSessionChat(item) {
        debugger;
//        $scope.selfIdUser = $scope.AgentInfo.id;
//        $scope.otherIdUser = parseInt(item.customerId);
//        $scope.emailCustomer = item.email;
//        $scope.$broadcast('eventName', {selfIdUser: $scope.selfIdUser, otherIdUser: $scope.otherIdUser});
//            $(".media-list li").css({"background": "#ffffff"});
//            $("#" + item.id).css({"background": "#e1e6f4"});
        for (var i = 0; i < vm.items.length; i++) {
            if (item.id !== vm.items[i].id) {
                vm.items[i].isselected = false;
            }
        }
        item.isread = false;
        item.isselected = true;
        $('.action-control-end-container').attr('ss-data', item.id);
        $('.action-control-end-container').attr('cus-id', item.customerId);
        $('.action-control-tranfer-container').attr('cus-id', item.customerId);
        $('.action-control-tranfer-container').attr('ss-id', item.id);
        $('.media-list .' + item.id).attr('cus-id', item.customerId);
        $('#users').show();
        $('.chat-content').attr('sessionId', item.id);
        if ($('.media-list .' + item.id).attr('ss-end') == 'yes') {
            $('#submitchat').hide();
        } else {
            $('#submitchat').show();
        }
        togleActionControl(true);
        $(".user-chat").animate({scrollTop: 9999999});

    }
    ;
    function togleActionControl($check) {
        if ($check)
            $('.chat-action-control ').show();
        else
            $('.chat-action-control ').hide();
    }

    $rootScope.$on('GET_LIST_AGENT', function (event, data) {
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
});