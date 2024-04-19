<?php
// Start the session and include your database connection file
session_start();
require_once ('mysqli_connect.php');

if(!isset($_SESSION['userID'])){
    header('Location: login.php');
}

$userID = $_SESSION['userID'];

// Initialize user information variables
$userInfo = array();

// Retrieve user information from the userInfo table
$queryUserInfo = "SELECT * FROM userinfo WHERE userID = '$userID'";
$resultUserInfo = mysqli_query($dbc, $queryUserInfo);
if(mysqli_num_rows($resultUserInfo)==1){
    $row=mysqli_fetch_array($resultUserInfo);
    $name=$row['userName'];
    $email=$row['email'];
    $phoneNumber=$row['phoneNumber'];
    $address=$row['address'];

}



// Check if user information exists
if (mysqli_num_rows($resultUserInfo) > 0) {
    $userInfo = mysqli_fetch_assoc($resultUserInfo);
} else {
    echo "User information not found.";
}

// Initialize subtotal and total variables
$subTotal = 0;
$total = 0;

// Check if the checkout button was clicked
if (isset($_POST['checkout'])) {
    // Check if any products were checked
    if (isset($_POST['checked']) && !empty($_POST['checked'])) {
        // Retrieve the checked product IDs
        $checkedProducts = $_POST['checked'];
        // Display the checked products and their quantities
        echo "<h2>Checkout</h2>";
        echo "<table border='1'>";
        echo "<tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        </tr>";

        foreach ($checkedProducts as $productID) {
            // Retrieve product details based on the product ID
            $query = "SELECT cart.*, product.*, product.maxquantity
                      FROM cart
                      INNER JOIN product ON cart.productID = product.productID
                      WHERE cart.userID = '$userID' and cart.productID='$productID'";
            $result = mysqli_query($dbc, $query);
            $row = mysqli_fetch_assoc($result);

            // Calculate subtotal for each product
            $subtotalForProduct = $row['proPrice'] * $row['quantity'];
            $subTotal += $subtotalForProduct;

            // Display product name, price, quantity, and subtotal
            echo "<tr>";
            echo "<td>" . $row['proName'] . "</td>";
            echo "<td>" . $row['proPrice'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $subtotalForProduct . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        // Calculate total price including tax or any other charges
        $total = $subTotal; // You can add tax or other charges here if needed

        // Display subtotal and total
        echo "<h2>Total: $" . $total . "</h2>";

    } else {
        // If no products were checked, display an error message or redirect to the cart page
        echo "No products were selected for checkout.";
        // You can redirect to the cart page or any other page as needed
        header("Location: cart.php");
        // exit();
    }
} else {
    // If the checkout button was not clicked, redirect to the cart page or any other page
    header("Location: cart.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Order</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 12px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
            display: block;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Table styles */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Information & Checkout Form</h2>
        <form action="process_checkout.php" method="POST">
            <!-- User Information Inputs -->
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required value="<?php echo $name; ?>"><br>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required  value="<?php echo $phoneNumber; ?>"><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required  value="<?php echo $email ?>"><br>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" required><?php echo $address; ?></textarea><br>

            <?php
            foreach ($checkedProducts as $productID) {
                echo "<input type='hidden' name='checked[]' value='$productID'>";
            }
            ?>

            <input type="submit" value="Checkout">
        </form>
    </div>
</body>
</html>