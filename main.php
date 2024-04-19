<?php
 session_start();
 require_once ('mysqli_connect.php');
 if(!isset($_SESSION['userID'])){
     header('Location: login.php');
 }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Main</title>
    <style>
        /* Resetting margin and padding for HTML, body, and footer */
        html, body, footer {
            margin: 0;
            padding: 0;
        }

        .title {
            font-size: 30px;
            font-weight: bold;
            color: black;
            text-align: center;
            padding: 30px 0px 0px 0px;
        }

        .des {
            font-size: 50px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            color: rgb(106, 90, 205);
            text-align: center;
            padding: 0px;
        }

        .texta {
            margin-left: 15%;
            margin-right: 15%;
        }

        .texta p {
            font-size: 15px;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .texta a {
            text-decoration: none;
            color: black;
        }

        .cover-image {
            position: relative;
            display: block;
            width: 100%; /* Make sure the cover image spans the full width */
            margin: 0;
            padding: 0;
        }

        .cover-image img {
            width: 100%; /* Set image width to 100% */
            display: block; /* Ensure the image is treated as a block element */
            margin: 0; /* Remove any margins */
            padding: 0; /* Remove any padding */
            filter: brightness(70%); /* Adjust brightness to make it darker */
        }

        .cover-text,
        .cover-info {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
        }

        .cover-text {
            font-size: 60px;
            font-weight: bold;
            width:100%;
        }

        .cover-info {
            font-size: 20px;
            font-weight: bold;
            margin-top:70px;
            
        }

        .order-button {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 12px;
        }

        footer {
            width: 100%;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin: 0; /* Resetting margin */
            position: relative;
            bottom: 0; /* Positioning at the bottom */
        }
    </style>
</head>

<body>

    <?php include("header2.php"); ?>

    <div class="cover-image">
        <img src="cover1.jpg" alt="Cover Image">
        <div class="cover-text">Graduation Bouquet</div>
        <div class="cover-info">Pre-order now and get 15% OFF + 2X BloomRewards Points until 7 June 2024. Free delivery in KL, Selangor, Penang & JB</div>

        <!-- Add the form with the submit button -->
        <button class="order-button" onclick="window.location.href = 'product.php';">Order Now</button>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>
