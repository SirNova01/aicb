<?php

  $user_id = $_SESSION['user_id'];

  $user_pic_query = "SELECT * FROM users WHERE user_id='$user_id' LIMIT 1";
  $user_pic_result = mysqli_query($db_handle, $user_pic_query);
  $user__pic_details = mysqli_fetch_assoc($user_pic_result);
  if ($user__pic_details) {
    $profile_image ="profile_img".$user__pic_details['profile_pic_url'];
  } 

   function xtime_elapsed_string($datetime, $full = false) {
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

      function shorten($msg){
        $maxLength = 15;
        if (strlen($msg) > $maxLength){
            $new_msg = substr($msg, 0, $maxLength);
            $new_msg= $new_msg."...";
            return $new_msg;
        }
      }


?>

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo"><img src="images/logo.png" alt="logo"/></a>
      <a class="navbar-brand brand-logo-mini"><img src="images/logo.png" alt="logo"/></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-apps"></span>
      </button>
      
      <ul class="navbar-nav navbar-nav-right">
        
        <li class="nav-item dropdown">
          <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="notificationDropdown" href="#" data-toggle="dropdown">
            <i class="mdi mdi-bell-outline mx-0"></i>
            <span class="count"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
            <b><h6 style="color:blue;" class="mb-0 font-weight-normal float-left dropdown-header"> Notifications</h6></b>
            <?php
              $notification_counter = 1;
              $empty = TRUE;
              $table_result = $db_handle->query("SELECT * FROM notifications WHERE receiver_id ='ichonia.com' AND status= 'unseen' ");
              foreach ($table_result as $notification_row): ?>
                <a class="dropdown-item preview-item">
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal"><?php $body = shorten($notification_row['body']);
                    echo $body;  ?></td></h6>
                    <p class="font-weight-light small-text text-muted mb-0">
                      <span style="color:red;"><?php $date_sent  = time_elapsed_string($notification_row['send_day'], $full = false);
                      echo $date_sent;
                        ?></span>
                        </td>
                    </p>
                  </div>
                </a>
            <?php $empty = FALSE; $notification_counter++; endforeach; unset($notification_row); if ($empty == TRUE) echo "<h6 style='text-align: center; color: red'>You have no notification(s)</h6>" ?>
            
          </div>
        </li>
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
            <img src="<?=$profile_image?>" alt="profile"/>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            
            <a class="dropdown-item" href="logout">
              <i class="mdi mdi-logout text-primary"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
  </nav>