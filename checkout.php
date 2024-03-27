<?php
include "db.php";

include "header.php";
include "contactwhatsapp.php";
$current_url = $_SERVER['REQUEST_URI'];

                         
?>

<style>

.row-checkout {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container-checkout {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.checkout-btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.checkout-btn:hover {
  background-color: #45a049;
}



hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row-checkout {
    flex-direction: column-reverse;
  }
  .col-50 {
    margin-bottom: 20px;
  }
}
</style>
  <style>
        .button-box {
            display: flex;
            justify-content: center;
        }

        .button-box label {
            display: inline-block;
            padding: 10px 20px;
            background-color: #eaeaea;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        .button-box input[type="radio"] {
            display: none;
        }

        .button-box input[type="radio"]:checked + label {
            background-color: #3c8dbc;
            color: #fff;
        }
     </style>



					
<section class="section">       
	<div class="container-fluid">
		<div class="row-checkout">
		<?php
		if(isset($_SESSION["uid"])){
			$sql = "SELECT * FROM customers WHERE user_id='$_SESSION[uid]'";
			$query = mysqli_query($con,$sql);
			$row=mysqli_fetch_array($query);
		
		echo'
			<div class="col-50">
				<div class="container-checkout">
				<form id="checkout_form" action="checkout_process.php" method="POST" class="was-validated">

					<div class="row-checkout">
					
					<div class="col-50">
						<h3>Yours Address/ Details</h3>
						<label for="fname"><i class="fa fa-user" ></i> Full Name *</label>
						<input type="text" id="fname" class="form-control" name="firstname" pattern="^[a-zA-Z ]+$"  value="'.$row["first_name"].''.$row["last_name"].'" readonly>
						<label for="email"><i class="fa fa-envelope"></i> Email</label>
						<input type="text" id="email" name="email" class="form-control" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$" value="'.$row["email"].'" required>
						<label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
						<input type="text" id="adr" name="address" class="form-control" value="'.$row["address1"].'" required>
						<label for="city"><i class="fa fa-institution"></i> City</label>
						 <input type="text" id="city" name="city" class="form-control" value="'.$row["address2"].'" pattern="^[a-zA-Z ]+$" required>
            <label for="cardNumber">Phone number</label>
            <input type="text" class="form-control" id="Number" name="contact"  value="'.$row["mobile"].'" required><br>
          </div>
					
					
				 	<div class="col-50">
						<h3>Payment Details</h3>
						<label for="fname">Accepted Methods</label>
						<div class="icon-container">
					

						<i class="fa fa-mobile-alt" style="color:blue;"></i>
						<i class="fa fa-mobile-alt" aria-hidden="true" style="font-size:24px">M-Pesa-</i> 
						<i class="fa fa-mobile" style="font-size:24px"></i>
						<i class="fa fa-mobile-alt" aria-hidden="true" style="font-size:20px">Airtel Money-</i>
							
					
            <i class="fa fa-money"> cash</i>
						<i class="fa fa-cc-mastercard" style="color:red;"></i>
						<i class="fa fa-cc-paypal" style="color:blue;"></i>
					  
		      </div>


<div class="form-group" id="payment">
  <h4>Select Payment Mode:</h4>
  <div class="button-box">
    <input type="radio" id="cod" name="paymentMode" value="COD" required>
    <label for="cod">Cash on Delivery (COD)</label>

    <input type="radio" id="banking" name="paymentMode" value="Banking" required>
    <label for="banking">Banking</label>

    <input type="radio" id="mpesa" name="paymentMode" value="Mpesa" required>
    <label for="mpesa">M-Pesa</label>
  </div>
  
  <div class="button-box">
    <div id="paymentbuttonbank" style="display: none;">
      <input type="checkbox" id="banking-pay">
      <label for="banking-pay">Pay</label>
    </div>
    <div id="paymentbuttonmpesa" style="display: none;">
      <input type="checkbox" id="mpesa-pay">
      <label for="mpesa-pay">Pay</label>
    </div>
  </div>
</div>

<br><br>

<p><b>Steps<br></b>
<b>1.Select Payment Method</b>:<a style="color:blue"> Choose preferred payment mode.</a><br>
<b>2.Checkout for COD</b>: <a style="color:blue"> For Cash on Delivery, proceed to checkout.</a><br>
<b>3.Pay with Other Methods</b>:<a style="color:blue"> For non-COD payments, select your preferred option and make the payment.</a><br>
<b>4.Finalize and Checkout</b>: <a style="color:blue">Select the payment mode again and proceed to checkout.</a><p>

    


				</div>
				</div>

					<label><input type="CHECKBOX" name="q" class="roomselect" value="conform" required> Shipping address same as billing
					</label>
					<label><input type="CHECKBOX" name="q" class="roomselect" value="conform" required> Confirm orders
					</label>

					';
					//$order_time= date("Y-m-d h:i:sa"); //Order DAte
					$order_date1 = date("m-d-Y"); //Order DAte
          $status = "Ordered";  // Ordered, On Delivery
					$i=1;
					$total=0;
					$total_count=$_POST['total_count'];
					while($i<=$total_count){
						$item_name_ = $_POST['item_name_'.$i];
						$amount_ = $_POST['amount_'.$i];
						$quantity_ = $_POST['quantity_'.$i];
						$total=$total+$amount_ ;


						$sql = "SELECT product_id,product_code FROM products WHERE product_title='$item_name_'";
						$query = mysqli_query($con,$sql);
					  $row=mysqli_fetch_array($query);
						$product_id=$row["product_id"];
						$product_code=$row["product_code"];

						echo "	
						<input type='hidden' name='prod_id_$i' value='$product_id'>
						<input type='hidden' name='item_name_$i' value='$item_name_'>
						<input type='hidden' name='prod_code_$i' value='$product_code'>
						<input type='hidden' name='prod_price_$i' value='$amount_'>
						<input type='hidden' name='prod_qty_$i' value='$quantity_'>
						";
						$i++;
					}
					
				echo'	
				<input type="hidden" name="total_count" value="'.$total_count.'">
					<input type="hidden" name="total_price" value="'.$total.'">
					
					<input type="submit"  style="background-color:RGB(255, 78, 80)" id="submit" value="Proceed with checkout" class="checkout-btn">
				</form>
				</div>
			</div>
			';
		}else{
			echo"<script>window.location.href = 'cart.php'</script>";
		}
		?>

			<div class="col-25">
				<div class="container-checkout">
				
				<?php
				if (isset($_POST["cmd"])) {
				
					$user_id = $_POST['custom'];
					
					
					$i=1;
					echo
					"
					<h4>Cart 
					<span class='price' style='color:black'>
					<i class='fa fa-shopping-cart'></i> 
					<b>$total_count</b>
					</span>
				</h4>

					<table class='table table-condensed'>
					<thead><tr>
					<th >no</th>
					<th >product title</th>
          <th>qty	</th>
					<th>amount</th></tr>
					</thead>
					<tbody>
					";
					$total=0;
					while($i<=$total_count){
						$item_name_ = $_POST['item_name_'.$i];
						
						$item_number_ = $_POST['item_number_'.$i];

						$amount_ = $_POST['amount_'.$i];
						
						$quantity_ = $_POST['quantity_'.$i];
						$total=$total+$amount_ ;
						$sql = "SELECT product_id,product_code FROM products WHERE product_title='$item_name_'";
						$query = mysqli_query($con,$sql);
						$row=mysqli_fetch_array($query);
						$product_id=$row["product_id"];
						$product_code=$row["product_code"];
					
						echo "

						<tr style='width:25px;'>
						<td>
						<p>$item_number_</p>
						</td>
						<td>
						<p>$item_name_</p>
						</td>
						
						
						<td >
						<p>$quantity_</p>
						</td>
						<td >
						<p>$amount_</p>
						</td></tr>";
						
						$i++;
					}

				echo"

				</tbody>
				</table>
				<hr>
				
				<h3>Total<span class='price' style='color:black'><b>KSHS  $total</b></span></h3>";
					
				}
				?>
				</div>
			</div>
		</div>
	</div>
</section>
		<div id="newsletter" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="newsletter">
							<p>Sign Up for the Update On Offers</p>
							<form >
								<input class="input" type="email" placeholder="Enter Your Email">
								<button class="newsletter-btn"><i class="fa fa-envelope"></i> Sign up</button>
							</form>
							<ul class="newsletter-follow">
								<li>
									<a href="#"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-instagram"></i></a>
								</li>
								
							</ul>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>

<script>
    var bankingButton = document.getElementById("banking-pay");
    var mpesaButton = document.getElementById("mpesa-pay");
    var paymentButtons = document.getElementById("payment-buttons");

    document.getElementById("banking").addEventListener("change", function() {
        if (this.checked) {
            bankingButton.style.display = "block";
            mpesaButton.style.display = "none";
            paymentbuttonbank.style.display = "block";
            paymentbuttonmpesa.style.display = "none";
        }
    });

    document.getElementById("mpesa").addEventListener("change", function() {
        if (this.checked) {
            bankingButton.style.display = "none";
            mpesaButton.style.display = "block";
            paymentbuttonbank.style.display = "none";
            paymentbuttonmpesa.style.display = "block";
        }
    });
     document.getElementById("cod").addEventListener("change", function() {
        if (this.checked) {
            bankingButton.style.display = "none";
            mpesaButton.style.display = "none";
            paymentbuttonbank.style.display = "none";
            paymentbuttonmpesa.style.display = "none";
        }
    });
</script>

     <script>
        window.addEventListener('DOMContentLoaded', function() {
            var mpesaRadio = document.getElementById('mpesa-pay');
            var bankingRadio = document.getElementById('banking-pay');

            mpesaRadio.addEventListener('change', function() {
                if (mpesaRadio.checked) {
                    // Redirect to the Mpesa payment page
                    window.location.href = 'mpesa_payment.php';
                }
            });

     bankingRadio.addEventListener('change', function() {
     if (bankingRadio.checked) {
    // Redirect to the banking payment page with user details
    // var user_id = <?php // echo $_SESSION["uid"]; ?>;
    // var amount = <?php // echo $_SESSION["amount"]; ?>;
    var originalUrl = encodeURIComponent(window.location.href);
    window.location.href = 'banking_payment.php?original_url=' + originalUrl;
     }


            });
        });
    </script>

		
<?php
include "footer.php";
?>