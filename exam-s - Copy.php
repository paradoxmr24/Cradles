<?php 

$role = 'Student';

$isExam = true;

require 'includes/validate.php';

require_once 'includes/connection.php';

require_once 'includes/log.php';

$e_id = $_GET['id'];

addlog($e_id,'Success','Enterted the exam');

$useAngular = true;

$js = 'exam-s.js';

$title = 'Exam';

$style='loader.css';

?>





<!----------------------------------------------------------Header-------------------------------------------->

<?php include 'includes/topbar.php'; ?>

<span style="display:none;!important" id="id"><?php echo $e_id ?></span>

<!-------------- Body -------------------------------------------------------------->

<div class="text-dark card rounded p-3 my-2 mx-md-5 mx-lg-5 mx-1 border-left-primary font-weight-bold">

<h4 id="time" class="ml-auto" ng-if="!over">Time Remaining - {{timeLimit}}</h4>

<div id="serial" class="d-none">{{serial}}</div>

<div id="skipped" class="d-none"><?php echo 'false'; ?></div>

<div id="marks" class="d-none">0/{{marks}}</div>

    <div ng-if="started && question">

      

    <h4 class="text-dark"><pre>{{serial}}. {{question}}

This question contains - {{marks}} Marks</pre>

        

        

        <button class="my-5 btn btn-primary" onclick="document.getElementById('inputfile').click()">Upload</button>

        <div id="success"></div>

        <input type='file' id="inputfile" name="inputfield" onchange="success(this)" style="display:none">

        

</div></h4>

<h1 ng-if="!started && remDate">

  Exam will start on:<br>

  Date: {{remDate}}<br>

  Time: {{remTime}}

</h1>



<h1 ng-if="over">Exam is Over</h1>



    <button ng-if="canStart && !started" class="btn btn-primary" ng-click="start()">Start</button>

    <button ng-if="started && question" class="btn btn-primary mb-2" ng-click="start()" id="next" onclick="changed()" disabled>Next</button>

    <button ng-if="started && question" class="btn btn-danger mb-2" onclick="skno()" ng-click="start();" id="skip">Skip</button>

    <button class="btn btn-primary" ng-if="((started && !question) || showingSkip) && serial" ng-click="finish()" id="finish">Finish</button>

</div>

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



  <!-- Custom scripts for all pages-->

  <script src="js/sb-admin-2.js"></script>

  <script lang="javascript">

      

        console.log("ready");

        function success(el) {

          if(document.getElementById('buffer').classList[1] == 'd-none') {

          

          if($('#inputfile').prop('files')[0].name != '') {

              document.getElementById("next").removeAttribute("disabled");

              document.getElementById("success").innerHTML = 'Click next to submit answer';

          }

        }

        }

    function changed(){

      if(document.getElementById("inputfile").value != '') {

        console.log("changed");

        var file_data = $('#inputfile').prop('files')[0];   

        var form_data = new FormData();                  

        form_data.append('file', file_data);

        form_data.append('id',document.getElementById("id").innerHTML);

        form_data.append('serial',document.getElementById("serial").innerHTML);

        form_data.append('marks',document.getElementById("marks").innerHTML);

        document.getElementById("inputfile").value = '';

        document.getElementById("next").setAttributeNode(document.createAttribute("disabled"));

        document.getElementById("success").innerHTML = '';

        $.ajax({

            url: "functions/upload.php",

            type: "POST",

            data: form_data,

            contentType: false,

            cache: false,

            processData:false,

            success: function(response){

                console.log(response);

                document.getElementById('buffer').classList.add('d-none');
                document.getElementById('cover').classList.add('d-none');
            }

        });

    } else {

      console.log("error");

    }

  };

  function skno() {

    document.getElementById('skipped').innerHTML = document.getElementById('serial').innerHTML;

    console.log('<?php echo $_SESSION['skipped']; ?>');

  }

      </script>





</body>



</html>