<header id="navbar" class="navigationstyle__NavigationWrap-sc-1llh5hp-0 icfdoF nav-block">
   <div class="containerstyle__ContainerWrapper-sc-8s1uzo-0 dnkXqM container">
      <div class="navbar-wrap">
         <a class="logo" href="home"><img src="images/logo.png" alt="AICB"/></a>
         <nav class="nav">
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" class="mobile-menu-icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
               <path d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path>
            </svg>
            </a>
            <div class="topnav">
               <!-- Navigation links (hidden by default) -->
               <div id="myLinks">
                  <a href="home">Home</a>
                  <a href="home">About</a>
                  <a href="home">Token</a>
                  <a href="home">Features</a>
                  <a href="competition">Competition</a>
                  <a href="login">Sign In</a>
                  <a href="getting_started">Get Started</a>
               </div>
               <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
            
            </div>

            <ul class=" collapsed ">
               <li class="nav-item"><a>Home</a></li>
               <li class="nav-item"><a>About</a></li>
               <li class="nav-item"><a>Token</a></li>
               <li class="nav-item"><a>Features</a></li>
               <li class="nav-item"><a href="competition">Competition</a></li>
               <li class="nav-item"><a href="login">Sign In</a></li>
               <li> <a href="getting_started"> <button class="nav__button">Get Started</button></a></li>
            </ul>
         </nav>
      </div>
   </div>
</header> 

<style>
   /* #myLinks {
      display: none;
   } */

   /* Style the navigation menu */
.topnav {
  overflow: hidden;
  background-color: #00000000;
  position: relative;
}

/* Hide the links inside the navigation menu (except for logo/home) */
.topnav #myLinks {
  display: none;
}

/* Style navigation menu links */
.topnav a {
  color: white;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
  display: block;
}

/* Style the hamburger menu */
.topnav a.icon {
  background: black;
  display: block;
  position: absolute;
  right: 0;
  top: 0;
}

/* Add a grey background color on mouse-over */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Style the active link (or home/logo) */
.active {
  background-color: #4CAF50;
  color: white;
}
</style>

<script>
   function myFunction() {
      var x = document.getElementById("myLinks");
      if (x.style.display === "block") {
         x.style.display = "none";
      } else {
         x.style.display = "block";
      }
   }
</script>