<?php
session_start();
error_reporting(0);
include('includes/config.php');

    if (isset($_GET['lastCheckedTimestamp'])) {
        $lastCheckedTimestamp = $_GET['lastCheckedTimestamp']; // Make sure to validate and sanitize this input

        // Query the database for new messages since the last checked timestamp
        $username = $_SESSION['alogin'];
        $sql = "SELECT * FROM message WHERE (sender_name = :username OR receiver_name = :username) AND dates > :lastCheckedTimestamp ORDER BY dates ASC";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':lastCheckedTimestamp', $lastCheckedTimestamp, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        // Prepare the response data
        $response = array();
        $response['success'] = false;
        $response['messages'] = array();

        if ($query->rowCount() > 0) {
            $response['success'] = true;
            $response['messages'] = $results;
        }

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

?>
