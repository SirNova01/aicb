<?php

   session_start();
   include("includes/db_conn.php");
   $day = date("Y-m-d");
   $year = date("y");
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
                  $email_verification_status = $user['evs'];
                  $_SESSION['email'] = $email;
                  if ($email_verification_status == "verified"){
                      $account_verification_status = $user['account_verification_status'];
  
                    if($account_verification_status == "active" || $account_verification_status == "not_verified"){
                      $_SESSION['status'] = "logged in";
                      $_SESSION['email'] = $email;
                      $_SESSION['account_type'] = $user['account_type'];
                      $_SESSION['user_id'] = $user['user_id'];
                      $_SESSION['account_verification_status'] =$user['account_verification_status'];
                     
                      if( $user['account_type'] == "admin_nova"){
                        header('location: admin');
                      }else{
                        header('location: account');
                      }
                      
                    }else{
                      if($account_verification_status == "suspended"){
                        array_push($errors, "Your account has been suspended, please contact support@aicb.capital");
                       
                      }else{
                        array_push($errors, "Your account is not active, please contact support@aicb.capital");
                       
                      }
                    }
  
                  }else{
                      header("location: confirm_email_message");
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

<!doctype html>
<html class="no-js" lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>Crypto Bank - </title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
      <link rel="icon" type="image/png" href="favicon.png">
      <!-- Place favicon.ico in the root directory -->
      <link rel="apple-touch-icon" href="apple-touch-icon.html">
      <link rel="stylesheet" href="assets/css/fontawesome-min.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/xsIcon.css">
      <link rel="stylesheet" href="assets/fonts/icomoon/style.css">
      <link rel="stylesheet" href="assets/css/magnific-popup.css">
      <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
      <link rel="stylesheet" href="assets/css/navigation.css">
      <link rel="stylesheet" href="assets/css/animate.css">
      <!--Theme custom css -->
      <link rel="stylesheet" href="assets/css/style.css">
      <!--Theme Responsive css-->
      <link rel="stylesheet" href="assets/css/responsive.css"/>
      
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

  .center {
   height: 100%;
   display: flex;
   align-items: center;
   justify-content: center;
}
</style>

  
      <div class="preloader" id="preloader">
         <div class="center">
            <img src="images/logo.png" />
            </div>
         <a class="cencel-preloader" href="#">X</a>
      </div>
    
      <!-- sidebar cart item -->
     
      <!-- END sidebar cart item -->    <!-- END offset cart strart -->
      <!-- sidebar cart item -->
      <?php include("inc/side.php"); ?>
      <!-- END sidebar widget item -->    <!-- END offset cart strart -->
      <div class="wrap-area-v2">
         <!-- header section start -->
         <?php include("inc/header.php") ?>
         <!-- header section end -->
         <div id="particles-js">
            <!-- banner start -->
            <section class="banner-sec banner-v2">
              
            </section>
         
         </div>

         <div id="signup" class="blockcain-and-featured-area">
          
            <section class="blockcain-business-sec">
               <div class="container">
                  <div class="row">
                     <!-- col end -->
                     <div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-duration="1.5s" style="visibility: visible; animation-duration: 1.5s; animation-name: fadeInUp;">
                        <div class="blockcain-img">
                           <img src="assets/ft1.png" alt="">
                        </div>
                     </div>
                     
                     <div class="col-md-6 col-lg-5 offset-lg-1 wow fadeInUp" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-name: fadeInUp;">
                        <div class="blockcain-content">
                           <small class="xs-section-title">Sign In</small>
                           <h3 class="column-title">Create a Secure Account</h3>
                           <form method="post" class="widget-subscibe">
                           <?php include('includes/errors.php'); ?>
                              <input style="margin-top:20px;" type="email" name="email" class="subscribe-email" placeholder="Email">
                              <input style="margin-top:20px;" type="password" name="password" class="subscribe-email" placeholder="Password">
                              <button name="login" type="submit" class="btn btn-primary">Sign In </button>
                           </form>
                           
                           <!-- <a href="#" class="btn btn-primary">Get Started</a> -->
                        </div>
                     </div>

                  </div>
               </div>
            </section>
           
         </div>

         <div class="blog-and-footer-area">
          
            <!-- footer section start -->
            <?php include("inc/footer.php"); ?>
            <!-- footer section end -->
         </div>
      </div>
      <!-- footer section start -->
      <!--back to top start-->
      <div class="BackTo">
         <a href="#" class="fa fa-angle-up" aria-hidden="true"></a>
      </div>
      <!--back to top end-->
      <script src="assets/js/jquery-3.2.1.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="assets/js/jquery.magnific-popup.min.js"></script>
      <script src="assets/js/owl.carousel.min.js"></script>
      <script src="assets/js/navigation.js"></script>
      <script src="assets/js/jquery.appear.min.js"></script>
      <script src="assets/js/wow.min.js"></script>
      <script src="assets/js/chart.min.js"></script>
      <script src="assets/js/particles.min.js"></script>
      <script src="assets/js/smooth-scroling.js"></script>
      <script src="assets/js/main.js"></script>
   </body>
</html>
