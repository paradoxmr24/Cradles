<?php 
$role = 'Teacher';
require 'includes/validate.php';
require 'includes/connection.php';
  $connect = connectdb($_SESSION['username']);
  $e_id = $_POST['e_id'];
  $s_id = $_POST['s_id'];
  if(!isset($_POST['serial'])) {
    $serial = 0;
  } else {
    $serial = $_POST['serial'];
  }
  $title = 'Answer Sheet';
  ?>
  <?php include 'includes/topbar.php'; ?>
<section class="card rounded p-3 my-2 mx-5 border-left-primary">
<h4 class="mb-4">
<?php
$query = "SELECT *,answers.Marks AS Mks FROM answers INNER JOIN `$e_id` WHERE `$e_id`.Id = answers.Answer_id && answers.Exam_id='$e_id' && answers.Student_id='$s_id' && answers.Answer_id > '$serial' && answers.Image != 'none'";
  $result = mysqli_query($connect,$query);
  $row = mysqli_fetch_assoc($result);?>
  <?php
if($row != '') {
echo $row['Id'] . '. ';
echo $row['Question'] . ' - ' . $row['Mks'] . ' Marks';
?></h4>
<img class="w-100 mb-4" src="<?php echo 'functions/uploads/' . $row['Image']; ?>">
<form method="POST" action="">
    <input name="e_id" style="display:none!important;" value="<?php echo $e_id; ?>">
    <input name="s_id" style="display:none!important;" value="<?php echo $row['Student_id']; ?>">
    <div class="text-center">
    <?php 
      $query1 = "SELECT * FROM answers WHERE Exam_id='$e_id' && Student_id='$s_id' && Image != 'none'";
      $result1 = mysqli_query($connect, $query1);
      while($row1 = mysqli_fetch_assoc($result1)) {
    ?>
      <button class="list-button" name="serial" value="<?php echo $row1['Answer_id']-1; ?>"><?php echo $row1['Answer_id'] ?></button>
    <?php } ?>
      </div>
    </select>
</form>
<form method="POST" action="">
    <input name="e_id" style="display:none!important;" value="<?php echo $e_id; ?>">
    <input name="s_id" style="display:none!important;" value="<?php echo $row['Student_id']; ?>">
    <input name="serial" style="display:none!important;" value="<?php echo $row['Id']; ?>">
    <button class="btn btn-primary text-white mt-4 form-control" name="next" type="submit">Next</button>
  </form>
      </section>
      <?php } else {
        echo 'Completed';
      } ?>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>

