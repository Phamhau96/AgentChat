var app = angular.module('app', []);

app.controller('uploadCtrl', function ($scope, $rootScope, FileUploader) {
    $scope.data = {};
    $scope.data['type'] = "slide";
    $scope.type = '';
    var uploader = $scope.uploader = new FileUploader({
        url: '/admin/service/upload.php',
        formData: [
            $scope.data
        ],
        queueLimit: 5
    });
    // FILTERS

    uploader.filters.push({
        name: 'customFilter',
        fn: function (item /*{File|FileLikeObject}*/, options) {
            return this.queue.length < 5;
        }
    });
    // CALLBACKS

    uploader.onWhenAddingFileFailed = function (item /*{File|FileLikeObject}*/, filter, options) {
        console.info('onWhenAddingFileFailed', item, filter, options);
    };
    uploader.onAfterAddingFile = function (fileItem) {
        console.info('onAfterAddingFile', fileItem);
    };
    uploader.onAfterAddingAll = function (addedFileItems) {
        console.info('onAfterAddingAll', addedFileItems);
    };
    uploader.onBeforeUploadItem = function (item) {
        $scope.data['type'] = $scope.type;
    };
    uploader.onProgressItem = function (fileItem, progress) {
        console.info('onProgressItem', fileItem, progress);
    };
    uploader.onProgressAll = function (progress) {
        console.info('onProgressAll', progress);
    };
    uploader.onSuccessItem = function (fileItem, response, status, headers) {
        console.info('onSuccessItem', fileItem, response, status, headers);
    };
    uploader.onErrorItem = function (fileItem, response, status, headers) {
        console.info('onErrorItem', fileItem, response, status, headers);
    };
    uploader.onCancelItem = function (fileItem, response, status, headers) {
        console.info('onCancelItem', fileItem, response, status, headers);
    };
    uploader.onCompleteItem = function (fileItem, response, status, headers) {
        $rootScope.$emit('add_image_success', response.file_name);
        uploader.clearQueue();
    };
    uploader.onCompleteAll = function () {
        console.info('onCompleteAll');
    };
    console.info('uploader', uploader);
});

app.factory('mainService', function ($http, $rootScope, $q, $log) {
    var domain = "service/";
    var factory = {};

    factory.doAction = function (data, uri) {
        return  $http({
            url: domain + uri,
            method: "POST",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            data: jQuery.param(data)
        }).then(function (response) {
            return response;
        });
    };
    return factory;
});

app.filter('safeHtml', function ($sce) {
    return function (val) {
        return $sce.trustAsHtml(val);
    };
});

app.directive('stringToNumber', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function (value) {
                return '' + value;
            });
            ngModel.$formatters.push(function (value) {
                return parseFloat(value);
            });
        }
    };
});

app.directive('ngThumb', ['$window', function ($window) {
        var helper = {
            support: !!($window.FileReader && $window.CanvasRenderingContext2D),
            isFile: function (item) {
                return angular.isObject(item) && item instanceof $window.File;
            },
            isImage: function (file) {
                var type = '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        };

        return {
            restrict: 'A',
            template: '<canvas/>',
            link: function (scope, element, attributes) {
                if (!helper.support)
                    return;

                var params = scope.$eval(attributes.ngThumb);

                if (!helper.isFile(params.file))
                    return;
                if (!helper.isImage(params.file))
                    return;

                var canvas = element.find('canvas');
                var reader = new FileReader();

                reader.onload = onLoadFile;
                reader.readAsDataURL(params.file);

                function onLoadFile(event) {
                    var img = new Image();
                    img.onload = onLoadImage;
                    img.src = event.target.result;
                }

                function onLoadImage() {
                    var width = params.width || this.width / this.height * params.height;
                    var height = params.height || this.height / this.width * params.width;
                    canvas.attr({width: width, height: height});
                    canvas[0].getContext('2d').drawImage(this, 0, 0, width, height);
                }
            }
        };
    }]);