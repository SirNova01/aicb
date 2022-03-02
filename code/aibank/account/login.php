<!DOCTYPE html>

<?php
  session_start();
  include("../includes/db_conn.php");
  $day = date("Y-m-d");
  $date = date("Y-m-d H:i:s");
  $errors = array();
  $email =""; 
  $password="";
 
  if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($db_handle, $_POST['email']);
    $password =  mysqli_real_escape_string($db_handle, $_POST['password']);
  
    if (empty($email)) { array_push($errors, "email is required"); }
    if (empty($password)) { array_push($errors, "password is required"); }

    if (count($errors) == 0) {
      $enc_password = md5($password);

      $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
		$result = mysqli_query($db_handle, $user_check_query);
		$user = mysqli_fetch_assoc($result);
		if ($user) { // if user exists
			if ($user['password'] === $enc_password) {
                $email_verification_status = $user['email_verification_status'];
                if ($email_verification_status == "verified"){
                    $account_status = $user['account_status'];

                  if($account_status == "active"){
                    $_SESSION['status'] = "logged in";
                    $_SESSION['email'] = $email;
                    $_SESSION['user_role'] = $user['user_role'];
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['account_status'] =$user['account_status'];
                   
                    if( $user['user_role'] == "admin_nova"){
                      header('location: home');
                    }else{

                    }
                    
                      
                  
                    
                  }else{
                    if($account_status == "suspended"){
                      array_push($errors, "Your account has been suspended, please contact support@ichoni.com");
                     
                    }else{
                      array_push($errors, "Your account is not activated, please contact support@ichoni.com");
                     

                    }
                  }

                }else{
                    array_push($errors, "Email not verified, please click on the link sent to your email to verify your pletracoin account");
                }
            }else{
                array_push($errors, "Incorrect password");
            }
        }else{
            array_push($errors, "Email not registered");
        }

    }
    
  }
?>
<html lang="en">


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/font/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
<style>

  .errror {
  width: 100%; 
  margin: 0px auto; 
  padding: 10px; 
  border: 1px solid #a94442; 
  color: #a94442; 
  background: #f2dede; 
  border-radius: 5px; 
  text-align: left;
  }
</style>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div style="text-align:center;" class="brand-logo">
                <img src="images/i1.jpg" alt="logo">
              </div>
              <!-- <h4>Login</h4> -->
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" method="post" action="login">
                <?php include('includes/errors.php'); ?>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email:" name="email" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password:" name="password" required>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="login">
                      <i class="mdi mdi-login"></i>                      
                      Sign In
                    </button>
                </div>
               
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
</body>


</html>
