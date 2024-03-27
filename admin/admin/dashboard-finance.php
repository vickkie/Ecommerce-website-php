<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    exit('No direct script access allowed');
}
?>

<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin']) == 0 || $_SESSION['position'] !== 'finance manager') {
    // Redirect the user to the login page or any other appropriate page
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


  if (isset($_SESSION['position'])) {
        $position = $_SESSION['position'];
         $username = $_SESSION['alogin'];




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
    <title>Promokings | Dashboard
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
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/adminlte.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
       <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12"><center class="pull-right";><span><img src="product_images/promokings.jpg" style="width:40%" alt="Promokings" /></center></span>
              <h2 class="page-title">Dashboard | <?php  echo (strtolower($position)) ?>
              </h2>


  <!-- Main content -->
        <div class="row">
          <!-- Main content -->
          <div class="col-md-12">
             <div class="row">
               <div class="col-lg-2 col-6">
              <!-- small box -->
            <div class="small-box bk-uzi2">
              <div class="inner">
                 <div class="stat-panel text-center" style="color:white;">
                         <?php
                        if (isset($_SESSION['position'])) {
                         $position = $_SESSION['position'];
                        $username = $_SESSION['alogin'];

                         $sql1 = "SELECT id FROM message WHERE receiver_name=:username";
                         $query1 = $dbh->prepare($sql1);
                         $query1->bindParam(':username', $username, PDO::PARAM_STR);
                         $query1->execute();
                         $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                        $regbd = $query1->rowCount();
                        }
                        ?>
                 </div>

                          <div class="stat-panel-number h1 ">
                          <?php echo htmlentities($regbd);?>
                          </div>

                <p style="color:black">Messages</p>
              </div>

              <div class="icon">
             <i class="ion ion-chatboxes"></i>
             </div>
            <a href="messaging.php" class="small-box-footer">more info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
      

          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box" >
            <div class="inner">
                 
                <h5 style="color:black;text-align: center;">CLOCK</h5>
              </div>
               <div class="stat-panel-number h6 " style="text-align: center;">
                          <?php echo strtoupper($username);?>
               </div>
              <div id="clock" style="text-center;font-size: 44px;">
                
              </div>
              <div class="icon">
             <i class="icon ion-clock" style="font-size: 120px;"></i>

             </div>
             <a><i class="fas fa-clock"></i></a>
             </div>
             </div> 
            
           </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Include the necessary Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="col-lg-6">
    <div class="card">
        <div class="card-header no-border">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Sales</h3>
                <a href="javascript:void(0);" style="float-right">View Report</a>
                      <div class="card-tools float-right">
                        
                            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex">
               <p class="d-flex flex-column">
              <span class="text-bold text-lg">  <?php
// Get the current month
$currentMonth = date('n');

// SQL query to retrieve the total sales for the current month
$sql = "SELECT SUM(total_amt) AS total_sales FROM orders_info WHERE MONTH(`date`) = :month";
$query = $dbh->prepare($sql);
$query->bindParam(':month', $currentMonth, PDO::PARAM_INT);
$query->execute();
$results = $query->fetch(PDO::FETCH_ASSOC);

$currentMonthSales = $results['total_sales'];
?>

<span>Total sales:</span>
<span>
    <?php echo 'Kshs ' . number_format($currentMonthSales,2); ?>
</span>
             </p>

                <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                       <span id="percentage-change"></span>%
                    </span>
                    <span class="text-muted">Since last month</span>
                </p>
            </div>
            <!-- /.d-flex -->

            <div class="position-relative mb-4">
                <canvas id="sales-chart" height="200"></canvas>
            </div>

            <div class="d-flex flex-row justify-content-end">
                <span class="mr-2">
                    <i class="fa fa-square text-primary"></i> This year
                </span>
            </div>
        </div>
    </div>
    <!-- /.card -->
</div>

<script>
    // Retrieve data from the database and format it for the chart
    <?php

    $sql = "SELECT MONTH(`date`) AS month, SUM(total_amt) AS total_sales FROM orders_info GROUP BY MONTH(`date`)";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    // Convert the fetched data into a format suitable for the chart
    $data = [];
    for ($month = 1; $month <= 12; $month++) {
        $data[] = [
            "month" => $month,
            "total_sales" => 0
        ];
    }

    foreach ($results as $row) {
        $month = $row['month'];
        $data[$month - 1]["total_sales"] = floatval($row['total_sales']);
    }
    ?>

    const salesData = <?php echo json_encode($data); ?>;
    const labels = [];
    const values = [];

    // Iterate through all 12 months
    for (let month = 1; month <= 12; month++) {
        labels.push(getMonthName(month)); // Add month name to labels array

        // Check if there is data available for the month
        const data = salesData.find(item => item.month === month);
        if (data) {
            values.push(data.total_sales); // Add total sales value
        } else {
            values.push(0); // Set total sales to 0 for months with no data
        }
    }

    const maxSales = Math.max(...values); // Get the maximum sales value

    const ctx = document.getElementById('sales-chart').getContext('2d');


    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                hoverBackgroundColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 0 // Remove the border lines around the bars
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: false // Remove the vertical grid lines
                    },
                    ticks: {
                        display: true // Show the x-axis labels
                    }
                },
                y: {
                    beginAtZero: true, // Start y-axis from 0
                    max: Math.ceil(maxSales / 100000) * 100000, // Round up the maximum sales value to the nearest hundred thousand
                    ticks: {
                        stepSize: Math.ceil(maxSales / 10), // Adjust the step size of y-axis ticks based on the maximum sales value
                        display: true // Show the y-axis labels
                    },
                    grid: {
                        display: true, // Show the horizontal grid lines
                        color: 'rgba(0, 0, 0, 0.1)', // Customize the color of the horizontal grid lines
                        drawBorder: false // Remove the border lines on the y-axis grid
                    }
                }
            },
            plugins: {
                legend: {
                    display: false // Hide the legend
                }
            },
            layout: {
                padding: {
                    bottom: 20 // Add bottom padding to accommodate x-axis labels
                }
            },
            bar: {
                borderRadius: 5, // Adjust the border radius of the bars
                categoryPercentage: 0.9, // Adjust the width of the bars relative to the available space
                barPercentage: 1 // Make the bars fill the available space for each category
            },
            tooltips: {
                enabled: false // Disable tooltips
            }
        }
    });

    function getMonthName(month) {
        const monthNames = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ];
        return monthNames[month - 1];
    }

