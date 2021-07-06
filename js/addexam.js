let app = angular.module("myApp",[]);
app.controller("myController",($scope, $http) => {
    $scope.data={id:'',name:'',subject:'',class:'',section:'A',date:'',time:'',type:'',duration:''};
     $scope.submit = () => {
         buffer('start');
        $scope.data.time = document.getElementById("Time").value;
        $scope.data.id = document.getElementById("Id").value;
        $scope.data.date = document.getElementById("Date").value;
        $http.post("functions/addexam.php",{
            'data':$scope.data
        }).then((response) => {
            buffer('stop');
            if(response.data == "successful") {
                if($scope.data.type == 'O') 
                    window.location.replace("addques.php");
                else 
                    window.location.replace("addques-s.php");
            } else {
                showAlert(response.data);
            }
        },(error) => {
            console.log(error);
        })
     }
     showAlert = (msg) => {
		$scope.alertMsg = msg;
		setTimeout(() => {
			$scope.alertMsg = undefined;
		}, 1);
    }
    buffer = (power) => {
        if(power == 'start') {
          document.getElementById('cover').classList.remove('d-none');
          document.getElementById('buffer').classList.remove('d-none');
          console.log('b-start');
        } 
        else if(power == 'stop'){
          document.getElementById('cover').classList.add('d-none');
          document.getElementById('buffer').classList.add('d-none');
          console.log('b-stop');
        }
    }
});