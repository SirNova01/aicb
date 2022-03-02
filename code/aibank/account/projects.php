<!DOCTYPE html>
<?php
      session_start();
      include("../includes/db_conn.php");
  
      if (isset($_SESSION['status']) && $_SESSION['status']=="logged in") {          
      }else{
        header('location: logout');
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
        $username = $user_details['username'];       
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
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align:center;" class="d-flex flex-row align-items-center">
                            <i class="mdi mdi-monitor-dashboard text-facebook icon-md"></i>
                            <div class="ml-3">
                                <h6 class="text-facebook">Projects Portfolio</h6>
                                <p class="mt-2 text-muted card-text">Manage portfolio items.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>


          <div class="row">
            <?php
              $item_one_counter = 1;
              $empty = TRUE;
              $item_result = $db_handle->query("SELECT * FROM projects");
              foreach ($item_result as $item_one_row): ?>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row flex-wrap">
                      <img src="<?= $item_one_row['thumb_image'] ?>" class="img-lg rounded" alt="profile image">
                      <div class="ml-3">
                        <h6>App Name: <?= $item_one_row['app_name'] ?></h6>
                        <p class="text-muted">Niche:  <?= $item_one_row['niche'] ?> </p>
                        <p class="mt-2 text-primary font-weight-bold">Niche: <?= $item_one_row['short_note'] ?></p>
                        
                      </div>
                    </div>
                    <a href="delete_design?id=<?= $item_one_row['app_id'] ?>"><button type="button" class="btn btn-outline-danger btn-fw">Delete</button></a>
                    <a href="edit_project?id=<?= $item_one_row['app_id'] ?>"><button type="button" class="btn btn-outline-primary btn-fw">Edit</button></a>
                  
                  </div>
                </div>
              </div>
            <?php $empty = FALSE; $item_one_counter++; endforeach; unset($item_one_row); if ($empty == TRUE) echo "<h6 style='text-align: center; color: red'>There are no items to display</h6>" ?>
           
            <a href="add_projects"> <button style="margin-bottom:25px; margin-left:15px;" type="button" class="btn btn-outline-primary btn-icon-text"><i class="mdi mdi-database-plus btn-icon-prepend"></i>Add More Projects</button> </a>
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
