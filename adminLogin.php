<?php
require_once('mysqli_connect.php');
session_start();

$adminID = "";
$adminpassword = ""; // Changed variable name
$error = array();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["adminID"])) {
        $adminID = ($_POST["adminID"]);
    }

    $adminpassword = $_POST['password']; // Changed variable name

    if (empty($adminID)) {
        $error['adminID'] = "Please enter your Admin ID.";
    }

    if (empty($adminpassword)) { // Changed variable name
        $error['password'] = "Please enter your password.";
    }

    if (empty($error)) {
        $q = "SELECT adminPassword FROM admininfo WHERE adminID = ?";
        $stmt = mysqli_prepare($dbc, $q);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $adminID);

            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $password_2);
                mysqli_stmt_fetch($stmt);

                // You should use password_verify if passwords are hashed
                if ($adminpassword != $password_2) { // Changed variable name
                    $error['password'] = "Invalid password.";
                } else {
                    $_SESSION['adminID'] = $adminID;
                    header("Location: AdOrder.php");
                    exit();
                }
            } else {
                $error['adminID'] = "Invalid Admin ID.";
            }

            mysqli_stmt_close($stmt);
        } else {
            // Handle the case where prepare fails
            die('mysqli_prepare failed: ' . htmlspecialchars(mysqli_error($dbc)));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <div class="wrapper">
        <div class="title-text">
            <div class="title login">
                Admin Login
            </div>
        </div>
        <div class="form-container">
            <div class="form-inner">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login">
                    <div class="field">
                        <input type="text" id="adminID" name="adminID" placeholder="Admin ID" value="<?php echo($adminID); ?>">
                        <?php if(isset($error['adminID'])) echo '<p class="error">' . $error['adminID'] . '</p>'; ?>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" required>
                        <?php if(isset($error['password'])) echo '<p class="error">' . $error['password'] . '</p>'; ?>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const loginForm = document.querySelector("form.login");
        const loginBtn = document.querySelector("label.login");
       
        loginBtn.onclick = (() => {
            loginForm.style.marginLeft = "0%";
        });
    </script>
</body>
</html>
