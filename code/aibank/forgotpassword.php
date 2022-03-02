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

<!DOCTYPE html>
<html lang="en">
   <meta http-equiv="content-type" content="text/html;charset=utf-8" />
   <?php include("includes/head.php"); ?>
   <body>
      <div id="__next">
         <div class="footerstyle__FooterWrapper-sc-1cwgyes-0 fPHZiX">
            <div class="Box__BoxWrapper-sc-9qo6sy-0 hHLgFu box footer-content-wrapper">
               <div id="contact" class="subscribestyle__SubscribeWrapper-sc-9vdewm-0 hvKkOy">
                  <div class="containerstyle__ContainerWrapper-sc-8s1uzo-0 dnkXqM container">
                     <div class="rowstyle__RowWrapper-sc-1nreibv-0 ljhoKP row">
                        <div class="colstyle__ColWrapper-sc-1oqivd3-0 cSKItV col col-12">
                           <div class="Box__BoxWrapper-sc-9qo6sy-0 hHLgFu box subscribe-box-bg">
                              <div class="rowstyle__RowWrapper-sc-1nreibv-0 ljhoKP row">
                                 <div class="colstyle__ColWrapper-sc-1oqivd3-0 cSKItV col lg-6 offset-lg-3 xs-12">
                                    <div class="sectionTitlestyle__SectionTitleWrapper-lzdnsw-0 fjPqRn title__wrapper">
                                       <h1 class="Heading__HeadingWrap-sc-1tne3rx-0 kMvOWj heading">  Confirm your email</h1>
                                       <p class="Text__TextWrapper-sc-5ha4qu-0 cOKoiv text">please enter your registered email address to recover your AICB account </b> </p>
                                    </div>
                                 </div>
                              </div>
                              <form method="post" action="signin">
                              <?php include('includes/errors.php'); ?>
                              <div class="rowstyle__RowWrapper-sc-1nreibv-0 ljhoKP row">
                                 <div class="colstyle__ColWrapper-sc-1oqivd3-0 cSKItV col lg-8 offset-lg-2 xs-12">
                                    <div class="Box__BoxWrapper-sc-9qo6sy-0 hHLgFu box form-box">
                                       <div class="inputstyle__InputWrapper-x4q24z-0 eBaPLn input__wrapper"><input type="text" placeholder="Enter your email address . . ."/></div>
                                       
                                    </div>
                                 </div>
                              </div>
                      
                              <div style="margin-top:-40px;" class="rowstyle__RowWrapper-sc-1nreibv-0 ljhoKP row">
                                 <div class="colstyle__ColWrapper-sc-1oqivd3-0 cSKItV col lg-8 offset-lg-2 xs-12">
                                    <div class="Box__BoxWrapper-sc-9qo6sy-0 hHLgFu box form-box">
                                       <button class="buttonstyle__ButtonWrapper-vboqqy-0 khusAO btn">Confirm</button>
                                    </div>
                                 </div>
                              </div>
                              <div style="margin-top:60px;" class="rowstyle__RowWrapper-sc-1nreibv-0 ljhoKP row">
                                 <div class="colstyle__ColWrapper-sc-1oqivd3-0 cSKItV col lg-6 offset-lg-3 xs-6">
                                    <div class="sectionTitlestyle__SectionTitleWrapper-lzdnsw-0 fjPqRn title__wrapper">
                                       <!-- <h1 class="Heading__HeadingWrap-sc-1tne3rx-0 kMvOWj heading"> Sign In </h1> -->
                                       <p class="Text__TextWrapper-sc-5ha4qu-0 cOKoiv text"><b> <a href="signin"> Sign In </a></b> </p>
                                    </div>
                                 </div>
                              </div>
                              

                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="containerstyle__ContainerWrapper-sc-8s1uzo-0 dnkXqM container">
                  <div class="rowstyle__RowWrapper-sc-1nreibv-0 ljhoKP row">
                     <div class="colstyle__ColWrapper-sc-1oqivd3-0 cSKItV col lg-3 sm-6">
                        <div class="Box__BoxWrapper-sc-9qo6sy-0 hHLgFu box footer-widgets company-desc">
                           <img src="images/logo.png" alt="aicb footer logo" class="Image__ImageWrapper-l1s4uw-0 dvVulc image"/>
                           <p class="Text__TextWrapper-sc-5ha4qu-0 cOKoiv text">AICB is the first global decentralized investment bank powered by the highest performing machine learning models.</p>
                           <div class="Box__BoxWrapper-sc-9qo6sy-0 hHLgFu box contact-info">
                              <a href="#">
                                 <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a23.94 23.94 0 0 0 6.9-28l-48-112A24.16 24.16 0 0 0 122.6.61l-104 24A24 24 0 0 0 0 48c0 256.5 207.9 464 464 464a24 24 0 0 0 23.4-18.6l24-104a24.29 24.29 0 0 0-14.01-27.6z"></path>
                                 </svg>
                                 +88 12345 697858
                              </a>
                              <a href="#">
                                 <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path>
                                 </svg>
                                 contact@aicb.capital
                              </a>
                           </div>
                        </div>
                     </div>
                     <div class="colstyle__ColWrapper-sc-1oqivd3-0 cSKItV col lg-3 sm-6">
                        <div class="Box__BoxWrapper-sc-9qo6sy-0 hHLgFu box footer-widgets">
                           <h2 class="Heading__HeadingWrap-sc-1tne3rx-0 kMvOWj heading">Company</h2>
                           <ul class="List__ListWrapper-sc-1eqtjxi-0 jdwhEj list">
                              <li class="List__ListItemWrapper-sc-1eqtjxi-1 jNRSEn list__item"><a href="#">About Aicb</a></li>
                              <li class="List__ListItemWrapper-sc-1eqtjxi-1 jNRSEn list__item"><a href="#">Our Features</a></li>
                              <li class="List__ListItemWrapper-sc-1eqtjxi-1 jNRSEn list__item"><a href="#">Company News</a></li>
                           </ul>
                        </div>
                     </div>
                     <div class="colstyle__ColWrapper-sc-1oqivd3-0 cSKItV col lg-3 sm-6">
                        <div class="Box__BoxWrapper-sc-9qo6sy-0 hHLgFu box footer-widgets">
                           <h2 class="Heading__HeadingWrap-sc-1tne3rx-0 kMvOWj heading">Support</h2>
                           <ul class="List__ListWrapper-sc-1eqtjxi-0 jdwhEj list">
                              <li class="List__ListItemWrapper-sc-1eqtjxi-1 jNRSEn list__item"><a href="#">Contact Us</a></li>
                              <li class="List__ListItemWrapper-sc-1eqtjxi-1 jNRSEn list__item"><a href="#">FAQ</a></li>
                              <li class="List__ListItemWrapper-sc-1eqtjxi-1 jNRSEn list__item"><a href="#">Support</a></li>
                              <li class="List__ListItemWrapper-sc-1eqtjxi-1 jNRSEn list__item"><a href="#">Media</a></li>
                           </ul>
                        </div>
                     </div>
                     <div class="colstyle__ColWrapper-sc-1oqivd3-0 cSKItV col lg-3 sm-6">
                        <div class="Box__BoxWrapper-sc-9qo6sy-0 hHLgFu box footer-widgets address">
                           <h2 class="Heading__HeadingWrap-sc-1tne3rx-0 kMvOWj heading">Our Address</h2>
                           <p class="Text__TextWrapper-sc-5ha4qu-0 cOKoiv text">1370 Roosevelt Street, Little York City, New Jersey 08834</p>
                        </div>
                     </div>
                  </div>
                  <div class="rowstyle__RowWrapper-sc-1nreibv-0 ljhoKP row">
                     <div class="colstyle__ColWrapper-sc-1oqivd3-0 cSKItV col xs-12">
                        <div class="Box__BoxWrapper-sc-9qo6sy-0 hHLgFu box footer-social-links">
                           <a href="#">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
                              </svg>
                           </a>
                           <a href="#">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 320 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M309.8 480.3c-13.6 14.5-50 31.7-97.4 31.7-120.8 0-147-88.8-147-140.6v-144H17.9c-5.5 0-10-4.5-10-10v-68c0-7.2 4.5-13.6 11.3-16 62-21.8 81.5-76 84.3-117.1.8-11 6.5-16.3 16.1-16.3h70.9c5.5 0 10 4.5 10 10v115.2h83c5.5 0 10 4.4 10 9.9v81.7c0 5.5-4.5 10-10 10h-83.4V360c0 34.2 23.7 53.6 68 35.8 4.8-1.9 9-3.2 12.7-2.2 3.5.9 5.8 3.4 7.4 7.9l22 64.3c1.8 5 3.3 10.6-.4 14.5z"></path>
                              </svg>
                           </a>
                           <a href="#">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M386.061 228.496c1.834 9.692 3.143 19.384 3.143 31.956C389.204 370.205 315.599 448 204.8 448c-106.084 0-192-85.915-192-192s85.916-192 192-192c51.864 0 95.083 18.859 128.611 50.292l-52.126 50.03c-14.145-13.621-39.028-29.599-76.485-29.599-65.484 0-118.92 54.221-118.92 121.277 0 67.056 53.436 121.277 118.92 121.277 75.961 0 104.513-54.745 108.965-82.773H204.8v-66.009h181.261zm185.406 6.437V179.2h-56.001v55.733h-55.733v56.001h55.733v55.733h56.001v-55.733H627.2v-56.001h-55.733z"></path>
                              </svg>
                           </a>
                           <a href="#">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 320 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                              </svg>
                           </a>
                           <a href="#">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path>
                              </svg>
                           </a>
                           <a href="#">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M94.12 315.1c0 25.9-21.16 47.06-47.06 47.06S0 341 0 315.1c0-25.9 21.16-47.06 47.06-47.06h47.06v47.06zm23.72 0c0-25.9 21.16-47.06 47.06-47.06s47.06 21.16 47.06 47.06v117.84c0 25.9-21.16 47.06-47.06 47.06s-47.06-21.16-47.06-47.06V315.1zm47.06-188.98c-25.9 0-47.06-21.16-47.06-47.06S139 32 164.9 32s47.06 21.16 47.06 47.06v47.06H164.9zm0 23.72c25.9 0 47.06 21.16 47.06 47.06s-21.16 47.06-47.06 47.06H47.06C21.16 243.96 0 222.8 0 196.9s21.16-47.06 47.06-47.06H164.9zm188.98 47.06c0-25.9 21.16-47.06 47.06-47.06 25.9 0 47.06 21.16 47.06 47.06s-21.16 47.06-47.06 47.06h-47.06V196.9zm-23.72 0c0 25.9-21.16 47.06-47.06 47.06-25.9 0-47.06-21.16-47.06-47.06V79.06c0-25.9 21.16-47.06 47.06-47.06 25.9 0 47.06 21.16 47.06 47.06V196.9zM283.1 385.88c25.9 0 47.06 21.16 47.06 47.06 0 25.9-21.16 47.06-47.06 47.06-25.9 0-47.06-21.16-47.06-47.06v-47.06h47.06zm0-23.72c-25.9 0-47.06-21.16-47.06-47.06 0-25.9 21.16-47.06 47.06-47.06h117.84c25.9 0 47.06 21.16 47.06 47.06 0 25.9-21.16 47.06-47.06 47.06H283.1z"></path>
                              </svg>
                           </a>
                           <a href="#">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M71.5 142.3c.6-5.9-1.7-11.8-6.1-15.8L20.3 72.1V64h140.2l108.4 237.7L364.2 64h133.7v8.1l-38.6 37c-3.3 2.5-5 6.7-4.3 10.8v272c-.7 4.1 1 8.3 4.3 10.8l37.7 37v8.1H307.3v-8.1l39.1-37.9c3.8-3.8 3.8-5 3.8-10.8V171.2L241.5 447.1h-14.7L100.4 171.2v184.9c-1.1 7.8 1.5 15.6 7 21.2l50.8 61.6v8.1h-144v-8L65 377.3c5.4-5.6 7.9-13.5 6.5-21.2V142.3z"></path>
                              </svg>
                           </a>
                           <a href="#">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M446.7 98.6l-67.6 318.8c-5.1 22.5-18.4 28.1-37.3 17.5l-103-75.9-49.7 47.8c-5.5 5.5-10.1 10.1-20.7 10.1l7.4-104.9 190.9-172.5c8.3-7.4-1.8-11.5-12.9-4.1L117.8 284 16.2 252.2c-22.1-6.9-22.5-22.1 4.6-32.7L418.2 66.4c18.4-6.9 34.5 4.1 28.5 32.2z"></path>
                              </svg>
                           </a>
                           <a href="#">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M510.846 392.673c-5.211 12.157-27.239 21.089-67.36 27.318-2.064 2.786-3.775 14.686-6.507 23.956-1.625 5.566-5.623 8.869-12.128 8.869l-.297-.005c-9.395 0-19.203-4.323-38.852-4.323-26.521 0-35.662 6.043-56.254 20.588-21.832 15.438-42.771 28.764-74.027 27.399-31.646 2.334-58.025-16.908-72.871-27.404-20.714-14.643-29.828-20.582-56.241-20.582-18.864 0-30.736 4.72-38.852 4.72-8.073 0-11.213-4.922-12.422-9.04-2.703-9.189-4.404-21.263-6.523-24.13-20.679-3.209-67.31-11.344-68.498-32.15a10.627 10.627 0 0 1 8.877-11.069c69.583-11.455 100.924-82.901 102.227-85.934.074-.176.155-.344.237-.515 3.713-7.537 4.544-13.849 2.463-18.753-5.05-11.896-26.872-16.164-36.053-19.796-23.715-9.366-27.015-20.128-25.612-27.504 2.437-12.836 21.725-20.735 33.002-15.453 8.919 4.181 16.843 6.297 23.547 6.297 5.022 0 8.212-1.204 9.96-2.171-2.043-35.936-7.101-87.29 5.687-115.969C158.122 21.304 229.705 15.42 250.826 15.42c.944 0 9.141-.089 10.11-.089 52.148 0 102.254 26.78 126.723 81.643 12.777 28.65 7.749 79.792 5.695 116.009 1.582.872 4.357 1.942 8.599 2.139 6.397-.286 13.815-2.389 22.069-6.257 6.085-2.846 14.406-2.461 20.48.058l.029.01c9.476 3.385 15.439 10.215 15.589 17.87.184 9.747-8.522 18.165-25.878 25.018-2.118.835-4.694 1.655-7.434 2.525-9.797 3.106-24.6 7.805-28.616 17.271-2.079 4.904-1.256 11.211 2.46 18.748.087.168.166.342.239.515 1.301 3.03 32.615 74.46 102.23 85.934 6.427 1.058 11.163 7.877 7.725 15.859z"></path>
                              </svg>
                           </a>
                           <a href="#">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 384 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path>
                              </svg>
                           </a>
                           <a href="#">
                              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 576 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path>
                              </svg>
                           </a>
                        </div>
                        <div class="Box__BoxWrapper-sc-9qo6sy-0 hHLgFu box copyright-text">
                           <p class="Text__TextWrapper-sc-5ha4qu-0 cOKoiv text">© AICB | All right rserved 2020</p>
                           <span class="Text__TextWrapper-sc-5ha4qu-0 cOKoiv text">
                              Powered By <a href="http://intellidane.com">Intellidane Cybernetics</a>
                           </span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>