<?php
session_start();
error_reporting(0);
include('includes/config.php');

$allowedPositions = array('finance manager','sales manager', 'superadmin' ,'admin');

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
    <title>Sales Report</title>
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
                            <a>Sales Graph</a>
                        </h2>
                        <!-- Zero Configuration Table -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Sales</div>
                            <canvas id="sales-chart" width="800" height="400"></canvas>
                            <script>

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
      hoverBackgroundColor: 'rgba(54, 162, 235, 1)'
    }]
  },
  options: {
    responsive: false,
    maintainAspectRatio: true,
    scales: {
      x: {
        title: {
          display: true,
          text: 'Month'
        }
      },
      y: {
        title: {
          display: true,
          text: 'Total Sales'
        },
        beginAtZero: true, // Start y-axis from 0
        max: Math.ceil(maxSales / 100000) * 100000, // Round up the maximum sales value to the nearest hundred thousand
        ticks: {
          stepSize: Math.ceil(maxSales / 10) // Adjust the step size of y-axis ticks based on the maximum sales value
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
    }
  }
});

function getMonthName(month) {
  const monthNames = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
  ];
  return monthNames[month - 1];
}


                            </script>
                        </div>
                        <div><center><?php  echo COMPANY_LOGOS ?></center></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            setTimeout(function() {
                $('.succWrap').slideUp("slow");
            }, 3000);
        });
    </script>
</body>
</html>
<?php } ?>
