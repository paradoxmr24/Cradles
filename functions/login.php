<?php
if(!isset($_POST['username'])) {
    header('location:../login.php');
    exit();
}
require '../includes/connection.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
$school = $_POST['school'];
$key = 's^b)46fbr7@#2t4r2#*%@!*@B$*TcVQ$fr@b5*b5y*^vhur@%@V68(&Y#hcerbu$ew';

//-------------------------------Teacher Login
if($role == 'Teacher') {
    $connect = connectdb('admin');
    if(!$connect) {
        $_SESSION['status'] = 'Failed to connect to server';
        header('location:../login.php');
        exit();
    }
    $query = "Select * from logindata where Username = BINARY '$username'";
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) {
        $result = mysqli_fetch_assoc($result);
        if($result['Expire'] < date('Y') . '-' . date('m') . '-' . date('d')){
            $_SESSION['status'] = 'Plan Expired';
            header('location:../login.php');
            exit();
        }
        
        if($password == decrypt_this($result['Password'])) {
            addDataToSession($result);
        } 
        else {
            $_SESSION['status'] = 'Invalid username or password for '. $role;
        }
    } else {
        $_SESSION['status'] = 'Invalid username or password for '. $role;
    }
}
//----------------------------------Student login
                if($role == 'Student') {
                    $connect = connectdb($school);
                    if(!$connect) {
                        $_SESSION['status'] = 'Failed to connect to server';
                        header('location:../login.php');
                        exit();
                    }
                    $query = "Select * from students where Username = BINARY '$username'";
                    $result = mysqli_query($connect, $query);
                    if(mysqli_num_rows($result)) {
                            $result = mysqli_fetch_assoc($result);
                            
                            if($password == decrypt_this($result['Password'])) {
                                addDataToSession($result);
                            } else {
                                $_SESSION['status'] = 'Invalid username or password for ' . $role;
                            }
                        } else {
                            $_SESSION['status'] = 'Invalid username or password for ' . $role;
                        }
                }



if(isset($_SESSION['username'])) {
    
    if(isset($_POST['id'])) {
        $loc = 'location:../exam';
        $connect = connectdb($_SESSION['d_name']);
        $query = "SELECT * FROM exams WHERE Id = '$_POST[id]'";
        $result = mysqli_fetch_assoc(mysqli_query($connect,$query));
        if($result['Type'] == 'S') {
           $loc .= '-s.php?id=' . $_POST['id'];
        } else {
            $loc .= '.php?id=' . $_POST['id'];
        }
        header($loc);
    } else {
        header('location:../index.php');
    }
} else {
    if(isset($_POST['id'])) {
        header('location:../login.php' . '?id=' . "$_POST[id]");
    } else {
        header('location:../login.php');
    }
}
function addDataToSession($data) {
    global $role;
    if($role == 'Teacher') {
        $_SESSION['username']   = $data['Username'];
        $_SESSION['name']       = $data['Name'];
        $_SESSION['school']     = $data['School'];
        $_SESSION['address']    = $data['Address'];
        $_SESSION['phone']      = $data['Phone'];
        $_SESSION['email']      = $data['Email'];
        $_SESSION['role']       = $data['Role'];
        $_SESSION['plan']       = $data['Plan'];
        $_SESSION['expire']     = $data['Expire'];
    }
    elseif($role == 'Student') {
        $_SESSION['username']   = $data['Username'];
        $_SESSION['name']       = $data['Name'];
        $_SESSION['class']      = $data['Class'];
        $_SESSION['section']    = $data['Section'];
        $_SESSION['phone']      = $data['Phone'];
        $_SESSION['mail']       = $data['Mail'];
        $_SESSION['role']       = $data['Role'];
        $_SESSION['d_name']     = $data['D_name'];
    }
}

function decrypt_this($data) {
    global $key;
    $encryption_key = base64_decode($key);
    list($encrypted_data,$iv) = array_pad(explode('::', base64_decode($data),2),2,null);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

?>