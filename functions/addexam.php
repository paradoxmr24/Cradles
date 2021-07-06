<?php
$rdata = json_decode(file_get_contents("php://input"));
if(!$rdata) {
    header('location:../login.php');
    exit();
}
require '../includes/connection.php';
session_start();
$connect = connectdb($_SESSION['username']);
$data;
$error;
if(validation($rdata)) {
    saveData($data);
    echo 'successful';
} else {
    echo $error;
}




//--------------------------------------------functions-----------------------------------------------
function validation($rdata) {
    global $error, $data;
    if(!isValid($rdata->data->type, 1, 1, '/^[OS]+$/','Type', 'should be O for objective and S for subjective')) {
        return false;
    }
    if(!isValid($rdata->data->name, 5, 20, '/^[a-zA-Z0-9 ]+$/','Name', 'should be alphanumeric only')) {
        return false;
    }
    if(!isValid($rdata->data->subject, 1, 15, '/^[a-zA-Z0-9 ]+$/','Subject', 'should be alphanumeric only')) {
        return false;
    }
    if(!isValid($rdata->data->class, 1, 2, '/^[0-9]+$/','Class', 'Should be numbers only')) {
        return false;
    }
    if(!isValid($rdata->data->section, 1, 1, '/^[a-zA-Z]+$/','Section', 'should be A,B,C,D')) {
        return false;
    }
    if($rdata->data->date == '') { 
        $error = 'Date not defined';
        return false;
    }
    if($rdata->data->time == '') {
        $error = 'Time not defined';
        return false;
    } 
    if(!isValid($rdata->data->duration, 1, 3, '/^[0-9]+$/','Duration', 'should be time duration')) {
        return false;
    }
    $data = getData($rdata);
    return true;
}

function getData($rdata) {
    global $connect;
    $data['id'] = mysqli_real_escape_string($connect, $rdata->data->id);
    $data['name'] = mysqli_real_escape_string($connect, $rdata->data->name);
    $data['subject'] = mysqli_real_escape_string($connect, $rdata->data->subject);
    $data['class'] = mysqli_real_escape_string($connect, $rdata->data->class);
    $data['section'] = strtoupper(mysqli_real_escape_string($connect, $rdata->data->section));
    $data['date'] = mysqli_real_escape_string($connect, $rdata->data->date);
    $data['time'] = mysqli_real_escape_string($connect, $rdata->data->time);
    $data['type'] = mysqli_real_escape_string($connect, $rdata->data->type);
    $data['duration'] = mysqli_real_escape_string($connect, $rdata->data->duration);
    $data['questions'] = 0;
    return $data;
}
function saveData($data) {
    global $connect;
    if(!$connect) {
        echo 'Fatal error: Cannot connect to database, contact to administrator';
    }
    $query = "INSERT INTO exams VALUES ('$data[id]','$data[name]','$data[subject]','$data[class]','$data[section]','$data[date]','$data[time]','$data[type]','$data[duration]','$data[questions]')";
    if(!mysqli_query($connect,$query)) {
        echo 'not submitted';
    }
    $_SESSION['e_id'] = $data['id'];
}

function isValid($value,$ll,$lh,$preg,$name,$tme) {
    global $error;
    if(strlen($value) == 0) {
        $error = $name . ' Not defined';
        return false;
    }

    if($name == 'Class') {
        if($value > 12) {
            $error = "Class must be less than 12";
            return false;
        }
        if($value < 1) {
            $error = "Class is not valid";
            return false;
        }
    }
    if(!preg_match($preg, $value)) {
        $error = $name . ' ' . $tme;
        return false;
    }
    if(strlen($value) > $lh || strlen($value) < $ll) {
        $error = $name . ' should be between ' . $ll . ' and ' . $lh . ' characters long';
        if($ll == $lh) {
            $error = $name . ' should be exactly ' . $ll . ' Characters long';
        }
        return false;
    }
    else {
        return true;
    }
}
?>