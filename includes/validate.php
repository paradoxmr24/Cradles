<?php
session_start();
if(!isset($role) || !(isset($_SESSION['username']) && ($_SESSION['role'] == $role || $role == 'All'))) {
  $loc = 'location:login.php';
  if(isset($isExam)) $loc .= '?id=' . $_GET['id']; 
  session_destroy();
  header($loc);
  exit();
}
?>