// Calculate the percentage increase or decrease from the previous month
const currentMonthIndex = (new Date().getMonth() + 1) - 1;
    const currentMonthSales = values[currentMonthIndex];
    const previousMonthSales = values[currentMonthIndex - 1];
    let percentageChange = 0;
 

if (previousMonthSales !== 0) {
    percentageChange = ((currentMonthSales - previousMonthSales) / previousMonthSales) * 100;
}

    // Show the percentage change with arrow
    const percentageChangeFormatted = Math.abs(percentageChange).toFixed(2);
    const percentageChangeElement = document.getElementById('percentage-change');
    percentageChangeElement.textContent = percentageChangeFormatted;

     if (percentageChange < 0) {
        percentageChangeElement.style.color = 'red'; // Set the text color to red

        const downArrow = document.createElement('i');
        downArrow.classList.add('fa', 'fa-arrow-down', 'text-red'); // Add 'text-red' class for the arrow color
        percentageChangeElement.prepend(downArrow);
    }

     if (percentageChange > 0) {
        const upArrow = document.createElement('i');
        upArrow.classList.add('fa', 'fa-arrow-up');
        percentageChangeElement.prepend(upArrow);
    }

</script>
 <script>
  $(document).ready(function() {
    // Minimize the card when the minus icon is clicked
    $('.card-tools .btn[data-widget="collapse"]').click(function() {
      var card = $(this).closest('.card');
      card.toggleClass('collapsed');
    });

    // Close the card when the times icon is clicked
    $('.card-tools .btn[data-widget="remove"]').click(function() {
      var card = $(this).closest('.card');
      card.remove();
    });
  });
</script>


  <script type="text/javascript">
  function updateClock() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();

    hours = hours < 10 ? "0" + hours : hours;
    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    var time = hours + ":" + minutes + ":" + seconds;
    document.getElementById("clock").textContent = time;

    setTimeout(updateClock, 1000);
  }

  updateClock();
</script>


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
  </body>
</html>
<?php } ?>