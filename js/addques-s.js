let app = angular.module("myApp",[]);

app.controller("myController",($scope, $http) => {
	$scope.data = {id:1}; 
	dataCount = 4;
	$scope.data.e_id = document.getElementById("e_id").innerHTML;


	$scope.submit = () => {
		if(checkFields()) {
			buffer('start');
		$http.post("functions/addques-s.php",{
			'data':$scope.data
			}).then((response) => {
				buffer('stop');
				console.log('isqowking');
                showAlert(response.data);
                if(response.data == 'Successfully submitted') {
				    clearInputs();
                    $scope.data.id++;
                }
			},(error) => {
				showAlert(error);
			});
		} else {
            showAlert("Fill all the fields");
        }
	}

	$scope.finish = () => {
		window.location.replace("index.php");
	}

//--------------------------------------------- Manmade ;) Functions

	checkFields = () => {
		for (let member in $scope.data) {
			if(!$scope.data[member] || !(Object.keys($scope.data).length == dataCount)) return false;
		}
		return true;
	}

	clearInputs = () => {
		for (let member in $scope.data) {
			if(member != "id" && member != "e_id") {
				$scope.data[member] = undefined;
			}
		}
	}

	showAlert = (msg) => {
		$scope.alertMsg = msg;
		setTimeout(() => {
			$scope.alertMsg = undefined;
		}, 1);
	}

	buffer = (power) => {
		console.log(power);
        if(power == 'start') {
			console.log('rwmoved');
          document.getElementById('cover').classList.remove('d-none');
          document.getElementById('buffer').classList.remove('d-none');
        } 
        else if(power == 'stop'){
          document.getElementById('cover').classList.add('d-none');
          document.getElementById('buffer').classList.add('d-none');
        }
    }
});



/*
showAlert(msg) = shows a alert msg and clears it when some action performed
clearInputs() = undefine all the data in data object;
checkFields() = returns false if any fields is undefined;
*/
