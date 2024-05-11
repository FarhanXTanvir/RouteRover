<?php
if (isset($_POST['search'])) {
  // Get the departure and destination locations from the form data

  $departure = $_POST['dept'];
  $destination = $_POST['dest'];

  // Check if the posted locations are not empty and the location exists in the options

  if (!empty($departure) && !empty($destination)) {
    if ($departure === $destination) {
      $table = "আপনি ইতোমধ্যে আপনার গন্তব্যে পৌছে গিয়েছেন। আপনি কি পুনরায় আপনার গন্তব্যস্থল নির্বাচন করতে চান?";
    } else {
      // Check if destination and departure are in the unique values
      if (in_array($departure, $uniqueValues) && in_array($destination, $uniqueValues)) {
        // Find the route numbers for the departure and destination
        $routeNo = array();
        foreach ($data as $key => $values) {
          if (in_array($departure, $values) && in_array($destination, $values)) {
            $routeNo[] = $key;
          }
        }
        if (count($routeNo) > 0) {
          // Connect to the database
          require_once 'connect.php';
          // Get the bus fare for each route number from the each table of routes
          $fare = array();
          foreach ($routeNo as $route) {
            $tableCheck = "SHOW TABLES LIKE '$route'";
            $tableCheckResult = mysqli_query($con, $tableCheck);
            if (mysqli_num_rows($tableCheckResult) > 0) {
              // The table exists, so you can run your query
              $sql = "SELECT Fare FROM $route";
              $result = mysqli_query($con, $sql);
              // ...
            } else {
              $error .= "দুঃখিত, এই রুটে কোন তথ্য পাওয়া যায়নি।";
              continue;
            }
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $fare[] = $row['Fare'];
              }
            }
          }
          $table = "
          <span class='dd'>" . $departure . " => " . $destination . "</span>
          <table class=\"table\">
          <tr><th>Route No.</th><th>Fare</th></tr>";
          foreach ($routeNo as $index => $route) {
            $fareValue = isset($fare[$index]) ? $fare[$index] : 'N/A';
            $table .= "<tr class='tr'><td><a href='#'> [click] " . $route . "</a></td><td>" . $fareValue . "</td></tr>";
          }
          $table .= "</table>";
        } else {
          $error = "দুঃখিত, এই দুটি লোকেশনের মধ্যে কোন রুট নম্বর পাওয়া যায়নি। দয়া করে অন্য লোকেশন নির্বাচন করুন।";
        }
      } else {
        $error = "দুঃখিত, আপনি সঠিক লোকেশন নির্বাচন করেননি। দয়া করে সঠিক লোকেশন নির্বাচন করুন।";
      }
    }
  } else {
    $error = "যাত্রাস্থান এবং গন্তব্যস্থল পূরণ করুন।";
  }
}