<!DOCTYPE html>
<?php

  session_start();
    include("../includes/db_conn.php");
    $user_id = $_SESSION['user_id'];
    $date = date("Y-m-d H:i:s");
    $day = date("Y-m-d");
    $script_name = pathinfo(__FILE__, PATHINFO_FILENAME);
    $errors = array();

    $app_id = "";
    $app_name ="";
    $niche = "";
    $short_note = "";
    $thumb_image = "";
    $android_url = "";
    $ios_url =  "";
    $web_url =  "";
    $desktop_url =  "";
    $demo_url =  "";
    $date_registered =  "";
    $day_registered =  "";

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $_SESSION['app_id'] = $id;
    }

    if(isset($_SESSION['app_id'])){
      $app_id = $_SESSION['app_id'];
    }else{
      header("location: home");
    }



    $projects_check_query = "SELECT * FROM projects WHERE app_id='$app_id' LIMIT 1";
    $result = mysqli_query($db_handle, $projects_check_query);
    $projects = mysqli_fetch_assoc($result);
    if ($projects) { 
      $app_id = $projects['app_id'];
      $app_name = $projects['app_name'];
      $niche = $projects['niche'];
      $short_note = $projects['short_note'];
      $thumb_image = $projects['thumb_image'];
      $android_url = $projects['android_url'];
      $ios_url = $projects['ios_url'];
      $web_url = $projects['web_url'];
      $desktop_url = $projects['desktop_url'];
      $demo_url = $projects['demo_url'];
      $date_registered = $projects['date_registered'];
      $day_registered = $projects['day_registered'];
      
    }

      
    if(isset($_POST['update_project'])){

      

      $app_id = $_POST['app_id'];
      $demo_url = $_POST['demo_url'];
      $android_url = $_POST['android_url'];
      $ios_url = $_POST['ios_url'];
      $web_url = $_POST['web_url'];
      $desktop_url = $_POST['desktop_url'];
      
      $sql = "UPDATE projects SET demo_url='$demo_url', android_url='$android_url', ios_url='$ios_url', web_url='$web_url', desktop_url='$desktop_url' WHERE app_id='$app_id'";

      if(mysqli_query($db_handle, $sql)){

        header("location: edit_project?id=".$app_id."&&msg_success=updated!");
        
      }else{
        header("location: edit_project?id=".$app_id."&&msg_error=could not write data!");
      }



      
    }

    if(isset($_POST['add_project_image'])){

      $image_url = "../image_uploads/project_images/";
      $num_image = uniqid(rand (), true);    

      $image_url  = $image_url.$num_image . basename( $_FILES['project_image']['name']);

      if(move_uploaded_file($_FILES['project_image']['tmp_name'], $image_url)) {

        


          $item_query = "INSERT INTO project_image_assets ( app_id,	image_url ) 
                                                VALUES('$app_id',  '$image_url')";
          if(mysqli_query($db_handle, $item_query)){

            header("location: edit_project?id=".$app_id."&&msg_success=upload success!");
        
          }else{
            header("location: edit_project?id=".$app_id."&&msg_error=could not write data!");
          }



      }

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

?>


<html lang="en">


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title> Edit Project | Admin Ichonia</title>
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
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row justify-content-center">
                    <div class="col-lg-8">
                      <div class="border-bottom text-center pb-4">
                        <img style="margin-top:53px;" src="<?=$thumb_image?>" alt="profile" class="img-lg rounded-circle mb-3"/>
                       <!--  <h4></h4>
                        <div class="d-flex justify-content-between">
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
                            App Id
                          </span>
                          <span class="float-right text-muted">
                            <?=$app_id?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            App Name
                          </span>
                          <span class="float-right text-muted">
                          <?=$app_name?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Niche
                          </span>
                          <span class="float-right text-muted">
                          <?=$niche?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Description
                          </span>
                          <span class="float-right text-muted">
                            <a style="color:blue;"><?=$short_note?></a>
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

                    <div class="col-lg-4">
                      <div class="card">
                        <div class="card-body">
                          <form class="forms-sample" method="post" acton="edit_project" enctype="multipart/form-data">
                            <input type="hidden" value="<?=$app_id?>" name="app_id">

                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="demo_url" placeholder="Demo Url:" value="<?=$demo_url?>" name="demo_url">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="design_type" placeholder="Android Url:" value="<?=$android_url?>" name="android_url">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="design_type" placeholder="Ios Url:" value="<?=$ios_url?>" name="ios_url">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="design_type" placeholder="Web Url:" value="<?=$web_url?>" name="web_url">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="design_type" placeholder="Desktop Url:" value="<?=$desktop_url?>" name="desktop_url">
                            </div>
                          
                            <div class="mt-3">
                                <button type="submit" name="update_project" class="btn btn-primary btn-lg btn-block">
                                    <i class="mdi mdi-folder-edit"></i>                      
                                    Update Links
                                </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-body">
                          <form class="forms-sample" method="post" acton="edit_project" enctype="multipart/form-data">
                            <div class="form-group row">
                              <div class="col">
                                <div class="ajax-upload-dragdrop" style="vertical-align: top; width: 400px;"><div class="ajax-file-upload" style="position: relative; overflow: hidden; cursor: default;">Upload
                                <!-- <form method="POST" action="YOUR_FILE_UPLOAD_URL" enctype="multipart/form-data" style="margin: 0px; padding: 0px;"> -->
                                <input type="file" id="ajax-upload-id-1600986446008" name="project_image" accept="*" multiple="" 
                                style="position: absolute; cursor: pointer; top: 0px; width: 100%; height: 100%; left: 0px; z-index: 100; opacity: 0;">
                                <!-- </form> -->
                                </div><span><b>Drag &amp; Drop Files</b></span></div>
                              </div>
                              <div class="col">
                                <button type="submit" name="add_project_image" class="btn btn-outline-dark btn-icon-text">
                                  <i class="mdi mdi-upload btn-icon-prepend mdi-36px"></i>
                                  <span class="d-inline-block text-left">
                                    <small class="font-weight-light d-block">choose file &</small>
                                    Upload
                                  </span>
                                </button>
                              </div>
                            </div>
                          </form>

                        </div>
                      </div>
                    </div>



                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-body">

                          <div class="row">
                            <?php
                              $item_one_counter = 1;
                              $empty = TRUE;
                              $item_result = $db_handle->query("SELECT * FROM project_image_assets");
                              foreach ($item_result as $item_one_row): ?>
                              <div class="col-md-3 grid-margin stretch-card">
                                <div class="card">
                                  <div class="card-body">
                                    <div class="d-flex flex-row flex-wrap">
                                      <img src="<?= $item_one_row['image_url'] ?>" class="img-lg rounded" alt="profile image">
                                    </div>
                                    <a style="margin-top:10px;" href="delete_portfolio_image?id=<?= $item_one_row['id'] ?>"><button type="button" class="btn btn-outline-danger btn-fw">Delete</button></a>
                                  
                                  </div>
                                </div>
                              </div>
                            <?php $empty = FALSE; $item_one_counter++; endforeach; unset($item_one_row); if ($empty == TRUE) echo "<h6 style='text-align: center; color: red'>There are no items to display</h6>" ?>
                          
                          </div>

                        </div>
                      </div>
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
