<?php
session_start(); 
include('includes/config.php');
?>

<div class="brand clearfix">

<h4 class="pull-left text-white" style="padding-left: 20px;margin:20px 0px 0px 20px"><i class="fa fa-shopping-cart"></i>&nbsp<?php echo COMPANY_NAME;?></h4>

		<span class="menu-btn"><i class="fa fa-bars"></i></span>

		<ul class="ts-profile-nav">

			
<?php
if (isset($_SESSION['alogin'])) {
  $username = $_SESSION['alogin'];
  $profile_picture = $_SESSION['profilepicture'] ;

		echo'	<li class="ts-account">

				<a href="#"><img src="img/members/' . $profile_picture . '" class="ts-avatar hidden-side" alt=""> ';


  //$profilepicture = $_SESSION['profile_picture'];
  // Use the $username variable as needed
  echo "" . $username;
} 
?>




					<i class="fa fa-angle-down hidden-side"></i></a>

				<ul>

					<li><a href="change-password.php"><i class="fa fa-lock"></i> Change Password</a></li>

					<li  ><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>

				</ul>

			</li>

		</ul>
		 
	</div>
?>
