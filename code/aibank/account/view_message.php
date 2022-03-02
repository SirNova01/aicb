<!DOCTYPE html>
<?php

  session_start();
    include("../includes/db_conn.php");
    $user_id = $_SESSION['user_id'];
    $date = date("Y-m-d H:i:s");
    $day = date("Y-m-d");

    $script_name = pathinfo(__FILE__, PATHINFO_FILENAME);

    $errors = array();

    if(isset($_GET['notification_id'])){
        $notification_id = $_GET['notification_id'];
    }else{
        header("location: all-notifications");
    }

    $message_update_query= "UPDATE notifications SET status = 'seen' WHERE notification_id='$notification_id'";
        if (mysqli_query($db_handle, $message_update_query)) {
        }
 
    $user_check_query = "SELECT * FROM users WHERE user_id='$user_id' LIMIT 1";
    $result = mysqli_query($db_handle, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) { 
      $username = $user['username'];
      $full_name = $user['full_name'];
      $email = $user['email'];
      $account_status = $user['account_status'];
      $profile_pic = $user['profile_pic_url'];
    }

    $notification_query = "SELECT * FROM notifications WHERE notification_id='$notification_id' LIMIT 1";
    $notification_result = mysqli_query($db_handle, $notification_query);
    $notification = mysqli_fetch_assoc($notification_result);
    if ($notification) { 
      $body = $notification['body'];
      $sender_id = $notification['sender_id'];
      $receiver_id = $notification['receiver_id'];
      $send_day = $notification['send_day'];
    }

    if($sender_id == "admin@fbs.com"){
        $receiver_query = "SELECT * FROM users WHERE user_id='$receiver_id' LIMIT 1";
        $receiver_result = mysqli_query($db_handle, $receiver_query);
        $receiver = mysqli_fetch_assoc($receiver_result);
        if ($receiver) { 
            $receiver_name = $receiver['username'];
       
        }
    }else{

        $sender_query = "SELECT * FROM users WHERE user_id='$sender_id' LIMIT 1";
        $sender_result = mysqli_query($db_handle, $sender_query);
        $sender = mysqli_fetch_assoc($sender_result);
        if ($sender) { 
            $sender_name = $sender['username'];
       
        }

    }

?>


<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Notifications</title>
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
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php include("includes/header.php");?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_settings-panel.html -->
      
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      <?php include("includes/sidebar.php");?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

            <div class="mail-view d-none d-md-block col-md-12 col-lg-12 bg-white">
                <div class="row">
                    <div class="col-md-12 mb-4 mt-4">
                    <div class="btn-toolbar">
                        <div class="btn-group">
                        <a href="message_user?user_id=<?php
                            if($sender_id == "admin@fbs.com"){
                                echo $receiver_id;
                            }else{
                                echo $sender_id;
                            }
                         ?>"><button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-message-reply text-primary"></i> Message User</button></a>
                        </div>
                      
                    </div>
                    </div>
                </div>
                <div class="message-body">
                    <div class="sender-details">
                    <div class="details">
                    <?php if($sender_id == "admin@fbs.com"){ ?>
                        <p class="msg-subject"> Sent on: <?= $send_day ?> </p>
                        <p class="sender-email"> To: <a href="#"> <?= $receiver_name ?> </a></p>
                    <?php }else{ ?>
                        <p class="msg-subject"> Received on: <?= $send_day ?> </p>
                        <p class="sender-email"> From: <a href="#"> <?= $sender_name ?> </a></p>
                    <?php } ?>
                        <br><br>
                    </div>
                    </div>
                    <div class="message-content">
                        <?= $body ?>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php include("includes/footer.php");?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
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
  <!-- Custom js for this page-->
  <script src="js/profile-demo.js"></script>
  <!-- End custom js for this page-->
</body>


</html>
