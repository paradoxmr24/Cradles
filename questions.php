<?php 
$role = 'Teacher';
require 'includes/validate.php';
require 'includes/connection.php';
if(!isset($_POST['id'])) {
  header('location:index.php');
  exit();
}
$id = $_POST['id'];
$connect = connectdb($_SESSION['username']);
$query = "SELECT * FROM `$id`";
$result = mysqli_query($connect,$query);

$style='list.css';
$title = 'Questions';
$bjs = 'rtable.js';
?>
<?php include 'includes/topbar.php'; ?>

<!-------------- Body -------------------------------------------------------------->
<div class="container-fluid px-4">
<table class="table table-striped table-responsive-stack">
  <thead class="thead-light">
    <tr>
    <?php $row = mysqli_fetch_assoc($result); 
      foreach($row as $i => $v) {   
   ?>
      <th scope="col"><?php echo $i ?></th>
      <?php } ?>
      
    </tr>
  </thead>
  <tbody>
<?php do { ?>
    <tr>

      <?php
      foreach($row as $i => $v) {
        echo '<td><pre>' . $v . '</pre></td>';
      }
      ?>

    </tr>
<?php }while($row = mysqli_fetch_assoc($result)); ?>
  </tbody>
</table>
</div>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>

