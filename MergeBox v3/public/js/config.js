/**
 * INSPINIA - Responsive Admin Theme
 *
 * Inspinia theme use AngularUI Router to manage routing and views
 * Each view are defined as state.
 * Initial there are written state for all view in theme.
 *
 */
function config($stateProvider, $urlRouterProvider, $ocLazyLoadProvider) {
    $urlRouterProvider.otherwise("/index/main");

    $ocLazyLoadProvider.config({
        // Set to true if you want to see what and when is dynamically loaded
        debug: false
    });

    $stateProvider
        .state('index', {
            abstract: true,
            url: "/index",
            templateUrl: "/views/common/content.html",
        })
        .state('index.main', {
            url: "/main",
            templateUrl: "/views/main.html",
            data: { pageTitle: 'Example view' },
            resolve: {
                loadPlugin: function ($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        {
                            serie: true,
                            files: ['/js/plugins/dataTables/jquery.dataTables.js','/css/plugins/dataTables/dataTables.bootstrap.css']
                        },
                        {
                            serie: true,
                            files: ['/js/plugins/dataTables/dataTables.bootstrap.js']
                        },
                        {
                            name: 'datatables',
                            files: ['/js/plugins/dataTables/angular-datatables.min.js']
                        },
                        {
                            serie: true,
                            files: ['/js/api.js']
                        }
                    ]);
                }
            }
        })
        .state('index.linkaccounts', {
            url: "/linkaccounts",
            templateUrl: "views/linkaccounts.html",
            data: { pageTitle: 'Link Accounts' }
        })
		.state('index.accountinformation', {
            url: "/accountinformation",
            templateUrl: "views/accountinformation.html",
            data: { pageTitle: 'Account Information' }
        })
		.state('index.accountsettings', {
            url: "/accountsettings",
            templateUrl: "views/accountsettings.html",
            data: { pageTitle: 'Account Settings' }
        })
}
angular
    .module('inspinia')
    .config(config)
    .run(function($rootScope, $state) {
        $rootScope.$state = $state;
    });
