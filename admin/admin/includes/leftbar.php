        
<?php
session_start(); 
include('includes/config.php');
if (isset($_SESSION['alogin'])) {

    if (isset($_SESSION['position'])) {
        $position = $_SESSION['position'];
}
if ($position == "admin" || $position == "superadmin")
{



    echo'
<nav class="ts-sidebar">
<ul class="ts-sidebar-menu">
    <li class="ts-label">Promokings |'.$position.' </li>
    <li>
        <a href="dashboard-new.php">
            <i class="fa fa-dashboard"></i> Dashboard
        </a>
    </li>

<li class="active">
        <a href="#">
            <i class="fa fa-shopping-cart"></i> Orders
        </a>
        <ul>
            <li>
        <a href="manage-orders.php">
            <i class="fa fa-cart-arrow-down"></i> Orders
        </a>
    </li>

            <li>
                <a href="manage-invoices.php"><i class="fa fa-cogs"></i>Manage invoices</a>
            </li>
             <li>
                <a href="order-assign.php"><i class="fa fa-cogs"></i>Assigned</a>
            </li>
            <li>
                <a href="assign-driver.php"><i class="fa fa-cogs"></i>Assign Orders</a>
            </li>
        </ul>
    </li>

    
    
    <li class="active">
        <a href="#">
            <i class="fa fa-dedent"></i> Products
        </a>
        <ul>
            <li>
                <a href="add-items.php">Add Items</a>
            </li>
            <li>
                <a href="manage-items.php">Manage Items</a>
            </li>
        </ul>
    </li>
    <li class="active">
        <a href="#">
            <i class="fa fa-th-list"></i> Categories
        </a>
        <ul>
            <li>
                <a href="add-category.php">Add Category</a>
            </li>
            <li>
                <a href="manage-category.php">Manage Category</a>
            </li>
        </ul>
    </li>
    <li class="active">
        <a href="#">
            <i class="fa fa-user"></i> Customers
        </a>
        <ul>
            
            <li>
                <a href="manage-customer.php">Manage Customers</a>
            </li>
        </ul>
    </li>
    <li class="active">
        <a href="#">
            <i class="fa fa-car"></i> Drivers
        </a>
        <ul>
            <li>
                <a href="new-driver.php">New Registered</a>
            </li>
            <li>
                <a href="manage-driver.php">Approved Drivers</a>
            </li>
            <li>
                <a href="add-driver.php">Add Drivers</a>
            </li>
        </ul>
    </li>
    <li class="active">
        <a href="#">
            <i class="fa fa-cart-plus"></i> Suppliers
        </a>
        <ul>
            <li>
                <a href="new-supplier.php">New Registered</a>
            </li>
             <li>
                <a href="manage-supplier.php">Approved Suppliers</a>
            </li>
            <li>
                <a href="add-supplier.php">Add Suppliers</a>
            </li>
           
        </ul>
    </li>
    <li>
        <a href="#">
            <i class="fa fa-user-secret"></i> System users
        </a>
        <ul>
            <li class="active">
                <a href="new-user.php">New Registered</a>
            </li>
            
            <li class="active">
                <a href="manage-user.php">Approved Users</a>
            </li>
            <li class="active">
                <a href="add-user.php">Add Users</a>
            </li>
        </ul>
    </li>

     <li class="active">
        <a href="#">
            <i class="fa fa-area-chart"></i> Sales
         </a>
    <ul>
        <li>
        <a href="sales-report.php">

        <i class="fa fa-bar-chart"></i> Sales reports
        </a>
        </li>
      <li>
        <a href="sales-graphs.php">
            <i class="  fa fa-line-chart"></i> Sales Graphs
        </a>
        </li>
    </ul>

    </li>

    <li>
        <a href="#">
            <i class="fa fa-plus-circle"></i> New Staff
        </a>
        <ul>
            <li class="active">
                <a href="request-user.php"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                Register Request</a>
            </li>
            
            <li class="active">
                <a href="request-approved.php"><i class="fa fa-user" aria-hidden="true">
                </i>Approved Staff</a>
            </li>
        </ul>
     </li>
        <li class="active">
        <a href="messaging.php">
            <i class="fa fa-inbox"></i> Messaging
        </a>
    </li>

    <li class="active">
        <a href="to-do.php">
            <i class="fa fa-envelope"></i> Tasks
        </a>
    </li>
    <li class="active">
        <a href="notification.php">
            <i class="fa fa-bell"></i> Notification
        </a>
    </li>
    <li class="active">
        <a href="log-out.php">
            <i class="fa fa-sign-out"></i> Log out
        </a>
    </li>
   

  <p class="text-center" style="color:#ffffff; margin-top: 100px;">© Promokings
  </p>
</nav>
';

}

if ($position == "inventory manager") 
{

    echo'
<nav class="ts-sidebar">
<ul class="ts-sidebar-menu">
    <li class="ts-label">Promokings </li>
    <li>
        <a href="dashboard-inventory.php">
            <i class="fa fa-dashboard"></i> Dashboard
        </a>
    </li>

    
    
    <li class="active">
        <a href="#">
            <i class="fa fa-dedent"></i> Products
        </a>
        <ul>
            <li>
                <a href="add-items.php">Add Items</a>
            </li>
            <li>
                <a href="manage-items.php">Manage Items</a>
            </li>
        </ul>
    </li>
    <li class="active">
        <a href="#">
            <i class="fa fa-th-list"></i> Categories
        </a>
        <ul>
            <li>
                <a href="add-category.php">Add Category</a>
            </li>
            <li>
                <a href="manage-category.php">Manage Category</a>
            </li>
        </ul>
    </li>
    
    
    <li class="active">
        <a href="#">
            <i class="fa fa-cart-plus"></i> Suppliers
        </a>
        <ul>
            <li>
                <a href="new-supplier.php">New Registered</a>
            </li>
             <li>
                <a href="manage-supplier.php">Approved Suppliers</a>
            </li>
            <li>
                <a href="add-supplier.php">Add Suppliers</a>
            </li>
           
        </ul>
    </li>
    

    <li class="active">
        <a href="notification-others.php">
            <i class="fa fa-bell"></i> Notification
        </a>
    </li>
    <li class="active">
        <a href="messaging.php">
            <i class="fa fa-inbox"></i> Messages
        </a>
    </li>
    <li class="active">
        <a href="log-out.php">
            <i class="fa fa-sign-out"></i> Log out
        </a>
    </li>
   

  <p class="text-center" style="color:#ffffff; margin-top: 100px;">© Promokings
  </p>
</nav>
';
}

if ($position == "driver") 
{

    echo'
<nav class="ts-sidebar">
<ul class="ts-sidebar-menu">
    <li class="ts-label">Promokings </li>
    <li>
        <a href="dashboard-others.php">
            <i class="fa fa-dashboard"></i> Dashboard
        </a>
    </li>

    
    
    
   
    
    <li class="active">
        <a href="assigned-orders.php">
            <i class="fa fa-truck"></i> Orders
        </a>
    </li>
    

    <li class="active">
        <a href="notification-others.php">
            <i class="fa fa-bell"></i> Notification
        </a>
    </li>
   <li class="active">
        <a href="Messaging.php">
            <i class="fa fa-inbox"></i> Messages
        </a>
    </li>
        <li class="active">
        <a href="log-out.php">
            <i class="fa fa-sign-out"></i> Log out
        </a>
    </li>
   

  <p class="text-center" style="color:#ffffff; margin-top: 100px;">© Promokings
  </p>
</nav>
';


}
if ($position == "finance manager") 
{

    echo'
<nav class="ts-sidebar">
<ul class="ts-sidebar-menu">
    <li class="ts-label">Promokings </li>
    <li>
        <a href="dashboard-finance.php">
            <i class="fa fa-dashboard"></i> Dashboard
        </a>
    </li>

    
    
    
   
    
    <li class="active">
        <a href="#">
            <i class="fa fa-area-chart"></i> Sales
         </a>
    <ul>
        <li>
        <a href="sales-report.php">

        <i class="fa fa-bar-chart"></i> Sales reports
        </a>
        </li>
      <li>
        <a href="sales-graphs.php">
            <i class="  fa fa-line-chart"></i> Sales Graphs
        </a>
        </li>
    </ul>

    </li>
    <li class="active">
        <a href="notification.php">
            <i class="fa fa-bell"></i> Notification
        </a>
    </li>
    <li class="active">
        <a href="messaging.php">
            <i class="fa fa-inbox"></i> Messages
        </a>
    </li>
    <li class="active">
        <a href="log-out.php">
            <i class="fa fa-sign-out"></i> Log out
        </a>
    </li>
   

  <p class="text-center" style="color:#ffffff; margin-top: 100px;">© Promokings
  </p>
</nav>
';


}
if ($position == "Approved") 
{

    echo'
<nav class="ts-sidebar">
<ul class="ts-sidebar-menu">
    <li class="ts-label">Promokings </li>
    <li>
        <a href="dashboard-finance.php">
            <i class="fa fa-dashboard"></i> Dashboard
        </a>
    </li>

    <li class="active">
        <a href="notification.php">
            <i class="fa fa-bell"></i> Notification
        </a>
    </li>
    <li class="active">
        <a href="log-out.php">
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
