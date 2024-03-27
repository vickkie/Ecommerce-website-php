<?php
session_start();
error_reporting(E_ALL);
include('includes/config.php');
require('includes/vendor/autoload.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_REQUEST['order_id'])) {
        $orderid = ($_GET['order_id']);
    }

    // Fetch order details from the database
    $sql = "SELECT * FROM orders_info WHERE order_id = :orderid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':orderid', $orderid, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    // Generate PDF using mPDF
    $mpdf = new \Mpdf\Mpdf();

    // Company Information and Logo
    $html = '<table style="width: 100%;">';
    $html .= '<tr>';
    $html .= '<td style="width: 30%;">';
    $html .= COMPANY_LOGO;
    $html .= '</td>';
    $html .= '<td style="width: 70%; text-align: right;">';
    $html .= '<h2>' . COMPANY_NAME . '</h2>';
    $html .= '<p>' . COMPANY_ADDRESS_1 . '</p>';
    $html .= '<p>' . COMPANY_ADDRESS_2 . '</p>';
    $html .= '<p>' . COMPANY_ADDRESS_3 . '</p>';
    $html .= '<p>' . COMPANY_COUNTY . ', ' . COMPANY_POSTCODE . '</p>';
    $html .= '<p>' . COMPANY_PHONENUMBER . '</p>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '</table>';
    $html .= '<br>';

    // Order Information
    $html .= '<h3>Order Details</h3>';
    $html .= '<p><strong>Order ID: </strong>'.$orderid.'</p>';
    $html .= '<p><strong>Customer Name:</strong> ' . strtoupper($result->f_name) . '</p>';
    $html .= '<p><strong>Phone:</strong> 0' . htmlentities($result->contact) . '</p>';
    $html .= '<p><strong>County:</strong> ' . strtoupper($result->city) . '</p>';
    $html .= '<p><strong>Order Date:</strong> ' . $result->date . '</p>';
    $html .= '<br>';

    // Product Details
    $html .= '<h3>Product Details</h3>';
    $html .= '<table style="width: 90%;" border="1" cellpadding="5" cellspacing="0">';
    $html .= '<tr><th>#</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr>';

    $sql = "SELECT * FROM sales_orders WHERE order_id = :orderid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':orderid', $orderid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    $grandTotal = 0;

    foreach ($results as $result) {
        $html .= '<tr>';
        $html .= '<td>' . $cnt . '</td>';
        $html .= '<td>' . $result->product_title . '</td>';
        $html .= '<td>' . $result->quantity . '</td>';
        $html .= '<td>' . $result->product_price . '</td>';
        $total = $result->quantity * $result->product_price;
        $html .= '<td>' . $total . '</td>';
        $html .= '</tr>';
        $grandTotal += $total;
        $cnt++;
    }

    $html .= '</table>';
    $html .= '<br>';

    // Grand Total
    $html .= '<p><strong>TOTAL AMOUNT: ' . CURRENCY . ' ' . number_format($grandTotal, 2) . '</strong></p>';



// Stamp (Payment Type)
$html .= '<div style="text-align: center; margin-top: 20px; background-color: #25d366; color: #000; padding: 10px; display: inline-block; border-radius: 15px; transform: rotate(-10deg);">';
$sql2 = "SELECT * FROM orders_info WHERE order_id = :orderid";
    $query2 = $dbh->prepare($sql2);
    $query2->bindParam(':orderid', $orderid, PDO::PARAM_STR);
    $query2->execute();
    $results2 = $query2->fetch(PDO::FETCH_OBJ);

if($results2) {
$html .= 'PAYMENT TYPE: '. (strtoupper($results2->payment));
$html .= '</div>';
$html .= '<br>';
}
   //Thanks 
    $html .= '<table style="width: 100%;">';
    $html .= '<tr>';
    $html .= '<td style="width: 50%;text-align:center;">';
    $html .= '<i style="color:blue">'. COMPANY_THANKS . '</i>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '</table>';
    $html .= '<br>';



    // Footer
    $html .= '<table style="width: 100%;">';
    $html .= '<tr>';
    $html .= '<td style="width: 30%;">';
    $html .= COMPANY_LOGOS;
    $html .= '</td>';
    $html .= '<td style="width: 70%; text-align: right;">';
    $html .= '<p>' . COMPANY_PHONENUMBER . '</p>';
    $html .= '<p>' . COMPANY_COUNTY . ', ' . COMPANY_POSTCODE . '</p>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '</table>';

    // Generate PDF using mPDF
    $mpdf->WriteHTML($html);

    // Get the PDF data as a string
    $pdfData = $mpdf->Output('', 'S');

    // Save the PDF to a folder
    $filename = 'order_' . $orderid . '.pdf';
    $filepath = 'invoices/' . $filename;
    file_put_contents($filepath, $pdfData);

    // Redirect back to the original page with success parameter
    header('location: view-order.php?order_id=' . $orderid . '&success=true');
}
?>
