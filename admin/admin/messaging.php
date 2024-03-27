<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $sendername = $_SESSION['alogin'];
    $profile_picture = $_SESSION['profilepicture'];
    if (isset($_REQUEST['del'])) {
        $delid = intval($_GET['del']);
        $sqldel = "DELETE FROM message WHERE id=:delid";
        $querydel = $dbh->prepare($sqldel);
        $querydel->bindParam(':delid', $delid, PDO::PARAM_STR);
        $querydel->execute();
        unset($sqldel);
        $msg = "Message Deleted Sucessfully";
    }
    if (isset($_GET['submit'])) {


        $sendername = $_SESSION['alogin'];
         $receiver = $_GET['receiver'];
         $sender = $sendername;
         $dateTime = date('Y-m-d H:i:s');
         $message = $_GET['desc'];
         $profpic = $profile_picture;

try {
    


        // Check if the same message and sender combination already exists
        $sqlCheck = "SELECT * FROM message WHERE sender_name = :sender AND cmsg = :message";
        $queryCheck = $dbh->prepare($sqlCheck);
        $queryCheck->bindParam(':sender', $sender, PDO::PARAM_STR);
        $queryCheck->bindParam(':message', $message, PDO::PARAM_STR);
        $queryCheck->execute();
        if ($queryCheck->rowCount() > 0) {
            echo '<script>exists();</script>';

          } else {
            // Insert the data if the combination doesn't exist
            $sql = "INSERT INTO message(sender_name, receiver_name, cmsg, profpic, dates) VALUES(:sender, :receiver, :message, :profpic, :dates)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':sender', $sender, PDO::PARAM_STR);
            $query->bindParam(':receiver', $receiver, PDO::PARAM_STR);
            $query->bindParam(':message', $message, PDO::PARAM_STR);
            $query->bindParam(':profpic', $profpic, PDO::PARAM_STR);
            $query->bindParam(':dates', $dateTime, PDO::PARAM_STR); // Updated variable name
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $msg = "Message sent Successfully";
            } else {
                $error = "Something went wrong. Please try again";
            }

}
          } catch (PDOException $e) {

echo "An error occurred: " . $e->getMessage();
}

            
        
    }
}
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <!-- Your head content goes here -->

     <link rel="shortcut icon" href="itemimg/promoking.jpg">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Promokings | Dashboard
    </title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap.css">
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
</head>
<body>
    <!-- Your body content goes here -->

  <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
      
  
        <form>

               <div class="container-fluid"  style="border: 1px solid #ccc;">
                 <div class="content-wrapper">
                        

                          <label class="col-sm-2 control-label">SEND MESSAGE TO:
                            </label>
                             <br>

                               <?php
                            if (isset($_SESSION['alogin'])) {
                                $username = $_SESSION['alogin'];
                                
                                $sql = "SELECT * FROM users WHERE username = :username 
                                ORDER BY dates ASC  ";

                                 $query = $dbh->prepare($sql);
                                $query->bindParam(':username', $username, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                            
                            ?>
                         <div class="row">
                         <div class="col-md-6">
                         <input type="text" name="receiver" id="receiver" value="" required style="padding: 8px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 10px;" onkeyup="showUsernames(this.value)">
                        </div>
                         <div class="col-md-6"><b>Suggestions</b>
                        <div id="usernameSuggestions" style="color: black; background: #1ecbe1; font-size: 12px; border: 1px solid #ccc; border-radius: 14px;"></div>
                        </div>
                          </div>
                          </div>
                        </div>
                      </div>


                      <div class="form-group">
                     <div class="container-fluid ">
                     <div class="content-wrapper">
                     <div class="row">
                      <div class="card direct-chat direct-chat-primary col-md-12" style="margin: auto;margin-right: 10px;">
                      <div class="card-header">
                        <h3 class="card-title">Messages</h3>
                      </div>
                      <div class="card-body">
                        <!-- Conversations are loaded here -->
  <div class="direct-chat-messages">
<?php
if (isset($_SESSION['alogin'])) {
    $username = $_SESSION['alogin'];

    $sql = "SELECT * FROM message WHERE sender_name = :username OR receiver_name = :username ORDER BY dates DESC";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $senderName = htmlentities($result->sender_name);
            $receiverName = htmlentities($result->receiver_name);
            $message = htmlentities($result->cmsg);
            $timestamp = strtotime($result->dates); // Convert to UNIX timestamp

            // Create DateTime object with the timestamp and the server's timezone
            $dateTime = new DateTime('@' . $timestamp, new DateTimeZone('UTC'));
            $dateTime->setTimezone(new DateTimeZone('Africa/Nairobi')); // Set the timezone to Africa/Nairobi

            // Get the current day and format the date accordingly
            $currentDay = date('l'); // e.g., "Wednesday"
            $formattedDate = '';

            if ($dateTime->format('Y-m-d') === date('Y-m-d')) {
                // Today's date
                $formattedDate = $dateTime->format('H:i') . ' today';
            } elseif ($dateTime->format('Y-m-d') === date('Y-m-d', strtotime('-1 day'))) {
                // Yesterday's date
                $formattedDate = $dateTime->format('H:i') . ' yesterday';
            } else {
                // Other days
                $formattedDate = $dateTime->format('l H:i');
            }

            if ($senderName === $username) {
                // Display sender's message on sender's side
                echo '<div class="direct-chat-msg">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name float-right">' . $senderName . '</span>&nbsp
                            <span class="direct-chat-timestamp float-right" style="color:red">' . $formattedDate . '</span>
                        </div>
                        <div class="direct-chat-text float-right">' . $message . '</div>
                    </div>';
            } else {
                // Display receiver's reply on receiver's side
                echo '<div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name float-left" style="font-size:14px;font-size:16px">' . $senderName . '</span>&nbsp&nbsp&nbsp 
                            <span class="direct-chat-timestamp float-left" style="color:red">' . $formattedDate . '</span>
                        </div>
                        <div class="direct-chat-text float-left">' . $message . '</div>
                    </div>';
           // }
       // }
    }
}
?>






                            <?php
                             
                           // }
                        
                                
                            ?>
                         </div>
                         </div>
                         <div class="card-footer">
                        <div class="col-sm">
                            <div class="input-group">
                             <input type="text" id="desc" name="desc" placeholder="Type Message ..." class="form-control">
                             <span class="input-group-append">
                             <button id="sendMessageButton" class="btn btn-primary" name="submit" type="submit"  class="form-control" >SEND</button>
                             </span>
                         </div>
                       </div>

                    
                     </div>
                  </div>
               </div>
            </form>
        </div>
    </div>

    <!-- Your script tags go here -->


<script>
    function selectUsername(username) {
        document.getElementById("receiver").value = username;
        document.getElementById("usernameSuggestions").innerHTML = "";
    }
</script>

<script>
   function showUsernames(str) {
    if (str.length == 0) {
        document.getElementById("usernameSuggestions").innerHTML = "";
        return;
    }
    $.ajax({
        url: "includes/get_usernames.php",
        method: "GET",
        data: { search: str },
        success: function(response) {
            document.getElementById("usernameSuggestions").innerHTML = response;
        }
    });
}

</script>

<script>
    // Function to reload the page
    function reloadPage() {
        window.location.reload();
    }

    // Set the reload interval
    setInterval(reloadPage, 35000); // Adjust the interval time (in milliseconds) as needed
</script>



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

<?php 
}}
                            }
//}
//} 
?>