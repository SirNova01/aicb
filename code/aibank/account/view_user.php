<!DOCTYPE html>
<?php

  session_start();
    include("../includes/db_conn.php");
    $user_id = $_SESSION['user_id'];
    $date = date("Y-m-d H:i:s");
    $day = date("Y-m-d");
    $script_name = pathinfo(__FILE__, PATHINFO_FILENAME);
    $errors = array();

    if(isset($_GET['user_id'])){

        $account_id = $_GET['user_id'];

    }else{
        header("location: all_users.php");
    }

    $user_check_query = "SELECT * FROM users WHERE user_id='$account_id' LIMIT 1";
    $result = mysqli_query($db_handle, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) { 
      $username = $user['username'];
      $full_name = $user['full_name'];
      $email = $user['email'];
      $account_status = $user['account_status'];
      $profile_pic = "../account/".$user['profile_pic_url'];
      $last_login = $user['last_login_date'];
    }


    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
      }

?>


<html lang="en">


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>User Profile</title>
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
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row justify-content-center">
                    <div class="col-lg-8">
                      <div class="border-bottom text-center pb-4">
                        <img src="<?=$profile_pic?>" alt="profile" class="img-lg rounded-circle mb-3"/>
                        <h4><?=$full_name?></h4>
                        <a href="message_user?user_id=<?=$account_id?>">
                            <button class="btn btn-outline-secondary btn-icon">
                                <i class="mdi mdi-comment-processing"></i>
                            </button>
                        </a>
                        <!-- <div class="d-flex justify-content-between">
                          <button class="btn btn-success">Hire Me</button>
                          <button class="btn btn-success">Follow</button>
                        </div> -->
                      </div>
                      
                      <div class="border-bottom py-4">
                        <div class="d-flex mb-3">
                          <div class="progress progress-md flex-grow">
                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" style="width: 100%" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                      <div class="py-4">
                        <p class="clearfix">
                          <span class="float-left">
                            Username
                          </span>
                          <span class="float-right text-muted">
                            <?=$username?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Full Name
                          </span>
                          <span class="float-right text-muted">
                          <?=$full_name?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Email
                          </span>
                          <span class="float-right text-muted">
                          <?=$email?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Account Status
                          </span>
                          <span class="float-right text-muted">
                            <a style="color:blue;"><?=$account_status?></a>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Last Login
                          </span>
                          <span class="float-right text-muted">
                            <a style="color:blue;"><?php echo(time_elapsed_string($last_login));?> </a>
                          </span>
                        </p>
                        
                      </div>
                      <div class="d-flex mb-3">
                          <div class="progress progress-md flex-grow">
                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="100" style="width: 100%" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                      </div>
                      <!-- <button class="btn btn-primary btn-block">Preview</button> -->
                    </div>
                    
                  </div>
                </div>
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
