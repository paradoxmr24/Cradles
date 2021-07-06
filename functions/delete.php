<?php 
if(!isset($_POST['id'])) {
    header('location:../login.php');
    exit();
}
require '../includes/connection.php';
$id = $_POST['id'];
session_start();
$connect = connectdb($_SESSION['username']);

    //-------Delete Entry from exams table
    $query = "DELETE FROM exams WHERE Id = '$id'";
    if(mysqli_query($connect,$query)) {
        echo "Deleted " . $id;
        //--------------Delete questions table
        $query = "DROP TABLE `$id`";
        mysqli_query($connect,$query);
        //---------------Delete entry from marks table
        $query = "DELETE FROM marks WHERE Exam_id = '$id'";
        mysqli_query($connect,$query);
        //---------------Delete images from uploads folder
        $query = "SELECT Image FROM answers WHERE Exam_id = '$id'";
        $result = mysqli_query($connect,$query);
        while($row = mysqli_fetch_assoc($result)) {
            unlink('uploads/' . $row['Image']);
            echo $row['Image'];
        }
        //---------------Delete entries from answers table
        $query = "DELETE FROM answers WHERE Exam_id = '$id'";
        mysqli_query($connect,$query);
        header('location:../exams.php');
    } else {
        echo 'Cannot delete';
    }

?>