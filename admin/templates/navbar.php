<?php
session_start(); ?>

<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.php">Ecommerce Site</a>

  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <?php if (
          isset($_SESSION["admin_logged_in"]) &&
          $_SESSION["admin_logged_in"] === true
      ) { ?>
          <a class="nav-link" href="../admin/logout.php">Sign out</a>
          <?php } else {$uriAr = explode("/", $_SERVER["REQUEST_URI"]);
          $page = end($uriAr);

          if ($page !== "login.php") { ?>
              <a class="nav-link" href="../admin/login.php">Login</a>
              <?php }} ?>
    </li>
  </ul>
</nav>
