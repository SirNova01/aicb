

<?php
  session_start();
  include("../includes/db_conn.php");
  $day = date("Y-m-d");
  $date = date("Y-m-d H:i:s");


  if(isset($_GET['email']) && isset($_GET['code'])){

    $email = $_GET['email'];
    $code = $_GET['code'];

    $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($db_handle, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) { // if user exists
        if ($user['email_verification_code'] === $code) {
            
            $account_details_query= "UPDATE users SET   email_verification_status = 'verified', email_verification_code='0',account_status = 'active', reg_date = '$date', reg_day = '$day' WHERE email='$email'";
            if (mysqli_query($db_handle, $account_details_query)) {
                header("location: login.php");
            }


        }else{
            header("location: ../home.php");
        }
    }else{
        header("location: ../home.php");
    }
      
  }else{
      header("location: ../home.php");
  }


  ?>