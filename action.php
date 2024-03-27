
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
function added() {
  swal({
    title: "Success",
    text: "Added to Cart🛒!",
    icon: "success",
    timer: 1000, // Duration in milliseconds (1 second)
    buttons: false // Hide the buttons
  });
}
</script>


<script src="https://cdn.jsdelivr.net/npm/notiflix@2.7.0/dist/notiflix-aio-2.7.0.min.js"></script>
<script>
function addeds() {
  Notiflix.Notify.Success('Added successfully! 💃');
}
</script>


<script>
function exists() {
  swal({
    title: "Exists in cart❗",
    text: "Upadate in cart",
    icon: "error",
    timer: 1000, // Duration in milliseconds (1 second)
    buttons: false // Hide the buttons
  });
}
</script>

<script>
function deleted() {
  swal({
    title: "Success",
    text: "Product deleted❗",
    icon: "success",
    timer: 1000, // Duration in milliseconds (1 second)
    buttons: false // Hide the buttons
  });
}
</script>

<script>
function updated() {
  swal({
    title: "Updated🛒",
    text: "Quantity Updated🛒!",
    icon: "success",
    timer: 1000, // Duration in milliseconds (1 second)
    buttons: false // Hide the buttons
  });
}
</script>






<?php
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db.php";
if(isset($_POST["category"])){
	$category_query = "SELECT * FROM categories";
    
	$run_query = mysqli_query($con,$category_query) or die(mysqli_error($con));
	echo "
		
            
            <div class='aside'>
							<h3 class='aside-title'>Categories</h3>
							<div class='btn-group-vertical'>
	";
	if(mysqli_num_rows($run_query) > 0){
        $i=1;
		while($row = mysqli_fetch_array($run_query)){
            
			$cid = $row["cat_id"];
			$cat_name = $row["cat_title"];
            $sql = "SELECT COUNT(*) AS count_items FROM products WHERE product_cat=$i";
            $query = mysqli_query($con,$sql);
            $row = mysqli_fetch_array($query);
            $count=$row["count_items"];
            $i++;
            
            
			echo "
					
                    <div type='button' class='btn navbar-btn category' cid='$cid'>
									
									<a href='#'>
										<span  ></span>
										$cat_name
										<small class='qty'>($count)</small>
									</a>
								</div>
                    
			";
            
		}
        
        
		echo "</div>";
	}
}

if(isset($_POST["page"])){
	$sql = "SELECT * FROM products";
	$run_query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($run_query);
	$pageno = ceil($count/9);
	for($i=1;$i<=$pageno;$i++){
		echo "
			<li><a href='#product-row' page='$i' id='page' class='active'>$i</a></li>
            
            
		";
	}
}
if(isset($_POST["getProduct"])){
	$limit = 9;
	if(isset($_POST["setPage"])){
		$pageno = $_POST["pageNumber"];
		$start = ($pageno * $limit) - $limit;
	}else{
		$start = 0;
	}
	$product_query = "SELECT * FROM products,categories WHERE product_cat=cat_id LIMIT $start,$limit";
	$run_query = mysqli_query($con,$product_query);
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_cat'];
			//$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];
            
            $cat_name = $row["cat_title"];
			echo "
				
                        
                        <div class='col-md-3 col-xs-6' >
								<a href='product.php?p=$pro_id'><div class='product'>
									<div class='product-img'>
										<img src='admin/admin/product_images/$pro_image' style='max-height: 170px;' alt=''>
										<div class='product-label'>
											
											<span class='new'>VIEW</span>
										</div>
									</div></a>
									<div class='product-body'>
										<p class='product-category'>$cat_name</p>
										<h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
										<h4 class='product-price header-cart-item-info'>Kshs $pro_price</h4>
										<div class='product-rating'>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
										</div>
										<div class='product-btns'>
											<button class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
											<button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
											<button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
										</div>
									</div>
									<div class='add-to-cart'>
										<button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
									</div>
								</div>
							</div>
                        
			";
		}
	}
}


