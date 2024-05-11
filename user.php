<?php
// require_once './validators/config.php';
// Start the session
// $location = "user.php";
session_start();
include './validators/check_cookie.php';
if (isset($_SESSION["username"])) {
  if ($_SESSION['role'] === "admin") {
    header('Location: admin');
  }
} else {
  header('Location: login');
}
$table = " ";
$error = " ";
$sqlAll = " ";
// Get the last modification time of the routes.json file
$routesLastModified = filemtime('script/routes.json');
// Check if the last modification time is stored in the session
if (!isset($_SESSION['routesLastModified'])) {
  // If not, store it in the session
  $_SESSION['routesLastModified'] = $routesLastModified;
}

$jsonData = file_get_contents('script/routes.json');

// Check if the unique values file exists
if (!file_exists('script/unique_values.json') || $routesLastModified > $_SESSION['routesLastModified']) {
  // Decode the JSON data into a PHP array
  $data = json_decode($jsonData, true);
  // If the file doesn't exist, compute the unique values

  // Initialize an associative array to hold unique values
  $uniqueValues = array();
  require_once 'connect.php';
  // Loop through each item in the data array
  foreach ($data as $key => $values) {
    // $tableName = "রুট" . $key;

    // // Start the SQL query
    // $sql = "CREATE TABLE IF NOT EXISTS $tableName (id INT AUTO_INCREMENT PRIMARY KEY, location VARCHAR(255) UNIQUE";

    // $location = "INSERT INTO $tableName (location) VALUES ";
    foreach ($values as $value) {
      // Add a column for each value in the data array
      // $sql .= ", `$value` VARCHAR(255)";
      // $location .= "('$value'), ";

      // Use the value as the key in the associative array
      // This will automatically remove duplicates
      $uniqueValues[$value] = true;
    }
    // $location = rtrim($location, ", ") . ";";
    // // End the SQL query
    // $sql .= "); " . $location . " ";

    // $sqlAll .= $sql . " ";

    // Execute the SQL query
    // if ($con->multi_query($sql) === TRUE) {
    //   do {
    //     if ($result = $con->store_result()) {
    //       $result->free();
    //     }
    //   } while ($con->more_results() && $con->next_result());

    //   $sqlAll .= "<br>Table $tableName created successfully<br><br>";
    // } else {
    //   $sqlAll .= "Error creating table $tableName: " . $con->error;
    // }
  }
  // Close the connection
  // $con->close();

  // Get the keys of the associative array, which are the unique values
  $uniqueValues = array_keys($uniqueValues);

  // Sort the unique values
  sort($uniqueValues);

  // Save the unique values to a file
  file_put_contents('script/unique_values.json', json_encode($uniqueValues));
} else {
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
  <title> Home | RouteRover </title>

  <!-- Style Sheet -->
  <link rel="stylesheet" href="css/style.css">
  <?php include 'src/inc.php'; ?>

  <!-- Font Family -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
  <link rel="manifest" href="favicon_io/site.webmanifest">
</head>

<body>
  <?php include 'src/inc/header.php'; ?>
  <section class="main">
    <div class="route-finder" id="route-finder" style="height:auto;">
      <?php echo "<h2 style='color: red; font-size: 2rem;'>Hey " . $_COOKIE['username'] . " " . $_COOKIE['id'] . "!</h2>"; ?>
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
      <?php include 'contact.php'; ?>
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