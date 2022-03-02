<!DOCTYPE html>
<?php

    session_start();
    include("../includes/db_conn.php");
    $day = date("Y-m-d");
    $date = date("Y-m-d H:i:s");
    $script_name = pathinfo(__FILE__, PATHINFO_FILENAME);


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
    
    if(isset($_GET['notification_id'])){
      $notification_id = $_GET['notification_id'];

      $notification_details_query = "SELECT * FROM notifications WHERE notification_id='$notification_id' LIMIT 1";
      $notification_details_result = mysqli_query($db_handle, $notification_details_query);
      $notification_details = mysqli_fetch_assoc($notification_details_result);
      if ($notification_details) {
        $notification_title = $notification_details['title'];
        $notification_message = $notification_details['body'];
        $notification_date = $notification_details['send_date'];
        $notification_date = time_elapsed_string($notification_date);
      }

    }else{
      header("location: home.php");
    }

    $notification_update_query = "UPDATE notifications SET  status = 'seen' WHERE notification_id='$notification_id'";
    if (mysqli_query($db_handle, $notification_update_query)) {
    }

    
?>
<html lang="en">


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Message</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/font/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body class="sidebar-icon-only sidebar-fixed">
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
          <div class="email-wrapper wrapper">
            <div class="row align-items-stretch">
         
              <div class="mail-view d-none d-md-block col-md-9 col-lg-12 bg-white">
                <div class="row">
                  <div class="col-md-12 mb-4 mt-4">
                    <div class="btn-toolbar">
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary"><i class="mdi mdi-reply text-primary"></i> Reply</button>
                        
                      </div>
                      
                    </div>
                  </div>
                </div>
                <div class="message-body">
                  <div class="sender-details">
                    <img class="img-sm rounded-circle mr-3" src="images/faces/face11.jpg" alt="">
                    <div class="details">
                      <p class="sender-email">
                        From: 
                        <a>admin@fbs.com</a>
                      </p>
                      <p>
                        <?=$notification_date?>
                      </p>
                    </div>
                  </div>
                  <div class="message-content">
                    <?=$notification_message?>
                  </div>
                  <!-- <div class="attachments-sections">
                    <ul>
                      <li>
                        <div class="thumb"><i class="mdi mdi-file-pdf"></i></div>
                        <div class="details">
                          <p class="file-name">Seminar Reports.pdf</p>
                          <div class="buttons">
                            <p class="file-size">678Kb</p>
                            <a href="#" class="view">View</a>
                            <a href="#" class="download">Download</a>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="thumb"><i class="mdi mdi-file-image"></i></div>
                        <div class="details">
                          <p class="file-name">Product Design.jpg</p>
                          <div class="buttons">
                            <p class="file-size">1.96Mb</p>
                            <a href="#" class="view">View</a>
                            <a href="#" class="download">Download</a>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div> -->
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
  <!-- End custom js for this page-->
</body>


</html>
