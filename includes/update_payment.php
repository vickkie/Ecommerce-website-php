<?php
include('config.php');
try {
    // SQL query to select data
    $sql = "SELECT 
                orders_info.order_id, 
                orders_info.email, 
                orders_info.total_amt 
                orders_info.username,
                
                banking_payment.status,
                banking_payment.order_id,
                banking_payment.email,
                banking_payment.amount,
                mpesa_payment.order_id,
                mpesa_payment.email,
                mpesa_payment.status,
                mpesa_payment.amount

            FROM 
                orders_info";

    // execute SQL query and get result set
    $stmt = $dbh->query($sql);


    // update
    $update_status_query = "UPDATE banking_payment
                            JOIN orders_info ON banking_payment.order_id = orders_info.order_id
                            SET banking_payment.status = orders_info.status
                            WHERE banking_payment.status <> orders_info.status";

    $dbh->query($insert_query);
    $dbh->query($update_status_query);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// close database connection
$dbh = null;
?>
