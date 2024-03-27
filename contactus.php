<?php
include "headermain.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>About Us</title>
  <style>
/* Center the text */
  #about-text {
    margin: 0 auto;
    width: 17%;
    max-width: 990px;
    font-weight: bold; 
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
      background-image: url('img/contactus.jpg');
      background-repeat: no-repeat;
      background-size: cover;
     opacity: 0.9;
      z-index: -1;
    }
    
  /* Move the image to the right */
  #about-image {
    float: right;
    margin-left: 20px;
  }
</style>

</head>
<body>
<div id="about-background"></div>
<div id="about-text"><br><br><br><br><br><br><br>
    <h2 style="color:WHITE;">CONTACT US</h2><br><br><br><br><br><br>

  </div>
  
  
   </div>
</body>

</html>

<?php
include "contactusfooter.php";
include "contactwhatsapp.php";
include "footer.php";
?>
