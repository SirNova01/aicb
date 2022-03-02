<?php

    session_start();
    include("../includes/db_conn.php");

    if (isset($_SESSION['status']) && $_SESSION['status']=="logged in") {          
    }else{
        header('location: logout');
    }
      
    $item_id = "";
    if(isset($_GET["id"])){
        $item_id = $_GET["id"];
    }else{
        header("location: home");
    }

    // unlink("t.txt");

    $item_update_query = "DELETE FROM project_image_assets  WHERE id='$item_id'";
    if (mysqli_query($db_handle, $item_update_query)) {
        
            header("location: edit_project?msg_success='success'");
        
    }else{
        header("location: edit_project?msg_error='failed'");
    }
    

?>