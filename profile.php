<?php
  session_start();
  require_once ('mysqli_connect.php');
  if(!isset($_SESSION['userID'])){
      header('Location: login.php');
  }

// Default userID for testing

$id = $_SESSION['userID'];

$name = "";
$email = "";
$phoneNumber = "";
$address = "";

// Fetch user data from the database
$query = "SELECT * FROM userinfo WHERE userID = ?";
$stmt = mysqli_prepare($dbc, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $id); // 's' indicates a string parameter
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['userName'];
        $email = $row['email'];
        $phoneNumber = $row['phoneNumber'];
        $address = $row['address'];
    }

    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($dbc);
}

// Handle form submission to update user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPhoneNumber = $_POST['phoneNumber'];
    $newAddress = $_POST['address'];

    // Update the user information in the database
    $updateQuery = "UPDATE userinfo SET userName = ?, email = ?, phoneNumber = ?, address = ? WHERE userID = ?";
    $updateStmt = mysqli_prepare($dbc, $updateQuery);

    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, 'sssss', $newName, $newEmail, $newPhoneNumber, $newAddress, $id); // 'sssss' indicates five string parameters
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);

        // Refresh the page to reflect the updated information
        header("Location: profile.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($dbc);
    }
}

$orderQuery = "SELECT orderID, tracking_code FROM ordercom WHERE userID = ?";
$orderStmt = mysqli_prepare($dbc, $orderQuery);
if ($orderStmt) {
    mysqli_stmt_bind_param($orderStmt, 's', $id);
    mysqli_stmt_execute($orderStmt);
    $orderResult = mysqli_stmt_get_result($orderStmt);

    // Check if there was an error in executing the query
    if (!$orderResult) {
        die("Error: " . mysqli_error($dbc));
    }
} else {
    echo "Error: " . mysqli_error($dbc);
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile</title>
    <style>
      body {
            font-family: Arial, sans-serif;
            background-image: url("rainbow2.jpg");
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .container1 {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px auto;
            border-radius: 10px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            width: 80%;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        

        .title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            resize: none;
            height: 100px;
        }

        .form-control:focus {
            outline: none;
            border-color: #6cb2eb;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        #button1 {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #6cb2eb;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
            width:100%;
        }

        #button1:hover, #button2:hover {
            background-color: #4f89c8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        th:first-child, td:first-child {
            text-align: left;
        }
    </style>
</head>
<body>
<?php include("header2.php"); ?>
<div class="container1">
    <div class="title">
        <h1>User Profile</h1>
    </div>
    <form action="profile.php" method="post">
        <label for="name" class="label">Name:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>">

        <label for="email" class="label">Email:</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">

        <label for="phoneNumber" class="label">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" value="<?php echo htmlspecialchars($phoneNumber); ?>">

        <label for="address" class="label">Address:</label>
        <textarea id="address" name="address" class="form-control"><?php echo htmlspecialchars($address); ?></textarea>
       

        <div class="form-control">
            <button type="submit" id="button1" name="submit">Confirm</button>
         
        </div>
    </form>
</div>

<div class="container1">
    <h2>Order Information</h2>
    <table border="1">
        <thead>
            <tr>
                <th >Order ID</th>
                <th>Tracking Code</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($orderRow = mysqli_fetch_assoc($orderResult)) {
                echo "<tr>";
                echo "<td>" . $orderRow['orderID'] . "</td>";
                echo "<td>";
                if (empty($orderRow['tracking_code'])) {
                    echo "Seller is preparing for shipping";
                } else {
                    echo $orderRow['tracking_code'];
                }
                echo "</td>";
                echo "</tr>";
            }
            mysqli_free_result($orderResult);
            ?>
        </tbody>
    </table>

</div>

<script>
document.getElementById("button2").addEventListener("click", function() {
    window.location.href = "main.php";
});
</script>
<?php include("footer.php"); ?>
</body>
</html>
