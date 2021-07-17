<?php 
$role = 'Student';
require 'includes/validate.php';
require_once 'includes/connection.php';
$connect = connectdb($_SESSION['d_name']);
$query = "SELECT exams.Id,exams.Name,exams.Subject,exams.E_Date,exams.E_Time,exams.Type,exams.Duration,marks.Marks FROM marks INNER JOIN exams WHERE exams.Id = marks.Exam_id && marks.Student_id = '$_SESSION[username]' && marks.Checked = '1'";
$result = mysqli_query($connect,$query);

function getFormattedDate($date) {
  $date = $date[8] . $date[9] . '/' . $date[5] . $date[6] . '/' . $date[0] . $date[1] . $date[2] . $date[3];
  return $date;
}

function getFormattedTime($time) {
  $time_h = $time[0] . $time[1];
  $m = 'AM';
  if($time_h > 11) {
  $m = 'PM';
  $time_h -= 12;
  } 
  $time = $time_h . ':' . $time[3] . $time[4] . ' ' . $m;
  return $time;
}

$style = 'list.css';
$title = 'Marks';
$bjs = 'rtable.js';
?>
<?php include 'includes/topbar.php'; ?>

<!-------------- Body -------------------------------------------------------------->
<div class="container-fluid px-4">
<table  class="table table-striped table-responsive-stack ">
  <thead  class="thead-light">
    <th scope="col">Exam Name</th>
    <th scope="col">Subject</th>
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
      <td><?php echo $row['Subject']; ?></td>
      <td><?php echo getFormattedDate($row['E_Date']); ?></td>
      <td><?php echo getFormattedTime($row['E_Time']); ?></td>
      <td><?php echo $row['Type']; ?></td>
      <td><?php echo $row['Duration']; ?></td>
      <td><?php echo $row['Marks'] ?></td>
      <td>
        <form method="post" action="answersheet-s.php">
          <input name="e_id" style="display:none;!important" value="<?php echo $row['Id']; ?>">
          <input name="s_id" style="display:none;!important" value="<?php echo $_SESSION['username']; ?>">
          <button class="btn btn-primary text-white" type="submit">View</button>
        </form>
      </td>
    </tr>
<?php } ?>
  </tbody>
</table>
</div>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>
