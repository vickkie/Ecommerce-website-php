  <link rel="stylesheet" href="css/style.css">

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
    <link rel="stylesheet" href="css/adminlte.css">


    <script type= "text/javascript" src="../vendor/countries.js">
    </script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

      <script>
function save() {
  swal({
    title: "Save Task?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((save) => {
    if (save) {
      swal("Task saved!", {
        icon: "success",
      });
    }
  });
}
</script>
<script>
function unsave() {
  swal({
    title: "Data already Exist😒",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  });
}
</script>
  <?php

session_start();
ini_set('display_errors', E_ALL);
ini_set('display_startup_errors', E_ALL);
error_reporting(0);

include('includes/config.php');

$allowedPositions = array('inventory manager', 'admin', 'super admin');

if (isset($_POST['submit'])) {
    $tasker_name = $_SESSION['alogin'];
    $task = $_POST['task'];
    $dtime = date('Y-m-d H:i:s');
    $status = $_POST['selected_status'];
    $timing = $_POST['selected_timing'];

    // Check if the data already exists in the table
    $sql = "SELECT COUNT(*) AS count FROM to_do_list WHERE tasker_name = :tasker_name AND task = :task";
    $query = $dbh->prepare($sql);
    $query->bindParam(':tasker_name', $tasker_name, PDO::PARAM_STR);
    $query->bindParam(':task', $task, PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];

    // If the data doesn't exist, perform the insertion
    if ($count == 0) {
        // Get the maximum existing task_id from the database
        $sql = "SELECT MAX(task_id) AS max_task_id FROM to_do_list";
        $query = $dbh->prepare($sql);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $max_task_id = $row['max_task_id'];

        // Increment the task_id for the new record
        $task_id = $max_task_id + 1;

        // Prepare and execute the INSERT statement
        $sql = "INSERT INTO to_do_list (task_id, tasker_name, task, dtime, timing, status) 
                VALUES (:task_id, :tasker_name, :task, :dtime, :timing, :status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':task_id', $task_id, PDO::PARAM_INT);
        $query->bindParam(':tasker_name', $tasker_name, PDO::PARAM_STR);
        $query->bindParam(':task', $task, PDO::PARAM_STR);
        $query->bindParam(':dtime', $dtime, PDO::PARAM_STR);
        $query->bindParam(':timing', $timing, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);


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
    <title>Add Driver
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
    <script type= "text/javascript" src="../vendor/countries.js">
    </script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



      <?php

        if ($query->execute()) {

          echo "<script> save();</script>";
            //$msg = "Task added successfully";
        } else {
           echo "<script> unsave();</script>";
        }
    } else {
        echo "<script> unsave();</script>";
    }


    

?>


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
   
 
<?php } ?>
 <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h2 class="page-title">Add Task
              </h2>

<div class="x_content">
  <ul class="nav nav-tabs bar_tabs " id="myTab" role="tablist">
        <li class="nav-item">
      <a class="nav-link" id="contact-tab" href="manage-tasks.php">Manage tasks</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" id="profile-tab" href="to-do.php">Add task</a>
    </li>

   
  </ul>
</div>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">Task Info
                    </div>
                    <?php if($error){?>
                    <div class="errorWrap">
                      <?php echo htmlentities($error); ?> 
                    </div>
                    <?php } 
                    else if($msg){?>
                    <div class="succWrap">
                      <?php echo htmlentities($msg); ?> 
                    </div>
                    <?php }?> 
                    
               <div class="panel-body">
  <form method="post" class="form-horizontal" enctype="multipart/form-data" >
    <div class="form-group">
      <label class="col-sm-2 control-label">Task <span style="color:red">*</span></label>
      <div class="col-sm-4">
        <input type="text" name="task" class="form-control" placeholder="Enter Task name" required>

      </div>
    </div>


<div class="form-group">
  <label class="col-sm-2 control-label">Status<span style="color:red">*</span></label>
  <div class="col-sm-4">
    <select name="status" class="form-control" required onchange="updateStatusField(this)">
      <option value="completed">Completed</option>
      <option value="pending">Pending</option>
    </select>
  </div>
  <div class="form-group">
  <label class="col-sm-2 control-label">Selected Status</label>
  <div class="col-sm-3">
    <input type="text" name="selected_status" id="selectedStatusField" class="form-control" readonly required>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Time<span style="color:red">*</span></label>
  <div class="col-sm-4">
    <select name="timing" class="form-control" required onchange="updateTimeField(this)" >
      <option value="2 min">2 min</option>
      <option value="10 min">10 min</option>
      <option value="30 min">30 min</option>
      <option value="1 hr">1 hr</option>
      <option value="1 day">1 day</option>
      <option value="10 days">10 days</option>
      <option value="30 days">30 days</option>
    </select>
  </div>
  <div class="form-group">
  <label class="col-sm-2 control-label">Selected Time</label>
  <div class="col-sm-3">
    <input type="text" name="selected_timing" id="selectedTimeField" class="form-control" readonly required>
  </div>
</div>


<script>
  function updateStatusField(select) {
    document.getElementById("selectedStatusField").value = select.value;
  }

  function updateTimeField(select) {
    document.getElementById("selectedTimeField").value = select.value;
  }
</script>

<div class="form-group">
      <div class="col-sm-8 col-sm-offset-2">
        <button class="btn btn-default" type="reset">Cancel</button>
        <button class="btn btn-primary" name="submit" type="submit">Save Changes</button>
      </div>
    </div>
  </form>
</div>

 </body>
</html>




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
        }</script>
  
