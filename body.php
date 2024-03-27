 <div class="welcome">
 	<!DOCTYPE html>
 	<html>
 	<head>
 		<link rel="stylesheet" type="text/css" href="css/themehome.css">

 		<meta charset="utf-8">
 		<meta name="viewport" content="width=device-width, initial-scale=1">
 		<title>Promokings</title>
 	</head>
	<body>
		   <style>
/* Center the text */
  #about-text {
    margin: 0 auto;
    width: 50%;
    max-width: 990px;
    font-weight:500; 
       background-repeat: no-repeat;
      background-size: cover;
      padding: 10px;


  }
  
    #about-background {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('img/promokings11.jpg');
      background-repeat: no-repeat;
      background-size: cover;
     opacity: 0.05;
      z-index: -1;
    }
    
  /* Move the image to the right */
  #about-image {
    float: right;
    margin-left: 20px;
  }
</style>
 <div id="about-container">
    <div id="about-background"></div>
  <div id="about-text">
		<h1>Welcome to Promokings</h1>
    <p>Discover a world of exciting deals, exclusive offers, and unbeatable discounts.</p>
    <p>We're here to make your shopping  and branding experience extraordinary.</p>
    <p>Whether you're searching for the perfect gift,company essentials,or branding, Promokings is your ultimate destination.</p>
 <p style="font-weight: 700;">Get ready to reign supreme with Promokings!</p>
 	 </div>
  
  
   </div>
 	</body>
 	</html>


 </div>

   <div class="main">
        <div class="container" style="width:100%; margin-left: 0px;">
   <!--movement..-->
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
   
    <div class="carousel-inner">

    	   <div class="item">
        <img src="img/hotdeal22.jpg" style="width:100%;">
        
      </div>
        <div class="item">
        <img src="img/hotdeal4.jpg" alt="New York" style="width:100%;">
        
      </div>

      <div class="item active">
        <img src="img/hotdeal12.jpg" alt="Los Angeles" style="width:100%;">
        
      </div>

    	

     
    
   
      <div class="item">
        <img src="img/hotdeal3.jpg" alt="New York" style="width:100%;">
        
      </div>
     
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control _26sdfg" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only" >Previous</span>
    </a>
    <a class="right carousel-control _26sdfg" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
     


		<!-- SECTION -->
		<div class="section mainn mainn-raised">
		
		
			<!-- container -->
			<div class="container">
			
				<!-- row -->
				<div class="row">
					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<a href="product.php?p=78"><div class="shop">
							<div class="shop-img">
								<img src="./img/shop01.jpg" alt="">
							</div>
							<div class="shop-body">
								<h3>Clothes<br>Collection</h3>
								<a href="product.php?p=5" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div></a>
					</div>
					<!-- /shop -->

					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<a href="product.php?p=1"><div class="shop">
							<div class="shop-img">
								<img src="./img/shop03.jpg" alt="">
							</div>
							<div class="shop-body">
								<h3>Accessories<br>Collection</h3>
								<a href="product.php?p=0" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div></a>
					</div>
					<!-- /shop -->

					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<a href="product.php?p=1"><div class="shop">
							<div class="shop-img">
								<img src="./img/shop02.png" alt="Stationery">
							</div>
							<div class="shop-body">
								<h3>Stationery<br>Collection</h3>
								<a href="product.php?p=0" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
                            </div></a>
					</div>
					<!-- /shop -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
		  
		

		

		<!-- HOT DEAL SECTION -->
		<div id="hot-deal" class="section mainn mainn-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="hot-deal">
							<ul class="hot-deal-countdown">
								<li>
									<div>
										<h3>03</h3>
										<span>Days</span>
									</div>
								</li>
							
							</ul>
							<h2 class="text-uppercase">hot deals this week</h2>
							<p>Products Up to 10% OFF</p>
							<a class="primary-btn cta-btn" href="store.php">Shop now</a>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /HOT DEAL SECTION -->
		

		<!-- SECTION -->
		<div class="section" style="background-color:whitesmoke;">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<?php
                    include 'db.php';
								
                    
					$sql = "SELECT * FROM categories ";
           $result = mysqli_query($con,$sql);
           

                     ?>

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">New products</h3>
							<div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<?php /*while ($row = mysqli_fetch_assoc($result)) { ?>
					<li class="active"><a data-toggle="tab" href="#tab2"><?php echo $row["cat_title"]; ?></a></li>
				<?php } */?>
									
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12 mainn mainn-raised" style="background-color:whitesmoke;">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab2" class="tab-pane fade in active">
									<div class="products-slick" data-nav="#slick-nav-2">
										<!-- product -->
										<?php
                    include 'db.php';
								
                    
				$product_query = "SELECT * FROM products INNER JOIN categories ON products.product_cat = categories.cat_id ORDER BY products.product_id DESC";

                $run_query = mysqli_query($con,$product_query);
                if(mysqli_num_rows($run_query) > 0){

                    while($row = mysqli_fetch_array($run_query)){
                        $pro_id    = $row['product_id'];
                        $pro_cat   = $row['product_cat'];
                       
                        $pro_title = $row['product_title'];
                        $pro_price = $row['product_price'];
                        $pro_image = $row['product_image'];

                        $cat_name = $row["cat_title"];

                        echo "
				
                        
                                
								<div class='product'>
									<a href='product.php?p=$pro_id'><div class='product-img'>
										<img src='admin/admin/product_images/$pro_image' style='max-height: 170px;' alt=''>
										<div class='product-label'>
											
											<span class='new'>VIEW</span>
										</div>
									</div></a>
									<div class='product-body'>
										<p class='product-category'>$cat_name</p>
										<h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
										<h4 class='product-price header-cart-item-info'>kshs $pro_price</h4>
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
                               
							";
		}
        ;
      
}
?>	
                        

										
										<!-- /product -->
									</div>
									<div id="slick-nav-2" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- /Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->



</div>



				