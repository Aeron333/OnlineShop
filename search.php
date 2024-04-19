<?php
  session_start();
  require_once ('mysqli_connect.php');
  if(!isset($_SESSION['userID'])){
      header('Location: login.php');
  }

?>
<html>
  <head>
    <title>Search</title>
    <style>

.container1 {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: 50px; /* Increase margin */
      }

      .card1 {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        width: 300px; /* Set fixed width */
        height: 400px; /* Set fixed height */
        margin: 15px;
        text-align: center;
        font-family: arial;
       
      }

      .price {
        color: grey;
        font-size: 22px;
      }

      .card1 button {
        border: none;
        outline: 0;
        padding: 12px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
      }

      .card1 button:hover {
        opacity: 0.7;
      }
    </style>
  </head>
  <body>
  <?php include("header2.php"); ?>

    <div class="container1">
    <?php
    if(isset($_GET['search'])) {
      $query = mysqli_real_escape_string($dbc, $_GET['search']);
      $q = "SELECT * FROM product WHERE proName LIKE '%$query%'";
      $r = mysqli_query($dbc,$q);
      $num = mysqli_num_rows($r);
      if ($num > 0) {
        while ($row = mysqli_fetch_array($r)) {
          $description = $row['proDesc'];
          // Check if description is longer than 100 characters
          if (strlen($description) > 50) {
            $description = substr($description, 0, 30) . "..."; // Truncate description
          }
          echo '
            <div class="card1">
              <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" style="width:100%; height: 200px;">
              <h1>' . $row['proName'] . '</h1>
              <p class="price">RM' . $row['proPrice'] . '</p>
              <p>' . $description . '</p>
              <p><a href="viewProduct.php?productID='.$row['productID'].'"><button>View Product</button></a></p>
            </div>';
        }
      } else {
        echo '<p>No product found.</p>';
      }
      mysqli_free_result($r);
    } else {
      echo '<p>Please enter a search query.</p>';
    }
    mysqli_close($dbc);
    ?>

  </body>
</html>