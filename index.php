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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the departure and destination locations from the form data
  $departure = $_POST['loc1'];
  $destination = $_POST['loc2'];
  // Check if the posted locations are not empty and the location exists in the options

  $locations = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S"];
  if (!empty($departure) && !empty($destination)) {
    if (in_array($departure, $locations) && in_array($destination, $locations)) {
      // Both locations are valid, connect database
      require_once ('connect.php');

      // Get the route number from the database
      $stmt = $con->prepare("SELECT $destination FROM routes WHERE name = ?");
      $stmt->bind_param("s", $departure);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        // Output the fare
        while ($row = $result->fetch_assoc()) {

          $routeNo = $row[$destination];
        }
      } else {
        echo "No route found.";
      }
      $stmt->close();
      $tableName = "route" . $routeNo;
      // Prepare the SQL query
      $stmt = $con->prepare("SELECT $destination FROM $tableName WHERE name = ?");
      $stmt->bind_param("s", $departure);
      // Execute the SQL query
      $stmt->execute();

      // Get the result
      $result = $stmt->get_result();

      // Check if the query returned a result
      $table = " ";
      if ($result->num_rows > 0) {
        // Output the fare
        while ($row = $result->fetch_assoc()) {
          // Create Table for output
          $table = "<table>
                  <tr>
                    <th>যাত্রাস্থান</th>
                    <th>গন্তব্যস্থল</th>
                    <th>রুট নং</th>
                    <th>ভাড়া</th>
                  </tr>
                  <tr>
                    <td>$departure</td>
                    <td>$destination</td>
                    <td>$routeNo</td>
                    <td>$row[$destination]</td>
                  </tr>
                </table>";
        }
      } else {
        $table = "No results found.";
      }

      // Close the statement
      $stmt->close();

    } else {
      $table = "Invalid location selected.";
    }
  } else {
    $table = "Please select both a departure and destination location.";
  }
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
      <h1>RouteRover - এ আপনাকে স্বাগতম!</h1>
      <p class="welcome">
        <!-- Want to find your Route no., Available transports and Pricing details for going to your next destination?
        RouteRover is here on your service!! Get everything on your fingertips with a single click. -->
        আপনি কি আপনার পরবর্তী গন্তব্যস্থলে যাওয়ার জন্য আপনার রুট নম্বর, উক্ত রুটে সচল ্বাস এবং বাস ভাড়া জানতে চাচ্ছেন?
        তাহলে RouteRover আছে আপনার সেবায়!! শুধু একটি ক্লিকের মাধ্যমে সব কিছু আপনার হাতের মুঠোয়।
      </p>
      <h2>Route Finder</h2>
      <form action="index.php" method="post">
        <div class="input">
          <input class="input-field" name="loc1" list="loc1" placeholder="যাত্রাস্থান">
          <datalist id="loc1">
            <!-- options -->
            <?php foreach ($locations as $location): ?>
              <option value="<?php echo $location; ?>">
              <?php endforeach; ?>
          </datalist>
        </div>
        <div class="input">
          <input class="input-field" name="loc2" list="loc2" placeholder="গন্তব্যস্থল">
          <datalist id="loc2">
            <!-- options -->
            <?php foreach ($locations as $location): ?>
              <option value="<?php echo $location; ?>">
              <?php endforeach; ?>
          </datalist>
        </div>
        <button type="submit">Search</button>
      </form>
      <!-- Display the search results in a table -->
      <?php
      if (isset($table)) {
        echo "<div class=\"output\" style=\"color: white\">"
          . $table .
          "</div>";
      }
      ?>
    </div>

    <div id="contact" class="contact">
      <h3> Contact Form </h3>
      <p>
        <!-- While using our services if you face any inconvenience then please inform us. -->
        আমাদের সেবা ব্যবহার করার সময় আপনি যদি কোনও অসুবিধা অনুভব করেন তাহলে অনুগ্রহ করে আমাদের জানান।

      </p>
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
</body>

</html>