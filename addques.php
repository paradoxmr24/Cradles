<?php 
$role = 'Teacher';
require 'includes/validate.php';
require_once 'includes/connection.php';

if(!isset($_SESSION['e_id'])) {
  header('location:addexam.php');
  exit();
}
$examId = $_SESSION['e_id'];
unset($_SESSION['e_id']);

$useAngular = true;
$js = 'addques.js';
$title = 'Add Questions';
?>
<?php include 'includes/topbar.php'; ?>

<!-------------- Body -------------------------------------------------------------->

<div class="card rounded p-3 my-2 mx-5 border-left-primary">
  <h4>Exam Id: <span id="e_id"><?php echo $examId;?></span></h4>
    <div class="alert alert-warning alert-dismissible fade show" role="alert" ng-if="alertMsg">
      {{alertMsg}}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form>
      <div align="right">Id:<span class="badge badge-primary p-2">{{data.id}}</span></div>
      <div class="form-group">
        <label>Question</label>
        <input type="text" class="form-control" ng-model="data.question">
      </div>
  
      Options:
      <div class="row">

        <div class="col-lg-6 col-md-6 col-12 my-2">

            <input type="text" class="form-control" ng-model="data.option1">

        </div>
        <div class="col-lg-6 col-md-6 col-12 my-2">
          
            <input type="text" class="form-control" ng-model="data.option2">
          
        </div>
        <div class="col-lg-6 col-md-6 col-12 my-2">
          
            <input type="text" class="form-control" ng-model="data.option3">
          
        </div>
        <div class="col-lg-6 col-md-6 col-12 my-2">
          
            <input type="text" class="form-control" ng-model="data.option4">
         
        </div>
        <div class="col-12 my-2">
        Answer:
          <select class="custom-select mr-sm-2" ng-model="data.answer">
            <option value="1" ng-show="data.option1">{{data.option1}}</option>
            <option value="2" ng-show="data.option2">{{data.option2}}</option>
            <option value="3" ng-show="data.option3">{{data.option3}}</option>
            <option value="4" ng-show="data.option4">{{data.option4}}</option>
          </select>
          <button class="form-control btn btn-primary mt-3" ng-click="submit()">Add Question</button>
          <button class="form-control btn btn-primary my-3" ng-click="finish()">Finish</button>
        </div>
      </div>
    </form>
</div>

<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>
