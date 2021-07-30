<?php

$rdata = json_decode(file_get_contents("php://input"));
if(!$rdata) {
    header('location:../login.php');
    exit();
}
require '../includes/connection.php';
session_start();
if($_SESSION['username'] == 'Admin') {
    $key = 's^b)46fbr7@#2t4r2#*%@!*@B$*TcVQ$fr@b5*b5y*^vhur@%@V68(&Y#hcerbu$ew';
    $connect = connectdb('admin');
    $data;
    if(!$connect) {
        echo 'Fatal error: Database cannot be accessed';
        exit();
    }
    if(validation()) {
        //--------------Submitting data after validation
    if(createEnvironment($data['username'])) {
        $connect = connectdb('admin');
       $query = "INSERT INTO logindata values ('$data[username]','$data[password]','$data[school]','$data[address]','$data[phone]','$data[mail]','$data[plan]','$data[purchase]','$data[expire]','$data[valid]','Teacher','$data[name]')";
       if(mysqli_query($connect, $query)) {
            echo 'Submitted Successfully '; 
        } else {
        echo 'Submition Failed ';
        }
    }
    } else {
        echo $error;
    }
} else {
    header('location:../login.php');
    exit();
}


function createEnvironment($name) {
    global $connect;

//-----------------Creating environment for the user
//-----------------Checking for database
if($_SERVER['SERVER_NAME'] != 'localhost') {
    $a = 'ncagop4r_' . $name;
} else {
    $a = $name;
}
$query = "SHOW DATABASES LIKE '$a'";
if(mysqli_num_rows(mysqli_query($connect,$query))) {
    echo "database $name Created ";
    $connect = connectdb($name);
    //------Creating student table
    $query = "CREATE TABLE students (
        Username VARCHAR(15),
        Name VARCHAR(20), 
        Class INTEGER(2),
        Section VARCHAR(1), 
        Phone VARCHAR(14), 
        Mail VARCHAR(30), 
        Password VARCHAR(56),
        Role VARCHAR(7),
        D_name VARCHAR(15),
        PRIMARY KEY (Username)
        )";
    if(mysqli_query($connect, $query)) {
        echo 'Student table created ';
    } else {
        echo 'Cannot create student table ';
    }

    //-----------Creating exams table
    $query = "CREATE TABLE exams (
        Id INTEGER(6),
        Name VARCHAR(20),
        Subject VARCHAR(15),
        Class INTEGER(2),
        Section VARCHAR(1),
        E_Date DATE,
        E_Time TIME,
        Type VARCHAR(1),
        Duration INTEGER(3),
        Questions INTEGER(3),
        PRIMARY KEY (Id)
        )";
    if(mysqli_query($connect, $query)) {
        echo 'Exams table created ';
    } else {
        echo 'Cannot create exams table ';
    }

    //-----------Creating notification table
    $query = "CREATE TABLE notification (
        Message VARCHAR(100),
        Sender VARCHAR(15),
        Reciever VARCHAR(4),
        P_date Date
        )";
    if(mysqli_query($connect, $query)) {
        echo 'Notification table created ';
    } else {
        echo 'Cannot create notification table ';
    }

    //-----------Creating answers table Subjective
    $query = "CREATE TABLE answers (
        Student_id VARCHAR(15),
        Exam_id VARCHAR(6),
        Answer_id VARCHAR(6),
        Image VARCHAR(50),
        Marks VARCHAR(7),
        PRIMARY KEY(Student_id,Exam_id,Answer_id)
        )";
    if(mysqli_query($connect, $query)) {
        echo 'Answers table created ';
    } else {
        echo 'Cannot create answers table ';
    }

    //---------Creating answers table Objective
    $query = "CREATE TABLE oanswers (
        Student_id VARCHAR(15),
        Exam_id VARCHAR(6),
        Question_id VARCHAR(6),
        Answer_id VARCHAR(6),
        Correct INT(1),
        PRIMARY KEY(Student_id, Exam_id, Question_id)
    )";
    if(mysqli_query($connect, $query)) {
        echo 'answer-o table created';
    } else {
        echo 'Cannot create answers-o table';
    }

    //---------Creating table marks
    $query = "CREATE TABLE marks (
        Student_id VARCHAR(15),
        Exam_id INTEGER(6),
        Marks VARCHAR(7),
        Checked INTEGER(1),
        PRIMARY KEY (Student_id,Exam_id)
        )";
    if(mysqli_query($connect, $query)) {
        echo 'Marks table created ';
    } else {
        echo 'Cannot create marks table ';
    }
    return true;
} else {
    echo 'Cannot find the database ';
    return false;
}
}

