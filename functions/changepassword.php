<?php
session_start();
if(!isset($_POST['oldpassword']) || !isset($_SESSION['username'])) {
    header('location:../login.php');
    exit();
}
require '../includes/connection.php';
require_once '../includes/encrypt.php';
if($_SESSION['role'] == 'Teacher' || $_SESSION['role'] == 'Admin') {
    $connect = connectdb('admin');
    $db = 'logindata';    
}
if($_SESSION['role'] == 'Student') {
    $connect = connectdb($_SESSION['d_name']);
    $db = 'students';
}
    $query = "SELECT Password FROM $db WHERE Username = '$_SESSION[username]'";
    $result = mysqli_fetch_assoc(mysqli_query($connect, $query));
if($_POST['oldpassword'] == decrypt_this($result['Password'])) {
    $pass = encrypt_this($_POST['newpassword']);
    $query = "UPDATE $db SET Password='$pass' WHERE Username = '$_SESSION[username]'";
    mysqli_query($connect, $query);
    $_SESSION['status'] = 'Password changed';
    header('location:../login.php');
} else {
    $_SESSION['status'] = 'Old password is wrong';
    header('location:../changepassword.php');
}
?>