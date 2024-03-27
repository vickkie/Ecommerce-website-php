

<?php

if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    exit('Direct access is not allowed.');
}

session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM users WHERE username = ?";
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