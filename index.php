<?php 
$role = 'All';
require 'includes/validate.php';
require_once 'includes/connection.php';
require_once 'includes/format.php';

$title = 'Home';
?>

<?php include 'includes/topbar.php'; ?>

<!-------------- Body -------------------------------------------------------------->
<div class="jumbotron">
    <h1>
    <?php 
    if($_SESSION['role'] == 'Teacher') {
        echo 'Hello ' . $_SESSION['username'];
        echo '<br>School - ' . $_SESSION['school'];
        echo '<br>Address - ' . $_SESSION['address'];
        echo '<br>Phone - ' . $_SESSION['phone'];
        echo '<br>E-mail - ' . $_SESSION['email'];
        echo '<br>Plan - ' . $_SESSION['plan'] . ' Months';
        echo '<br>Expire - ' . getFormattedDate($_SESSION['expire']);
    }
    if($_SESSION['role'] == 'Student') {
        echo 'Hello ' . $_SESSION['username'];
        echo '<br>Name - ' . $_SESSION['name'];
        echo '<br>Class - ' . $_SESSION['class'];
        echo '<br>Section - ' . $_SESSION['section'];
        echo '<br>Phone - ' . $_SESSION['phone'];
        echo '<br>Mail - ' . $_SESSION['mail'];
    }
     ?></h1>
</div>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>
