
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
    <div class="login-container" style="width: 80vh; min-height: 70vh; background-color: white; border-radius: 15px; box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);">
    <br>

        <div class="row d-flex justify-content-center">
            <img src="Assets/img/logo.png" alt="">
        </div>

        <div class="row ">
           <br>
        </div>

        <form action="resetPass.php" method="POST">
            <div class="form-group row mx-auto d-flex justify-content-center">
                
                <div class="col-sm-10">
                    <input type="text" id="username" name="username" class="form-control " placeholder="Username"  style="border-color: #28a745;" required>
                </div>
            </div>
            <div class="form-group row mx-auto d-flex justify-content-center">
              
                <div class="col-sm-10">
                    <input type="password" id="password" name="password" class="form-control" placeholder="New Password" required style="border-color: #28a745;" required>
                </div>
            </div>
            <div class="form-group row mx-auto d-flex justify-content-center">
              
              <div class="col-sm-10">
                  <input type="password" id="confirm_password"  name="confirm_password" class="form-control" placeholder="Confirm New Password" required style="border-color: #28a745;" required>
              </div>
          </div>
            <div class="form-group row mx-auto  ">
                <div class="col-sm-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success col-sm-10">Reset</button>  
                </div>
                    
            </div>

            <div class="form-group row mx-auto  ">

                <div class="col-sm-12 d-flex justify-content-center">
                     <a href="index.php">Log In</a>
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
    
    if ($jsonData === false) {
        return null; // Return null if there was an error reading the file
    }
    
    return json_decode($jsonData, true);
}

// Function to update a user's password
function updatePassword($username, $newPassword, $jsonFilePath) {
    $users = getUsersFromJson($jsonFilePath);

    if ($users === null) {
        echo 'Error reading JSON file.';
        return;
    }

    // Find the user by username
    foreach ($users as &$user) {
        if ($user['username'] === $username) {
            $user['password'] = $newPassword;
            break;
        }
    }

    // Save the updated data back to the JSON file
    $jsonData = json_encode($users, JSON_PRETTY_PRINT);
    $result = file_put_contents($jsonFilePath, $jsonData);

    if ($result === false) {
        echo 'Error writing to JSON file.';
    } else {
        echo "<script>
        Swal.fire({
            title: 'Password Updated Successfully',
            showCancelButton: false,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'OK'
        }).then(function(result) {
            if (result.value) {
                // Redirect to logIn_JSON.php
                window.location.href = 'index.php';
            }
        });
    </script>";
    
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        // Passwords match, proceed to update
        // Do not reassign $jsonFilePath here
        // Path to the JSON file containing user data
        // $jsonFilePath = '/Assets/js/user.json';

        // Update the user's password
        updatePassword($username, $newPassword, $jsonFilePath);
    } else {
        // Passwords do not match, display an error message
        echo "<script>
        Swal.fire({
            title: 'Passwords do not match',
            showCancelButton: false,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'OK'
        });
    </script>";
    }
}
?>