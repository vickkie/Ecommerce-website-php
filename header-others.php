<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <title>Promokings</title><link rel="shortcut icon" href="img/promokings1.jpg">

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">


    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="css/slick.css"/>
    <link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/ionicons.min.css">



    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="css/style.css"/>
    <link type="text/css" rel="stylesheet" href="css/accountbtn.css"/>
    
    
    
         

    <style>
        #navigation {
          background: #FF4E50; 
            background: -webkit-linear-gradient(to right, #F9D423, #FF4E50);
            background: linear-gradient(to right, ##FF4E50, #FF4E50);

          
        }
        #header {
  
            background: #780206; 
            background: -webkit-linear-gradient(to right, #061161, #780206);
            background: linear-gradient(to right, #000000, #780206); 

  
        }
        #top-header {
              
  
            background: #870000;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #190A05, #870000); 
            background: linear-gradient(to right, #ff4e50 , #870000);


        }
        #footer {
            background: #7474BF;  
            background: -webkit-linear-gradient(to right, #348AC7, #7474BF);  
            background: linear-gradient(to right, ##FF4E50, #FF4E50);


          color: #1E1F29;
        }
        #bottom-footer {
            background: #7474BF;  
            background: -webkit-linear-gradient(to right, #348AC7, #7474BF); 
            background: linear-gradient(to right, ##FF4E50, #FF4E50); 
          

        }
        .footer-links li a {
          color: #1E1F29;
        }
        .mainn-raised {
            
            margin: -7px 0px 0px;
            border-radius: 6px;
            box-shadow: 0 16px 24px 2px rgba(0, 0, 0, 0.14), 0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);

        }
       
        .glyphicon{
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    }
    .glyphicon-chevron-left:before{
        content:"\f053"
    }
    .glyphicon-chevron-right:before{
        content:"\f054"
    }
        

       
        
        </style>

    </head>
  <body>
    <!-- HEADER -->
    <header>
      <!-- TOP HEADER -->
      <div id="top-header">
        <div class="container">
          <font style="font-style:normal; font-size: 22px;color: aliceblue;font-family: serif ; display: inline-block;">
                                       Promokings
                                    </font>
          
          <ul class="header-links pull-right">
            <li><a href="#"><i class="fa fa-cc alt"></i> HELLO </a></li>
            <li><?php
                             include "db.php";
                            if(isset($_SESSION["uid"])){
                                $sql = "SELECT first_name FROM customers WHERE user_id='$_SESSION[uid]'";
                                $query = mysqli_query($con,$sql);
                                $row=mysqli_fetch_array($query);
                                
                                echo '
                               <div class="dropdownn">
                                  <a href="#" class="dropdownn" data-toggle="modal" data-target="#myModal" ><i class="fa fa-user-o" style="color:white"></i> Welcome,     '.$row["first_name"].'</a>
                                 <div class="dropdownn-content">
                                    <a href="my-profile.php" ><i class="fa fa-user-circle" aria-hidden="true" ></i>My Profile</a>
                                     <a href="customer-orders.php"  ><i class="fa fa-shopping-cart" aria-hidden="true"></i>Orders</a>

                                    <a href="logout.php"  ><i class="fa fa-sign-in" aria-hidden="true"></i>Log out</a>
                                    
                                  </div>
                                </div>';

                            }else{ 
                                echo '
                                <div class="dropdownn">
                                  <a href="#" class="dropdownn" data-toggle="modal" data-target="#myModal" ><i class="fa fa-user-o"></i> My Account</a>
                                  <div class="dropdownn-content">
                                    <a href="" data-toggle="modal" data-target="#Modal_login"><i class="fa fa-sign-in" aria-hidden="true" ></i>Login</a>
                                    <a href="" data-toggle="modal" data-target="#Modal_register"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a>
                                     
                                    
                                  </div>
                                </div>';
                                
                            }
                                             ?>
                               
                                </li>       
          </ul>
          
        </div>
      </div>
      <!-- /TOP HEADER -->
      
      

      <!-- MAIN HEADER -->
      <div id="header">

        <!-- container -->
        <div class="container">
          <!-- row -->
          <div class="row">
            <!-- LOGO -->
            <div class="col-md-3">
              <div class="header-logo">
                <a href="#" class="logo">
                
                                    <img src="img/promokings.jpg" alt="Website Header Image">
                  
                </a>
              </div>
            </div>
            <!-- /LOGO -->

             
    <!-- SEARCH BAR -->
            <div class="col-md-6">

              <div class="header-search" align="right">
                <form>
                  <link rel="stylesheet" type="text/css" href="store.php"></link>
                  
                  </select>
                  <link class="input" id="search" type="text" placeholder="Search here"></link>
                  <link href="store.php" id="search_btn" class="search-btn">promokings</link>
                </form>
              </div>
            </div> 
            <!-- /SEARCH BAR -->

            <!-- ACCOUNT -->
            <div class="col-md-3 clearfix">
              <div class="header-ctn">
                

                <!-- Cart -->
                <div class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" align="right">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Your Cart</span>
                    <div class="badge qty">0</div>
                  </a>
                  <div class="cart-dropdown"  >
                    <div class="cart-list" id="cart_product">
                    
                      
                    </div>
                    
                    <div class="cart-btns">
                        <a href="cart.php" style="width:100%;"><i class="fa fa-edit"></i> Edit cart</a>
                      
                    </div>
                  </div>
                    
                  </div>
                <!-- /Cart -->

                <!-- Cart -->
                <div class="dropdown">
                  <a href="customer-orders.php"  ><i class="fa fa-truck" aria-hidden="true"></i>Orders
                  </a>
                  
                    
                  </div>
                <!-- /Cart -->

                <!-- Menu Toogle -->
                <div class="menu-toggle">
                  <a href="#">
                    <i class="fa fa-bars"></i>
                    <span>Menu</span>
                  </a>
                </div>
                <!-- /Menu Toogle -->
              </div>
            </div>
            <!-- /ACCOUNT -->
          </div>
          <!-- row -->
        </div>
        <!-- container -->
      </div>
      <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->

    <!--NAVIGATION main-->


<style>
  .diagonal-nav {
    display: flex;
    flex-direction: row;
    justify-content: center; /* Add this line to center the navigation horizontally */
    align-items: center; /
 
  }
  
  .diagonal-nav li {


  }
  
  .diagonal-nav li a {
    display: block;
    padding: 20px;
    color: white;
    font-size: 14px;
    transition: background-color 0.3s ease;

  }

  .diagonal-nav li a:hover{
    background-color: brown;
  }

/* Add a CSS class to make the navigation bar stick to the top */
  .sticky {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #333;
    z-index: 999; /* Ensure that the navigation bar is on top of other elements */
  }
  
  /* Add a transition effect when the navigation bar becomes sticky */
  .sticky .diagonal-nav li a {
    transition: background-color 0.3s ease, color 0.3s ease;
  }
  
  /* Change the background color and text color when the item is hovered over and the navigation bar is sticky */
  .sticky .diagonal-nav li a:hover {
    background-color: #666;
    color: #fff;
  }
</style>

<script>
  window.addEventListener('scroll', function() {
    var nav = document.getElementById('navigation');
    if (window.pageYOffset > nav.offsetTop) {
      nav.classList.add('sticky');
    } else {
      nav.classList.remove('sticky');
    }
  });
</script>
            

    <!-- NAVIGATION -->
    
    <div class="modal fade" id="Modal_login" role="dialog">
                        <div class="modal-dialog">
                          
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              
                            </div>
                            <div class="modal-body">
                            <?php
                                include "login_form.php";
    
                            ?>
          
                            </div>
                            
                          </div>
                          
                        </div>
                      </div>





                <div class="modal fade" id="Modal_register" role="dialog">
                        <div class="modal-dialog" style="">

                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              
                            </div>
                            <div class="modal-body">
                            <?php
                                include "register_form.php";
    
                            ?>
          
                            </div>
                            
                          </div>

                        </div>
                      </div>
    