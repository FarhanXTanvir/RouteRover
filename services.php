<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Services | RouteRover </title>

  <!-- Style Sheet -->
  <link rel="stylesheet" href="css/services.css">
  <?php include 'src/inc.php'; ?>

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
  <link rel="manifest" href="favicon_io/site.webmanifest">
</head>

<body>
  <?php include 'src/inc/header.php'; ?>
  <section class="services">
    <h2>Our Services</h2>
    <div class="row">
      <div class="column">
        <a href="index#route-finder">
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
        <a class="reserveBus">
          <div class="card">
            <div class="icon-wrapper">
              <i class="fas fa-wrench"></i>
            </div>
            <h3>Reserve Bus</h3>
            <p>
              Reserve local bus for group trips.
            </p>
          </div>
        </a>
      </div>
    </div>
  </section>
  <!-- ----------------- Footer Section --------------- -->
  <?php include 'src/inc/footer.php'; ?>
  <script>
    document.querySelector('.reserveBus').addEventListener('click', () => {
      const row = document.querySelector('.row');
      const div = `
      <div class="error" style="padding: 1rem;">
        <h2 style="color: red;">Service Unavailable</h2>
        <span class="close"> x </span>
        <p>
          This service is currently unavailable. Please try again later.
        </p> 
      </div>`;
      // add div in the row before end
      row.insertAdjacentHTML('afterend', div);
    });
  </script>
</body>

</html>