<!DOCTYPE html>
<?php

require_once ('mysqli_connect.php');
if(!isset($_SESSION['userID'])){
    header('Location: login.php');
}
?>

<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->

      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
      <!-- font awesome -->
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!--  -->
      <!-- owl stylesheets -->
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
     
     <style>
--------------------------------------------------------------------- File Name: style.css ---------------------------------------------------------------------*/
/*--------------------------------------------------------------------- import Files ---------------------------------------------------------------------*/

@import url(animate.min.css);
@import url(normalize.css);
@import url(icomoon.css);
@import url(css/font-awesome.min.css);
@import url(meanmenu.css);
@import url(owl.carousel.min.css);
@import url(swiper.min.css);
@import url(slick.css);
@import url(jquery.fancybox.min.css);
@import url(jquery-ui.css);
@import url(nice-select.css);

/*--------------------------------------------------------------------- skeleton ---------------------------------------------------------------------*/

* {
    box-sizing: border-box !important;
    transition: ease all 0.5s;
}

html {
    scroll-behavior: smooth;
    overflow-x: hidden;
}



a {
    color: #1f1f1f;
    text-decoration: none !important;
    outline: none !important;
    -webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    -ms-transition: all .3s ease-in-out;
    -o-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
}

h1,
h2,
h3,
h4,
h5,
h6 {
    letter-spacing: 0;
    font-weight: normal;
    position: relative;
    padding: 0 0 10px 0;
    font-weight: normal;
    line-height: normal;
    color: #111111;
    margin: 0
}

h1 {
    font-size: 24px
}

h2 {
    font-size: 22px
}

h3 {
    font-size: 18px
}

h4 {
    font-size: 16px
}

h5 {
    font-size: 14px
}

h6 {
    font-size: 13px
}

*,
*::after,
*::before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

h1 a,
h2 a,
h3 a,
h4 a,
h5 a,
h6 a {
    color: #212121;
    text-decoration: none!important;
    opacity: 1
}

button:focus {
    outline: none;
}

ul,
li,
ol {
    margin: 0px;
    padding: 0px;
    list-style: none;
}

p {
    margin: 20px;
    font-weight: 300;
    font-size: 15px;
    line-height: 24px;
}

a {
    color: #222222;
    text-decoration: none;
    outline: none !important;
}

a,
.btn {
    text-decoration: none !important;
    outline: none !important;
    -webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    -ms-transition: all .3s ease-in-out;
    -o-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
}

img {
    max-width: 100%;
    height: auto;
}

 :focus {
    outline: 0;
}

.paddind_bottom_0 {
    padding-bottom: 0 !important;
}

.btn-custom {
    margin-top: 20px;
    background-color: transparent !important;
    border: 2px solid #ddd;
    padding: 12px 40px;
    font-size: 16px;
}

.lead {
    font-size: 18px;
    line-height: 30px;
    color: #767676;
    margin: 0;
    padding: 0;
}

.form-control:focus {
    border-color: #ffffff !important;
    box-shadow: 0 0 0 .2rem rgba(255, 255, 255, .25);
}

.navbar-form input {
    border: none !important;
}

.badge {
    font-weight: 500;
}

blockquote {
    margin: 20px 0 20px;
    padding: 30px;
}

button {
    border: 0;
    margin: 0;
    padding: 0;
    cursor: pointer;
}

.full {
    float: left;
    width: 100%;
}

.layout_padding {
    padding-top: 90px;
    padding-bottom: 0px;
}

.padding_0 {
    padding: 0px;
}






/* header top section end */


/* logo section start */

.logo_section {
    width: 100%;
    float: left;
    background-color: #000000;
}

.logo {
    width: 100%;
    float: left;
    text-align: center;
    padding: 30px 0px;
    background-color:  #000000; /* Add this line to set the background color */
}

.logo img {
    max-width: 250px; /* Increase the max-width value to make the image larger */
}


/* logo section end */


/* header section start */

.header_section {
    width: 100%;
    display: flex;
    background-color: #000000;
    padding-bottom: 20px;
    
}




.containt_main {
    display: flex;
}


/* opennav bar start */

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 20px;
    color: #ffffff;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover {
    color: #f26522;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

@media screen and (max-height: 450px) {
    .sidenav {
        padding-top: 15px;
    }
    .sidenav a {
        font-size: 18px;
    }
}

