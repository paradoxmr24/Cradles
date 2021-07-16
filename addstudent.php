<?php 
$role = 'Teacher';
require 'includes/validate.php';
require_once 'includes/connection.php';

$useAngular = true;
$js = 'addstudent.js';
$title = 'Add Student';
$bjs = 'copy.js';
?>
<?php include 'includes/topbar.php'; ?>

<!-------------- Body -------------------------------------------------------------->
<div class="card my-2 mx-5 rounded shadow p-3 border-left-primary">
  <div class="alert alert-warning alert-dismissible fade show" role="alert" ng-if="alertMsg">
    {{alertMsg}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <pre class="d-none" id="copy">Username - {{data.username}} 
  Password - {{data.password}}</pre>
    <form class="py-3">
        <div class="row">
          <div class="form-group col-6">
            <label>Username</label>
            <input type="text" class="form-control" ng-model="data.username">
          </div>
        <div class="form-group col-6">
          <label>Name</label>
          <input type="text" class="form-control" ng-model="data.name">
        </div>
        </div>
        <div class="row">
        <div class="form-group col-6">
          <label>Class</label>
          <input type="text" class="form-control" ng-model="data.class">
        </div>
        <div class="form-group col-6">
          <label>Section</label>
          <input type="text" class="form-control" ng-model="data.section">
        </div>
        </div>
        <div class="row">
          <div class="form-group col-6">
            <label>Phone</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">+91</span>
                </div>
                <input type="text" class="form-control" ng-model="data.phone">
            </div>
        </div>
        <div class="form-group col-6">
          <label>Mail</label>
          <input type="text" class="form-control" ng-model="data.mail">
        </div>
        </div>
        <div class="row">
        <div class="form-group col-6">
          <label>Password</label>
          <input type="text" class="form-control" ng-model="data.password">
        </div>
        <div class="form-group col-6">
          <label style="color: transparent"> 0</label>
        <button ng-click="submit()" class="form-control btn btn-primary" onclick="copyToClipboarda(document.getElementById('copy'));">Sign Up</button>
        </div></div>

    </form>
</div>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>
