<?php 
$role = 'Student';
$isExam = true;
require 'includes/validate.php';
require_once 'includes/connection.php';
$e_id = $_GET['id'];


$useAngular = true;
$js = 'exam.js';
$title = 'Exam';
?>
<?php include 'includes/topbar.php'; ?>

<span style="display:none;!important" id="id"><?php echo $e_id ?></span>
<!-------------- Body -------------------------------------------------------------->
<div class="text-dark card rounded p-3 my-2 mx-md-5 mx-lg-5 mx-2 border-left-primary">
<h4 id="time" class="ml-auto" ng-if="!over">Time Remaining - {{timeLimit}}</h4>
    <div ng-if="started && question">
    <h4 class="font-weight-bold">{{id}}. {{question}}
    <form  class="my-4">
      <div class="row">
        <div class="rounded shadow col-11 m-2 px-3" onclick="document.getElementById('answer1').click();">
        <div class="form-check" >
          <input class="form-check-input" type="radio" name="answer" id="answer1" value="{{option1}}" checked>
          <h4 class="form-check-label" for="answer1">
            {{option1}}
          </h4>
        </div>
</div>
        <div class="rounded shadow col-11 m-2 px-3" onclick="document.getElementById('answer2').click();">
        <div class="form-check" >
          <input class="form-check-input" type="radio" name="answer" id="answer2" value="{{option2}}">
          <h4 class="form-check-label" for="answer2">
            {{option2}}
          </h4>
        </div>
</div>
      </div>
      <div class="row">
        <div class="rounded shadow col-11 m-2 px-3" onclick="document.getElementById('answer3').click();" >
        <div class="form-check" >
          <input class="form-check-input" type="radio" name="answer" id="answer3" value="{{option3}}">
          <h4 class="form-check-label" for="answer3">
            {{option3}}
          </h4>
        </div>
</div>
        <div class="rounded shadow col-11 m-2 px-3" onclick="document.getElementById('answer4').click();">
        <div class="form-check" >
          <input class="form-check-input" type="radio" name="answer" id="answer4" value="{{option4}}">
          <h4 class="form-check-label" for="answer4">
            {{option4}}
          </h4>
        </div>
</div>
      </div>
    </form>
</div></h4>
<h1 ng-if="!started && remDate">
  Exam will start on:<br>
  Date: {{remDate}}<br>
  Time: {{remTime}}
</h1>
<h1 ng-if="over">Exam is Over</h1>

    <button ng-if="canStart && !started" class="btn btn-primary" ng-click="start()">Start</button>
    <div class="text-right">
      <button ng-if="started && question" class="btn btn-primary" ng-click="start()">Next</button>
    </div>
    <button class="btn btn-primary" ng-if="started && !question" ng-click="finish()">Finish</button>

</div>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>
