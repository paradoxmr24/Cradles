<?
session_start();
require_once '../includes/connection.php';
resetData($_POST['e_id'],$_POST['s_id']);
header('location:../studentcontrol.php');
function resetData($e_id,$s_id) {
  $connect = connectdb($_SESSION['username']);
  $query = "DELETE FROM marks WHERE Student_id='$s_id' && Exam_id='$e_id'";
  mysqli_query($connect,$query);
  $query = "SELECT Image FROM answers WHERE Student_id='$s_id' && Exam_id='$e_id'";
  $result = mysqli_query($connect,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    unlink('uploads/' . $row['Image']);  
  }
  $query = "DELETE FROM answers WHERE Student_id='$s_id' && Exam_id='$e_id'";
  mysqli_query($connect,$query);
}
?>