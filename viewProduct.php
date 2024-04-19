<?php

session_start();
require_once ('mysqli_connect.php');
if(!isset($_SESSION['userID'])){
    header('Location: login.php');
}


// Check if productID is set in the URL
if (!isset($_REQUEST['productID'])) {
    // Redirect the user to another page if productID is not set
    header("Location: product.php");
    exit(); // Stop executing the script after redirecting
}

$id = $_REQUEST['productID'];

$userID = $_SESSION['userID'];

$name = "";
$price = "";
$quantity = "";
$description = "";
$error = "";

$image_name = "";
$image_type = "";
$image_size = "";
$image_data = "";
$max_quantity="";
?>

<?php

if (!empty($_POST)) {
    // Get the quantity from the form
    $requestedQuantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $maxQuantity = $_POST['maxquantity']; // Maximum allowed quantity

    // Check the total quantity in the cart
    $cartQuantity = 0;
    $checkCartQuery = "SELECT quantity FROM cart WHERE userID = '$userID' AND productID = '$id'";
    $checkCartResult = mysqli_query($dbc, $checkCartQuery);
    if ($checkCartResult && mysqli_num_rows($checkCartResult) == 1) {
        $cartRow = mysqli_fetch_assoc($checkCartResult);
        $cartQuantity = intval($cartRow['quantity']);
    }

    // Calculate the remaining quantity that can be added to the cart
    $remainingQuantity = max(0, $maxQuantity - $cartQuantity);


    // Check if the requested quantity exceeds the remaining quantity
    if ($requestedQuantity > $remainingQuantity) {
        // Adjust the requested quantity to the remaining quantity
        $requestedQuantity = $remainingQuantity;
        $error = "The quantity in your cart plus the requested quantity exceeds the maximum allowed quantity for this product.";
    }

    // Check if the product is already in the cart
    $checkExistingQuery = "SELECT * FROM cart WHERE userID = '$userID' AND productID = '$id'";
    $checkExistingResult = mysqli_query($dbc, $checkExistingQuery);
    if ($checkExistingResult && mysqli_num_rows($checkExistingResult) > 0) {


        // If the product exists in the cart, update the quantity
        $updateQuantityQuery = "UPDATE cart SET quantity = quantity + $requestedQuantity WHERE userID = '$userID' AND productID = '$id'";
        if (mysqli_query($dbc, $updateQuantityQuery)) {
            echo "<script>alert('Quantity updated successfully in the cart.'); window.location.href = 'viewProduct.php?productID=$id';</script>";
            exit(); // Stop executing the script after redirecting
        } else {
            echo "<script>alert('Error updating quantity: " . mysqli_error($dbc) . "'); window.location.href = 'viewProduct.php?productID=$id';</script>";
            exit(); // Stop executing the script after redirecting
        }
    } else {
        // If the product does not exist in the cart, insert it into the cart
        $insertQuery = "INSERT INTO cart(userID, productID, quantity) VALUES ('$userID', '$id', $requestedQuantity)";
        if (mysqli_query($dbc, $insertQuery)) {
            echo "<script>alert('Product inserted successfully into the cart.'); window.location.href = 'viewProduct.php?productID=$id';</script>";
            exit(); // Stop executing the script after redirecting
        } else {
            echo "<script>alert('Error inserting product into the cart: " . mysqli_error($dbc) . "'); window.location.href = 'viewProduct.php?productID=$id';</script>";
            exit(); // Stop executing the script after redirecting
        }
    }
}else{
  $q="SELECT * FROM product where productID ='$id'";
  $r=mysqli_query($dbc,$q);
if(mysqli_num_rows($r)==1){
    $row=mysqli_fetch_array($r);
    $id=$row['productID'];
    $name=$row['proName'];
    $price=$row['proPrice'];
    $description=$row['proDesc'];
    $quantity=$row['maxQuantity'];
    $image_data = $row['image']; // Assuming 'image_data' is the column name where the image data is stored

}else{
    header("Location: product.php");
    exit(); // Stop executing the script after redirecting
}

mysqli_free_result($r);

}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <!-- CSS -->
    <meta name="robots" content="noindex,follow" />
    <style>
        /* Basic Styling */
        h1{
            text-decoration:underline;
            font-size:20px;
        }

        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .container1 {
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px;
            display: flex;
            justify-content: center; /* Center the content horizontally */
            align-items: center; /* Center the content vertically */
            margin-top: 20px;
        }

        /* Columns */
        .left-column {
           
            width: 50%; /* Adjust width as needed */
            position: relative;
            text-align: center; /* Center the image horizontally */
        }

        .left-column img {
            width: 400px; /* Fixed width for the image */
            height: 400px; /* Fixed height for the image */
            object-fit: cover; /* Ensure the image covers the entire container */
            object-position: center; /* Center the image within the container */
        }

        .right-column {
            width: 50%; /* Adjust width as needed */
      
        }

        /* Right Column */
        /* Product Description */
        .product-description {
            border-bottom: 1px solid #E1E8EE;
            margin-bottom: 20px;
            padding-left: ; /* Add some padding for better appearance */
        }

        .product-description span {
            font-size: 12px;
            color: #358ED7;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
        }

        .product-description h1 {
            font-weight: 300;
            font-size: 32px; /* Adjust font size as needed */
            color: #43484D;
            letter-spacing: -1px;
            margin-top: 10px; /* Add some space between heading and paragraph */
        }

        .product-description p {
            font-size: 16px;
            font-weight: 300;
            color: #86939E;
            line-height: 24px;
        }

        /* Product Configuration */
        .product-color span,
        .cable-config span {
            font-size: 14px;
            font-weight: 400;
            color: #86939E;
            margin-bottom: 20px;
            display: inline-block;
        }

        /* Product Color */
        .product-color {
            margin-bottom: 30px;
        }

        .quantity div {
            display: inline-block;
        }

        .cable-choose button {
            border: 2px solid #E1E8EE;
            border-radius: 6px;
            padding: 13px 20px;
            font-size: 14px;
            color: #5E6977;
            background-color: #fff;
            cursor: pointer;
            transition: all .5s;
        }

        .cable-choose button:hover,
        .cable-choose button:active,
        .cable-choose button:focus {
            border: 2px solid #86939E;
            outline: none;
        }

        .cable-config {
            border-bottom: 1px solid #E1E8EE;
            margin-bottom: 20px;
        }

        .cable-config a {
            color: #358ED7;
            text-decoration: none;
            font-size: 12px;
            position: relative;
            margin: 10px 0;
            display: inline-block;
        }

        .cable-config a:before {
            content: "?";
            height: 15px;
            width: 15px;
            border-radius: 50%;
            border: 2px solid rgba(53, 142, 215, 0.5);
            display: inline-block;
            text-align: center;
            line-height: 16px;
            opacity: 0.5;
            margin-right: 5px;
        }

        /* Product Price */
        .product-price {
            display: flex;
            align-items: center;
            
        }

        .product-price span {
            font-size: 26px;
            font-weight: 300;
            color: #43474D;
            margin-right: 20px;
        }

        .cart-btn {
            display: inline-block;
            background-color: #7DC855;
            border-radius: 6px;
            font-size: 16px;
            color: #FFFFFF;
            text-decoration: none;
            padding: 12px 30px;
            transition: all .5s;
        }

        .cart-btn:hover {
            background-color: #64af3d;
        }

        
    </style>
