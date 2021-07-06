<?php 
$role = 'Teacher';
require 'includes/validate.php';
require 'includes/connection.php';
$connect = connectdb($_SESSION['username']);
$query = getQuery('students');

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
  return $query;
  }
$result = mysqli_query($connect,$query);

$title = 'Students';
$style='list.css';
$bjs = 'rtable.js';
?>
<?php include 'includes/topbar.php'; ?>

<!-------------- Body -------------------------------------------------------------->
<div class="container-fluid px-4">
<form method="post" class="notthis my-3">
  <div class="row">
    <div class="col">
      <input type="text" class="form-control" name="Name" placeholder="Name">
    </div>
    <div class="col">
      <input type="number" class="form-control" name="Class" placeholder="Class">
    </div>
    <div class="col">
      <input type="text" class="form-control" name="Section" placeholder="Section">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary form-control">Filter</button>
    </div>
  </div>
</form>
<table class="table table-striped table-responsive-stack">
  <thead class="thead-light">
    <tr>
      <th scope="col">Username</th>
      <th scope="col">Name</th>
      <th scope="col">Class</th>
      <th scope="col">Section</th>
      <th scope="col">Phone</th>
      <th scope="col">Mail</th>
    </tr>
  </thead>
  <tbody>
<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td scope="row"><?php echo $row['Username'];?></td>
      <td><?php echo $row['Name']; ?></td>
      <td><?php echo $row['Class']; ?></td>
      <td><?php echo $row['Section']; ?></td>
      <td><?php echo $row['Phone']; ?></td>
      <td><?php echo $row['Mail']; ?></td>
<?php } ?>
  </tbody>
</table>
</div>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>

