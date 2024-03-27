<footer id="footer">
			<!-- top footer -->
			<div class="section" style="background-color:rgb(255, 78, 90);">
				<!-- container -->
				<div class="container" style="background-color:rgb(255, 78, 90);">
					<!-- row -->
					<div class="row">
						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Contact us</h3>
								
								<ul class="footer-links">
									<li><a style="color: white; font-size:12px"><i class="fa fa-map-marker"></i>Nairobi ,Kenya</a></li>
									<li><a style="color: white; font-size:12px"><i class="fa fa-phone"></i>0758015158</a></li>
									<li><a style="color: white; font-size:12px"s><i class="fa fa-envelope-o"></i>promokings@gmail.com</a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-6 text-center" style="margin-top:20px;">
                  <h3 class="footer-title" style="color: white; font-size:18px" >Accepted payments Methods</h3>
								

							<ul class="footer-payments" style="margin-top:80px;">
								<li><a href="#"><i class="fa fa-mobile-alt" style="font-size:24px">M-pesa</i></a></li>
								<li><a href="#"><i class="fa fa-credit-card" style="font-size:24px"></i></a></li>
								<li><a href="#"><i class="fa fa-mobile-alt" style="font-size:24px"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-paypal" style="font-size:24px"></i></a></li>
								<li><a href="#"><i class="fa fa-mobile-alt"style="font-size:24px" >Cash</br></i></a></li>
								<li><a href="#"><i class="fa fa-cc-visa" style="font-size:24px"></i></a></li>
							
							</ul>
							<span class="copyright">
						
								Copyright &copy;<script>document.write(new Date().getFullYear());</script>  Promokings. All rights reserved
							
							</span>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Continue shopping</h3>
								<ul class="footer-links">
									<li><b><a href="#">Back to top </a></b></li>
						
								</ul>
							</div>
						</div>

						<div class="clearfix visible-xs"></div>

						
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /top footer -->
                

			<!-- bottom footer -->
			
			<!-- /bottom footer -->
		</footer>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/actions.js"></script>
		<script src="js/sweetalert.min"></script>
		<script src="js/jquery.payform.min.js" charset="utf-8"></script>
    <script src="js/script.js"></script>
		<script>var c = 0;
        function menu(){
          if(c % 2 == 0) {
            document.querySelector('.cont_drobpdown_menu').className = "cont_drobpdown_menu active";    
            document.querySelector('.cont_icon_trg').className = "cont_icon_trg active";    
            c++; 
              }else{
            document.querySelector('.cont_drobpdown_menu').className = "cont_drobpdown_menu disable";        
            document.querySelector('.cont_icon_trg').className = "cont_icon_trg disable";        
            c++;
              }
        }
           
		
</script>
    <script type="text/javascript">
		$('.block2-btn-addcart').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});

		$('.block2-btn-addwishlist').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");
			});
		});
	</script>
	
