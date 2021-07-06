<?php 

$role = 'Teacher';

require 'includes/validate.php';

require 'includes/connection.php';

  $connect = connectdb($_SESSION['username']);

  $e_id = $_POST['e_id'];

  $s_id = $_POST['s_id'];



  if(!isset($_POST['serial'])) {

    $serial = 0;

    //initMarks($e_id,$s_id);

  }

  else {

    $serial = $_POST['serial'];

    setMarks($_POST['marks'],$e_id,$s_id,$serial); 

  }

  

  

  function initMarks($e_id,$s_id) {

      global $connect;



      $query = "SELECT Marks FROM marks WHERE Student_id = '$s_id' && Exam_id = '$e_id'";

      $result = mysqli_fetch_assoc(mysqli_query($connect,$query));

          $result['Marks'] = 0 . strstr($result['Marks'],'/');

      $query = "UPDATE marks SET Marks='$result[Marks]' WHERE Student_id = '$s_id' && Exam_id = '$e_id'";

      mysqli_query($connect, $query);

  }

  function setMarks($marks,$e_id,$s_id,$serial) {

      global $connect;

      $query = "SELECT Marks FROM answers WHERE Student_id = '$s_id' && Exam_id = '$e_id' && Answer_id = '$serial'";

      $result = mysqli_fetch_assoc(mysqli_query($connect,$query));

      if(strstr($result['Marks'],'/',true) == 0) {

      $query = "SELECT Marks FROM marks WHERE Student_id = '$s_id' && Exam_id = '$e_id'";

      $result = mysqli_fetch_assoc(mysqli_query($connect,$query));

      $result['Marks'] = strstr($result['Marks'],'/',true) + $marks . strstr($result['Marks'],'/');

      $query = "UPDATE marks SET Marks='$result[Marks]' WHERE Student_id = '$s_id' && Exam_id = '$e_id'";

      mysqli_query($connect, $query);

      $query = "SELECT Marks FROM answers WHERE Student_id = '$s_id' && Exam_id = '$e_id' && Answer_id = '$serial'";

      $result = mysqli_fetch_assoc(mysqli_query($connect,$query));

      $marks .= strstr($result['Marks'],'/');

      $query = "UPDATE answers SET Marks='$marks' WHERE Student_id = '$s_id' && Exam_id = '$e_id' && Answer_id = '$serial'";

      mysqli_query($connect, $query);

      }



  }



  function deleteEntry($e_id,$s_id) {

      global $connect;

      $query = "SELECT Image FROM answers WHERE Exam_id='$e_id' && Student_id='$s_id'";

      $result = mysqli_query($connect,$query);

      while($row = mysqli_fetch_assoc($result)) {

        unlink('functions/uploads/' . $row['Image']);

      } 

      $query = "DELETE FROM answers WHERE Exam_id='$e_id' && Student_id='$s_id'";

      mysqli_query($connect, $query);

  }



  function setChecked($e_id,$s_id) {

      global $connect;



      $query = "SELECT Checked FROM marks WHERE Student_id = '$s_id' && Exam_id = '$e_id'";

      $result = mysqli_fetch_assoc(mysqli_query($connect,$query));

      $result['Checked'] = 1;

      $query = "UPDATE marks SET Checked='$result[Checked]' WHERE Student_id = '$s_id' && Exam_id = '$e_id'";

      mysqli_query($connect, $query);

  }



  $title = 'Check-S';

  ?>

  <?php include 'includes/topbar.php'; ?>

<section class="card rounded p-3 my-2 mx-5 border-left-primary">

<h4 class="mb-4">

<?php

  $query = "SELECT * FROM answers INNER JOIN `$e_id` WHERE `$e_id`.Id = answers.Answer_id && answers.Exam_id='$e_id' && answers.Student_id='$s_id' && answers.Answer_id > '$serial' && answers.Image != 'none'";

  $result = mysqli_query($connect,$query);

  

  

  $row = mysqli_fetch_assoc($result);

  

if($row != '') {

    echo 'This question contains ' . $row['Marks'] . ' marks';

echo '<pre>' . $row['Id'] . '. ' . $row['Question'] . '<pre>';

?></h4>

<img class="w-100 mb-4" src="<?php echo 'functions/uploads/' . $row['Image']; ?>">

<form method="post" action="">

    <input name="e_id" style="display:none!important;" value="<?php echo $e_id; ?>">

    <input name="s_id" style="display:none!important;" value="<?php echo $row['Student_id']; ?>">

    <input name="serial" style="display:none!important;" value="<?php echo $row['Id']; ?>">

    <select name="marks" class="custom-select">

      <?php for($i=0; $i<=$row['Marks'];$i++) { ?>

        <option value="<?php echo $i; ?>"><?php echo $i . ' Marks'; ?></option>

      <?php } ?>

    </select>

    <button class="btn btn-primary text-white mt-4 form-control" name="post" type="submit">Next</button>

  </form>

      </section>

      <?php } else { 

  setChecked($e_id,$s_id);

  //deleteEntry($e_id,$s_id);

  echo 'Checked';

?>
<div id="e_id" class="d-none"><?php echo $e_id; ?></div>
<script>setTimeout(()=> {window.location.replace('copies.php?e_id=' + document.getElementById('e_id').innerHTML);},1000);</script><?php } ?>

<!-------------- Footer ------------------------------------------------------------>



<?php include 'includes/bottom.php' ?>



