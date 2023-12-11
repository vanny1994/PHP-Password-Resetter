<?php
include_once 'db_conn.php'; 
session_start();

// Check if the 'id' is provided via POST
if (isset($_POST['userId'])) {
    // Get the 'id' from the POST data
    $id = $_POST['userId'];

    // Hash the new password "Password1*"
    $hashedPassword = password_hash('Password1*', PASSWORD_BCRYPT);

    // Define the SQL query to update the password
    $sql = "UPDATE itlabaradman_user SET password = ? WHERE id = ?";

    // Assuming you're using MySQLi for database operations
    if ($stmt = $db_conn->prepare($sql)) {
        // Bind the hashed password and user ID to the SQL query
        $stmt->bind_param("si", $hashedPassword, $id);

        // Execute the SQL query
        if ($stmt->execute()) {
            // Password reset successful
            echo "Password reset successful.";
        } else {
            // Error occurred during password reset
            echo "Password reset failed: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Error preparing the SQL statement
        echo "Error preparing SQL statement: " . $db_conn->error;
    }

    // Close the database connection
    $db_conn->close();
} else {
    // 'id' not provided in the POST request
    echo "User ID not provided.";
}
?>
