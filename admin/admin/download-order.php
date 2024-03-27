<?php
if (isset($_REQUEST['order_id'])) {
    $orderid = ($_GET['order_id']);

    // Generate the file path
    $filename = 'order_' . $orderid . '.pdf';
    $filepath = 'invoices/' . $filename;

    // Check if the file exists
    if (file_exists($filepath)) {
        // Set the appropriate headers for file download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filepath));

        // Output the file content
        readfile($filepath);
    } else {
        // File not found
        // Redirect to the original page with order ID and error parameter
        header('location: manage-invoices.php?order_id=' . $orderid . '&error=Generate invoice first');
        exit;
    }
} else {
    // Invalid order ID
    echo 'Invalid order ID.';
}
?>
