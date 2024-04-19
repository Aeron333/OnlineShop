<?php
session_start();
require_once ('mysqli_connect.php');
if(!isset($_SESSION['adminID'])){
  header('Location: adminLogin.php');
}


?>
<html>
<head>
    <title>Admin Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .order-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        form {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        input[type="text"] {
            width: calc(100% - 22px);
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-bottom: 2px solid #ccc;
            background-color: transparent;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        hr {
            border: 0;
            height: 1px;
            background-color: #ccc;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .alert {
            background-color: #f2dede;
            color: #a94442;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<?php include("adheader.php"); ?>
<div class="container">
    <?php
    require_once('mysqli_connect.php');

    if (isset($_GET['tracking_updated']) && $_GET['tracking_updated'] == 1) {
        echo "<div class='alert'>Tracking code updated successfully!</div>";
    }

    // Function to display order products
    function displayOrder($orderID, $orderProducts, $trackingCode) {
        echo "<div class='order-details'>";
        echo "<b>Order Products:</b><br>";
        foreach ($orderProducts as $product) {
            echo "Product ID: " . $product["productID"] . ", Quantity: " . $product["quantity"] . "<br>";
        }
        echo "<br>";
        echo "<form method='post' action='update_tracking.php'  onsubmit='return validateForm(\"tracking_code_$orderID\")'>";
        echo "<input type='hidden' name='orderID' value='$orderID'>";
        echo "<input type='text' name='tracking_code' id='tracking_code_$orderID' placeholder='Enter tracking code' required><br>";
        echo "<input type='submit' value='Update Tracking Code'><br>";
        echo "</form>";
        echo "</div>";
        echo "<hr>";
    }

    // Fetch order details along with order products
    $sql = "SELECT o.orderID, o.userID, o.Name, o.Address, o.number, o.email, o.datetime, o.totalPrice, o.tracking_code, op.productID, op.quantity
            FROM ordercom o
            INNER JOIN orderproduct op ON o.orderID = op.orderID";
    $result = $dbc->query($sql);

    if ($result->num_rows > 0) {
        // Initialize variables to store current order details
        $currentOrderID = null;
        $orderProducts = [];

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Check if current order ID is different from previous row
            if ($row["orderID"] !== $currentOrderID) {
                // If it's a new order, display previous order details (if any)
                if ($currentOrderID !== null) {
                    displayOrder($currentOrderID, $orderProducts, $currentTrackingCode);
                }
                
                // Reset order products array for the new order
                $orderProducts = [];

                // Update current order ID
                $currentOrderID = $row["orderID"];

                // Update current tracking code
                $currentTrackingCode = $row["tracking_code"];

                // Display order details
                echo "<div class='order-details'>";
                echo "Order ID: " . $row["orderID"] . "<br>";
                echo "User ID: " . $row["userID"] . "<br>";
                echo "Name: " . $row["Name"] . "<br>";
                echo "Address: " . $row["Address"] . "<br>";
                echo "Contact Number: " . $row["number"] . "<br>";
                echo "Email: " . $row["email"] . "<br>";
                echo "Order Datetime: " . $row["datetime"] . "<br>";
                echo "Total Price: " . $row["totalPrice"] . "<br>";
                echo "Tracking Code : " . $row["tracking_code"] . "<br>";
                echo "</div>";
            }

            // Add current product to the order products array
            $orderProducts[] = array(
                "productID" => $row["productID"],
                "quantity" => $row["quantity"]
            );
        }

        // Display the last order (if any)
        if ($currentOrderID !== null) {
            displayOrder($currentOrderID, $orderProducts, $currentTrackingCode);
        }
    } else {
        echo "0 results";
    }

    $dbc->close();
    ?>
</div>

<script>
function validateForm(id) {
    var trackingCode = document.getElementById(id).value;
    if (trackingCode.trim() === '') {
        alert('Please enter a tracking code.');
        return false;
    }
    return true;
}
</script>

</body>
</html>
