<?php
  session_start();
  require_once ('mysqli_connect.php');
  if(!isset($_SESSION['userID'])){
      header('Location: login.php');
  }


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orderID']) && isset($_POST['tracking_code'])) {
    $orderID = $_POST['orderID'];
    $trackingCode = $_POST['tracking_code'];

    // Prepare SQL statement with parameter binding
    $stmt = $dbc->prepare("UPDATE ordercom SET tracking_code = ? WHERE orderID = ?");
    $stmt->bind_param("si", $trackingCode, $orderID);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Redirect back to the page displaying the orders with a success message
        header("Location: AdOrder.php?tracking_updated=1");
        exit();
    } else {
        echo "Error updating tracking code: " . $stmt->error;
    }

    // Close prepared statement
    $stmt->close();
}

$dbc->close();
?>