function validation() {
    global $error, $rdata, $connect, $data;

    if($rdata->data->username == '') {
        $error = 'Username not defined';
        return false;
    }
    if(!isUsernameValid()) {
        return false;
    }
    if($rdata->data->password == '') {
        $error = 'Password not defined';
        return false;
    }
    if(!isPasswordValid()) {
        return false;
    }
    if($rdata->data->school == '') {
        $error = 'School not defined';
        return false;
    }
    if(!isSchoolValid()) {
        return false;
    }
    if($rdata->data->address == '') {
        $error = 'Address not defined';
        return false;
    }
    if(!isAddressValid()) {
        return false;
    }
    if($rdata->data->phone == '') {
        $error = 'Phone not defined';
        return false;
    }
    if(!isPhoneValid()) {
        return false;
    }
    if($rdata->data->mail == '') {
        $error = 'E-Mail not defined';
        return false;
    }
    if(!isMailValid()) {
        return false;
    }
    if($rdata->data->plan == '') {
        $error = 'Plan not defined';
        return false;
    }

    $data['username'] = mysqli_real_escape_string($connect, $rdata->data->username);
    $data['password'] = encrypt_this(mysqli_real_escape_string($connect, $rdata->data->password));
    $data['school'] = mysqli_real_escape_string($connect, $rdata->data->school);
    $data['address'] = mysqli_real_escape_string($connect, $rdata->data->address);
    $data['phone'] = '+91 ' . mysqli_real_escape_string($connect, $rdata->data->phone);
    $data['mail'] = mysqli_real_escape_string($connect, $rdata->data->mail);
    $data['plan'] = mysqli_real_escape_string($connect, $rdata->data->plan);
    $data['purchase'] = date('Y') . '-' . date('m') . '-' . date('d');
    $data['expire'] = getExpireDate($data['plan']);
    $data['valid'] = 1;
    $data['name'] = mysqli_real_escape_string($connect, $rdata->data->name);
    return true;
}

function isUsernameValid() {
    global $error, $rdata, $connect;
    
    $username = $rdata->data->username;
    //-------------Checking for nummber at start
    if(preg_match('/[0-9]/',$username[0])) {
        $error = "First character cannot be a number";
        return false;
    }
    //-------------Checking for count
    if(strlen($username) < 5 || strlen($username) > 15) {
        $error = 'Username must be between 5 to 15 Characters';
        return false;
    }

    //-----------Checking for alphamumeric
    if(!ctype_alnum($username)) {
        $error = 'Only alphanumeric Characters are allowed in username';
        return false;
    }

    //-------------Checking For availiabilility
    $query = "SELECT Username from logindata where Username = '$username'";
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) {
        $error = 'Username not availiable';
        return false;
    } else {
        return true;
    }

}

function isPasswordValid() {
    global $error, $rdata;

    $password = $rdata->data->password;
    //-------------Checking for count
    if(strlen($password) < 8 || strlen($password) > 15) {
        $error = 'Password must be between 8 to 15 characters long';
        return false;
    }
    return true;
}

function isSchoolValid() {
    global $error, $rdata;

    $school = $rdata->data->school;
    //-------------Checking for count and alphabets 
    if(strlen($school) > 40 || !preg_match('/^[a-zA-Z ]+$/', $school)) {
        $error = 'School Name must be smaller than 40 characters and must not include any special characters';
        return false;
    }
    return true;
}

function isAddressValid() {
    global $error, $rdata;

    $address = $rdata->data->address;
    //-------------Checking for count   
    if(strlen($address) > 40) {
        $error = 'Address must be smaller than 40 characters';
        return false;
    }
    return true;
}

function isPhoneValid() {
    global $error, $rdata;

    $phone = $rdata->data->phone;
    //---------------Checking for count and numbers only
    if(strlen($phone) != 10 || !ctype_digit($phone)) {
        $error = 'Phone Number mmust be 10 digits and numbers only';
        return false;
    }
    return true;
}

function isMailValid() {
    global $error, $rdata;

    $mail = $rdata->data->mail;
    //----------Checking for @ adn count
    if(strlen($mail) < 30) {
        $mail = strstr($mail,'@');

        if($mail) {
            $mail = substr($mail,1);
            if($mail == '') {
                $error = 'None after @';
                return false;
            }
            $mail = strstr($mail,'@');
            if(!$mail) {
                return true;
            }
            $error = '@ again found';
            return false;
        }
        $error = '@ not found';
    return false;
    } else {
        $error = 'Email must be less than 30 charcters long';
        return false;
    }

}

function getExpireDate($m) {
    if(date('m') + ($m%12) > 12) {
        $data = date('Y') + floor($m/12) + 1 . '-';
        $data .= date('m') + ($m%12) - 12;
    } else {
        $data = date('Y') + floor($m/12) . '-';
        $data .= date('m') + ($m%12);
    }
    $data .= '-' . date('d');
    return $data;
}

function encrypt_this($data) {
    global $key;
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}
?>