if(isset($_POST["get_seleted_Category"]) || isset($_POST["selectBrand"]) || isset($_POST["search"])){
	if(isset($_POST["get_seleted_Category"])){
		$id = $_POST["cat_id"];
		$sql = "SELECT * FROM products,categories WHERE product_cat = '$id' AND product_cat=cat_id";
        
	//}else if(isset($_POST["selectBrand"])){
		//$id = $_POST["brand_id"];
		//$sql = "SELECT * FROM products,categories WHERE product_brand = '$id' AND product_cat=cat_id";
	}else {
        
		$keyword = $_POST["keyword"];
        header('Location:store.php');
		$sql = "SELECT * FROM products,categories WHERE product_cat=cat_id AND product_keywords LIKE '%$keyword%'";
       
	}
	
	$run_query = mysqli_query($con,$sql);
	while($row=mysqli_fetch_array($run_query)){
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_cat'];
			//$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];
            $cat_name = $row["cat_title"];
			echo "
					
                        
                        <div class='col-md-3 col-xs-6'>
								<a href='product.php?p=$pro_id'><div class='product'>
									<div class='product-img'>
										<img  src='admin/admin/product_images/$pro_image'  style='max-height: 170px;' alt=''>
										<div class='product-label'>
											
											<span class='new'>VIEW</span>
										</div>
									</div></a>
									<div class='product-body'>
										<p class='product-category'>$cat_name</p>
										<h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
										<h4 class='product-price header-cart-item-info'>Kshs $pro_price</h4>
										<div class='product-rating'>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
										</div>
										<div class='product-btns'>
											<button class='add-to-wishlist' tabindex='0'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
											<button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
											<button class='quick-view' ><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
										</div>
									</div>
									<div class='add-to-cart'>
										<button pid='$pro_id' id='product' href='#' tabindex='0' class='add-to-cart-btn'><i class='fa fa-shopping-cart'></i> add to cart</button>
									</div>
								</div>
							</div>
			";
		}
	}
	


	if(isset($_POST["addToCart"])){
		

		$p_id = $_POST["proId"];
		

		if(isset($_SESSION["uid"])){

		$user_id = $_SESSION["uid"];

		$sql = "SELECT * FROM cart WHERE p_id = '$p_id' AND user_id = '$user_id'";
		$run_query = mysqli_query($con,$sql);
		$count = mysqli_num_rows($run_query);
		if($count > 0){
			echo "
				<script> exists();</script>
			";

			//INSERTING IN CART
		} else {
			$sql = "INSERT INTO `cart`
			(`p_id`, `ip_add`, `user_id`, `qty`) 
			VALUES ('$p_id','$ip_add','$user_id','1')";
			if(mysqli_query($con,$sql)){
				echo "
					<script> added();</script>
				";
			}
		}
		}else{
			$sql = "SELECT id FROM cart WHERE ip_add = '$ip_add' AND p_id = '$p_id' AND user_id = -1";
			$query = mysqli_query($con,$sql);
			if (mysqli_num_rows($query) > 0) {
				echo "
					<script>exists();</script>";
					exit();
			}
			$sql = "INSERT INTO `cart`
			(`p_id`, `ip_add`, `user_id`, `qty`) 
			VALUES ('$p_id','$ip_add','-1','1')";
			if (mysqli_query($con,$sql)) {
				echo "
					<script> added();</script>
				";
				exit();
			}
			
		}
		
		
		
		
	}

//Count User cart item
if (isset($_POST["count_item"])) {
	//When user is logged in then we will count number of item in cart by using user session id
	if (isset($_SESSION["uid"])) {
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE user_id = $_SESSION[uid]";
	}else{
		//When user is not logged in then we will count number of item in cart by using users unique ip address
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE ip_add = '$ip_add' AND user_id < 0";
	}
	
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query);
	echo $row["count_item"];
	exit();
}
//Count User cart item

