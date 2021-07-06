<?php 
$role = 'Student';
require 'includes/validate.php';
require_once 'includes/format.php';
require_once 'includes/connection.php';
$title = 'Apply';
$style = 'list.css';
$bjs = 'rtable.js';
?>
<?php include 'includes/topbar.php'; ?>

<!-------------- Body -------------------------------------------------------------->
<?php 
$query = "SELECT * FROM exams WHERE Class = '$_SESSION[class]' and Section = '$_SESSION[section]'";
$result = mysqli_query($connect,$query); ?>
<div class="container-fluid px-4">
<table class="table table-striped table-responsive-stack">
    <thead  class="thead-light">
    <tr>
        <th scope="col">Name</th>
        <th scope="col">Subject</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th scope="col">Type</th>
        <th scope="col">Duration</th>
        <th scope="col">Apply</th>
        </tr>
    </thead>
<?php while($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td scope="row"><?php echo $row['Name'] ?></td>
    <td><?php echo $row['Subject'] ?></td>
    <td><?php echo getFormattedDate($row['E_Date']); ?></td>
    <td><?php echo getFormattedTime($row['E_Time']); ?></td>
    <td><?php echo printType($row['Type']); ?></td>
    <td><?php echo $row['Duration'] ?></td>
    <td><?php if($row['Type'] == 'O') formButton('get','exam.php','e_id',$row['Id'],'btn-primary','Apply'); ?>
    <?php if($row['Type'] == 'S') formButton('get','exam-s.php','e_id',$row['Id'],'btn-primary','Apply'); ?></td>
  </tr>
    <?php } ?>
</table>
</div>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>

