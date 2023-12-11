


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aradman</title>
    <link rel="icon" type="image/png" href="Assets/img/logo.png" />

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

        <form action="index.php" method="POST">
            <div class="form-group row mx-auto d-flex justify-content-center">
                
                <div class="col-sm-10">
                    <input type="text" id="username" name="username" class="form-control " placeholder="Username"  style="border-color: #28a745;" required>
                </div>
            </div>
            <div class="form-group row mx-auto d-flex justify-content-center">
              
                <div class="col-sm-10">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required style="border-color: #28a745;" required>
                </div>
            </div>
            <div class="form-group row mx-auto  ">
                <div class="col-sm-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success col-sm-10">Login</button>
                    
                </div>
            </div>

            <div class="form-group row mx-auto">
                <div class="col-sm-12 d-flex justify-content-center">
                    <a href="resetPass.php" >Forgot Password</a> 
                </div>
            </div>


            
        </form>
    </div>
</div>


    
</body>
</html>



<?php

// Define the path to the external JSON file
$jsonFilePath = 'Assets/js/user.json';

// Function to read user data from JSON file
function getUsersFromJson($jsonFilePath) {
    $jsonData = file_get_contents($jsonFilePath);
    return json_decode($jsonData, true);
}

// Function to validate user credentials
function validateUser($username, $password, $users) {
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {

           
            return true;
        }
    }
    return false;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get user data from the JSON file
    $users = getUsersFromJson($jsonFilePath);

    // Validate user credentials
    if (validateUser($username, $password, $users)) {
        // Successful login, redirect to home.php
        session_start();
        $_SESSION['loggedin'] = true;

        header('Location: home.php');
     
    } else {
        // Invalid credentials, display an error message
        echo "<script>
        Swal.fire({
            title: 'Invalid username or password',
            showCancelButton: false,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'OK'
        });
    </script>";
    }
}
?>