//Get Cart Item From Database to Dropdown menu
if (isset($_POST["Common"])) {

	if (isset($_SESSION["uid"])) {
		//When user is logged in this query will execute
		$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$_SESSION[uid]'";
	}else{
		//When user is not logged in this query will execute
		$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty FROM products a,cart b WHERE a.product_id=b.p_id AND b.ip_add='$ip_add' AND b.user_id < 0";
	}
	$query = mysqli_query($con,$sql);
	if (isset($_POST["getCartItem"])) {
		//display cart item in dropdown menu
		if (mysqli_num_rows($query) > 0) {
			$n=0;

			$total_price=0;
			while ($row=mysqli_fetch_array($query)) {
                
				$n++;
				$product_id = $row["product_id"];
				$product_title = $row["product_title"];
				$product_price = $row["product_price"];
				$product_image = $row["product_image"];
				$cart_item_id = $row["id"];
				$qty = $row["qty"];
				$total_price=$total_price+$product_price;
				echo '
					
                    
                    <div class="product-widget">
												<div class="product-img">
													<img src="admin/admin/product_images/'.$product_image.'" alt="">
												</div>
												<div class="product-body">
													<h3 class="product-name"><a href="#">'.$product_title.'</a></h3>
													<h4 class="product-price"><span class="qty">'.$n.'</span>Kshs '.$product_price.'.00</h4>
												</div>
												
											</div>'
                    
                    
                    ;
				
			}
            
            echo '<div class="cart-summary">
				    <small class="qty">'.$n.' Item(s) selected</small>
				    <h5>Kshs '.$total_price.'.00</h5>
				</div>'
            ?>
				
				
			<?php
			
			exit();
		}
	}
	
    
    
    if (isset($_POST["checkOutDetails"])) {
		if (mysqli_num_rows($query) > 0) {
			//display user cart item with "Ready to checkout" button if user is not login
			echo '<div class="main ">
			<div class="table-responsive">
			<form onsubmit="return validateForm()" method="post" action="login_form.php">
			
	               <table id="cart" class="table table-hover table-condensed" id="">
    				<thead>
						<tr>
							<th style="width:50%">Product</th>
							<th style="width:10%">Price</th>
							<th style="width:8%">Quantity</th>
							<th style="width:7%" class="text-center">Subtotal</th>
							<th style="width:5%">Update here(each)</th>
							<th style="width:5%">Delete</th>
						</tr>
					</thead>
					<tbody>
                    ';
				$n=0;
				while ($row=mysqli_fetch_array($query)) {
					$n++;
					$product_id = $row["product_id"];
					$product_title = $row["product_title"];
					$product_price = $row["product_price"];
					$product_image = $row["product_image"];
					$cart_item_id = $row["id"];
					$qty = $row["qty"];

					echo 
						'
                             
						<tr>
							<td data-th="Product" >
								<div class="row">
								
									<div class="col-sm-3 "><img src="admin/admin/product_images/'.$product_image.'" style="height: 70px;width:75px;"/>
									<h4 class="nomargin product-name header-cart-item-name"><a href="product.php?p='.$product_id.'">'.$product_title.'</a></h4>
									</div>
									<div class="col-sm-3">
										<div style="max-width=30px;">
										<p>Ordering</p>
										</div>
									</div>
									
									
								</div>
							</td>
                            <input type="hidden" name="product_id[]" value="'.$product_id.'"/>
				            <input type="hidden" name="" value="'.$cart_item_id.'"/>
							<td data-th="Price">
							      <input type="text" class="form-control price" name="product_price" value="'.$product_price.'" readonly="readonly" ></td>
							<td data-th="Quantity">
								   <input type="text" class="form-control qty" name="qty" value="'.$qty.'" pattern="\d*" title="Please" required  />

							</td>
							   <td data-th="Subtotal" class="text-center">
							          <input type="text" class="form-control total" value="'.$product_price.'" readonly="readonly"></td>
							<td class="actions" data-th="">
							<div class="btn-group">
								<a href="#" class="btn btn-info btn-sm update Update" update_id="'.$product_id.'">Update<i class="fa fa-refresh" style="width: 60px;"></i></a>
							</div>							
							</td>
							<td class="actions" data-th="">
							<div class="btn-group">
								<a href="#" class="btn btn-danger btn-sm remove" remove_id="'.$product_id.'">Delete <i class="fa fa-trash-o"></i></a>		
							</div>							
							</td>
						</tr>
					
                            
                            ';
				}
				
				echo '</tbody>
				<tfoot>
					
					<tr>
						<td><a href="store.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
						<td colspan="2" class="hidden-xs"></td>
						<td class="hidden-xs text-center"><b class="net_total" ></b></td>
						<div id="issessionset"></div>
                        <td>
							
							';

				if (!isset($_SESSION["uid"])) {
					echo '
					
							<a href="" data-toggle="modal" data-target="#Modal_register" class="btn btn-success">Ready to Checkout</a></td>
								</tr>
							</tfoot>
				
							</table></div></div>
							';


                }else if(isset($_SESSION["uid"])){
					//Paypal checkout form
					echo '
					</form>
					
						<form action="checkout.php" method="post">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="business" value="shoppingcart@vic.com">
							<input type="hidden" name="upload" value="1">';
							  
							$x=0;
							$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$_SESSION[uid]'";
							$query = mysqli_query($con,$sql);
							while($row=mysqli_fetch_array($query)){
								$x++;
								echo  	

									'<input type="hidden" name="total_count" value="'.$x.'">
									<input type="hidden" name="item_name_'.$x.'" value="'.$row["product_title"].'">
								  	 <input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
								     <input type="hidden" name="amount_'.$x.'" value="'.($row["product_price"] * $row["qty"]).'">
								    <input type="hidden" name="quantity_'.$x.'" value="'.$row["qty"].'">';
								}
							  
							echo   
								'   <input type="hidden"    name="return" value="http://localhost/promokings/payment_success.php"/>
					                <input type="hidden" name="notify_url" value="http://localhost/promokings/payment_success.php">
									<input type="hidden" name="cancel_return" value="http://localhost/promokings/cancel.php"/>
									<input type="hidden" name="currency_code" value="KSHS"/>
									<input type="hidden" name="custom" value="'.$_SESSION["uid"].'"/>
									<input type="submit" id="submit" name="login_user_with_product" name="submit" class="btn btn-success" value="Ready to Checkout" >
									</form></td>
									
									</tr>
									
									
									</tfoot>
									
							</table>

							<div style"position:center"><label><input type="CHECKBOX" name="q" class="roomselect" value="conform" required > Confirm You Have Updated Each product
					</label></div> </div></div>   
								';



				}
			}
	}
	
	
}





//Remove Item From cart
if (isset($_POST["removeItemFromCart"])) {
	$remove_id = $_POST["rid"];
	if (isset($_SESSION["uid"])) {
		$sql = "DELETE FROM cart WHERE p_id = '$remove_id' AND user_id = '$_SESSION[uid]'";
	}else{
		$sql = "DELETE FROM cart WHERE p_id = '$remove_id' AND ip_add = '$ip_add'";
	}
	if(mysqli_query($con,$sql)){
		echo  "<script> removed();</script>";
		exit();
	}
}


//Update Item IN cart
if (isset($_POST["updateCartItem"])) {
	$update_id = $_POST["update_id"];
	$qty = $_POST["qty"];
	if (isset($_SESSION["uid"])) {
		$sql = "UPDATE cart SET qty='$qty' WHERE p_id = '$update_id' AND user_id = '$_SESSION[uid]'";
	}else{
		$sql = "UPDATE cart SET qty='$qty' WHERE p_id = '$update_id' AND ip_add = '$ip_add'";
	}
	if(mysqli_query($con,$sql)){
		echo " <script> updated();</script>";
		exit();
	}
}





?>






