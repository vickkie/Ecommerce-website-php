<?php
include "db.php";
error_reporting(0);
session_start();

#If user given credential matches successfully with the data available in database then we will echo string login_success

if(isset($_POST["email"]) && isset($_POST["password"])){
	$email = mysqli_real_escape_string($con,$_POST["email"]);
	$password = $_POST["password"];
	$sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$password'";
	$run_query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($run_query);
    $row = mysqli_fetch_array($run_query);
		$_SESSION["uid"] = $row["user_id"];
		$_SESSION["name"] = $row["first_name"];
		$ip_add = getenv("REMOTE_ADDR");
		//created a cookie in login_form.php page so if that cookie is available means user is not login
        
	//if user record is available in database then $count will be equal to 1
	if($count == 1){
		   	
			if (isset($_COOKIE["product_list"])) {
				$p_list = stripcslashes($_COOKIE["product_list"]);
				//here we are decoding stored json product list cookie to normal array
				$product_list = json_decode($p_list,true);
				for ($i=0; $i < count($product_list); $i++) { 
					//After getting user id from database here we are checking user cart item if there is already product is listed or not
					$verify_cart = "SELECT id FROM cart WHERE user_id = $_SESSION[uid] AND p_id = ".$product_list[$i];
					$result  = mysqli_query($con,$verify_cart);
					if(mysqli_num_rows($result) < 1){
						//if user is adding first time product into cart we will update user_id into database table with valid id
						$update_cart = "UPDATE cart SET user_id = '$_SESSION[uid]' WHERE ip_add = '$ip_add' AND user_id = -1";
						mysqli_query($con,$update_cart);
					}else{
						//if already that product is available into database table we will delete that record
						$delete_existing_product = "DELETE FROM cart WHERE user_id = -1 AND ip_add = '$ip_add' AND p_id = ".$product_list[$i];
						mysqli_query($con,$delete_existing_product);
					}
				}
				// destroying user cookie
				setcookie("product_list","",strtotime("-1 day"),"/");
				//if user is logging from after cart page we will send cart_login
				echo "cart_login";
				
				
				exit();
				
			}
			//if user is login from page we will send login_success

			echo "login_success";


			if (isset($_SESSION['redirect_url'])) {
            $redirect_url = $_SESSION['redirect_url'];
            unset($_SESSION['redirect_url']);
            header("Location: $redirect_url");
            exit();
        } else {
            header("Location: index.php");
            exit();
        }

			/*$BackToMyPage = $_SERVER['HTTP_REFERER'];
				if(!isset($BackToMyPage)) {
					header('Location: '.$BackToMyPage);
					echo"<script type='text/javascript'>
					
					</script>";



				} else {
					header('Location: index.php'); // default page
				} 
				
			
            exit;
					*/
            

		}else{
                $email = mysqli_real_escape_string($con,$_POST["email"]);
                $password =($_POST["password"]) ;
                
                $sql = "SELECT * FROM users WHERE username = '$email' AND password = '$password' AND position='admin'";

                $run_query = mysqli_query($con,$sql);
                $count = mysqli_num_rows($run_query);

            //if user record is available in database then $count will be equal to 1
            if($count == 1){
                $row = mysqli_fetch_array($run_query);
                $_SESSION["uid"] = $row["id"];
                $_SESSION["name"] = $row["username"];
                $ip_add = getenv("REMOTE_ADDR");
                //created a cookie in login_form.php page so if that cookie is available means user is not login


                    //if user is login from page  send login_success
                    echo "login_success";

                    echo "<script> location.href='admin/admin/index.php'; </script>";
                    exit;

                }else{
                    echo "<span style='color:red;'>Please register before login!</span><br><span style='color:red;'>or check login credentials!</span>";
                    exit();
                }
    
	
}
    
	
}

?>