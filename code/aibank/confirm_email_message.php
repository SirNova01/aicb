<?php


    session_start();
    include("includes/db_conn.php");
    $day = date("Y-m-d");
    $date = date("Y-m-d H:i:s");
    $errors = array();

    $fullname ="";
    $email ="";
    $password="";
    $phone="";
    $ref_code="";

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
    $fullname =  mysqli_real_escape_string($db_handle, $_POST['fullname']);
    $email = mysqli_real_escape_string($db_handle, $_POST['email']);
    $password =  mysqli_real_escape_string($db_handle, $_POST['password']);
    $phone =  mysqli_real_escape_string($db_handle, $_POST['phone']);
    $ref_code =  mysqli_real_escape_string($db_handle, $_POST['ref_code']);


    if (empty($fullname)) { array_push($errors, "Full Name is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    $user_email_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $email_result = mysqli_query($db_handle, $user_email_check_query);
    $email_user = mysqli_fetch_assoc($email_result);
    if ($email_user) { array_push($errors, "Email already exists"); }
    if (empty($password)) { array_push($errors, "Password is required"); }
    if (empty($ref_code)) { array_push($errors, "Referral code is required"); }


    if (count($errors) == 0) {
      $enc_password = md5($password);

      $unique_number = uniqid(rand (), true);
      while(existInDb($unique_number, $db_handle)) {
         $unique_number = uniqid(rand (), true);                                       
      }
      $user_id = $unique_number;
      $email_verification_code = uniqid(rand (), true);   
      $register_query = "INSERT INTO users ( user_id, 	fullname,	  email,	   phone,	password,	     ref_code, referrer,  	 evs,	       evc,                         	lcdt,	account_verification_status,     account_type,	reg_date,	reg_day,	last_login_date,	last_login_day ) 
                                    VALUES('$user_id',  '$fullname', '$email','$phone', '$enc_password',      '',  '$ref_code','not_verified', '$email_verification_code',    '$date',  'not_verified',      'user',     '',  '',   '',  '' )";
      if(mysqli_query($db_handle, $register_query)){

         $_SESSION['email'] = $email;

      // $email_body = "
      //         Click on the link below to confirm your AICB account 
      //         http://www.aicb.capital/email_confirmation_redirect?email=$email&&code=$email_verification_code
      //     ";
      // $email_subject = "AICB Email Confirmation";
      // $res = mail($email, $email_subject, $email_body, "From: NoReply@aicb.capital");
      // if($res){
         header("location: confirm_email_message");
      // }
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
      <link rel="icon" type="image/png" href="favicon.html">
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
                           <img src="assets/banner-site-img.png" alt="">
                        </div>
                     </div>
                     
                     <div class="col-md-6 col-lg-5 offset-lg-1 wow fadeInUp" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-name: fadeInUp;">
                        <div class="blockcain-content">
                           <small class="xs-section-title">Get Started</small>
                           <h3 class="column-title">Create a Secure Account</h3>
                           <form method="post" class="widget-subscibe">
                           <?php include('includes/errors.php'); ?>
                              <input type="text" name="fullname" class="subscribe-email" placeholder="First & Last Name">
                              <input style="margin-top:20px;" type="email" name="email" class="subscribe-email" placeholder="Valid Email">
                              <input style="margin-top:20px;" type="text" name="phone" class="subscribe-email" placeholder="Phone Number">
                              <input style="margin-top:20px;" type="password" name="password" class="subscribe-email" placeholder="Create A Password">
                              <input style="margin-top:20px;" type="text" name="ref_code" class="subscribe-email" placeholder="Referral Code">
                              <button name="register" type="submit" class="btn btn-primary">Continue </button>
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
