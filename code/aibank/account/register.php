<!DOCTYPE html>
<?php

    session_start();
    include("../includes/db_conn.php");
    $day = date("Y-m-d");
    $date = date("Y-m-d H:i:s");
    $errors = array();
    $username ="";
    $full_name ="";
    $email ="";
    $password="";
    $cpassword="";

    function existInDb($code, $db){
      $code_query = "SELECT * FROM users WHERE user_id ='$code'";
      $result = mysqli_query($db, $code_query);
      $number = mysqli_num_rows($result);
      if($number >0){
          return true;
      }else{
          return false;
      }
    }

  if(isset($_POST['register'])){
    $username = mysqli_real_escape_string($db_handle, $_POST['username']);
    $full_name =  mysqli_real_escape_string($db_handle, $_POST['full_name']);
    $email = mysqli_real_escape_string($db_handle, $_POST['email']);
    $password =  mysqli_real_escape_string($db_handle, $_POST['password']);
    $cpassword =  mysqli_real_escape_string($db_handle, $_POST['cpassword']);

    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($full_name)) { array_push($errors, "Full Name is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    $user_email_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $email_result = mysqli_query($db_handle, $user_email_check_query);
    $email_user = mysqli_fetch_assoc($email_result);
    if ($email_user) { array_push($errors, "Email already exists"); }
    if (empty($password)) { array_push($errors, "Password is required"); }
    if (empty($cpassword)) { array_push($errors, "Password confirmation is required"); }
    if ($password != $cpassword) { array_push($errors, "Passwords do not match!"); }
    if(empty($_FILES['identity'])){array_push($errors, "Please upload a means of identity"); }
    if(empty($_FILES['profile_pic'])){array_push($errors, "Please upload a recent passport"); }

    $path = basename( $_FILES['identity']['name']);

    if (count($errors) == 0) {
      $enc_password = md5($password);

      $identity_url = "identity_upload/";
      $profile_pic_url = "profile_pic_upload/";
      $num_identity = rand();
      $num_profile = rand();
      $identity_url  = $identity_url.$num_identity . basename( $_FILES['identity']['name']);
      $profile_pic_url = $profile_pic_url.$num_profile . basename( $_FILES['profile_pic']['name']);

      if(move_uploaded_file($_FILES['identity']['tmp_name'], $identity_url)) {
        if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic_url)) {
        
          $unique_number = uniqid(rand (), true);
          while(existInDb($unique_number, $db_handle)) {
              $unique_number = uniqid(rand (), true);                                       
          }
          $user_id = $unique_number;
          $email_verification_code = rand();
          $register_query = "INSERT INTO users (user_id,     username,   full_name,    email,   password,       user_role, identity_url,    profile_pic_url,     email_verification_code,   email_verification_status, account_status, reg_date, reg_day ) 
  			                                 VALUES('$user_id', '$username','$full_name', '$email','$enc_password', 'user',    '$identity_url', '$profile_pic_url', '$email_verification_code', 'not_verified',            'not_active', '$date',  '$day' )";
          if(mysqli_query($db_handle, $register_query)){
            // $email_body = "
            //         Click on the link below to confirm your FCSC account 
            //         http://www.fcsc.com/email_confirmation_redirect.php?email=$email&&code=$email_verification_code
            //     ";
            // $email_subject = "FCSC Email Confirmation";
            // $res = mail($email, $email_subject, $email_body, "From: NoReply@fcsc.com");
            // if($res){
              header("location: confirm_email_message.php");
            // }
          }

                   
          

        }else{array_push($errors, "Profile Upload Failed!");}
      }else{array_push($errors, "Identity Upload Failed!");}

      
    }

  }

?>
<html lang="en">
 

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Register</title>
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

<body  style="background:white;">
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
  
  .successs {
  width: 100%; 
  margin: 0px auto; 
  padding: 10px; 
  border: 1px solid #43a744; 
  color: #43a744; 
  background: #e3f2de;
  border-radius: 5px; 
  text-align: left;
  }
</style>
  <div style="background:#fff;" class="container-scroller">
    <div style="background:#fff;" class="container-fluid page-body-wrapper full-page-wrapper">
      <div style="background:#fff;" class="content-wrapper d-flex align-items-center auth">
        <div  style="background:#fff;" class="row w-100">
          <div class="col-lg-8 mx-auto">
            <div class="auth-form-light p-2">
              <div style="text-align:center;" class="brand-logo">
                <img src="images/fcsc.png" alt="logo">
              </div>
              <!-- <h4>Login</h4> -->
              <center><h6 class="font-weight-light">Register to continue.</h6></center>
              <form class="pt-3" method="post" acton="register.php" enctype="multipart/form-data">
                <?php include('includes/errors.php'); ?>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username:" name="username" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Full Name:" name="full_name" required>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email:" name="email" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password:" name="password" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Confirm Password:" name="cpassword" required>
                </div>
                <div class="card-body">
                  <h4 class="card-title d-flex">Upload Identity
                  </h4>
                  <small class="ml-auto align-self-end">
                      Note: <code> your identity must be either International Id Card, Voters Card or E-passport</code>
                  </small>
                  <div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon"></span> <p>Drag and drop a file here or click</p><p class="dropify-error">Ooops, something wrong appended.</p></div><div class="dropify-loader"></div><div class="dropify-errors-container"><ul></ul></div>
                  <input name="identity" type="file" class="dropify">
                  <button type="button" class="dropify-clear">Remove</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">Drag and drop or click to replace</p></div></div></div></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title d-flex">Upload Profile Picture
                  </h4>
                  <div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon"></span> <p>Drag and drop a file here or click</p><p class="dropify-error">Ooops, something wrong appended.</p></div><div class="dropify-loader"></div><div class="dropify-errors-container"><ul></ul></div>
                  <input name="profile_pic" type="file" class="dropify">
                  <button type="button" class="dropify-clear">Remove</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">Drag and drop or click to replace</p></div></div></div></div>
                </div>
                <div class="mt-3">
                    <button type="submit" name="register" class="btn btn-primary btn-lg btn-block">
                      <i class="mdi mdi-login"></i>                      
                      Sign In
                    </button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  
                </div>
                
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="login.php" class="text-primary">Login</a>
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
  <script src="js/file-upload.js"></script>
  <!-- endinject -->
</body>


</html>