</head>

<body>
    <?php include("header2.php"); ?>
    <main class="container1">

        <div class="left-column">
            <?php
            if (!empty($image_data)) {
                $image_base64 = base64_encode($image_data);
                echo '<img src="data:image/jpeg;base64,' . $image_base64 . '" alt="Product Image">';
            } else {
                echo '<p>No image available</p>';
            }
            ?>
        </div>


        <!-- Right Column -->
        <div class="right-column">

            <!-- Product Description -->
            <div class="product-description">

                <h1><?php echo $name; ?></h1>
                <p><?php echo $description; ?></p>
            </div>

            <!-- Product Configuration -->
            <div class="product-configuration">

                <!-- Product Color -->
                <div class="product-color">
                    <span>Quantity</span>

                    <div class="quantity">
                        <?php
                        // Set the maximum quantity from the database
                        $max_quantity = intval($quantity); // Convert quantity to integer
                        // Ensure minimum quantity is 1
                        $min_quantity = 1;
                        ?>
                        <form id="add-to-cart-form" action="viewProduct.php" method="POST">
                            <input id="number" type="number" name="quantity" value="<?php echo $min_quantity; ?>" min="<?php echo $min_quantity; ?>" max="<?php echo $max_quantity; ?>" />
                            <input type="hidden" name="productID" value="<?php echo $id; ?>">
                            <input type="hidden" name="maxquantity" value="<?php echo $max_quantity; ?>">
                        </form>
                    </div>

                </div>


            </div>
            <!-- Product Pricing -->
            <div class="product-price">
                <span>RM<?php echo $price; ?></span>
                <button id="add-to-cart-btn" class="cart-btn">Add to cart</button>
            </div>
        </div>
    </main>

    <script>
        document.getElementById("add-to-cart-btn").addEventListener("click", function() {
            var form = document.getElementById("add-to-cart-form");
            var quantityInput = form.elements["quantity"];
            var maxQuantity = parseInt(quantityInput.getAttribute("max"));
            var quantity = parseInt(quantityInput.value);

            if (quantity > maxQuantity) {
                alert("Cannot add more than the available quantity.");
                return false; // Prevent form submission
            }

            form.submit(); // Submit the form if validation passes
        });
    </script>
    <?php include("footer.php"); ?>
</body>
</html>
