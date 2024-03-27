<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0)
{	
header('location:index.php');
}
else{
if(isset($_GET['del']))
{
$id=$_GET['del'];
$name=$_GET['name'];
$sql = "delete from register_requests WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$msg="Supplier Deleted successfully";
}
if(isset($_REQUEST['unconfirmid']))
{
$aeid=intval($_GET['unconfirmid']);
$memstatus="Unapproved";
$sql = "UPDATE suppliers SET status=:status WHERE  supplier_id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$memstatus, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
$msg="Changes Sucessfully";
}
if(isset($_REQUEST['confirmid']))
{
$aeid=intval($_GET['confirmid']);
$memstatus="Approve";
$sql = "UPDATE register_requests SET status=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$memstatus, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
$msg="Supplier Approved Sucessfully";
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
    <title>Approve Request
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
    <link rel="stylesheet" href="css/uzi.css">
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
              <h2 class="page-title" >
              Requested New Register  

               </h2>
<div class="x_content">
  <ul class="nav nav-tabs bar_tabs " id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="profile-tab" href="request-user.php">Unapproved</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" href="request-approved.php">Approved</a>
    </li>
  </ul>
</div>




              <!-- Zero Configuration Table -->
              <div class="panel panel-default">
                <div class="panel-heading">List Staff
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
                        <th>Full Name
                        </th>
                        <th>National ID
                        </th>
                        <th>Employee ID
                        </th>
                         <th>Status
                        </th>
                        <th>Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT * from register_requests WHERE status='Requested' ";
                      $query = $dbh -> prepare($sql);
                      $query->execute();
                       $results=$query->fetchAll(PDO::FETCH_OBJ);
                       $cnt=1;
                       if($query->rowCount() > 0)
                         {
                       foreach($results as $result)
                       {  ?>	
                      <tr>
                        <td>
                          <?php echo htmlentities($cnt);?>
                        </td>
                    
                        <td>
                          <?php echo htmlentities($result->fullname);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->id_no);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->employee_no);?>
                        </td>
                        <td>
                     <?php
                    $status = htmlentities($result->status);
                    $statusClass = '';

                    if ($status == 'Requested') {
                    $statusClass = 'text-danger';
                     } 
                   elseif ($status == 'Approved') {
                   $statusClass = 'text-success';
                   }

                  echo '<b class="' . $statusClass . '">' . $status . '</b>';
                  ?>
                 </td>
                  <td>
                        <a href="request-user.php?confirmid=<?php echo $result->id;?>" onhover="approve"   onclick="return confirm('Do you want to approve User');">
                            <i class="fa fa-check" style="color:blue">
                            </i>
                          </a>                        
                         <br>
                          <a href="request-user.php?del=<?php echo $result->id;?>" onclick="return confirm('Do you want to delete Request');">
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
        <script type="text/javascript">
      $(document).ready(function () {
        setTimeout(function() {
          $('.errorWrap').slideUp("slow");
        }
                   , 5000);
      }
                       );
    </script>
  </body>
</html>
<?php } ?>
