    let app = angular.module("myApp",[]);
    app.controller("myController", ($scope, $http) => {
        $scope.data = {username:'',name:'',password:'',school:'',address:'',phone:'',mail:'',plan:''};
        $scope.submit = () => {
            
            $http.post("functions/mastersignup.php", {
                'data':$scope.data
            }).then((response) => {
                showAlert(response.data);
            }, (error) => {
                showAlert(error);
            });
        }
        showAlert = (msg) => {
            $scope.alertMsg = msg;
            setTimeout(() => {
                $scope.alertMsg = undefined;
            }, 1);
        }
    });