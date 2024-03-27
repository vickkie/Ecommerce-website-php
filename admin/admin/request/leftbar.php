        
<?php
session_start(); 
include('includes/config.php');
if (isset($_SESSION['alogin'])) {

    if (isset($_SESSION['username'])) {
        $position = $_SESSION['position'];
}
if ($position == "Approve") 
{

    echo'
<nav class="ts-sidebar">
<ul class="ts-sidebar-menu">
    <li class="ts-label">Promokings </li>
    <li>
        <a href="dashboard-newbie.php">
            <i class="fa fa-dashboard"></i> Dashboard
        </a>
    </li>

    <li class="active">
        <a href="newbie-register.php">
            <i class="fa fa-user-plus"></i> Registration
        </a>
    </li>
    <li class="active">
        <a href="logout.php">
            <i class="fa fa-sign-out"></i> Log out
        </a>
    </li>
   

  <p class="text-center" style="color:#ffffff; margin-top: 100px;">© Promokings
  </p>
</nav>
';


}

}
?>
