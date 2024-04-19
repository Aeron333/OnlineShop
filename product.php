<?php
  session_start();
  require_once ('mysqli_connect.php');
  if(!isset($_SESSION['userID'])){
      header('Location: login.php');
  }


?>
<html>
  <head>
    <title>Product</title>
    <style>
      .container1 {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 25px; /* Increase margin */
      }

      .card2 {
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

      .card2 button {
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

      .card2 button:hover {
        opacity: 0.7;
      }

      #h1text {
            text-align: center;
            margin-top:15px;
            font-size:40px;
            text-decoration:underline;
        }
    </style>
  </head>
  <body>
  <?php include("header2.php"); ?>

    <h1 id="h1text">Product On Sell</h1>
    <div class="container1">
  <?php
  $q = "SELECT * FROM product";
  $r = mysqli_query($dbc, $q);

  if (!$r) {
    // Handle query execution error
    echo "Error executing query: " . mysqli_error($dbc);
  } else {
    $num = mysqli_num_rows($r);

    if ($num > 0) {
      while ($row = mysqli_fetch_array($r)) {
        $description = $row['proDesc'];
        // Check if description is longer than 100 characters
        if (strlen($description) > 50) {
          $description = substr($description, 0, 30) . "..."; // Truncate description
        }
        echo '
          <div class="card2">
            <img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" style="width:100%; height: 200px;">
            <h1>' . $row['proName'] . '</h1>
            <p class="price">RM' . $row['proPrice'] . '</p>
            <p>' . $description . '</p>
            <p><a href="viewProduct.php?productID='.$row['productID'].'"><button>View Product</button></a></p>
          </div>';
      }
    } else {
      echo "No products found.";
    }

    mysqli_free_result($r);
  }

  mysqli_close($dbc);
  ?>
</div>
<?php include("footer.php"); ?>
  </body>
</html>
