<!DOCTYPE html>
<?php
    session_start();
    include("../includes/db_conn.php");
    $day = date("Y-m-d");
    $date = date("Y-m-d H:i:s");
    $errors = array();
   
      if (isset($_SESSION['status']) && $_SESSION['status']=="logged in") {          
      }else{
        header('location: logout');
      }
  
      $script_name = pathinfo(__FILE__, PATHINFO_FILENAME);

      function existInDb($code, $db){
        $code_query = "SELECT * FROM projects WHERE app_id ='$code'";
        $result = mysqli_query($db, $code_query);
        $number = mysqli_num_rows($result);
        if($number >0){
            return true;
        }else{
            return false;
        }
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

      if(isset($_POST['submit'])){
          

        $app_name = $_POST['app_name'];
        $niche = $_POST['niche'];
        $short_note = $_POST['short_note'];
        $android_url = $_POST['android_url'];
        $ios_url = $_POST['ios_url'];
        $web_url = $_POST['web_url'];
        $desktop_url = $_POST['desktop_url'];

        if (empty($app_name)) { array_push($errors, "app Name is required"); }
        if (empty($niche)) { array_push($errors, "niche is required"); }
        if (empty($short_note)) { array_push($errors, "short note is required"); }

        if (count($errors) == 0) {
      
            $image_url = "../image_uploads/thumb_images/";
            $num_image = uniqid(rand (), true);    

            $image_url  = $image_url.$num_image . basename( $_FILES['thumb_image']['name']);

            if(move_uploaded_file($_FILES['thumb_image']['tmp_name'], $image_url)) {

              $unique_number = uniqid(rand (), true);
              while(existInDb($unique_number, $db_handle)) {
                  $unique_number = uniqid(rand (), true);                                       
              }
              $item_id = $unique_number;  


                $item_query = "INSERT INTO projects ( app_id,   	app_name,     	niche,	   short_note,	thumb_image,   	android_url,	ios_url,   	web_url,	desktop_url,	date_registered,	day_registered ) 
  			                                             VALUES('$item_id', '$app_name',  '$niche',    '$short_note', '$image_url', '$android_url', '$ios_url',  '$web_url',  '$desktop_url',   '$date',       '$day')";
                if(mysqli_query($db_handle, $item_query)){

                    header("location: edit_project?id=".$item_id);
                    
                }else{
                    echo "Could Not Write Data"; 
                }



            }

        }


      }






?>


<html lang="en">


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Dashboard</title>
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

            <center><h6 class="font-weight-light"> Add New Portfolio Item .</h6></center>
            <form class="pt-3" method="post" acton="add_projects" enctype="multipart/form-data">
              <?php include('includes/errors.php'); ?>
              <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="app_name" placeholder="App Name" name="app_name" required>
              </div>


              <div class="form-group">
                  <select name="niche" class="form-control" id="exampleSelectGender">
                      <?php
                          $user_counter = 1;
                          $empty = TRUE;
                          $table_result = $db_handle->query("SELECT * FROM niches");
                          foreach ($table_result as $user_row): ?>
                              <option><?=$user_row['niche_name']?></option>                               
                      <?php $empty = FALSE; $user_counter++; endforeach; unset($user_row); if ($empty == TRUE) echo "<h6 style='text-align: center; color: red'></h6>" ?>
                  </select>
              </div>

              <div class="form-group">
                  <label for="exampleTextarea1">Short Note</label>
                  <textarea name="short_note" class="form-control" id="exampleTextarea1" rows="4"></textarea>
              </div>

              <div class="card-body">
                  <h4 class="card-title d-flex">App Thumb Image / Logo (82x80)
                  </h4>
                  <div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon"></span> <p>Drag and drop a file here or click</p><p class="dropify-error">Ooops, something wrong appended.</p></div><div class="dropify-loader"></div><div class="dropify-errors-container"><ul></ul></div>
                  <input name="thumb_image" type="file" class="dropify">
                  <button type="button" class="dropify-clear">Remove</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">Drag and drop or click to replace</p></div></div></div></div>
              </div>

              <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="design_type" placeholder="Android Url:" name="android_url">
              </div>

              <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="design_type" placeholder="Ios Url:" name="ios_url">
              </div>

              <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="design_type" placeholder="Web Url:" name="web_url">
              </div>

              <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="design_type" placeholder="Desktop Url:" name="desktop_url">
              </div>
            
              <div class="mt-3">
                  <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">
                      <i class="mdi mdi-login"></i>                      
                      Submit
                  </button>
              </div>
              <div class="my-2 d-flex justify-content-between align-items-center">
                  
              </div>
            
            
            </form>


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
