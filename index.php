<?php
// Start the session
session_start();
if (isset($_SESSION["username"])) {
  if ($_SESSION['role'] === "user") {
    header('Location: user');
  } else if ($_SESSION['role'] === "admin") {
    header('Location: admin');
  }
} else if (isset($_COOKIE["username"])) {
  if (isset($_COOKIE['role'])) {
    if ($_COOKIE['role'] === "user") {
      header('Location: user');
    } else if ($_COOKIE['role'] === "admin") {
      header('Location: admin');
    }
  }
} else if (isset($_COOKIE["super"]) || isset($_SESSION["super"])) {
  header('Location: super.php');
}
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
  <!-- <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0"> -->
  <meta name="description" content="RouteRover is a web application that helps you find the best route to your destination.">
  <meta name="keywords" content="RouteRover, Route Finder, Transport, Bus, Route, Destination, Pricing">
  <meta name="author" content="RouteRover">
  <meta name="robots" content="index, follow">
  <meta name="googlebot" content="index, follow">
  <meta name="bingbot" content="index, follow">
  <meta property="og:title" content="RouteRover">
  <meta property="og:description" content="RouteRover is a web application that helps you find the best route to your destination.">
  <meta property="og:image" content="routerover_icon.png">
  <meta property="og:url" content="https://routerover.free.nf/">
  <meta property="og:site_name" content="RouteRover">
  <meta name="twitter:title" content="RouteRover">
  <meta name="twitter:description" content="RouteRover is a web application that helps you find the best route to your destination.">
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
</head>

<body>
  <?php include 'src/inc/header.php'; ?>
  <section class="main">
    <div class="route-finder" id="route-finder" style="height:auto;">
      <h1>R<span style="color: white;">oute</span>R<span style="color: white;">over - এ আপনাকে স্বাগতম!</span></h1>
      <p class="welcome">
        <!-- Want to find your Route no., Available transports and Pricing details for going to your next destination?
        RouteRover is here on your service!! Get everything on your fingertips with a single click. -->
        আপনি কি আপনার পরবর্তী গন্তব্যস্থলে যাওয়ার জন্য আপনার রুট নম্বর, উক্ত রুটে সচল বাস এবং বাস ভাড়া জানতে চাচ্ছেন?
        তাহলে RouteRover আছে আপনার সেবায়!! শুধু একটি ক্লিকের মাধ্যমে সব কিছু আপনার হাতের মুঠোয়।
      </p>
      <h2>Route Finder</h2>
      <form method="post">
        <div class="input">
          <input class="input-field" name="departure" list="departure" aria-label="departure" placeholder="যাত্রাস্থান" autocomplete="off">
          <ul id="departure">
            <!-- options -->
            <?php echo $options ?>
          </ul>
        </div>
        <div class="input">
          <input class="input-field" name="destination" list="destination" aria-label="destination" placeholder="গন্তব্যস্থল" autocomplete="off">
          <ul id="destination">
            <!-- options -->
            <?php echo $options ?>
          </ul>
        </div>
        <button type="submit" value="search" name="search">Search</button>
      </form>
      <div id="searchResult">
      </div>
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
        <?php require_once './contact.php'; ?>
        <button type="submit" value="contact" name="contact">Submit</button>
      </form>
    </div>
    </div>
  </section>
  <?php include 'src/inc/footer.php'; ?>
  <script src="script/script.js"></script>
</body>

</html>