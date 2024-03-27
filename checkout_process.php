
<script src="https://cdn.jsdelivr.net/npm/notiflix@2.7.0/dist/notiflix-aio-2.7.0.min.js"></script>

<script>
// Show the loading animation and redirect after 3 seconds
function thanks() {
  Notiflix.Loading.Standard('Loading...');

  setTimeout(function() {
    window.location.href = 'thanks.php';
  }, 3000); // 3000 milliseconds = 3 seconds
}
</script>



<?php
session_start();
include "db.php";
if (isset($_SESSION["uid"])) {

    $f_name = $_POST["firstname"];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
   // $order_time = time("h:i:sa");
   $order_date1 = date("Y-m-d"); //Order DAte
    $status = 'Ordered';
    $approval='disapproved';




    $contact= $_POST['contact'];
    $user_id=$_SESSION["uid"];
    $contactstr=(string)$contact;
   
    $total_count=$_POST['total_count'];
    $prod_total = $_POST['total_price'];
    
    
    $sql0="SELECT order_id from `orders_info`";
    $runquery=mysqli_query($con,$sql0);
    if (mysqli_num_rows($runquery) == 0) {
        echo( mysqli_error($con));
        $order_id=1;
    }else if (mysqli_num_rows($runquery) > 0) {
        $sql2="SELECT MAX(order_id) AS max_val from `orders_info`";
        $runquery1=mysqli_query($con,$sql2);
        $row = mysqli_fetch_array($runquery1);
        $order_id= $row["max_val"];
        $order_id=$order_id+1;
        echo( mysqli_error($con));
    }

    $sql = "INSERT INTO `orders_info` 
    (`order_id`,`user_id`,`f_name`, `email`,`address`, 
    `city`,`date`,`status`,`contact`,`prod_count`,`total_amt`,`approval`) 
    VALUES ($order_id, '$user_id','$f_name','$email', 
    '$address', '$city','$order_date1','$status','$contactstr','$total_count','$prod_total','$approval')";



    if(mysqli_query($con,$sql)){
        $i=1;
        $prod_id_=0;
        $prod_code_=0;
        $prod_price_=0;
        $prod_qty_=0;
        
        while($i<=$total_count){
            $str=(string)$i;

            $prod_id_+$str = $_POST['prod_id_'.$i];
            $prod_id=$prod_id_+$str;
             

           

            $prod_price_+$str = $_POST['prod_price_'.$i];
            $prod_price=$prod_price_+$str;

            $prod_qty_+$str = $_POST['prod_qty_'.$i];
            $prod_qty=$prod_qty_+$str;

            $sub_total=(int)$prod_price*(int)$prod_qty;

            $sql1="INSERT INTO `order_products` 
            (`order_pro_id`,`order_id`,`product_id`,`qty`,`amt`) 
            VALUES (NULL, '$order_id','$prod_id','$prod_qty','$sub_total')";

            if(mysqli_query($con,$sql1)){
                $del_sql="DELETE from cart where user_id=$user_id";
                if(mysqli_query($con,$del_sql)){
                    echo"<script>thanks();</script>";
                }else{
                    echo(mysqli_error($con));
                }

            }else{
                echo(mysqli_error($con));
            }
            $i++;


        }
    }else{

        echo(mysqli_error($con));
        
    }
    
}else{
    echo"<script>window.location.href='index.php'</script>";
}
    




?>