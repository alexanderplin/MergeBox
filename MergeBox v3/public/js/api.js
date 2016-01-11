angular.module('apiService', [])
    .factory('api', function($http) {
        return {
            // get all the comments
            getAccounts : function() {
                return $http.get('/api/getAccounts');
            },
            linkAccount : function(service){
                return $http.post('/api/link/'+service);
            },
            getAccountFiles : function(data){
                return $http.post('/api/getAccountFiles', data);
            }
        }
    });
