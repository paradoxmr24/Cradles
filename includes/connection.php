<?php
function connectdb($db) {
    if($_SERVER['SERVER_NAME'] == 'localhost') {
        return mysqli_connect('localhost','root','',$db);
    } else {
        $db = 'ncagop4r_' . $db;
        return mysqli_connect('localhost','ncagop4r','ncadocs2N!2N!',$db);
    }
}
?>