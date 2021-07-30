<?php 
$role = 'Student';
require 'includes/validate.php';
require 'includes/connection.php';
$alpha = ['0','a','b','c','d'];
  $connect = connectdb($_SESSION['d_name']);
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
$query = "SELECT *,oanswers.Correct AS Ans FROM oanswers INNER JOIN `$e_id` WHERE `$e_id`.Id = oanswers.Question_id && oanswers.Exam_id='$e_id' && oanswers.Student_id='$_SESSION[username]' && oanswers.Question_id> '$serial'";
  $result = mysqli_query($connect,$query);
  echo mysqli_error($connect);
  $row = mysqli_fetch_assoc($result);?>
  <?php
if($row != '') {
echo $row['Id'] . '. ';
echo $row['Question'] . ' ';
echo $row['Ans'] == 0 ? 'Wrong' : 'Correct';
$answer = $row['Answer_id'];
$correct = $row['Answer'];
?></h4>

<div class="row">
  <?php for($i=1; $i<5; $i++) { ?>
    <?php if($correct == $i) { ?>
    <div class="col-6 bg-success my-2 text-white rounded p"><?php echo $alpha[$i] . ') '; echo $row['Option' . $i]; if($answer == $i) echo ' &check;' ?></div>
    <?php } elseif($answer == $i) { ?>
      <div class="col-6 bg-danger my-2 text-white rounded p"><?php echo $alpha[$i] . ') '; echo $row['Option' . $i]; if($answer == $i) echo ' &check;'?></div>
    <?php } else { ?>
    <div class="col-6 my-2 p"><?php echo $alpha[$i] . ') '; echo $row['Option' . $i]; ?></div>
  <?php } } ?>
</div>

<form method="POST" action="" class="mt-3">
    <input name="e_id" style="display:none!important;" value="<?php echo $e_id; ?>">
    <input name="s_id" style="display:none!important;" value="<?php echo $_SESSION['username']; ?>">
    <div class="text-center">
    <?php 
      $query1 = "SELECT * FROM oanswers WHERE Exam_id='$e_id' && Student_id='$_SESSION[username]'";
      $result1 = mysqli_query($connect, $query1);
      while($row1 = mysqli_fetch_assoc($result1)) {
    ?>
      <button class="list-button" name="serial" value="<?php echo $row1['Question_id']-1; ?>"><?php echo $row1['Question_id'] ?></button>
    <?php } ?>
      </div>
    </select>
</form>
<form method="POST" action="">
    <input name="e_id" style="display:none!important;" value="<?php echo $e_id; ?>">
    <input name="s_id" style="display:none!important;" value="<?php echo $_SESSION['username']?>">
    <input name="serial" style="display:none!important;" value="<?php echo $row['Id']; ?>">
    <button class="btn btn-primary text-white mt-4 form-control" name="next" type="submit">Next</button>
  </form>
      </section>
      <?php } else {
        echo 'Completed';
      } ?>
<!-------------- Footer ------------------------------------------------------------>

<?php include 'includes/bottom.php' ?>