.toggle_icon {
    cursor: pointer;
    color: #ffffff;
    order: 2;
    margin-right: 20px; /* Add some space between toggle icon and search bar */
    margin-left:60px;
}

.header_box {
    order: 2;
    display: flex;
}

.toggle_icon img {
    width: 20px; /* Adjust the width as per your requirement */
    height: auto; /* This will automatically adjust the height based on the width */
}





.show>.btn-secondary.dropdown-toggle:focus {
    box-shadow: none;
}


/* opennav bar end */


/* Styles for wrapping the search box start */

.main {
    flex: 1;
    margin: 0; /* Removed the margin property */
    display: flex;
    align-items: center; /* Align items vertically */
    order: 2;
}

/* Adjust the width of the search input to fill the available space */
.main .input-group {
    flex: 1;
}

/* Adjust the width of the search input field to fill the available space */
.main .form-control {
    width: 100%;
}

/* Adjust the styles for the search icon */
.main .input-group-append {
    position: relative; /* Make it a relative positioning context */
}

.main .input-group-append .btn-secondary {
    position: absolute;
    left: 1px; /* Adjust the value as per your preference */
    z-index: 2;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
.header_box {
    order: 3; /* Change the order to move it to the right */
    margin-left: 50px; /* Align to the right */
    margin-right: 50px; /* Add some space between icons and search */
}
/* Bootstrap 4 text input with search icon */

.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}


/* Styles for wrapping the search box end */

.login_menu {
    display: flex;
    text-align: right;
    float: right;
}

.login_menu ul {
    margin: 0px;
    padding: 0px;
}

.login_menu li {
    float: left;
    font-size: 16px;
    color: #ffffff;
    text-transform: uppercase;
    padding-left: 10px;
    padding-top: 4px;
}

.login_menu li a {
    color: #ffffff;
}

.login_menu li a:hover {
    color: #f26522;
}

.padding_10 {
    padding-left: 10px;
}


/* flage css start */


a:hover {
    color: #f26522;
    text-decoration: underline;
}







     </style>
    
   </head>
   <body>
    <header>
      <!-- banner bg main start -->
      <div class="banner_bg_main">
         <!-- header top section start -->
         <div class="container">
           
         </div>
         <!-- header top section start -->
         <!-- logo section start -->
         <div class="logo_section">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="logo">><a href="main.php"><img src="loog3.png"></a></div>
                  </div>
               </div>
            </div>
         </div>
         <!-- logo section end -->
         <!-- header section start -->
         <div class="header_section">
            <div class="container">
               <div class="containt_main">
                  <div id="mySidenav" class="sidenav">
                     <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                     <a href="main.php">Home</a>
                     <a href="product.php">All Product</a>
                     <a href="logout.php">Log Out</a>
                     
                  </div>
                  <span class="toggle_icon" onclick="openNav()"><img src="images/toggle-icon.png"></span>
                 
                  <div class="main">
                     <!-- Another variation with a button -->
                     <form action="search.php" method="GET" class="main">
    <!-- Inside the form -->
<div class="input-group">
    <input type="text" class="form-control" placeholder="Search product..." name="search" required>
    <div class="input-group-append">
        <button class="btn btn-secondary" type="submit" style="background-color: #f26522; border-color:#f26522">
            <i class="fa fa-search"></i> <!-- Font Awesome search icon -->
        </button>
    </div>
</div>

</form>

                  </div>
                  <div class="header_box">
                   
                     <div class="login_menu">
                        <ul>
                           <li><a href="#" onclick="redirectToCart()">
                              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                              <span class="padding_10">Cart</span></a>
                           </li>
                           <li><a href="#" onclick="redirectToProfile()">
                              <i class="fa fa-user" aria-hidden="true"></i>
                              <span class="padding_10">Profile</span></a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- header section end -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "250px";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }

         function redirectToSearch() {
            window.location.href = 'search.php';
         }

         function redirectToProfile() {
        window.location.href = 'profile.php';
         }

         function redirectToCart() {
        window.location.href = 'cart.php';
         }
      </script>
      </header>
      <?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>


         <table>




<?php
$q = "SELECT * FROM product";
$r = mysqli_query($dbc, $q);

if (!$r) {
  // Handle query execution error
  die("Error executing query: " . mysqli_error($dbc));
}

$num = mysqli_num_rows($r);

mysqli_free_result($r);


?>
</table>

   </body>
</html>