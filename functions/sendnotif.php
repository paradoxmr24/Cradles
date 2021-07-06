<?php
if(!isset($_POST['Sender']))  {
    header('location:../index.php');
    exit();
}
require '../includes/connection.php';
session_start();
$connect = connectdb($_SESSION['username']);
if($_POST['Class'] != '') {
    $_POST['Reciever'] = $_POST['Class'] . '-' . $_POST['Section'];
    echo "not ser";
}
unset($_POST['Class']);
unset($_POST['Section']);
createQuery($connect);
header('location:../sendnotif.php');



function createQuery($connect) {
   $query = "INSERT INTO notification (";
   $_POST['P_date'] = getTodayDate();
   foreach($_POST as $i => $v) {
       $query .= "$i,";
   }
   $query = rtrim($query,',') . ')' . ' VALUES (';
   foreach($_POST as $i => $v) {
       $query .= "'$v',";
   }
   $query = rtrim($query,',') . ')';
   echo $query;
   echo mysqli_query($connect,$query);
}

function getTodayDate() {
    return date('Y') . '-' . date('m') . '-' . date('d');
}
?>