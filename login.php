<?php session_start(); require 'includes/connection.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
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
   
   <h4 class="mx-auto">Login to your Account<hr class="btn-primary mb-lg-4 mb-md-4 mb-3" id="hr"></h4>
   <div class="text-danger text-center mb-3">
      <?php
          if(isset($_SESSION['status'])) {
          echo $_SESSION['status'];
          }
          if(isset($_SESSION['username']))
              echo '<br>' . 'Successfully Logged out';
          session_destroy();
      ?>
      </div>
   <form action="functions/login.php" method="post">
      <div class="form-group input-icons">
         <i class="fas fa-fw fa-user-graduate icon"></i>
         <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off">
      </div>
      <div class="form-group input-icons">
         <i class="fas fa-fw fa-unlock icon"></i>
         <input type="text" name="password" class="form-control" placeholder="Password" autocomplete="off">
      </div>
      <div class="input-icons">
         <i class="fas fa-fw fa-user-tag icon"></i>
            <select name="role" class="custom-select form-control" id="role" onchange="change(this)">
                <option value="Student">Student</option>
                <option value="Teacher">Teacher</option>
            </select>
      </div>
      <div class="input-icons" id="school">
         <i class="fas fa-fw fa-school icon"></i>
         <select name="school" class="custom-select form-control" name="school"  id="school" autocomplete="off">
            <?php 
            $connect= connectdb('admin');
            $query = "SELECT School,Username FROM logindata";
            $result = mysqli_query($connect,$query);
            while($row = mysqli_fetch_assoc($result)) {
                if($row['School'] == '') continue;
            ?>
                <option value="<?php echo $row['Username'] ?>"><?php echo $row['School'] ?></option>
            <?php }
            unset($connect);
            unset($query);
            unset($result);
            ?>
         </select>
      </div>
      <?php if(isset($_GET['e_id'])) { ?>
      <input value="<?php echo $_GET['e_id']; ?>" class="d-none" name="id">
      <?php } ?>
      <button type="submit" class="btn btn-primary form-control mt-2 rounded">Login</button>
   </form>
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
     change = (el) => {
     if(el.value == 'Teacher')
         document.getElementById('school').classList.add('d-none');
      else 
         document.getElementById('school').classList.remove('d-none');
     }
        document.getElementById('hr').classList.add('loaded');
        
  </script>
</body>
</html>

