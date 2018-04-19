app.controller('activityCtrl', function ($scope, $rootScope, $timeout, mainService) {
    var vm = this;
    vm.openConnectionSocket = openConnectionSocket;

    openConnectionSocket();
    //<editor-fold defaultstate="collapsed" desc="Connect den socket">
    function openConnectionSocket() {
        $rootScope.wsChat = new WebSocket('ws://localhost:8080');
        debugger;
        $rootScope.wsChat.onopen = function (data) {
            var dataSend = {
                'action': 'Login',
                'clientType': 'agent'
            };
            $rootScope.wsChat.send(JSON.stringify(dataSend))
        };
        $rootScope.wsChat.onmessage = function (data) {
            var dataChat = JSON.parse(data.data);
            debugger;
            switch (dataChat.event) {
                case 'JoinEvent':
                    $rootScope.$broadcast("JOIN_EVENT", dataChat);
                    break;
                case 'GetMessage':
                    $rootScope.$broadcast("GET_LIST_AGENT", dataChat);
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
