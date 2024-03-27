<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('includes/config.php');

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM register_requests WHERE username = ?";
    $query = $dbh->prepare($sql);
    $query->execute([$username]);

    // Fetch the result
    $result = $query->fetch();

    if ($result) {
        // Username exists
        echo 'exists';
    } else {
        // Username does not exist
        echo 'available';
    }
} else {
    // No username parameter provided
    echo 'error';
}
?>
