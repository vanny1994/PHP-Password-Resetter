<?php
include_once 'db_conn.php';

session_start();
if ($_SESSION['loggedin'] == false) {
    header('Location: index.php');
   
}
?>



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
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-success">
    <div class="container">
        <div class="navbar-brand">
            <img src="Assets/img/logo.png" width="50" height="50" alt="" style="border-radius: 25px;">
        </div>
        <div class="navbar-text mx-auto">
            <h2 class="text-light">ARADMAN USER PASSWORD RESET</h2>
        </div>
    </div>

    <form class="form-inline my-2 my-md-0">
  <div class="dropdown">
    <button class="btn btn-success dropdown-toggle" type="button" id="navbarDropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-user"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-left" style="left: auto; right: 0; " aria-labelledby="navbarDropdown1">
      <a class="dropdown-item" id="logout-button" href="log-out.php">
        <span style="margin-right: 10px;">&#x279C</span> Log Out
      </a>
    </div>
  </div>
</form>





</nav>




<br><br>


<div class="d-flex justify-content-center align-items-center">
<table class="display" id="myTable" border="2">
    <thead id="head">
        <tr >
       
            <th class="text-center">Full Name</th>
            <th class="text-center">Username</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include_once 'db_conn.php';

        $result = $db_conn->query("SELECT * FROM itlabaradman_user WHERE id <> 2");

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
          
            echo '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td><button class="btn btn-success reset-button" data-toggle="modal" data-target="#resetPasswordModal" data-user-id="' . $row['id'] . '">Reset Password</button></td>';


            echo '</tr>';
        }
        ?>
    </tbody>
</table>

</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel">Confirm Password Reset</h5>
                
            </div>
            <div class="modal-body">
                Are you sure you want to reset the password?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success" id="confirmReset">Yes</button>



            </div>
        </div>
    </div>
</div>





    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>



 <script>
$(document).ready(function () {
    // Handle the click event for the reset button using event delegation
    $('#myTable').on('click', '.reset-button', function () {
        // When the button is clicked, show the modal
        $('#resetPasswordModal').modal('show');

        // Retrieve the user ID associated with the clicked button
        var userId = $(this).data('user-id');
        $('#confirmReset').data('user-id', userId); // Store the user ID in the modal button
    });

    // Handle the confirm reset button click
    $('#confirmReset').click(function () {
        // Retrieve the user ID from the stored data
        var userId = $(this).data('user-id');

        // Perform the password reset action here
        $.ajax({
            url: 'passwordReset.php',
            method: 'POST',
            data: {
                userId: userId
            },
            success: function (response) {
                // Handle the response from the server (e.g., show a success message)
                console.log('Password reset successfully.');
                Swal.fire({
                        title: 'Password Reset Successfull',
                        
                        showCancelButton: false,
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'OK'
                        });

                
            },
            error: function (error) {
                // Handle any errors from the server
                console.error('Password reset failed:', error);
            },
            complete: function () {
                // Once the password is reset or the request is complete, close the modal
                $('#resetPasswordModal').modal('hide');
            }
        });
    });
});
</script>




</script>

<br><br><br>
 <!--footer -->
 <footer class="py-4 bg-success mt-auto">
            <div class="container-fluid px-2 ">
                <div class="d-flex align-items-end justify-content-end">
                    <div class="text-light small" style="margin-left:50px;">Developed By Vanny &bull; &commat;ITLAB 2023</div>
                </div>
          
        </div>
    </div>

</footer>



   
</body>
</html>