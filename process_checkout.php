<?php
session_start();
require_once('mysqli_connect.php');

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['userID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $number = $_POST['phone'];
    $email = $_POST['email'];
    $checkedProducts = isset($_POST['checked']) ? $_POST['checked'] : array();
    $totalPrice = 0;
    $orderID = uniqid();

    // Start transaction
    mysqli_autocommit($dbc, false);

    $insertOrderProductQuery = "INSERT INTO orderproduct (orderID, productID, quantity) VALUES (?, ?, ?)";
    $stmtOrderProduct = mysqli_prepare($dbc, $insertOrderProductQuery);

    $insertOrderComQuery = "INSERT INTO ordercom (orderID, userID, Name, Address, number, email, totalPrice, datetime) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmtOrderCom = mysqli_prepare($dbc, $insertOrderComQuery);

    if ($stmtOrderProduct && $stmtOrderCom) {
        foreach ($checkedProducts as $productID) {
            $queryCart = "SELECT quantity FROM cart WHERE userID = ? AND productID = ?";
            $stmtCart = mysqli_prepare($dbc, $queryCart);
            mysqli_stmt_bind_param($stmtCart, "ss", $userID, $productID);
            mysqli_stmt_execute($stmtCart);
            mysqli_stmt_store_result($stmtCart);

            if (mysqli_stmt_num_rows($stmtCart) == 1) {
                mysqli_stmt_bind_result($stmtCart, $quantity);
                mysqli_stmt_fetch($stmtCart);
                mysqli_stmt_close($stmtCart);

                mysqli_stmt_bind_param($stmtOrderProduct, "ssi", $orderID, $productID, $quantity);
                mysqli_stmt_execute($stmtOrderProduct);

                $queryProduct = "SELECT proPrice, maxQuantity FROM product WHERE productID = ? FOR UPDATE";
                $stmtProduct = mysqli_prepare($dbc, $queryProduct);
                mysqli_stmt_bind_param($stmtProduct, "s", $productID);
                mysqli_stmt_execute($stmtProduct);
                mysqli_stmt_bind_result($stmtProduct, $proPrice, $availableQuantity);
                mysqli_stmt_fetch($stmtProduct);

                $newAvailableQuantity = $availableQuantity - $quantity;
                mysqli_stmt_close($stmtProduct);

                $updateProductQuery = "UPDATE product SET maxQuantity = ? WHERE productID = ?";
                $stmtUpdateProduct = mysqli_prepare($dbc, $updateProductQuery);
                mysqli_stmt_bind_param($stmtUpdateProduct, "is", $newAvailableQuantity, $productID);
                mysqli_stmt_execute($stmtUpdateProduct);
                mysqli_stmt_close($stmtUpdateProduct);

                $totalPrice += $proPrice * $quantity;

                $deleteFromCartQuery = "DELETE FROM cart WHERE userID = ? AND productID = ?";
                $stmtDeleteFromCart = mysqli_prepare($dbc, $deleteFromCartQuery);
                mysqli_stmt_bind_param($stmtDeleteFromCart, "ss", $userID, $productID);
                mysqli_stmt_execute($stmtDeleteFromCart);
                mysqli_stmt_close($stmtDeleteFromCart);
            }
        }

        mysqli_stmt_bind_param($stmtOrderCom, "ssssssd", $orderID, $userID, $name, $address, $number, $email, $totalPrice);
        mysqli_stmt_execute($stmtOrderCom);

        mysqli_commit($dbc);
        mysqli_autocommit($dbc, true);
        mysqli_close($dbc);

        header("Location: confirmation.php");
        exit();
    } else {
        // Rollback transaction if any error occurs
        mysqli_rollback($dbc);
        mysqli_autocommit($dbc, true);
        mysqli_close($dbc);

        // Redirect user to an error page
        header("Location: error.php");
        exit();
    }
} else {
    header("Location: cart.php");
    exit();
}
?>
