<!DOCTYPE html>
<?php
      session_start();
      include("../includes/db_conn.php");
  
      if (isset($_SESSION['account_type'])) {
        if ($_SESSION['account_type'] == 'user' && $_SESSION['status'] == 'logged in'){
        }else{
          header('location: ../login');
        }
       
      }else{
        header('location: ../login');
      }
  
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


      $user_id = $_SESSION['user_id'];
      $date = date("Y-m-d H:i:s");
      $day = date("Y-m-d");

      $user_details_query = "SELECT * FROM users WHERE user_id='$user_id' LIMIT 1";
      $user_details_result = mysqli_query($db_handle, $user_details_query);
      $user_details = mysqli_fetch_assoc($user_details_result);
      if ($user_details) {
        $fullname = $user_details['fullname'];
        $email = $user_details['email'];
        $phone = $user_details['phone'];
        $ref_code = $user_details['ref_code'];
        $account_verification_status = $user_details['account_verification_status'];
        $reg_date = $user_details['reg_date'];
                     	   
      }



?>


<html lang="en">


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>User Dashboard</title>
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
    <!-- partial:partials/_navbar.html -->
    <?php include("includes/header.php");?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      
      <!-- partial:partials/_sidebar.html -->
      <?php include("includes/sidebar.php");?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

          <?php if(isset($_GET['msg_success'])){ ?>
            <div class="alert alert-success" role="alert">
                  <?= $_GET['msg_success'] ?>
            </div>
          <?php } ?>

          <?php if(isset($_GET['msg_error'])){ ?>
            <div class="alert alert-danger" role="alert">
                  <?= $_GET['msg_error'] ?>
            </div>
          <?php } ?>

          <div class="row">
            <div class="col-md-4 grid-margin">
							<div class="card bg-facebook">
								<div class="card-body">
									<div class="d-flex flex-row align-items-top">
                    <i class="mdi mdi-account-multiple text-white icon-md"></i>
										<div class="ml-3">
                      <?php
                        // $unseen_reports_query = "SELECT * FROM reports WHERE report_status='completed' AND view_status = 'unseen'";
                        // $unseen_reports_result = mysqli_query($db_handle, $unseen_reports_query);
                        // $rows = mysqli_num_rows($unseen_reports_result);
                      ?>
											<h6 style="margin-top:8px" class="text-white"> 308 Users Visited Today </h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 grid-margin">
							<div class="card bg-linkedin">
								<div class="card-body">
									<div class="d-flex flex-row align-items-top">
                    <i class="mdi mdi-account-multiple text-white icon-md"></i>
										<div class="ml-3">
                      <?php
                        // $loggedin_users_query = "SELECT * FROM users WHERE last_login_day='$day'";
                        // $loggedin_users_result = mysqli_query($db_handle, $loggedin_users_query);
                        // $loggedin_users_rows = mysqli_num_rows($loggedin_users_result);
                      ?>
											<h6 style="margin-top:8px" class="text-white">308 Users Visited This Month</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 grid-margin">
							<div class="card bg-twitter">
								<div class="card-body">
									<div class="d-flex flex-row align-items-top">
										<i class="mdi mdi-account-multiple text-white icon-md"></i>
										<div class="ml-3">
                      <?php
                        // $registered_users_query = "SELECT * FROM users WHERE reg_day='$day'";
                        // $registered_users_result = mysqli_query($db_handle, $registered_users_query);
                        // $registered_users_rows = mysqli_num_rows($registered_users_result);
                      ?>
											<h6 style="margin-top:8px" class="text-white"> 308 Users Visited This Year</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>


          <div class="row">
            <div class="col-md-4 grid-margin">
							<div class="card">
								<div class="card-body">
									<div class="d-flex flex-row align-items-top">
										<i class="mdi mdi-package-variant text-facebook icon-md"></i>
										<div class="ml-3">
											<a href="projects"><h6 style="margin-top:8px" class="text-facebook"> Project Portfolio </h6></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 grid-margin">
							<div class="card">
								<div class="card-body">
									<div class="d-flex flex-row align-items-top">
										<i class="mdi mdi-format-list-bulleted text-youtube icon-md"></i>
										<div class="ml-3">
											<h6 style="margin-top:8px" class="text-youtube">Niches</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 grid-margin">
							<div class="card">
								<div class="card-body">
									<div class="d-flex flex-row align-items-top">
										<i class="mdi mdi-cursor-default text-twitter icon-md"></i>
										<div class="ml-3">
											<h6 style="margin-top:8px" class="text-twitter"> Total Project Views </h6>
										</div>
									</div>
								</div>
							</div>
						</div>
          </div>



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
                          $table_result = $db_handle->query("SELECT * FROM notifications WHERE receiver_id ='ichonia.com' ORDER BY id desc");
                          foreach ($table_result as $notification_row): ?>
                              <tr>
                                  <td>
                                      <?= $notification_counter ?>
                                  </td>

                                  <?php if($notification_row['sender_id'] == "ichonia.com"){ ?>
                                    <td class="pl-0"> Sent </td>
                                  <?php } else{ ?>
                                    <td class="pl-0"> Received </td>
                                  <?php } ?>

                                  <?php if($notification_row['sender_id'] == "ichonia.com"){ ?>
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
        <!-- partial:partials/_footer.html -->
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
  <script src="js/data-table.js"></script>
  <!-- End custom js for this page-->
</body>


</html>
