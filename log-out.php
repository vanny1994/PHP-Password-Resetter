<?php
session_start();

// Unset or clear the session data
session_unset();
session_destroy();



// Redirect to index.php
header('Location: index.php');

exit;
?>
