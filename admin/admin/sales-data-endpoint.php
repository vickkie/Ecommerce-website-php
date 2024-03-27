<?php
// Database connection and configuration
include('includes/config.php');

// Fetch the sales data from the database
$sql = "SELECT product_name, total_sales FROM sales_data";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

// Prepare the data in the desired format
$salesData = array();
foreach ($results as $row) {
    $salesData[] = array(
        'product_name' => $row['product_name'],
        'total_sales' => $row['total_sales']
    );
}

// Set the response header to JSON
header('Content-Type: application/json');

// Return the sales data as JSON
echo json_encode($salesData);
?>
