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
            Question VARCHAR(500),
            Option1 VARCHAR(100),
            Option2 VARCHAR(100),
            Option3 VARCHAR(100),
            Option4 VARCHAR(100),
            Answer VARCHAR(100),
            PRIMARY KEY (Id)
        )";
        mysqli_query($connect,$query);
    };
    $query = "INSERT INTO `$data[e_id]` VALUES ('$data[id]','$data[question]','$data[option1]','$data[option2]','$data[option3]','$data[option4]','$data[answer]')";
    $ret = mysqli_query($connect,$query);
    if($ret) {
        $query = "SELECT Questions FROM exams WHERE Id = '$data[e_id]'";
        $result = mysqli_fetch_assoc(mysqli_query($connect,$query));
        $result['Questions']++;
        $query = "UPDATE exams SET Questions='$result[Questions]' WHERE Id = '$data[e_id]'";
        mysqli_query($connect,$query);
    }

    return $ret;
}

function validation($rdata) {
    global $error, $data;

    if(!isValid($rdata->data->question, 500, 'Question')) {
        return false;
    }
    if(!isValid($rdata->data->option1, 100, 'Option1')) {
        return false;
    }
    if(!isValid($rdata->data->option2, 100, 'Option2')) {
        return false;
    }
    if(!isValid($rdata->data->option3, 100, 'Option3')) {
        return false;
    }
    if(!isValid($rdata->data->option4, 100, 'Option4')) {
        return false;
    }
    

    $data['id'] = $rdata->data->id;
    $data['question'] = $rdata->data->question;
    $data['option1'] = $rdata->data->option1;
    $data['option2'] = $rdata->data->option2;
    $data['option3'] = $rdata->data->option3;
    $data['option4'] = $rdata->data->option4;
    $data['answer'] = $rdata->data->answer;
    $data['e_id'] = $rdata->data->e_id;
    
    return true;
}

function isValid($value,$lh,$name) {
    global $error;

    if(strlen($value) > $lh) {
        $error = $name . ' should be less than ' . $lh . ' characters long';
        return false;
    } else {
        return true;
    }
}
?>