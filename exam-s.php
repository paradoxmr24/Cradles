<?php 
$role = 'Student';
$isExam = true;
require 'includes/validate.php';
require 'includes/connection.php';
require 'includes/format.php';
require 'includes/time.php';
$title = 'Exam';
$style = 'loader.css';
$e_id = $_GET['e_id'];
?>


<!----------------------------------------------------------Header-------------------------------------------->
<?php include 'includes/topbar.php'; ?>
<!-------------- Body -------------------------------------------------------------->


<section class="m-lg-5 m-md-5 m-3 shadow rounded p-lg-5 p-md-5 p-4">
<?php 
$timeData = checkTime(getExamTime($e_id));
if($timeData['status'] == 's') {
$data = getQuestion($e_id); 
if($data) {
  ?>
  <div class="row">
    <div class="col-lg-6 col-md-6 col-12 text-left">Time Remaining: <span id="time">00:00:00</span></div>
    <div class="col-lg-6 col-md-6 col-12 text-right"><?php echo $data['Marks']; ?> Marks</div>
  </div>
  <hr>
  <?php echo '<h4><pre>' . $data['Id'] . '. ' . $data['Question'] . '</pre></h4>'; ?>
  <img src="#" id="answer" width="200" class="d-none">
  <button class="form-control my-2 btn btn-primary" onclick="document.getElementById('inputfile').click()">Upload</button>
  <button class="form-control my-2 btn btn-primary" onclick="upload(this)" id="next" disabled>Next</button>
  <button class="form-control my-2 btn btn-danger" id="skip" onclick="upload(this)">Skip</button>
  <input type='file' id="inputfile" name="inputfield" onchange="success()" style="display:none">


  <!-------------Additonal Data----------------------->
  <div class="d-none" id="e_id"><?php echo $e_id; ?></div>
  <div class="d-none" id="serial"><?php echo $data['Id']; ?></div>
  <div class="d-none" id="marks"><?php echo $data['Marks']; ?></div>
<?php } else { ?>
  <div class="text-left">Time Remaining: <span id="time">00:00:00</span></div><hr>
  <?php
  $data = getQuestionList($e_id);
  while($row = mysqli_fetch_assoc($data)) { ?>
    <?php 
    if($row['Image'] == 'none') {
      $state = ' Skipped';
      $color = 'danger';
    } else {
      $state = ' Submitted';
      $color = 'primary';
    }
    ?>
    <a class="btn btn-<?php echo $color; ?> my-2 form-control" href="exam-s.php?e_id=<?php echo $e_id; ?>&q_id=<?php echo $row['Answer_id']; ?>">
    <?php
    echo $row['Answer_id'];
    if($row['Image'] == 'none')
      echo ' Skipped';
    else
      echo ' Submitted';
      echo ' -' . str_replace('/','',strstr($row['Marks'],'/')) . ' Marks';
    ?>
    </a>
    <?php
  }
}
} 
elseif ($timeData['status'] == 'ns') {
    echo '<h2>Exam will start on:</h2>';
    echo '<h3>Date: ' . $timeData['date'] . '<br>';
    echo 'Time: ' . $timeData['time'] . '</h3>';
} 
elseif ($timeData['status'] == 'e') {
    echo '<h2>Times Up!</h2>';
}
?>
<div class="d-none" id="remtime"><?php echo $timeData['endTime']; ?></div>
</section>
<!-------------- Footer ------------------------------------------------------------>
</div>
      <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you want to logout</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.php">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <div class="loader d-none" id="buffer"></div>
<div id="cover" class="d-none"></div>
 <!-- Optional JavaScript ---- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="libs/jquery/jquery-3.5.1.min.js"></script>
  <script src="libs/bootstrap/js/bootstrap.min.js"></script>
  <script>

