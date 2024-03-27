<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','professional');

// COMPANY INFORMATION
define('COMPANY_LOGO', '<img src=itemimg/promokings.jpg>');
define('COMPANY_LOGO_WIDTH', '300');
define('COMPANY_LOGO_HEIGHT', '90');

define('COMPANY_LOGOS', '<img src=itemimg/promokings.jpg>');
define('COMPANY_LOGOS_WIDTH', '100');
define('COMPANY_LOGOS_HEIGHT', '60');
define('COMPANY_NAME','PROMOKINGS');
define('COMPANY_ADDRESS_1','Meru, makutano');
define('COMPANY_ADDRESS_2','Nairobi, 23 Moi avenue');
define('COMPANY_ADDRESS_3','Parklands');
define('COMPANY_COUNTY','Nairobi');
define('COMPANY_POSTCODE','10100');
define('COMPANY_PHONENUMBER','Phone No: +254758015158'); // phone number

define('COMPANY_NUMBER','Company No: 699400000'); // Company registration number
define('COMPANY_VAT', 'Company VAT: 690000007'); // Company TAX/VAT number

// EMAIL DETAILS
define('EMAIL_FROM', 'Promokings@inms.ccc'); // Email address invoice emails will be sent from
define('EMAIL_NAME', 'Promokings'); // Email from address
define('EMAIL_SUBJECT', 'Invoice default email subject'); // Invoice email subject
define('EMAIL_BODY_INVOICE', 'Invoice default body'); // Invoice email body
define('EMAIL_BODY_QUOTE', 'Quote default body'); // Invoice email body
define('EMAIL_BODY_RECEIPT', 'Receipt default body'); // Invoice email body

// OTHER SETTINGS
define('INVOICE_PREFIX', 'MD'); // Prefix at start of invoice - leave empty '' for no prefix
define('INVOICE_INITIAL_VALUE', '1'); // Initial invoice order number (start of increment)
define('INVOICE_THEME', '#222222'); // Theme colour, this sets a colour theme for the PDF generate invoice
define('TIMEZONE', 'Africa/Kenya'); // Timezone - See for list of Timezone's http://php.net/manual/en/function.date-default-timezone-set.php
define('DATE_FORMAT', 'DD/MM/YYYY'); // DD/MM/YYYY or MM/DD/YYYY
define('CURRENCY', 'Kshs'); // Currency symbol
define('ENABLE_VAT', true); // Enable TAX/VAT
define('VAT_INCLUDED', false); // Is VAT included or excluded?
define('VAT_RATE', '10'); // This is the percentage value

define('PAYMENT_DETAILS', 'promoking<br>Sort Code: 12-00-00<br>Account Number: 6655777'); // Payment information
define('FOOTER_NOTE', 'Promokings');
define('PAYMENT_TYPE', 'PAY ON DELIVERY'); // This is the type of payment



// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>
