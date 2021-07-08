<?php
session_start();
if(!isset($role) || !(isset($_SESSION['username']) && ($_SESSION['role'] == $role || $role == 'All'))) {
  $loc = 'location:login.php';
  if(isset($isExam)) $loc .= '?e_id=' . $_GET['e_id']; 
  session_destroy();
  header($loc);
  exit();
}
?>