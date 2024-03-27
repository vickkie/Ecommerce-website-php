<?php
session_start();
error_reporting(0);
include('includes/config.php');

$allowedPositions = array('sales manager', 'superadmin' ,'admin');

// Check if the user is logged in and has an allowed position
if (empty($_SESSION['alogin']) || !in_array($_SESSION['position'], $allowedPositions)) {
    // Redirect the user to the access-denied page or any other appropriate page
    header('location:errors/access-denied.php');
    exit(); // Stop further execution of the script
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1500)) {
    // Last activity was more than 30 minutes ago
    session_unset();     // Unset all session variables
    session_destroy();   // Destroy the session
    header('location: index.php'); // Redirect the user to the login page
    exit(); // Stop further execution of the script
}

// Update last activity time stamp
$_SESSION['LAST_ACTIVITY'] = time();

if(strlen($_SESSION['alogin'])==0)
{	
header('location:index.php');
}
else{


$sql = "SELECT order_id, total_amt FROM orders_info";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

// Convert the fetched data into a format suitable for the pie chart
$data = [];
foreach ($results as $row) {
    $data[] = [
        "product_name" => $row['order_id'],
        "profit" => floatval($row['total_amt'])
    ];
}

?>
<!doctype html>
<html lang="en" class="no-js">
  <head>

     <link rel="shortcut icon" href="itemimg/promoking.jpg">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Promokings | Report  
    </title>
    <!-- Font awesome -->
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.3/css/ionicons.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <style>
      .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #dd3d36;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
      .succWrap{
        padding: 10px;
        margin: 0 0 20px 0;
        background: #5cb85c;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
    </style>
  </head>
  <body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h2 class="page-title">
                <a>Sales Report
                </a>
              </h2>

  <div class="x_content">
  <ul class="nav nav-tabs bar_tabs " id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="profile-tab" href="sales-report.php">Sales report</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" href="sales-graphs.php">Sales Graph</a>
    </li>
   
  </ul>
</div>
              <!-- Zero Configuration Table -->
              <div class="panel panel-default">
                <div class="panel-heading">Sales
                </div>
       <div class="panel-body">
                  <?php if($error){?>
                  <div class="errorWrap" id="msgshow">
                    <?php echo htmlentities($error); ?> 
                  </div>
                  <?php } 
else if($msg){?>
                  <div class="succWrap" id="msgshow">
                    <?php echo htmlentities($msg); ?> 
                  </div>
                  <?php }?>
                  <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#
                        </th>
                        <th>Name
                        </th>
                        <th>OrderId
                        </th>
                        <th>Transaction ID
                        </th>
                        <th>Email
                        </th>
                         <th>Status
                        </th>
                        <th>Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT * from  suppliers WHERE status='Unapproved' ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{       ?>  
                      <tr>
                        <td>
                          <?php echo htmlentities($cnt);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->name);?> 
                          <?php // echo htmlentities($result->lname);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->mobile);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->supplier_person);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->address);?>
                        </td>
                        <td>
  <?php
  $status = htmlentities($result->status);
  $statusClass = '';

  if ($status == 'Unapproved') {
    $statusClass = 'text-danger';
  } 
  elseif ($status == 'Approved') {
    $statusClass = 'text-success';
  }

  echo '<b class="' . $statusClass . '">' . $status . '</b>';
  ?>
</td>
<td>
                        <a href="new-supplier.php?confirmid=<?php echo $result->supplier_id;?>" onhover="approve"   onclick="return confirm('Do you want to approve supplier');">
                            <i class="fa fa-check" style="color:blue">
                            </i>
                          </a>                        
<br>
                          <a href="new-supplier.php?del=<?php echo $result->supplier_id;?>" onclick="return confirm('Do you want to delete supplier');">
                            <i class="fa fa-trash" style="color:red">
                            </i>
                          </a>
                          
  
  <script>
function unapproveHover(element) {
  element.style.color = "red"; // Example: Change the color to red on hover
}

// Alternatively, you can use CSS to handle the hover effect instead of JavaScript:
/*
<style>
a:hover i {
  color: red;
}
</style>
*/
</script>
                        </td>

                      </tr>
                      <?php $cnt=$cnt+1; }} ?>
                    </tbody>
                  </table>
                </div>
              </div>


                
              
              <div><center><span  style="width:20%;"><?php  echo COMPANY_LOGOS ?></span></center></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js">
    </script>
    <script src="js/bootstrap-select.min.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
    <script src="js/jquery.dataTables.min.js">
    </script>
    <script src="js/dataTables.bootstrap.min.js">
    </script>
    <script src="js/Chart.min.js">
    </script>
    <script src="js/fileinput.js">
    </script>
    <script src="js/chartData.js">
    </script>
    <script src="js/main.js">
    </script>
    <script type="text/javascript">
      $(document).ready(function () {
        setTimeout(function() {
          $('.succWrap').slideUp("slow");
        }
                   , 3000);
      }
                       );
    </script>
  </body>
</html>
<?php } ?>
