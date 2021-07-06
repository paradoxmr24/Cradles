<?php 
$role = 'Teacher';
require 'includes/validate.php';
if(!isset($_SESSION['e_id'])) {
  header('location:addexam.php');
  exit();
}
$examId = $_SESSION['e_id'];
unset($_SESSION['e_id']);
require_once 'includes/connection.php';
$useAngular = true;
$js = 'addques-s.js';
$style = 'loader.css';
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
        <textarea type="text" class="form-control" ng-model="data.question"></textarea>
      </div>
      <div class="form-group">
        <label>Marks</label>
        <input type="number" class="form-control" ng-model="data.marks">
      </div>
  

          <button class="form-control btn btn-primary mt-3" ng-click="submit()">Add Question</button>
          <button class="form-control btn btn-primary my-3" ng-click="finish()">Finish</button>
        
      </div>
    </form>
</div>
<div class="loader d-none" id="buffer"></div>
<div id="cover" class="d-none"></div>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>

