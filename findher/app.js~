/**
 *
 * @auther wangshuo16@baidu.com
 */

var fhCtrl = angular.module('findHerCtrl', []);

var allData = {};

fhCtrl.controller('peopleListCtrl', ['$scope', '$http', function ($scope, $http) {

    $http.get('data.json').success(function (data) {
        allData = data;
        $scope.people = allData['female'];
    });
    $scope.getData = function (gender) {
        $scope.people = allData[gender];
        $scope.gender = gender;
    };
    $scope.gender = 'female';

}]);

fhCtrl.controller('pdetailCtrl', ['$scope', '$routeParams', '$http', function ($scope, $routeParams, $http) {

    var gender = $routeParams.gender;
    var personId = $routeParams.personId;

    if (!allData) {
        var allData = {};
        $http.get('data.json').success(function (data) {
            allData = data;
            $scope.person = allData[gender][personId];
        });
    }
    else {
        $scope.person = allData[gender][personId];
    }

}]);


var fhApp = angular.module('findHerApp', ['ngRoute', 'findHerCtrl']);

fhApp.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
        .when('/index', {
            templateUrl: 'tpl/main.html',
            controller: 'peopleListCtrl'
        }).when('/index/:gender/:personId', {
            templateUrl: 'tpl/detail.html',
            controller: 'pdetailCtrl'
        }).otherwise({
            redirectTo: '/index'
        });
}]);




