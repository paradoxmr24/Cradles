<?php

date_default_timezone_set('Asia/Calcutta');

function addlog($exam,$type,$message) {

$name = $_SESSION['username'];

$class = $_SESSION['class'];

$connect = connectdb($_SESSION['d_name']);

$query = "SELECT Subject FROM exams WHERE Id='$exam'";

$result = mysqli_fetch_assoc(mysqli_query($connect,$query));

$subject = $result['Subject'];

$t = date('Y-m-d H:i:s');

$query = "INSERT INTO log VALUES ('$name','$class','$exam','$subject','$type','$message','$t','0')";

if(!mysqli_query($connect,$query)) {

    echo 'Error hl';

}

}

?>