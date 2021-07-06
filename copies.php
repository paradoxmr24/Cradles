<?php 
$role = 'Teacher';
require 'includes/validate.php';
require 'includes/connection.php';
$e_id = $_GET['e_id'];
$connect = connectdb($_SESSION['username']);

$style = 'list.css';
$title = 'Copies';
$bjs = 'rtable.js';
?>
<?php include 'includes/topbar.php'; ?>

<!-------------- Body -------------------------------------------------------------->
<?php 
$query = "SELECT marks.Student_id,students.Name FROM marks INNER JOIN students ON marks.Student_id = students.Username && marks.Exam_id = '$e_id' && marks.Checked = '1'";
$noChecked = mysqli_num_rows(mysqli_query($connect,$query));
$query = "SELECT marks.Student_id,students.Name FROM marks INNER JOIN students ON marks.Student_id = students.Username && marks.Exam_id = '$e_id' && marks.Checked = '0'";
$result = mysqli_query($connect,$query);
$noUnchecked = mysqli_num_rows($result);
?>
<div class="row">
  <div class="col">
    <div class="card rounded p-3 my-2 mx-5 border-left-primary">
      <h4>
        Checked Copies = <?php echo $noChecked; ?>
        <form method="post" action="checkedcopies.php">
          <input name="e_id" style="display:none;!important" value="<?php echo $e_id; ?>">
          <input name="s_id" style="display:none;!important" value="<?php echo $row['Student_id']; ?>">
          <button class="btn btn-primary text-white" type="submit">View</button>
        </form>
      </h4>
    </div>
    <div class="card rounded p-3 my-2 mx-5 border-left-primary">
      <h4>
        Unchecked Copies = <?php echo $noUnchecked; ?>
      </h4>
    </div>
    <div class="card rounded p-3 my-2 mx-5 border-left-primary">
      <h4>
        Total Copies = <?php echo $noChecked + $noUnchecked; ?>
      </h4>
    </div>
</div>
<div class="card rounded p-3 my-2 mx-5 border-left-primary col">
<table  class="table table-striped table-responsive-stack">
  <thead class="thead-light">
      <th scope="col"> Student</th>
      <th scope="col"> Check </th>
  </thead>
  <tbody>
<?php while($row = mysqli_fetch_assoc($result)) { 
  ?>
    <tr>
      <td scope="row"><?php echo $row['Name']; ?></td>
      <td>
      <form method="post" action="check-s.php">
  <input name="e_id" style="display:none;!important" value="<?php echo $e_id; ?>">
  <input name="s_id" style="display:none;!important" value="<?php echo $row['Student_id']; ?>">
  <button class="btn btn-primary text-white" type="submit">Check</button>
  </form>
      </td>
    </tr>
<?php } ?>
  </tbody>
</table>
</div>
      </div>

<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>
