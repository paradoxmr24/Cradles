<?php
$rdata = json_decode(file_get_contents("php://input"));
if(!$rdata) {
    header('location:../login.php');
    exit();
}
require '../includes/connection.php';
date_default_timezone_set("Asia/Calcutta");
session_start();
$sdata;
$connect = connectdb($_SESSION['d_name']);
$e_id = $rdata->e_id;
$query = "SELECT * FROM exams WHERE Id = '$e_id'";
$result = mysqli_fetch_assoc(mysqli_query($connect,$query));


if(isAlreadyApplied($e_id) && $rdata->q == '') {
    $sdata['status'] = "na";
    echo json_encode($sdata);
    exit();
}

checkTime();
if($sdata['status'] == 'e') {
    $rdata->q = '';
}
if($rdata->q == '') {
    echo json_encode($sdata);
    if($sdata['status'] == 's') {
        $_SESSION['count'] = 0;
        $_SESSION['answer'] = 0;
    }
} else {
    if($sdata['status'] == 's') {

        if($_SESSION['count'] > 0) {
            $answer = $rdata->answer;
                if($_SESSION['answer'] == $answer) {
                    incrementMarks();
                }
        } else {
            initEntry();
        }
        $_SESSION['count']++;

        $query = "SELECT * FROM `$e_id` WHERE Id='$_SESSION[count]'";
        $result = mysqli_query($connect,$query);
        $result = mysqli_fetch_assoc($result);
        if(isset($result['Answer'])) {
            $_SESSION['answer'] = $result['Answer'];
            unset($result['Answer']);
        }
        echo json_encode($result);
    }
}

function toSec($a) {
    return $a*60;
}

function initEntry() {
    global $connect, $e_id;
    $query = "SELECT Questions FROM exams WHERE Id = '$e_id'";
    $result = mysqli_fetch_assoc(mysqli_query($connect,$query));
    $total = '0/' . $result['Questions'];
    $query ="INSERT INTO marks VALUES ('$_SESSION[username]','$e_id','$total','1')";
    mysqli_query($connect,$query);
}

function checkTime() {
    global $result,$sdata;
    if($result['E_Date'] == date('Y') . '-' . date('m') . '-' . date('d')) {
        if (time() >= strtotime($result['E_Time']) && time() <= (strtotime($result['E_Time']) + toSec($result['Duration'])) ) {
            $sdata['status'] = 's';
            $sdata['time'] = strtotime($result['E_Time']) + toSec($result['Duration']);
        } else if(time() > (strtotime($result['E_Time']) + toSec($result['Duration']))) {
            $sdata['status'] = 'e';
        } 
        else {
            $sdata['status'] = 'ns';
            $sdata['time'] = getFormattedTime($result['E_Time']);
            $sdata['date'] = getFormattedDate($result['E_Date']);
        }
    } elseif($result['E_Date'] > date('Y') . '-' . date('m') . '-' . date('d')) {
        $sdata['status'] = 'ns';
        $sdata['time'] = getFormattedTime($result['E_Time']);
        $sdata['date'] = getFormattedDate($result['E_Date']);
    } else {
        $sdata['status'] = 'e';
    }
}

function isAlreadyApplied($id) {
    global $connect;
    $query = "SELECT * FROM marks WHERE Student_id = '$_SESSION[username]' && Exam_id = '$id'";
    return mysqli_num_rows(mysqli_query($connect,$query));
}

function getFormattedDate($date) {
$date = $date[8] . $date[9] . '/' . $date[5] . $date[6] . '/' . $date[0] . $date[1] . $date[2] . $date[3];
return $date;

}

function getFormattedTime($time) {
    $time_h = $time[0] . $time[1];
    $m = 'AM';
    if($time_h > 11) {
    $m = 'PM';
    $time_h -= 12;
    } 
    $time = $time_h . ':' . $time[3] . $time[4] . ' ' . $m;
    return $time;
}

function incrementMarks() {
    global $connect,$e_id;

    $query = "SELECT Marks FROM marks WHERE Student_id = '$_SESSION[username]' && Exam_id = '$e_id'";
    $result = mysqli_fetch_assoc(mysqli_query($connect,$query));
    $result['Marks'] = strstr($result['Marks'],'/',true) + 1 . strstr($result['Marks'],'/');
    $query = "UPDATE marks SET Marks='$result[Marks]' WHERE Student_id = '$_SESSION[username]' && Exam_id = '$e_id'";
    mysqli_query($connect, $query);
}
?>