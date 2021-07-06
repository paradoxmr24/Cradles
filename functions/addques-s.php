<?php
$rdata = json_decode(file_get_contents("php://input"));
if(!$rdata) {
    header('location:../login.php');
    exit();
}
require '../includes/connection.php';
session_start();
$error;
$data;
sleep(3);
if(validation($rdata) && saveData($data)) {
    echo 'Successfully submitted';
    
} else {
    echo $error;
}



//---------------------------------functions---------------------------------------------
function saveData($data) {
    global $error;
    $connect = connectdb($_SESSION['username']);
    if($data['id'] == 1) {
        $query = "CREATE TABLE `$data[e_id]` (
            Id INTEGER(3),
            Question VARCHAR(1000),
            Marks INTEGER(3),
            PRIMARY KEY (Id)
        )";
        mysqli_query($connect,$query);
    };
    $query = "INSERT INTO `$data[e_id]` VALUES ('$data[id]'," . '"' . "$data[question]" . '"' . ",'$data[marks]')";
    $ret = mysqli_query($connect,$query);
    if($ret) {
        $query = "SELECT Questions FROM exams WHERE Id = '$data[e_id]'";
        $result = mysqli_fetch_assoc(mysqli_query($connect,$query));
        $result['Questions'] += $data['marks'];
        $query = "UPDATE exams SET Questions='$result[Questions]' WHERE Id = '$data[e_id]'";
        mysqli_query($connect,$query);
    }
    return $ret;
}

function validation($rdata) {
    global $error, $data;
    if(!isValid($rdata->data->question, 1000, 'Question')) {
        return false;
    }
    $data['id'] = $rdata->data->id;
    $data['question'] = $rdata->data->question;
    $data['e_id'] = $rdata->data->e_id;
    $data['marks'] = $rdata->data->marks;
    return true;
}

function isValid($value,$lh,$name) {
    global $error;
    if(!(strpos($value,'"') === false)) {
        $error = $name . ' cannot contain double quotes' . strpos($value,'"');
        return false;
    }
    if(strlen($value) > $lh) {
        $error = $name . ' should be less than ' . $lh . ' characters long';
        return false;
    } else {
        return true;
    }
}
?>