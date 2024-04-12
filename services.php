<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Services | RouteRover </title>

  <!-- Style Sheet -->
  <link rel="stylesheet" href="css/services.css">
  <?php include 'src/lib/lib.html'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Font Family -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Favicon -->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>

<body>
  <?php include 'src/inc/header.php'; ?>
  <section class="services">
    <h2>Our Services</h2>
    <div class="row">
      <div class="column">
        <a href="index.php#route-finder">
          <div class="card">
            <div class="icon-wrapper">
              <i class="fas fa-search-plus"></i>
            </div>
            <h3>Route Finder</h3>
            <p>
              Search for the nearest route to your destination.
            </p>
          </div>
        </a>
      </div>
      <div class="column">
        <a href="eticket.php">
          <div class="card">
            <div class="icon-wrapper">
              <i class="fas fa-ticket"></i>
            </div>
            <h3>e-ticketing</h3>
            <p>
              Find your ticket and enjoy your journey.
            </p>
          </div>
        </a>
      </div>
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fas fa-wrench"></i>
          </div>
          <h3>Reserve Bus</h3>
          <p>
            Reserve local bus for group trips.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- ----------------- Footer Section --------------- -->
  <?php include 'src/inc/footer.php'; ?>
</body>

</html>