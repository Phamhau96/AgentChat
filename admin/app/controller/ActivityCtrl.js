app.controller('activityCtrl', function ($scope, $rootScope, $timeout, mainService) {
    var vm = this;
    vm.openConnectionSocket = openConnectionSocket;
    vm.agentId;
    openConnectionSocket();
    //<editor-fold defaultstate="collapsed" desc="Connect den socket">
    function openConnectionSocket() {
        $rootScope.wsChat = new WebSocket('ws://localhost:8080');
        $rootScope.wsChat.onopen = function (data) {
            var tmp = document.cookie.split('id=')[1];
            vm.agentId = tmp.split(';')[0];
            localStorage.setItem('AgentId', vm.agentId);
            var dataSend = {
                id: vm.agentId,
                'action': 'Login',
                'clientType': 'agent'
            };
            $rootScope.wsChat.send(JSON.stringify(dataSend))

            //get Conversation
            dataSend = {
                id: vm.agentId,
                action: 'GetConversationAgent',
                'clientType': 'agent'
            };
            $rootScope.wsChat.send(JSON.stringify(dataSend));
        };
        $rootScope.wsChat.onmessage = function (data) {
            var id = sessionStorage.getItem('staff_id');
            var dataChat = JSON.parse(data.data);
            switch (dataChat.event) {
                case 'AcceptChat':
                    $rootScope.$broadcast("ACCEPT_CHAT", dataChat);
                    break;
                case 'SendChat':
                    $rootScope.$broadcast("SEND_CHAT_EVENT", dataChat);
                    break;
                case 'GetMessage':
                    var message = dataChat.value.chatSessions;
                    $rootScope.$broadcast("GET_MESSAGE_EVENT", message);
                    break;
                case 'GetConversationAgent':
                    var message = dataChat.value;
                    $rootScope.$broadcast("GET_CONVERSATION_AGENT_EVENT", message);
                    break;
                case 'EndChat':
                    debugger;
                    var message = dataChat.value;
                    $rootScope.$broadcast("END_CHAT", message);
                    break;
                default:

                    break;
            }
        };

        $rootScope.wsChat.onclose = function (data) {

        };

        $rootScope.wsChat.onerror = function (data) {

        };
    }
    //</editor-fold>
});
