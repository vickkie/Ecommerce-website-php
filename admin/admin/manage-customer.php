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

if(strlen($_SESSION['alogin'])==0)
{	
header('location:index.php');
}
else{
if(isset($_GET['del']) && isset($_GET['name']))
{
$id=$_GET['del'];
$name=$_GET['name'];
$sql = "delete from customers WHERE user_id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$sql2 = "insert into deleteduser (email) values (:name)";
$query2 = $dbh->prepare($sql2);
$query2 -> bindParam(':name',$name, PDO::PARAM_STR);
$query2 -> execute();
$msg="Data Deleted successfully";
}
if(isset($_REQUEST['unconfirm']))
{
$aeid=intval($_GET['unconfirm']);
$memstatus=1;
$sql = "UPDATE customers SET status=:status WHERE  user_id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$memstatus, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
$msg="Changes Sucessfully";
}
if(isset($_REQUEST['confirm']))
{
$aeid=intval($_GET['confirm']);
$memstatus=0;
$sql = "UPDATE customers SET status=:status WHERE  user_id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$memstatus, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
$msg="Changes Sucessfully";
}
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from customers WHERE user_id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$msg="Data Deleted successfully";
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
    <title>Manage Customer
    </title>
    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
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
              <h2 class="page-title">Manage Customers
              </h2>
              <!-- Zero Configuration Table -->
              <div class="panel panel-default">
                <div class="panel-heading">List 
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
                        
                        <th>Username
                        </th>
                        <th>Mobile
                        </th>
                        <th>Address
                        </th>
                        <th>Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT * from  customers ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
                      <tr>
                        <td>
                          <?php echo htmlentities($cnt);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->first_name);?>  
                          <?php echo htmlentities($result->last_name);?>
                        </td>
                       
                        <td>
                          <?php echo htmlentities($result->email);?>
                        </td>
                         <td>
                          <?php echo htmlentities($result->mobile);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->address1);?>
                           , <?php echo htmlentities($result->address2);?>
                        </td>
                        
                         <td>
                          <a href="manage-customer.php?del=<?php echo $result->user_id;?>" onclick="return confirm('Do you want to delete');">
                            <i class="fa fa-trash" style="color:red">
                            </i>
                          </a>
                        </td>
                      </tr>
                      <?php $cnt=$cnt+1; }} ?>
                    </tbody>
                  </table>
                </div>
              </div>
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
    <script>
    $(document).ready(function() {
        // Destroy existing DataTable instance (if any)
        if ($.fn.DataTable.isDataTable('#zctb')) {
            $('#zctb').DataTable().destroy();
        }

        // Initialize DataTable with pagination options
        $('#zctb').DataTable({
            "lengthMenu": [20, 50, 100], // Set the available page lengths
            "pageLength": 20, // Set the initial page length to 20
            "pagingType": "full_numbers", // Display pagination with first, previous, next, and last buttons
            "order": [], // Disable initial sorting
        });
    });
</script>
  </body>
</html>
<?php } ?>
