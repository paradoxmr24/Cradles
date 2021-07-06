<?php 
$role = 'Teacher';
require 'includes/validate.php';
include_once 'includes/connection.php';
$useAngular = true;
$title = 'Add Exam';
$style = 'loader.css';
$js = 'addexam.js';
include 'includes/topbar.php'; 
?>
<!-------------- Body -------------------------------------------------------------->
<section class="card rounded p-3 my-2 mx-5 border-left-primary">
  <div class="alert alert-warning alert-dismissible fade show" role="alert" ng-if="alertMsg">
      {{alertMsg}}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <form>
    <div class="row">
      <div class="form-group col-lg-6 col-md-6 col-12">
        <label>Id</label>
        <input type="text" id="Id" value="<?php echo getRandomString(6); ?>" class="form-control" disabled>
      </div>
      <div class="form-group col-lg-6 col-md-6 col-12">
        <label>Type</label>
        <select class="custom-select" id="Type" placeholder="Select" ng-model="data.type">
          <option value="S">Subjective</option>
          <option value="O">Objective</option>
        </select>
      </div>
      <div class="form-group col-lg-6 col-md-6 col-12">
        <label>Name</label>
        <input type="text" id="Name" class="form-control" ng-model="data.name">
      </div>
      <div class="form-group col-lg-6 col-md-6 col-12">
        <label>Subject</label>
        <input type="text" id="Subject" class="form-control" ng-model="data.subject">
      </div>
      <div class="form-group col-lg-6 col-md-6 col-12">
        <label>Class</label>
        <input type="number" id="Class" class="form-control" ng-model="data.class">
      </div>
      <div class="form-group col-lg-6 col-md-6 col-12">
        <label>Section</label>
        <input type="text" id="Section" class="form-control" ng-model="data.section">
      </div>
      <div class="form-group col-lg-4 col-md-4 col-12">
        <label>Date</label>
        <input type="date" id="Date" class="form-control">
      </div>
      <div class="form-group col-lg-4 col-md-4 col-12">
        <label>Time</label>
        <input type="time" id="Time" class="form-control">
      </div>
      <div class="form-group col-lg-4 col-md-4 col-12">
        <label>Duration</label>
        <input type="number" id="Duration" class="form-control" placeholder="Minutes" ng-model="data.duration">
      </div>
      <div class="col-12">
        <button class="form-control btn btn-primary mt-4" ng-click="submit()">Submit</button>
      </div>
    </div>  
  </form>
</section>
<div class="loader d-none" id="buffer"></div>
<div id="cover" class="d-none"></div>
<script>
  console.log('working');
</script>
<!-------------- Footer ------------------------------------------------------------>
<?php include 'includes/bottom.php'; 
function generateRandomString($length) {
  $characters = '0123456789';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      if($i == 0) {
        $randomString .= $characters[rand(1, $charactersLength - 1)];
      } else {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
  }
  return $randomString;
}
function getRandomString($length) {
  for(;;) {
    $rand = generateRandomString($length);
    $connect = connectdb($_SESSION['username']);
    $query = "SELECT Id FROM exams WHERE Id = BINARY '$rand'";
      if(!mysqli_num_rows(mysqli_query($connect,$query))) {
        break;
      }
    }
    return $rand;
}
?>