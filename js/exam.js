let app = angular.module("myApp", []);
app.controller("myController", ($scope, $http, $interval) => {
    $scope.started = false;
    e_id = document.getElementById("id").innerHTML;
    $http.post("functions/exam.php", {
        'e_id': e_id,
        'q': '',
        'answer': ''
    }).then((response) => {
        if (response.data.status == "ns") {
            $scope.remTime = response.data.time;
            $scope.remDate = response.data.date;
        } else if (response.data.status == "e") {
            $scope.over = true;
        } else if (response.data.status == "s") {
            console.log("Started");
            timeRem = response.data.time;
            getRemainingTime();
            $interval(getRemainingTime, 1000);
            $scope.canStart = true;
        } else if (response.data.status == "na") {
            window.location.replace("index.php");
        }
    }, (error) => {
        console.log(error);
    });
    console.log("running");

    $scope.start = () => {
        if ($scope.started && $scope.question) {
            el = document.getElementsByName("answer");
            for (i = 0; i < el.length; i++) {
                if (el[i].checked) {
                    answer = el[i].value;
                }
            }
        } else {
            answer = '';
        }
        $http.post("functions/exam.php", {
            'e_id': e_id,
            'q': 'ques',
            'answer': answer
        }).then((response) => {
            if (response.data.status == "e") {
                $scope.over = true;
            }
            $scope.id = response.data.Id;
            $scope.question = response.data.Question;
            $scope.option1 = response.data.Option1;
            $scope.option2 = response.data.Option2;
            $scope.option3 = response.data.Option3;
            $scope.option4 = response.data.Option4;
            $scope.done = response.data.Answer;
        }, (error) => {
            console.log(error);
        });
        $scope.started = true;
    }

    $scope.finish = () => {
        window.location.replace("index.php");
    }
    function getRemainingTime() {
        var d = new Date();
        time = timeRem - Math.floor(d.getTime() / 1000);
        h = Math.floor(time / 3600);
        m = Math.floor((time / 60) % 60);
        s = time % 60;
        if (h < 10) h = '0' + h;
        if (m < 10) m = '0' + m;
        if (s < 10) s = '0' + s;
        time = h + ':' + m + ':' + s;
        if (time == '00:00:00')
            window.location.reload();
        $scope.timeLimit = time;
    }

})