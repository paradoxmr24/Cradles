<?php
$rdata = json_decode(file_get_contents("php://input"));
if(!$rdata) {
    header('location:../login.php');
    exit();
}
session_start();
require '../includes/connection.php';
$connect = connectdb($_SESSION['username']);
$data;
$error;
$key = 's^b)46fbr7@#2t4r2#*%@!*@B$*TcVQ$fr@b5*b5y*^vhur@%@V68(&Y#hcerbu$ew';
if(validation($rdata)) {
    saveData($data);
    echo 'successful';
} else {
    echo $error;
}


//---------------------------------------------functions----------------------------------------------

function validation($rdata) {
    global $error, $data;
    if(!isValid($rdata->data->username, 3, 15, '','Username','')) {
       return false;
   }
    if(!isAvail($rdata->data->username)) {
        return false;
    }
    if(!isValid($rdata->data->name, 3, 20, '/^[a-zA-Z0-9 ]+$/','Name', 'should be alphanumeric only')) {
        return false;
    }
    if(!isValid($rdata->data->class, 1, 2, '/^[0-9]+$/','Class', 'Should be numbers only')) {
        return false;
    }
    if(!isValid($rdata->data->section, 1, 1, '/^[a-zA-Z]+$/','Section', 'should be A,B,C,D')) {
        return false;
    }
    if(!isValid($rdata->data->phone, 10, 10, '/^[0-9]+$/','Phone', 'should be Phone Number')) {
        return false;
    }
    if(!isValid($rdata->data->mail, 1, 30, '/^[0-9a-zA-Z@.]+$/','Mail', 'should be a valid mail')) {
         return false;
    }
    if(!isValid($rdata->data->password, 5, 15, '','Password', '')) {
       return false;
    }

    $data['username'] = $rdata->data->username;
    $data['name'] = $rdata->data->name;
    $data['class'] = $rdata->data->class;
    $data['section'] = strtoupper($rdata->data->section);
    $data['phone'] = '+91 ' . $rdata->data->phone;
    $data['mail'] = $rdata->data->mail;
    $data['password'] = encrypt_this($rdata->data->password);
    
    return true;
}

function isAvail($name) {
    global $error, $connect;
    
    if(!$connect) {
        echo 'not connected';
    }
    $query = "SELECT Username FROM students WHERE Username = '$name'";
    if(mysqli_num_rows(mysqli_query($connect,$query))) {
        $error = 'Username not availiable';
        return false;
    } else {
        return true;
    }
}

function saveData($data) {
    global $connect;
    if(!$connect) {
        echo 'not connected';
    }
    $query = "INSERT INTO students VALUES ('$data[username]','$data[name]','$data[class]','$data[section]','$data[phone]','$data[mail]','$data[password]','Student','$_SESSION[username]')";
    if(!mysqli_query($connect,$query)) {
        echo 'not submitted';
    }

}
function isValid($value,$ll,$lh,$preg,$name,$tme) {
    global $error;

    if($name == 'Mail') {
        if(strlen($value) == 0) {
            return true;
        }
    }
    if(strlen($value) == 0) {
        $error = $name . ' Not defined';
        return false;
    }
    if(strlen($preg) != 0) {
        if(!preg_match($preg, $value)) {
            $error = $name . ' ' . $tme;
            return false;
        }
    }
    if($name == 'Class') {
        if($value > 12) {
            $error = "Class must be less than 12";
            return false;
        }
        if($value < 1) {
            $error = "Enter a valid class";
            return false;
        }
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
function encrypt_this($data) {
    global $key;
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
   $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}
?>