getRemainingTime();
//--------------------functions---------------------------------------------------------------
function success() {
      if($('#inputfile').prop('files')[0].name != '') {
        document.getElementById("next").removeAttribute("disabled");
        $('#answer').removeClass('d-none');
        $('#answer').attr("src",URL.createObjectURL($('#inputfile').prop('files')[0]));
      }
}

function upload(caller) {
      buffer('start');
      var file_data = $('#inputfile').prop('files')[0];   
      var form_data = new FormData();      
      form_data.append('request', caller.id);            
      form_data.append('file', file_data);
      form_data.append('e_id',document.getElementById("e_id").innerHTML);
      form_data.append('serial',document.getElementById("serial").innerHTML);
      form_data.append('marks',document.getElementById("marks").innerHTML);
      $.ajax({
        url: "functions/upload.php",
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData:false,
        success: function(response){
            buffer('stop');
            url = 'exam-s.php?e_id=' + document.getElementById("e_id").innerHTML;
            window.location.replace(url);
        }
      });
}

function buffer(power) {
    if(power == 'start') {
      document.getElementById('cover').classList.remove('d-none');
      document.getElementById('buffer').classList.remove('d-none');
      console.log('b-start');
    } 
    else if(power == 'stop'){
      document.getElementById('cover').classList.add('d-none');
      document.getElementById('buffer').classList.add('d-none');
      console.log('b-stop');
    }
}

function getRemainingTime() {
  timeRem = document.getElementById('remtime').innerHTML;
  var d = new Date();
  time = (+timeRem+2) - Math.floor(d.getTime()/1000);
  h = Math.floor(time/3600);
  m = Math.floor((time/60)%60);
  s = (time%60);
  if(h<10) h = '0' + h;
  if(m<10) m = '0' + m;
  if(s<10) s = '0' + s;
  time = h + ':' + m + ':' + s;
  if(time == '00:00:00')
      location.reload();
  document.getElementById('time').innerHTML = time;
  setTimeout(() => {
    getRemainingTime();
  }, 1000);
}  
  </script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.js"></script>
</body>
</html>
<?php
function getQuestion($e_id) {
  global $connect;
  if(isset($_GET['q_id']) && isSkippedQuestion($e_id, $_GET['q_id'])) {   
      $query = "SELECT * FROM `$e_id` WHERE Id='$_GET[q_id]'";
  } else {
    $query = "SELECT * FROM `$e_id` WHERE ('$e_id',Id) NOT IN (SELECT Exam_id,Answer_id FROM answers WHERE Student_id = '$_SESSION[username]')";
  }
  $result = mysqli_fetch_assoc(mysqli_query($connect, $query));
  return $result;
}

function getQuestionList($e_id) {
  global $connect;
  $query = "SELECT * FROM answers WHERE Student_id='$_SESSION[username]' && Exam_id='$e_id'";
  $result = mysqli_query($connect, $query);
  return $result;
}

function isSkippedQuestion($e_id, $q_id) {
  global $connect;
    $query = "SELECT * FROM answers WHERE Student_id = '$_SESSION[username]' && Exam_id = '$e_id' && Answer_id = '$q_id' && Image = 'none'";
    if(mysqli_num_rows(mysqli_query($connect, $query))) {
      return true;
    }
    return false;
}

function getExamTime($e_id) {
  global $connect;
  $query = "SELECT E_Date, E_Time, Duration FROM exams WHERE Id='$e_id'";
  return mysqli_fetch_assoc(mysqli_query($connect, $query));
}
// if(!$result) {
//   $query = "SELECT Exam_id,Answer_id FROM answers WHERE Student_id = '$_SESSION[username]' && Exam_id = '$e_id' && Image = 'none'";
//   $result = mysqli_fetch_assoc(mysqli_query($connect, $query));
//   $query = "SELECT * FROM `$e_id` WHERE Id = '$result[Answer_id]'";
//   $result = mysqli_fetch_assoc(mysqli_query($connect, $query));
// }
?>