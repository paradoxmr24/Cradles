<?
session_start();
require_once '../includes/connection.php';
checkData($_POST['e_id'],$_POST['s_id']);
header('location:../studentcontrol.php');
function checkData($e_id,$s_id) {
  $connect = connectdb($_SESSION['username']);
  $query = "SELECT * FROM answers WHERE Student_id='$s_id' && Exam_id='$e_id'";
  $result = mysqli_query($connect,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    echo $row['Answer_id'];
  }
}
?>
<br>
<button onclick="window.location.replace('../studentcontrol.php');">Go Back</button>