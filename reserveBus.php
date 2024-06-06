<?php
// require_once './validators/config.php';
session_start();
$uniqueValues = json_decode(file_get_contents('script/uniqueLocations.json'), true);
$options = "";
foreach ($uniqueValues as $location) {
  $options .= <<<FT
  <li>$location</li>
FT;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Reserve Bus | RouteRover </title>

  <!-- Style Sheet -->
  <link rel="stylesheet" href="./css/services.css">
  <?php include 'src/inc.php'; ?>

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
  <link rel="manifest" href="favicon_io/site.webmanifest">
  <!-- Include the flatpickr CSS and JavaScript files -->
  <script src="./assets/jquery.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body>
  <?php include 'src/inc/header.php'; ?>
  <section id="#reserveBus" class="service">
    <h2>Bus Reservation</h2>
    <form method="post" id="showTickets">
      <div class="binder">
        <fieldset class="input">
          <legend>যাত্রাস্থান</legend>
          <input class="input-field" name="departure" list="departure" aria-label="departure" placeholder="ষোলশহর" autocomplete="off">
          <ul id="departure">
            <!-- options -->
            <?php echo $options ?>
          </ul>
        </fieldset>
        <fieldset class="input">
          <legend>গন্তব্যস্থল</legend>
          <input class="input-field" name="destination" list="destination" aria-label="destination" placeholder="বহদ্দারহাট" autocomplete="off">
          <ul id="destination">
            <!-- options -->
            <?php echo $options ?>
          </ul>
        </fieldset>
      </div>
      <div class="binder">
        <fieldset class="input">
          <legend>সময়</legend>
          <input class="input-field" type="text" name="time" id="time" pattern="(1[012]|[1-9]):[0-5][0-9](\s)?(?i)(am|pm)" placeholder="11:30 AM">
        </fieldset>
        <fieldset class="input">
          <legend>তারিখ</legend>
          <input class="input-field" type="text" name="date" id="date" pattern="\d{2}-\d{2}-\d{4}" placeholder="15-05-2024">
        </fieldset>
      </div>
      <button class="btn btn-search" type="submit" value="search" name="search">Search</button>
    </form>
    <div id="showFairResult">
    </div>
  </section>
  <!-- ----------------- Footer Section --------------- -->
  <?php include 'src/inc/footer.php'; ?>
  <script src="script/services.js"></script>
  <script src="script/script.js"></script>
</body>

</html>

<!-- <div class="row">
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
    </div> -->