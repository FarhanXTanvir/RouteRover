<?php
// Start the session
session_start();
if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
  if (isset($_COOKIE['user'])) {
    $_SESSION["user"] = $_COOKIE['user'];
    header('Location: user');
  } elseif (isset($_COOKIE['admin'])) {
    $_SESSION["admin"] = $_COOKIE['admin'];
    header('Location: admin');
  }
} else if (isset($_SESSION["user"])) {
  header('Location: user');
} elseif (isset($_SESSION["admin"])) {
  header('Location: admin');
}

// Connect Database
require_once ('connect.php');

// Get the user's current location and desired destination
$currentLocation = $_POST['areas1'] ?? null;
$destination = $_POST['areas2'] ?? null;

$buses = [];
if ($currentLocation && $destination) {
  // Prepare the SQL query
  $sql = "SELECT * FROM buses WHERE DepartureLocation = ? AND Destination = ?";

  // Prepare the statement
  $stmt = $con->prepare($sql);

  // Bind the parameters
  $stmt->bind_param("ss", $currentLocation, $destination);

  // Execute the query
  $stmt->execute();

  // Get the results
  $result = $stmt->get_result();

  // Fetch the data
  $buses = $result->fetch_all(MYSQLI_ASSOC);

  // Close the connection
  $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="RouteRover is a web application that helps you find the best route to your destination.">
  <meta name="keywords" content="RouteRover, Route Finder, Transport, Bus, Route, Destination, Pricing">
  <meta name="author" content="RouteRover">
  <meta name="robots" content="index, follow">
  <meta name="googlebot" content="index, follow">
  <meta name="bingbot" content="index, follow">
  <meta property="og:title" content="RouteRover">
  <meta property="og:description"
    content="RouteRover is a web application that helps you find the best route to your destination.">
  <meta property="og:image" content="routerover_icon.png">
  <meta property="og:url" content="https://routerover.000webhostapp.com/">
  <meta property="og:site_name" content="RouteRover">
  <meta name="twitter:title" content="RouteRover">
  <meta name="twitter:description"
    content="RouteRover is a web application that helps you find the best route to your destination.">
  <meta name="twitter:image" content="routerover_icon.png">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:creator" content="@RouteRover">
  <meta name="twitter:site" content="@RouteRover">
  <meta name="theme-color" content="#000000">
  <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
  <link rel="manifest" href="favicon_io/site.webmanifest">
  <!-- <meta http-equiv="refresh" content="5"> -->
  <title> Home | RouteRover </title>

  <!-- Style Sheet -->
  <link rel="stylesheet" href="css/style.css">
  <?php include 'src/lib/lib.html'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Font Family -->
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Favicon -->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>

<body>
  <?php include 'src/inc/header.php'; ?>
  <section class="main">
    <div class="route-finder" id="route-finder" style="height:auto;">
      <h1>Welcome to RouteRover!</h1>
      <p class="welcome">
        Want to find your Route no., Available transports and Pricing details for going to your next destination?
        RouteRover is here on your service!! Get everything on your fingertips with a single click.
      </p>
      <h2>Route Finder</h2>
      <form action="index.php" method="post">
        <div class="input">
          <input class="input-field" name="areas1" list="areas1" placeholder="Departure Location">
          <datalist id="areas1">
            <!-- options -->
            <option value="A">
            <option value="B">
            <option value="C">
          </datalist>
        </div>
        <div class="input">
          <input class="input-field" name="areas2" list="areas2" placeholder="Destination Location">
          <datalist id="areas2">
            <!-- options -->
            <option value="A">
            <option value="B">
            <option value="C">
          </datalist>
        </div>
        <button type="submit">Search</button>
      </form>
    </div>
    <!-- Display the search results in a table -->
    <?php if (!empty($buses)): ?>
      <table>
        <tr>
          <th>Bus Name</th>
          <th>Departure Location</th>
          <th>Destination</th>
          <th>Departure Time</th>
          <th>Arrival Time</th>
          <th>Price</th>
        </tr>
        <?php foreach ($buses as $bus): ?>
          <tr>
            <td>
              <?php echo htmlspecialchars($bus['BusName']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($bus['DepartureLocation']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($bus['Destination']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($bus['DepartureTime']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($bus['ArrivalTime']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($bus['Price']); ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
    <div id="contact" class="contact">
      <h3> Contact Form </h3>
      <p>While using our services if you face any inconvenience then please inform us.</p>
      <form action="contact.php" method="post">
        <div class="input">
          <label for="email">Email: </label>
          <input type="email" placeholder="yourname@email.com" name="email" required>
        </div>
        <div class="input">
          <label for="message"> Message: </label>
          <textarea placeholder="Type here..." name="comments" cols="25" rows="10"></textarea>
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
    </div>
  </section>
  <?php include 'src/inc/footer.php'; ?>
  <script src="script\script.js"></script>
</body>

</html>