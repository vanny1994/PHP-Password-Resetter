<?php
session_start();
require_once 'db_conn.php';

session_start();
$_SESSION['loggedin'] = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the user's credentials (You may need to customize this part)
    $sql = "SELECT * FROM itlabaradman_user WHERE username = ? LIMIT 1";
    if ($stmt = $db_conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    // Authentication successful, set session variables
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $user['username'];
                    header("Location: home.php"); // Redirect to a welcome page or dashboard
                    exit();
                } else {
                    // Password is incorrect
                    $error = "Invalid password";
                }
            } else {
                // User does not exist
                $error = "User not found";
            }
        } else {
            // Database query failed
            $error = "Database error";
        }
        $stmt->close();
    } else {
        // Error preparing the SQL statement
        $error = "Database error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aradman</title>

    <link href="DataTables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
    


    <script src="Assets/js/jquery-3.7.1.min.js"></script>
    <script src="DataTables/datatables.min.js"></script>
    <script src="Assets/js/bootstrap.min.js"></script>
    <script src="Assets/js/sweetalert11.js"></script>
</head>
<body style="background-color:#f2f3f7!important;">
    
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; width: auto;">
    <div class="login-container" style="width: 80vh; min-height: 60vh; background-color: white; border-radius: 15px; box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);">
    <br>

        <div class="row d-flex justify-content-center">
            <img src="Assets/img/logo.png" alt="">
        </div>

        <div class="row ">
           <br>
        </div>

        <form action="login.php" method="POST">
            <div class="form-group row mx-auto d-flex justify-content-center">
                
                <div class="col-sm-10">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                </div>
            </div>
            <div class="form-group row mx-auto d-flex justify-content-center">
              
                <div class="col-sm-10">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                </div>
            </div>
            <div class="form-group row mx-auto  ">
                <div class="col-sm-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success col-sm-10">Login</button>
                    <?php if (isset($error)) { ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</div>


    
</body>
</html>
