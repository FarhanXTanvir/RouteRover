<?php
// require_once './validators/config.php'; 
// Start the session
session_start();
// include './validators/check_cookie.php';
if (isset($_SESSION["username"])) {
  if ($_SESSION['role'] === "user") {
    header('Location: user');
  } else if ($_SESSION['role'] === "admin") {
    header('Location: admin');
  }
} else if (isset($_COOKIE["username"])) {
  if ($_COOKIE['role'] === "user") {
    header('Location: user');
  } else if ($_COOKIE['role'] === "admin") {
    header('Location: admin');
  }
} else if (isset($_COOKIE["super"]) || isset($_SESSION["super"])) {
  header('Location: super.php');
}

$jsonData = file_get_contents('script/routes.json');
// Get the last modification time of the routes.json file
$routesLastModified = filemtime('script/routes.json');
// Check if the last modification time is stored in the session
if (!isset($_COOKIE['routesLastModified'])) {
  // If not, store it in the session
  $_SESSION['routesLastModified'] = $routesLastModified;
  setcookie('routesLastModified', $routesLastModified, time() + (86400 * 30), "/"); // 86400 = 1 da
} else {
  $_SESSION['routesLastModified'] = $_COOKIE['routesLastModified'];
}

$table = " ";
$error = " ";
$sqlAll = " ";


