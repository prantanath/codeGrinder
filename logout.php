<?php
// Start the session
session_start();

// Destroy the session
session_destroy();

// Redirect to main.php
header("Location: index.php");
exit;
?>
