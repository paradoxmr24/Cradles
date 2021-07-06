<?php 
$role = 'Admin';
require 'includes/validate.php';
require_once 'includes/connection.php';

$useAngular = true;
$js = 'mastersignup.js';
$title = 'Master SignUp';
?>

<?php include 'includes/topbar.php'; ?>

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
    <div class="col-6">
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" ng-model="data.username">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" ng-model="data.name">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" ng-model="data.password">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>School</label>
            <input type="text" class="form-control" ng-model="data.school">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Address</label>
            <input type="text" class="form-control" ng-model="data.address">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Phone</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">+91</span>
                </div>
                <input type="text" class="form-control" ng-model="data.phone">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Mail</label>
            <input type="text" class="form-control" ng-model="data.mail">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Plan (in months)</label>
            <input type="number" class="form-control" ng-model="data.plan">
        </div>
    </div>
</div>
        <button class="btn btn-primary form-control my-2" ng-click="submit()">Submit</button>
    </form>
</section>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>