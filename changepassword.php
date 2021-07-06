<?php 
$role = 'All';
require 'includes/validate.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Change Password</title>
   <style>
      
      body,html {
         height: 100%;
         margin:0px;
         padding:0px;
       }
       .bg {
         position: fixed;
         left: 0;
         right: 0;
         z-index: 1;
         height: 100%;
         background-color:#3158C9;
         
       }
       .main {
          position: fixed;
         left: 0;
         right: 0;
         z-index: 9999;
         height: 100%;
       }
       .card {
       }
       .form-control {
          border-top: none!important;
          border-left: none!important;
          border-right: none!important;
          border-radius: 0px!important;
          padding-left: 25px!important;
       }
       .input-icons i { 
            position: absolute; 
            
        } 
          
        .input-icons { 
            width: 100%; 
            
            margin-bottom: 16px;
        } 
          
        .icon { 
            padding-top: 10px; 
        } 
        .btn-primary {
            background-color:#3158C9!important;
        }
        hr {
           width: 0px;
        }
        hr.loaded {
           width: 100%;
           transition: all ease 2s;
        }
   
   </style>
   <link href="libs/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="bg"></div>

<div class="main">
<div class="row">
   <div class="col"></div>
   <div class="col-lg-4 col-md-6 col-12 p-4">
<div class="card p-lg-5 p-md-5 p-4 shadow">
   
   <h4 class="mx-auto">Change your password<hr class="btn-primary mb-lg-4 mb-md-4 mb-3" id="hr"></h4>
   <div id="error" class="text-danger text-center mb-3">
      <?php
          if(isset($_SESSION['status'])) {
            echo $_SESSION['status'];
          }
          $_SESSION['status'] = '';
      ?>
      </div>
   <form action="functions/changepassword.php" method="post">
      <div class="form-group input-icons">
         <i class="fas fa-fw fa-key icon"></i>
         <input type="text" name="oldpassword" id="oldpassword" class="form-control" placeholder="Old Password" autocomplete="off" onfocus="removeErrorMsg();">
      </div>
      <div class="form-group input-icons">
         <i class="fas fa-fw fa-unlock icon"></i>
         <input type="text" name="newpassword" id="newpassword" class="form-control" placeholder="New Password" autocomplete="off" onfocus="removeErrorMsg();">
      </div>
      <div class="form-group input-icons">
         <i class="fas fa-fw fa-unlock icon"></i>
         <input type="text" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm Password" autocomplete="off" onfocus="removeErrorMsg();">
      </div>
      <button type="submit" id="submit" class="btn btn-primary form-control mt-2 rounded d-none" disabled></button>
   </form>
   <button type="submit" class="btn btn-primary form-control mt-2 rounded" onclick="validatePassword()">Change Password</button>
</div>
</div>
<div class="col"></div>
</div>
</div>   
<!-------------- Body -------------------------------------------------------------->

<!-------------- Footer ------------------------------------------------------------>


<!-- Optional JavaScript ---- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="libs/jquery/jquery-3.5.1.min.js"></script>
  <script src="libs/bootstrap/js/bootstrap.min.js"></script>
  <script lang="javascript">
        document.getElementById('hr').classList.add('loaded');
        function validatePassword() {
           if(document.getElementById('oldpassword').value.length < 1) {
            document.getElementById('error').innerHTML = "Old password cannot be Blank";
           } else {
            if(document.getElementById('newpassword').value.length < 8) {
                document.getElementById('error').innerHTML = "New password must must be 8 characters or more";
            } else {
               if(document.getElementById('newpassword').value != document.getElementById('confirmpassword').value) {
                  document.getElementById('error').innerHTML = "New passwords and confirm password must be same";
               } else {
                  document.getElementById('submit').removeAttribute('disabled');
                  document.getElementById('submit').click();
               }
            }
           }
        }
        function removeErrorMsg() {
           document.getElementById('error').innerHTML = '';
        }
  </script>
</body>
</html>

