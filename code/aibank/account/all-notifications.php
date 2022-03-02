<!DOCTYPE html>
<?php

  session_start();
    include("../includes/db_conn.php");
    $user_id = $_SESSION['user_id'];
    $date = date("Y-m-d H:i:s");
    $day = date("Y-m-d");

    $script_name = pathinfo(__FILE__, PATHINFO_FILENAME);

    $errors = array();
    

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

          <div class="row">
            <div class="col-12">
              <div class="card">
              <div class="card-body">
                  <h4 class="card-title">Showing All Notifications</h4>
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                          <th class="pl-0">S/N</th>
                          <th class="pl-0">Type</th>
                          <th class="">Status</th>
                          <th class="text-right">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $notification_counter = 1;
                          $empty = TRUE;
                          $table_result = $db_handle->query("SELECT * FROM notifications WHERE receiver_id ='admin@fbs.com' OR sender_id = 'admin@fbs.com' ");
                          foreach ($table_result as $notification_row): ?>
                              <tr>
                                  <td>
                                      <?= $notification_counter ?>
                                  </td>

                                  <?php if($notification_row['sender_id'] == "admin@fbs.com"){ ?>
                                    <td class="pl-0"> Sent </td>
                                  <?php } else{ ?>
                                    <td class="pl-0"> Received </td>
                                  <?php } ?>

                                  <?php if($notification_row['sender_id'] == "admin@fbs.com"){ ?>
                                    <td><div class="badge badge-pill badge-primary"><i class="mdi mdi-check-all mr-2"></i>Delivered</div></td>
                                  <?php }else{ ?>
                                    <?php if($notification_row['status'] == "unseen"){ ?>
                                      <td><div class="badge badge-pill badge-danger"><i class="mdi mdi-eye-off mr-2"></i>Unseen</div></td>
                                    <?php }else{ ?>
                                      <td><div class="badge badge-pill badge-success"><i class="mdi mdi-eye mr-2"></i>Seen</div></td>
                                    <?php } ?>
                                  <?php } ?>

                                  <td class="pr-0 text-right">
                                    <a href="view_message?notification_id=<?= $notification_row['notification_id'] ?>">
                                      <button type="button" class="btn btn-primary btn-sm btn-rounded btn-icon-text">
                                        <i class="mdi mdi-eye btn-icon-prepend"></i>
                                        View
                                      </button>
                                    </a>
                                  </td>
                              </tr>
                          <?php $empty = FALSE; $notification_counter++; endforeach; unset($notification_row); if ($empty == TRUE) echo "<h6 style='text-align: center; color: red'>You have no notification(s)</h6>" ?>
                      </tbody>
                    </table>
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
  <script src="js/data-table.js"></script>
  <!-- End custom js for this page-->
</body>


</html>
