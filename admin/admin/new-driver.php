<?php
session_start();
error_reporting(0);

$allowedPositions = array('inventory manager','sales manager','human resource', 'superadmin' ,'admin');

// Check if the user is logged in and has an allowed position
if (empty($_SESSION['alogin']) || !in_array($_SESSION['position'], $allowedPositions)) {
    // Redirect the user to the access-denied page or any other appropriate page
    header('location:errors/access-denied.php');
    exit(); // Stop further execution of the script
}

include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{	
header('location:index.php');
}
else{
if(isset($_GET['del']) && isset($_GET['name']))
{
$id=$_GET['del'];
$name=$_GET['name'];
$sql = "delete from driver WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$sql2 = "insert into deleteduser (email) values (:name)";
$query2 = $dbh->prepare($sql2);
$query2 -> bindParam(':name',$name, PDO::PARAM_STR);
$query2 -> execute();
$msg="Data Deleted successfully";
}
if(isset($_REQUEST['unconfirmid']))
{
$aeid=intval($_GET['unconfirmid']);
$status='Unapproved';
$sql = "UPDATE driver SET status=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
$msg="Changes Sucessfully";
}
if(isset($_REQUEST['confirmid']))
{
$aeid=intval($_GET['confirmid']);
$status='Approved';
$sql = "UPDATE driver SET status=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
$msg="Changes Sucessfully";
}

if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from driver WHERE id=:id";
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
    <meta 
    charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Promokings || Approve Driver
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
              <h2 class="page-title">Approve Driver
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
                        <th>Image
                        </th>
                        <th>Full Name
                        </th>
                        <th>User Name
                        </th>
                        <th>Email
                        </th>
                        <th>Contact
                        </th>
                        <th>Address
                        </th>
                        <th>Status
                        </th>
                         <th width="20px">Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT * from  driver WHERE status='Unapproved' ";
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
                          <img src="img/members/<?php echo htmlentities($result->profpic);?>" style= "border-radius:50%; width: 50px ; height: 50px;" />
                        </td>
                        <td>
                          <?php echo htmlentities($result->firstname);?> 
                          <?php echo htmlentities($result->lastname);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->username);?>
                        </td>
                         <td>
                          <?php echo htmlentities($result->email);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->contact);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->address);?>
                        </td>
              
                        <td>
    <?php echo htmlentities($result->status);

   $statusClass = '';

  if ($status == 'Unapproved') {
    $statusClass = 'text-warning';
  }

  echo '<b class="' . $statusClass . '">' . $status . '</b>';
  ?>
                        </td>

                           <td>
                          
                          <a href="new-driver.php?confirmid=<?php echo $result->id;?>" onclick="return confirm('Do you want to Approve');">
                            <i class="fa fa-check" style="color:green"></i>

                          </a><br>
                          <a href="new-driver.php?del=<?php echo $result->id;?>" onclick="return confirm('Do you want to disapprove');">
                            <i class="fa fa-times" style="color:red"></i>
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
  </body>
</html>
<?php } ?>
