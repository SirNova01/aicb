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


      if(isset($_POST['create'])){
        $niche_name = mysqli_real_escape_string($db_handle, $_POST['niche_name']);
      
        if (empty($niche_name)) { array_push($errors, "niche name is required"); }
    
        if (count($errors) == 0) {
    
            $register_query = "INSERT INTO niches (niche_name ) 
                                            VALUES('$niche_name')";
            if(mysqli_query($db_handle, $register_query)){
            
                header("location: niches");

            }

    
        }
        
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
            
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <h4 class="card-title mt-1">Blog Categories</h4>
                            </div>
                            <!-- <a href="new_blog_category">
                                <button class="btn btn-outline-secondary btn-rounded btn-sm btn-icon">
                                    <span class="mdi mdi-plus text-black text-muted"></span>
                                </button>
                            </a> -->
                        </div>
                        <div class="d-flex flex-column">

                            <?php
                                $user_counter = 1;
                                $empty = TRUE;
                                $table_result = $db_handle->query("SELECT * FROM niches");
                                foreach ($table_result as $user_row): ?>
                                    
                                        
                                       
                                        <div class="d-flex mb-3">
                                            <div class="d-flex align-items-center justify-content-center mr-3">
                                                <i class="mdi mdi-google-hangouts text-hangouts social-icon-outline"></i>
                                            </div>
                                            <div class="d-flex flex-column ml-1">
                                                <h6 class="font-weight-normal mt-2"><?=$user_row['niche_name']?></h6>
                                                <p class="text-muted">...</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center ml-auto">
                                                <i class="mdi mdi-trash-can-outline text-black mr-2 icon-hover-red"></i>
                                            </div>

                                        </div>

                            <?php $empty = FALSE; $user_counter++; endforeach; unset($user_row); if ($empty == TRUE) echo "<h6 style='text-align: center; color: red'></h6>" ?>


                            
                          
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Create New Niche</h4>
                  <p class="card-description">
                    
                  </p>
                  <form class="forms-sample"  method="post" action="niches">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Niche Name</label>
                      <input type="text" name="niche_name" class="form-control" id="exampleInputUsername1" placeholder=" Name Your Niche:">
                    </div>
                  
                    <button name="create" type="submit" class="btn btn-success mr-2">Create Niche</button>
                  </form>
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
