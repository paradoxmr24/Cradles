let app = angular.module("myApp",[]);

app.controller("myController",($scope,$http,$interval) => {

    $scope.started = false;

    e_id = document.getElementById("id").innerHTML;

    $http.post("functions/exam-s.php",{

        'skipped':false,

        'e_id':e_id,

        'q':'',

        'answer':''

    }).then((response) => {

        if(response.data.status == "ns") {

            $scope.remTime = response.data.time;

            $scope.remDate = response.data.date;

        } else if(response.data.status == "e") {

            $scope.over = true;

        } else if(response.data.status == "s") {

            console.log("Started");

            timeRem = response.data.time;

            getRemainingTime();

            $interval(getRemainingTime, 1000);

            $scope.canStart = true;

        } else if(response.data.status == "na") {

            window.location.replace("index.php");

        }

    },(error) => {

        console.log(error);

    });

    console.log("running");



    $scope.start = () => {

        if($scope.serial > 0) {

        document.getElementById('buffer').classList.remove('d-none');
        document.getElementById('cover').classList.remove('d-none');

        }

        skipped = document.getElementById('skipped').innerHTML;

        $http.post("functions/exam-s.php",{

            'skipped': skipped,

            'e_id':e_id,

            'q':'ques',

        }).then((response)=> {

            if(response.data.status == "e") {

                $scope.over = true;

            }

            $scope.id = response.data.Id;

            $scope.question = response.data.Question;

            $scope.serial = response.data.count;

            $scope.marks = response.data.Marks;

            $scope.showingSkip = response.data.showingSkip;

            if(document.getElementById('skipped').innerHTML > 0) {

                console.log("skipped stop");

                document.getElementById('buffer').classList.add('d-none');
                document.getElementById('cover').classList.add('d-none');

            }

            document.getElementById('skipped').innerHTML = false;

        },(error) => {

            console.log(error);

        });

     

        $scope.started = true;

    }



    $scope.finish = () => {

        window.location.replace("index.php");

    }

    function getRemainingTime() {

        var d = new Date();

        time = timeRem - Math.floor(d.getTime()/1000);

        h = Math.floor(time/3600);

        m = Math.floor((time/60)%60);

        s = time%60;

        if(h<10) h = '0' + h;

        if(m<10) m = '0' + m;

        if(s<10) s = '0' + s;

        time = h + ':' + m + ':' + s;

        if(time == '00:00:00')

            window.location.reload('index.php');

        $scope.timeLimit = time;

    }  

})