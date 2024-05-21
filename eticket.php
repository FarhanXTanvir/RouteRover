<?php
// require_once './validators/config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> eticket | RouteRover </title>

  <!-- Style Sheet -->
  <link rel="stylesheet" href="css/eticket.css">
  <?php include 'src/inc.php'; ?>

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
  <link rel="manifest" href="favicon_io/site.webmanifest">
</head>

<body>
  <?php include 'src/inc/header.php'; ?>
  <section id="#eticket" class="et">
    <h2><span class="spane">e</span><span class="spanT">Ticket</span></h2>
    <div class="row">
      <form action="search.php" method="post">
        <div class="from">
          <input type="search" name="fromplace" id="fromplace" placeholder="From">
          <input type="time" name="fromtime" id="fromtime">
          <input type="date" name="fromdate" id="fromdate">
        </div>
        <div class="to">
          <input type="search" name="toplace" id="toplace" placeholder="To">
          <input type="time" name="totime" id="totime">
          <input type="date" name="todate" id="todate">
        </div>
        <button> Search </button>
      </form>
    </div>
    <div class="row">
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fas fa-bus"></i>
          </div>
          <h3>Bus</h3>
          <p>
            Description
          </p>
        </div>
      </div>
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fas fa-train"></i>
          </div>
          <h3>Train</h3>
          <p>
            Description
          </p>
        </div>
      </div>
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-motorcycle"></i>
          </div>
          <h3>Bike</h3>
          <p>
            Description
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- ----------------- Footer Section --------------- -->
  <?php include 'src/inc/footer.php'; ?>
</body>

</html>