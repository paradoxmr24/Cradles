let app = angular.module("myApp",[]);
app.controller("myController",($scope,$http) => {
    $scope.data = {username:'',name:'',class:'',section:'A',phone:'',mail:'',password:''};
    $scope.submit = () => {
        $http.post("functions/addstudent.php",{
            'data':$scope.data
        }).then((response) => {
            showAlert(response.data);
            if(response.data == 'successful')
                window.location.replace("students.php");
        }, (error) => {
            console.log(error);
        })
    }

    showAlert = (msg) => {
		$scope.alertMsg = msg;
		setTimeout(() => {
			$scope.alertMsg = undefined;
		}, 1);
	}
})