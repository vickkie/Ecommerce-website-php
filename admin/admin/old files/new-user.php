<?php
session_start();
error_reporting(0);
include('includes/config.php');

$allowedPositions = array('super admin' ,'admin');

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
$sql = "delete from users WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$sql2 = "insert into deleteduser (email) values (:name)";
$query2 = $dbh->prepare($sql2);
$query2 -> bindParam(':name',$name, PDO::PARAM_STR);
$query2 -> execute();
//$msg="Data Deleted successfully";
}
if(isset($_REQUEST['unconfirmid']))
{
$aeid=intval($_GET['unconfirmid']);
$sql = "UPDATE users SET status=:status WHERE  id=:aeid";
$status='Disapproved';
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
//$msg="Changes Sucessfully";
}
if(isset($_REQUEST['confirmid']))
{
$aeid=intval($_GET['confirmid']);
$sql = "UPDATE users SET status=:status WHERE  id=:aeid";
$status='Approved';
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
//$msg="Changes Sucessfully";
}
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from users WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
//$msg="Data Deleted successfully";
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
              <h2 class="page-title">Unapproved Users
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
                        <th>Position
                        </th>
                        <th>Status
                        </th>
                       
                        <th width="20px">Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT * from  users WHERE status='Unapproved'";
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
                          <?php echo htmlentities($result->name);?> 
                          <?php //echo htmlentities($result->lname);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->username);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->position);?>
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

    <a href="new-user.php?confirmid=<?php echo $result->id; ?>"  onclick="event.preventDefault();return approve();">

 <script>

function approve() {
  swal({
    title: "Approve User?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal("Successfully Approved!", {
        icon: "success",
      }).then(() => {
        window.location.href = "new-user.php?confirmid=<?php echo $result->id; ?>";
      });
    } else {
      swal("Aborted!");
    }
  });
}

 </script>


                          
 <i class="fa fa-check" style="color: blue;"></i>
                          </a>
                          <br>
                         
                          <a href="new-user.php?del=<?php echo $result->id;?>" onclick="event.preventDefault(); return willDelete();">
                      <script>

function willDelete() {
                     swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover data",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal(" User have been deleted! 🚮", {
      icon: "success",
    }).then(() => {
        window.location.href = "new-user.php?del=<?php echo $result->id; ?>";
      });
  } else {
    swal("Aborted!");
  }
});
}
</script>


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
