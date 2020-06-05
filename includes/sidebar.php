 
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Outlet Management</div>
      </a>


      <!-- Divider -->
      <hr class="sidebar-divider">

      

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="sales.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Sales</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="purchase.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Purchase</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="chat.php">
          <i class="fas fa-comments"></i>
          <span>Chat</span></a>
      </li>
<?php
include_once 'header.php';
if ($_SESSION["User_type"] == "Admin") {
?>
      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="branch.php">
          <i class="fas fa-fw fa-map-marker"></i>
          <span>Branch</span></a>
      </li>

      <?php
}
      ?>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->