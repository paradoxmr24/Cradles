<?php 
$role = 'Teacher';
require 'includes/validate.php';
require 'includes/connection.php';
require_once 'includes/format.php';

$url = $_SERVER['SERVER_NAME'] . '/';
if($url == 'localhost/') {
  $url .= 'exam/';
}

function getQuery($table) {
$query = "SELECT * FROM $table";
  $and = false;
  foreach($_POST as $a => $a_value) {
    if($a_value != '') {
      if($and) {
        $query .= ' && ';
      } else {
        $query .= ' WHERE ';
      }
      $query .= "$a = '$a_value' ";
      $and = true;
    }
} 
$query .= ' ORDER BY E_date DESC';
return $query;
}

$connect = connectdb($_SESSION['username']);
$query = getQuery('exams');

$result = mysqli_query($connect,$query);

//------------------- Predefined
$style = 'list.css';
$title = 'Exams';
$js = 'copy.js';
$bjs = 'rtable.js';
?> 

<!---------------------------topbar----------->
<?php include 'includes/topbar.php'; ?>

<!-------------- Body -------------------------------------------------------------->
<div class="container-fluid px-4">
<form method="post" class="my-3 notthis">
  <div class="row">

    <div class="col">
      <input type="text filter" class="form-control" name="Name" placeholder="Name">
    </div>
    <div class="col">
      <input type="text filter" class="form-control" name="Subject" placeholder="Subject">
    </div>
    <div class="col">
      <input type="number filter" class="form-control" name="Class" placeholder="Class">
    </div>
    <div class="col">
      <input type="text filter" class="form-control" name="Section" placeholder="Section">
    </div>
    <div class="col">
      <input type="date" class="form-control" name="E_Date" placeholder="Date">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary form-control">Filter</button>
    </div>
  </div>
</form>

<table class="table table-striped table-responsive-stack" style="color:#000!important;">
  <thead class="thead-light">
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Subject</th>
      <th scope="col">Class</th>
      <th scope="col">Sec</th>
      <th scope="col">Date</th>
      <th scope="col">Time</th>
      <th scope="col">Type</th>
      <th scope="col">Duration</th>
      <th scope="col"></th>
      <th scope="col"></th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td scope="row"><?php echo $row['Id'];?></td>
      <td><?php echo $row['Name']; ?></td>
      <td><?php echo $row['Subject']; ?></td>
      <td><?php echo $row['Class']; ?></td>
      <td><?php echo $row['Section']; ?></td>
      <td><?php echo getFormattedDate($row['E_Date']); ?></td>
      <td><?php echo getFormattedTime($row['E_Time']); ?></td>
      <td><?php echo printType($row['Type']); ?></td>
      <td><?php echo $row['Duration']; ?></td>
      <td><?php formButton('post','questions.php','id',$row['Id'],'btn-primary','View'); ?></td>
<?php if($row['Type'] == 'S') { ?>
      <td><?php formButton('get','copies.php','e_id',$row['Id'],'btn-primary','Check');?></td>
      <td><Button class="btn btn-primary" onclick="copyToClipboard(this)" value="<?php echo $url . 'exam-s.php?id=' . $row['Id']; ?>">Copy</button></td>
<?php } else { ?>
      <td><button class="btn btn-primary text-white" type="submit" disabled>Check</button></td>
      <td><Button class="btn btn-primary" onclick="copyToClipboard(this)" value="<?php echo $url . 'exam.php?id=' . $row['Id']; ?>">Copy</button></td>
<?php } ?>
      <td><?php formButton('post','functions/delete.php','id',$row['Id'],'btn-danger','Delete'); ?></td>
    </tr>
<?php }; ?>
  </tbody>
</table>
</div>
<?php include 'includes/bottom.php'; ?>

