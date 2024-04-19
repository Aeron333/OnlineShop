<?php
require_once('mysqli_connect.php');
session_start();

$userID = "";
$error = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["userID"])) {
        $userID = $_POST["userID"];
    }

    $password = $_POST['password'];

    if (empty($userID)) {
        $error['userID'] = "Please enter your User ID.";
    }

    if (empty($password)) {
        $error['password'] = "Please enter your password.";
    }

    if (empty($error)) {
        $q = "SELECT userID, userPassword FROM userinfo WHERE userID = ?";
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt, "s", $userID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $userID, $password_2);
            mysqli_stmt_fetch($stmt);

            // You should use password_verify if passwords are hashed
            if ($password != $password_2) {
                $error['password'] = "Invalid password.";
            } else {
                $_SESSION['userID'] = $userID;
                header("Location: main.php");
                exit();
            }
        } else {
            $error['userID'] = "Invalid User ID.";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($dbc);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <div class="wrapper">
        <div class="title-text">
            <div class="title login">
                Login Main
            </div>
        </div>
        <div class="form-container">
            <div class="form-inner">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login">
                    <div class="field">
                        <input type="text" id="userID" name="userID" placeholder="User ID" value="<?php echo($userID); ?>">
                        <?php if(isset($error['userID'])) echo '<p class="error">' . $error['userID'] . '</p>'; ?>
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
