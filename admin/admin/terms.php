


<!DOCTYPE html>
<html>
<head>
  <title>403 Forbidden</title>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-social.css">
  <link rel="stylesheet" href="css/bootstrap-select.css">
  <link rel="stylesheet" href="css/fileinput.min.css">
  <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/adminlte.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.3/css/ionicons.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style type="text/css">
    @import url("https://fonts.googleapis.com/css?family=Raleway:400,400i,700");
    * {
      font-family: Raleway, sans-serif;
    }

    html,
    body,
    .content {
      flex-basis: 100%;
    }

    .text-center {
      text-align: center;
    }

    .color-white-shadow {
      color: #fff;
      text-shadow: 0 -1px #0f0f0f;
    }

    .content ol {
      /* Styles for the ordered list */
    }

    .content ol li {
      /* Styles for the list items */
      font-size: 16px;
      margin-bottom: 15px;
      /* Add more styles as needed */
    }
     .blurred-image {
        height: 100vh;
        width: 100%;
        object-fit: cover;
        filter: blur(5px); /* Adjust the blur value as needed */
    }
  </style>
</head>

<body>
  <div class="login-pages">
    <div class="containers">
      <div class="row">
                <div class="col-md-3">
          <div class="contents" >
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              </ol>
              <!-- Slides -->
              <div class="carousel-inner">
                <div class="item active">
                  <img src="img/indexs/index6.jpg" class="blurred-image">
                  <img src="img/indexs/index6.jpg" class="blurred-image">
                  <img src="img/indexs/index6.jpg" class="blurred-image">
                  <div class="text-overlay">
                    <center>
                      <h1 style="color: #fb0417;text-weight:bold">Terms</h1><br>
                      <p style="color:black;">Terms of service</p>
                    </center>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="content" style="margin-top: 10px;">
<?php
error_reporting(0);
 include "includes/config.php";
?>
            <center><h1 style="color:blue"><?php echo COMPANY_NAME;?>
            </h1></center>
            <div class="x_content">
  <ul class="nav nav-tabs bar_tabs " id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="profile-tab" href="terms.php">Terms</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" href="register-request.php">Register</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" href="index.php">Login</a>
    </li>
  </ul>
</div>
<br>
            <p style="color:blue;">Read terms and conditions.</p>
            <p>Terms of Service</p>


<p>Welcome to <?php echo COMPANY_NAME;?> <br>These Terms of Service ("Terms") govern your use of our services, website, and any related products or applications (collectively referred to as the "Service"). By accessing or using our Service, you agree to be bound by these Terms. Please read them carefully before proceeding. If you do not agree with any part of these Terms, you may not access or use our Service.</p>
<br>
<ol>
  <li>
<h5 style="color:blue;">1. Acceptance of Terms</h5>
By accessing or using the Service, you represent and warrant that you are at least 18 years old and have the legal authority to enter into these Terms. If you are accessing or using the Service on behalf of a company or organization, you represent and warrant that you have the authority to bind such entity to these Terms.
 </li><br>
 <li>
<h5 style="color:blue;">2. Use of the Service</h5>
<p>a. You agree to use the Service for lawful purposes and in accordance with these Terms.</p>
<p>b. You are solely responsible for any content you submit, upload, or transmit through the Service.</p>
<p>c. You must not use the Service in any way that could damage, disable, overburden, or impair our servers or networks, or interfere with any other party's use and enjoyment of the Service.</p>
<p>d. You must not attempt to gain unauthorized access to the Service, user accounts, or any other systems or networks connected to the Service.</p>
<p>e. We reserve the right to suspend or terminate your access to the Service at any time, with or without cause, and without prior notice.</p>
<li>
<h5 style="color:blue;">3. Intellectual Property</h5>
<p>a. All intellectual property rights in the Service, including but not limited to trademarks, logos, copyrights, and trade secrets, are owned by &nbsp<?php echo strtolower(COMPANY_NAME); ?> or its licensors.</p>
<p>b. You may not copy, modify, distribute, sell, or lease any part of our Service or use it for any commercial purpose without our prior written consent.</p>
</li>
<li>
<h5 style="color:blue;">4. Privacy</h5>
<p>a. We respect your privacy and handle your personal information in accordance with our Privacy Policy.</p>
<p>b. By using the Service, you consent to the collection, use, and disclosure of your personal information as described in our Privacy Policy.</p>
</li>
<li>
<h5 style="color:blue;">5. Disclaimer of Warranties</h5>
<p>a. The Service is provided on an "as is" and "as available" basis. We make no warranties or representations of any kind, whether express or implied, including but not limited to the accuracy, reliability, or availability of the Service.</p>
<p>b. We do not warrant that the Service will be uninterrupted, error-free, or free from viruses or other harmful components.</p>
</li>
<li>
<h5 style="color:blue;">6. Limitation of Liability</h5>
<p>a. To the fullest extent permitted by applicable law, &nbsp<?php echo strtolower(COMPANY_NAME); ?> and its affiliates, officers, directors, employees, agents, and licensors shall not be liable for any direct, indirect, incidental, special, consequential, or exemplary damages, including but not limited to damages for loss of profits, goodwill, use, data, or other intangible losses, resulting from your use of or inability to use the Service.</p>
</li>
<li>
<h5 style="color:blue;">7. Modifications to the Terms</h5>
We reserve the right to modify these Terms at any time. Any changes will be effective upon posting the revised Terms on our website. Your continued use of the Service after the posting of any changes constitutes your acceptance of the modified Terms.
</li>
</ol>
<p>If you have any questions or concerns regarding these Terms, please contact us at &nbsp<SPAN style="color: red"><?php echo EMAIL_FROM;?>.</SPAN></p><br>
<center><h3><?php echo COMPANY_SLOGAN ; ?></h3></center>
            
             <p>
              <a href="index.php">Back to login</a><br>
              <a href="register-request.php">Back to register</a>
            </p>
          </div>
            <span class="copyright">
            
  <center>Copyright &copy;<script>document.write(new Date().getFullYear());</script> <?php echo DESIGNER; ?>. All rights reserved</center>
              
  </span>
        </div>

      </div>

    </div>

  </div>

 
</body> 

</html>
