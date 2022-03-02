
<?php
    // $script_name = pathinfo(__FILE__, PATHINFO_FILENAME);
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar"> 
    <ul class="nav">
        <li class="nav-item sidebar-category mt-4">
            <span style="color:black;">Hello, <b><?=$fullname?></b></span>
        </li>
        <li class="nav-item <?php if($script_name == "index"){echo("active");}?>">
            <a class="nav-link" href="home">
                <i class="mdi mdi-home-outline menu-icon"></i>
                <span class="menu-title">Home</span>
            </a>
        </li>

        <li class="nav-item <?php if($script_name == "projects"){echo("active");}?>">
            <a class="nav-link" href="projects">
                <i class="mdi mdi-briefcase-outline menu-icon"></i>
                <span class="menu-title">Projects</span>
            </a>
        </li>

        <li class="nav-item <?php if($script_name == "niches"){echo("active");}?>">
            <a class="nav-link" href="niches">
                <i class="mdi mdi-grid menu-icon"></i>
                <span class="menu-title">Niches</span>
            </a>
        </li>

        

        <li class="nav-item ">
            <a class="nav-link" href="">
                <span class="menu-title">-------------------------------------------------</span>
            </a>
        </li>


        <li class="nav-item <?php if($script_name == "new-report"){echo("active");}?>">
            <a class="nav-link" href="un_attended_reports.php">
                <i class="mdi mdi-file-document-box-multiple menu-icon"></i>
                <span class="menu-title">Unattended Reports</span>
            </a>
        </li>
        <li class="nav-item <?php if($script_name == "new-report"){echo("active");}?>">
            <a class="nav-link" href="report_history.php">
                <i class="mdi mdi-history menu-icon"></i>
                <span class="menu-title">Reports History</span>
            </a>
        </li>
        <li class="nav-item <?php if($script_name == "new-report"){echo("active");}?>">
            <a class="nav-link" href="all_users.php">
                <i class="mdi mdi-account-group menu-icon"></i>
                <span class="menu-title">All Users</span>
            </a>
        </li>
        
        <li class="nav-item <?php if($script_name == "all-notifications"){echo("active");}?>">
            <a class="nav-link" href="all-notifications.php">
                <i class="mdi mdi-bell-outline menu-icon"></i>
                <span class="menu-title">Notifications</span>
            </a>
        </li>
        <li class="nav-item <?php if($script_name == "logout"){echo("active");}?>">
            <a class="nav-link" href="logout.php">
                <i class="mdi mdi-logout menu-icon"></i>
                <span class="menu-title">Logout</span>
            </a>
        </li>          
    </ul>
</nav>