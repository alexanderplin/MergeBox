/**
 * INSPINIA - Responsive Admin Theme
 *
 */

/**
 * MainCtrl - controller
 */
var debug = true;
// console.log only when debug is true
function log(object){
    if(debug){
        console.log(object);
    }
}
// reduces the data into a collapsed to a single row and column format
function reduce(data, f){
    var temp = [];
    data.forEach(function (file) {
        file.content.forEach(function (v) {
            temp.push({
                name: v.name,
                kind: v.kind,
                path: v.path,
                size: v.size,
                index: file.index,
                service: file.service,
                type: file.type
            });
        });
        if (typeof f == "function") f(temp); else log('meh');
    });
}

function MainCtrl() {
    this.userName = 'Example user';
    this.helloText = 'Welcome in SeedProject';
    this.descriptionText = 'It is an application skeleton for a typical AngularJS web app. You can use it to quickly bootstrap your angular webapp projects and dev environment for these projects.';
};
function navigationCtrl() {
	this.menu = [
        {
            name: 'Accounts',
            url: 'index.main',
            icon: 'fa fa-laptop',
            level: [
                {
                    service: 'Dropbox'
                },
                {
                    service: 'Google Drive'
                },
                {
                    service: 'Box'
                }
            ]
        },
        {
            name: 'Link Accounts',
            url: 'index.linkaccounts',
            icon: 'fa fa-link'
        },
        {
            name: 'Account Information',
            url: 'index.accountinformation',
            icon: 'fa fa-bar-chart-o'
        },
        {
            name: 'Account Settings',
            url: 'index.accountsettings',
            icon: 'fa fa-gear'
        }
    ];
};
function LinkAccountsCtrl($scope, $window, api){
    $scope.linkAccount = function(service) {
        api.linkAccount(service)
            .success(function(url){
                $window.location.replace(url);
            })
    }
};
function TableAccountsCtrl($scope, $http, api) {
    $scope.loading = true;
    $scope.load = false;
    $scope.accounts = [];
    $scope.currentActive = [];
    $scope.files=[{}];

    api.getAccounts()
        .success(function (data) {
            $scope.accounts = data;
            console.log(data);
            $scope.loading = false;
        })
        .error(function (data, status) {
            console.error('Repos error', status, data);
        })
        .finally(function () {
            log("getAccounts function ended");
        });

    $scope.click = function () {
        $scope.load = true;
        $scope.currentActive = [];
        // gets the current active accounts
        $('tr.active').each(function () {
            $scope.currentActive.push($(this).data("index"));
        });

        $scope.files = [{}];
        // get the file of the requested accounts
        api.getAccountFiles($scope.currentActive)
            .success(function(data){
                reduce(data, function(result){
                    $scope.files = result;
                })
            })
            .finally(function() {
                $scope.load = false;
            });
    };
};
angular
    .module('inspinia')
    .controller('MainCtrl', MainCtrl)
	.controller('navigationCtrl', navigationCtrl)
    .controller('TableAccountsCtrl', ['$scope','$http','api', TableAccountsCtrl])
    .controller('LinkAccountsCtrl', ['$scope', '$window', 'api', LinkAccountsCtrl])