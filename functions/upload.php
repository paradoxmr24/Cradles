<?php

if(!isset($_POST['e_id'])) {
   session_destroy();
   header('location:../login.php');
   exit();
}

require '../includes/connection.php';
require '../includes/log.php';
session_start();
date_default_timezone_set("Asia/Calcutta");
$connect = connectdb($_SESSION['d_name']);

if(checkTime() == 'a') {
   if($_POST['serial'] == 1) initEntry($_POST['e_id']);
   if($_POST['request'] == 'next') {
      clearSkipped($_POST['e_id'], $_POST['serial']);
      postAnswer('done',uploadImage());
   } 
   elseif ($_POST['request'] == 'skip') {
      postAnswer('skip');
   }
}

function clearSkipped($e_id, $q_id) {
   global $connect;
   if(isSkippedQuestion($e_id, $q_id)) {
      $query = "DELETE FROM answers WHERE Student_id = '$_SESSION[username]' && Exam_id = '$e_id' && Answer_id = '$q_id' && Image = 'none'";
      mysqli_query($connect, $query);
   }
}

function isSkippedQuestion($e_id, $q_id) {
   global $connect;
     $query = "SELECT * FROM answers WHERE Student_id = '$_SESSION[username]' && Exam_id = '$e_id' && Answer_id = '$q_id' && Image = 'none'";
     if(mysqli_num_rows(mysqli_query($connect, $query))) {
       return true;
     }
     return false;
}

function postAnswer($action, $file_name = 'none') {
   global $connect;
   if($action == 'done') {
      $query = "INSERT INTO answers VALUES ('$_SESSION[username]','$_POST[e_id]','$_POST[serial]','$file_name','0/$_POST[marks]')";
   } 
   elseif($action == 'skip') {
      $query = "INSERT INTO answers VALUES ('$_SESSION[username]','$_POST[e_id]','$_POST[serial]','$file_name','0/$_POST[marks]')";
   }
   mysqli_query($connect,$query);
}

function uploadImage() {
   $errors= array();
   $file_name = $_FILES['file']['name'];
   $file_size = $_FILES['file']['size'];
   $file_tmp = $_FILES['file']['tmp_name'];
   $file_type = $_FILES['file']['type'];
   $parts = explode('.',$file_name);
   $file_ext = strtolower(end($parts));
   $extensions= array("jpeg","jpg","png");
      
   if(in_array($file_ext,$extensions) === false){
      $errors[]="extension not allowed, please choose a JPEG or PNG file.";
   }

   do{         
      $rand = generateRandomString(29);
      $file_name = 'a' . $rand . '.' . $file_ext;
   } while(file_exists('uploads/' . $file_name));

   move_uploaded_file($file_tmp,"uploads/".$file_name);
   return $file_name;
}


function checkTime() {
   global $connect;
   $query = "SELECT * FROM exams WHERE Id = '$_POST[e_id]'";
   $result = mysqli_fetch_assoc(mysqli_query($connect,$query));
        
   if($result['E_Date'] == date('Y') . '-' . date('m') . '-' . date('d')) {
      if (time() >= strtotime($result['E_Time']) && time() <= (strtotime($result['E_Time']) + toSec($result['Duration'])) ) {
         $data = true;
      }
   } else {
      $data = false;
   }
   return $data;
}

function toSec($a) {
   return $a * 60;
}

function generateRandomString($length) {
   $characters = '0123456789';
   $charactersLength = strlen($characters);
   $randomString = '';
   for ($i = 0; $i < $length; $i++) {
      if($i == 0) {
         $randomString .= $characters[rand(1, $charactersLength - 1)];
      } else {
         $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
   }
   return $randomString;
}

function initEntry($e_id) {
   global $connect;
   $query = "SELECT Questions FROM exams WHERE Id = '$e_id'";
   $result = mysqli_fetch_assoc(mysqli_query($connect,$query));
   $total = '0/' . $result['Questions'];
   $query ="INSERT INTO marks VALUES ('$_SESSION[username]','$e_id','$total',0)";
   mysqli_query($connect,$query);
}
?>