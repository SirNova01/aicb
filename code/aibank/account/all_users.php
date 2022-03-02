<!DOCTYPE html>
<?php
      session_start();
      include("../includes/db_conn.php");
  
      $auth = 0;
      if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'user'){
           $auth = 1;
        }
        if($_SESSION['user_role'] == 'admin'){
          $auth = 1;
        }
        if($_SESSION['account_status'] == 'suspended'){
          header('location: ../account_suspended.php');
        }
        if($auth == 0){
          header('location: ../home.php');
        }
          
      }else{
        header('location: ../home.php');
      }
  
      $script_name = pathinfo(__FILE__, PATHINFO_FILENAME);
      

    

      $user_id = $_SESSION['user_id'];
      $date = date("Y-m-d H:i:s");
      $day = date("Y-m-d");

      $user_details_query = "SELECT * FROM users WHERE user_id='$user_id' LIMIT 1";
      $user_details_result = mysqli_query($db_handle, $user_details_query);
      $user_details = mysqli_fetch_assoc($user_details_result);
      if ($user_details) {
        $username = $user_details['username'];
        $fullname = $user_details['full_name'];
        $email = $user_details['email'];
      }


?>


<html lang="en">


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>All Users</title>
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


          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Showing All Users</h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th> .</th>
                            <th>.</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $user_counter = 1;
                          $empty = TRUE;
                          $table_result = $db_handle->query("SELECT * FROM users");
                          foreach ($table_result as $user_row): ?>
                            <tr>
                                <td><?= $user_counter ?></td>
                                <td>
                                  <?=$user_row['full_name']?>
                                </td>
                                <td><?= $user_row['account_status'] ?></td>
                                <td>
                                  <a href="view_user.php?user_id=<?= $user_row['user_id'] ?>">
                                    <button type="button" class="btn btn-primary btn-icon-text">
                                      <i class="mdi mdi-eye btn-icon-prepend"></i>
                                      View
                                    </button>
                                  </a>
                                </td>
                                <td>
                                    <a href="message_user?user_id=<?= $user_row['user_id'] ?>">
                                      <button type="button" class="btn btn-success btn-icon-text">
                                        <i class="mdi mdi-message-alert btn-icon-prepend"></i>
                                        Message
                                      </button>
                                    </a>
                                </td>
                            </tr>
                        <?php $empty = FALSE; $user_counter++; endforeach; unset($user_row); if ($empty == TRUE) echo "<h6 style='text-align: center; color: red'></h6>" ?>
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