echo "<script>console.log('Current: $routesLastModified and LastMod: {$_SESSION['routesLastModified']}');</script>";
// Check if the unique values file exists
if (!file_exists('script/unique_values.json') || $routesLastModified > $_SESSION['routesLastModified']) {
  // Log to the browser's console
  echo "<script>console.log('Unique Values Generated');</script>";

  // Decode the JSON data into a PHP array
  $data = json_decode($jsonData, true);
  // If the file doesn't exist, compute the unique values

  // Initialize an associative array to hold unique values
  $uniqueValues = array();
  require_once 'connect.php';
  mysqli_set_charset($con, 'utf8');
  // Loop through each item in the data array
  foreach ($data as $key => $values) {
    $tableName = "রুট" . $key;

    // Start the SQL query
    $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (id INT AUTO_INCREMENT PRIMARY KEY, location VARCHAR(255) UNIQUE";

    $location = "INSERT IGNORE INTO `$tableName` (location) VALUES ";
    foreach ($values as $value) {
      // Add a column for each value in the data array
      $sql .= ", `$value` VARCHAR(255)";
      $location .= "('$value'), ";

      // Use the value as the key in the associative array
      // This will automatically remove duplicates
      $uniqueValues[$value] = true;
    }
    $location = rtrim($location, ", ") . ";";
    // End the SQL query
    $sql .= "); " . $location . " ";

    $sqlAll .= $sql . " ";

    // Execute the SQL query
    if ($con->multi_query($sql) === TRUE) {
      do {
        if ($result = $con->store_result()) {
          $result->free();
        }
      } while ($con->more_results() && $con->next_result());
      $sqlAll .= "<br>Table $tableName created successfully<br><br>";
    } else {
      $sqlAll .= "Error creating table $tableName: " . $con->error;
    }
  }
  // Close the connection
  $con->close();

  // Get the keys of the associative array, which are the unique values
  $uniqueValues = array_keys($uniqueValues);

  // Sort the unique values
  sort($uniqueValues);

  // Save the unique values to a file
  file_put_contents('script/unique_values.json', json_encode($uniqueValues));
  $routesLastModified = filemtime('script/routes.json');
  setcookie('routesLastModified', $routesLastModified, time() + (86400 * 30), "/");
} else {
  echo "<script>console.log('Unique Values Exists');</script>";
  // Decode the JSON data into a PHP array
  $data = json_decode($jsonData, true);

  // If the file exists, read the unique values from the file
  $uniqueValues = json_decode(file_get_contents('script/unique_values.json'), true);
}

include './search.php'

  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0"> -->
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
  <meta property="og:url" content="https://routerover.free.nf/">
  <meta property="og:site_name" content="RouteRover">
  <meta name="twitter:title" content="RouteRover">
  <meta name="twitter:description"
    content="RouteRover is a web application that helps you find the best route to your destination.">
  <meta name="twitter:image" content="routerover_icon.png">
  <!-- <meta name="twitter:card" content="summary_large_image"> -->
  <meta name="twitter:creator" content="@RouteRover">
  <meta name="twitter:site" content="@RouteRover">
  <!-- <meta name="theme-color" content="#000000"> -->

  <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
  <link rel="manifest" href="favicon_io/site.webmanifest">
  <!-- <meta http-equiv="refresh" content="5"> -->
  <title> Home | RouteRover </title>

  <!-- Style Sheet -->
  <link rel="stylesheet" href="css/style.css">
  <?php include 'src/inc.php'; ?>


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
      <h1>R<span style="color: white;">oute</span>R<span style="color: white;">over - এ আপনাকে স্বাগতম!</span> </h1>
      <p class="welcome">
        <!-- Want to find your Route no., Available transports and Pricing details for going to your next destination?
        RouteRover is here on your service!! Get everything on your fingertips with a single click. -->
        আপনি কি আপনার পরবর্তী গন্তব্যস্থলে যাওয়ার জন্য আপনার রুট নম্বর, উক্ত রুটে সচল বাস এবং বাস ভাড়া জানতে চাচ্ছেন?
        তাহলে RouteRover আছে আপনার সেবায়!! শুধু একটি ক্লিকের মাধ্যমে সব কিছু আপনার হাতের মুঠোয়।
      </p>
      <h2>Route Finder</h2>
      <form method="post">
        <div class="input">
          <input class="input-field" name="dept" list="dept" aria-label="dept" placeholder="যাত্রাস্থান">
          <datalist id="dept">
            <!-- options -->
            <?php foreach ($uniqueValues as $location): ?>
              <option value="<?php print_r($location); ?>">
              <?php endforeach; ?>
          </datalist>
        </div>
        <div class="input">
          <input class="input-field" name="dest" list="dest" aria-label="dest" placeholder="গন্তব্যস্থল">
          <datalist id="dest">
            <!-- options -->
            <?php foreach ($uniqueValues as $location): ?>
              <option value="<?php print_r($location); ?>">
              <?php endforeach; ?>
          </datalist>
        </div>
        <button type="submit" value="search" name="search">Search</button>
      </form>
      <!-- Display the search results in a table -->
      <?php
      // Now $uniqueValues is a unique set of all values in the data array
      if ($table !== " ") {
        echo "
        <div class='welcome'>
          <span class='close'> x </span>"
          . $table .
          "</div>";
      } else if ($error !== " ") {
        echo "
          <div class='error'>
            <span class='close'> x </span>"
          . $error .
          "</div>";
      }
      ?>
    </div>

    <div id="contact" class="contact">
      <h3> Contact Form </h3>
      <p>
        <!-- While using our services if you face any inconvenience then please inform us. -->
        আমাদের সার্ভিস ব্যবহার করার সময় আপনি যদি কোনও অসুবিধা অনুভব করেন তাহলে অনুগ্রহ করে আমাদের জানান।

      </p>
      <form method="post" id="contactForm">
        <div class="input">
          <label for="email">Email: </label>
          <input type="text" placeholder="yourname@email.com" id="email" name="email" autocomplete="email">
        </div>
        <div class="input">
          <label for="message"> Message: </label>
          <textarea placeholder="Type here..." id="message" name="message" cols="25" rows="10"></textarea>
        </div>
        <button type="submit" value="contact" name="contact">Submit</button>
      </form>
      <?php include './contact.php'; ?>
    </div>
    </div>
    <?php
    if ($sqlAll !== " ") {
      echo "
    <div class='success'> 
      <span class='close'> x </span> "
        . $sqlAll .
        "</div>";
    }
    ?>
  </section>
  <?php include 'src/inc/footer.php'; ?>
  <script src="script/script.js"></script>
</body>

</html>