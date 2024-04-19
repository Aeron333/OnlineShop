<!DOCTYPE html>
<?php

require_once('mysqli_connect.php');
if(!isset($_SESSION['adminID'])){
    header('Location: adminLogin.php');
  }
  
?>


<html>

<head>
    <style>
        * {
            margin: 0;
            padding: 0;
            list-style: none;
            text-decoration: none;
        }

        .header-container {
            width: 100%; /* Adjust width if necessary */
            background-color: black; /* Change the background color to black */
            color: white; /* Set the text color to white */
        }

        header {
            height: 100px;
            border-bottom: solid 1px rgba(16, 16, 16, 0.1);
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            font-size: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px; /* Add padding to the inner div for spacing */
        }

        header .logo {
            height: 100%;
        }

        header .logo img {
            height: 150px; /* Adjust the height of the logo */
            margin-top: -25px; /* Adjust margin-top if necessary */
        }

        nav ul {
            display: flex;
            align-items: center;
        }

        nav ul li {
            margin-right: 20px; /* Adjust spacing between menu items */
        }

        .button {
            color: white; /* Set the color to white */
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            font-size: 16px; /* Make the text smaller */
        }

        .button:hover {
            background-color: #f0f0f0;
            color: black; /* Change the text color on hover */
        }

        #logout {
            color: white; /* Set the color to white */
        }

    </style>
</head>

<body>

    <div class="header-container">
        <header>
            <div class="logo">
                <a href="AdOrder.php" target="_blank"><img src="loog3.png" alt="graduation-logo"></a>
            </div>
            <nav>
                <ul>
                    <li><a href="AdOrder.php" class="button">Order</a></li>
                    <li><a href="adminproduct.php" class="button">Product</a></li>
                    <li><a href="logout.php" id="logout" class="button">Log Out</a></li>
                </ul>
            </nav>
        </header>
    </div>



</body>

</html>
