<?php 
$role = 'Teacher';
require_once 'includes/validate.php';
require_once 'includes/connection.php';
require_once 'includes/format.php';

$query = getQuery('exams');

function getQuery($table) {
$query = "SELECT students.Name,exams.Name AS E_Name,exams.Subject,exams.Class,exams.Section,exams.E_Date,exams.E_Time,exams.Type,exams.Duration,marks.Marks FROM students INNER JOIN marks INNER JOIN exams ON marks.Student_id = students.Username && exams.Id = marks.Exam_id && marks.Checked = '1'";
  foreach($_POST as $a => $a_value) {
    $a = str_replace('_','.',$a);
    if($a_value != '') {
        $query .= ' && ';
      $query .= "$a = '$a_value' ";
    }
} 
return $query;
}
//echo $query;
$connect = connectdb($_SESSION['username']);
//$query = "SELECT students.Name,exams.Name AS E_Name,exams.Subject,exams.Class,exams.Section,exams.E_Date,exams.E_Time,exams.Type,exams.Duration,marks.Marks FROM students INNER JOIN marks INNER JOIN exams ON marks.Student_id = students.Username && exams.Id = marks.Exam_id && marks.Checked = '1'";
$result = mysqli_query($connect,$query);


$title = 'Result';
$style='list.css';
$bjs = 'rtable.js';
?>
<?php include 'includes/topbar.php'; ?>

<!-------------- Body -------------------------------------------------------------->
<div class="container-fluid px-4">
<form method="post" class="my-3">
  <div class="row">

    <div class="col">
      <input type="text" class="form-control" name="students.Name" placeholder="Name">
    </div>
    <div class="col">
      <input type="text" class="form-control" name="exams.Name" placeholder="Exam Name">
    </div>
    <div class="col">
      <input type="text" class="form-control" name="exams.Subject" placeholder="Subject">
    </div>
    <div class="col">
      <input type="number" class="form-control" name="exams.Class" placeholder="Class">
    </div>
    <div class="col">
      <input type="text" class="form-control" name="exams.Section" placeholder="Section">
    </div>
    <div class="col">
      <input type="date" class="form-control" name="exams.E_Date" placeholder="Date">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary form-control">Filter</button>
    </div>
  </div>
</form>

<table  class="table table-striped table-responsive-stack">
  <thead  class="thead-light">
      <th scope="col"> Student</th>
    <th scope="col">Exam Name</th>
    <th scope="col">Subject</th>
    <th scope="col">Class</th>
    <th scope="col">Section</th>
    <th scope="col">Date</th>
    <th scope="col">Time</th>
    <th scope="col">Type</th>
    <th scope="col">Duration</th>
    <th scope="col">Marks</th>
  </thead>
  <tbody>
<?php while($row = mysqli_fetch_assoc($result)) { 
  ?>
    <tr>
      <td scope="row"><?php echo $row['Name']; ?></td>
      <td><?php echo $row['E_Name']; ?></td>
      <td><?php echo $row['Subject']; ?></td>
      <td><?php echo $row['Class']; ?></td>
      <td><?php echo $row['Section']; ?></td>
      <td><?php echo getFormattedDate($row['E_Date']); ?></td>
      <td><?php echo getFormattedTime($row['E_Time']); ?></td>
      <td><?php echo printType($row['Type']); ?></td>
      <td><?php echo $row['Duration']; ?></td>
      <td><?php echo $row['Marks'] ?></td>
    </tr>
<?php } ?>
  </tbody>
</table>
</div>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>

