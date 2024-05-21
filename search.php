<?php
if (isset($_POST['search'])) {
  $table = " ";
  $error = " ";
  // Get the departure and destination locations from the form data
  $departure = $_POST['departure'];
  $destination = $_POST['destination'];

  // Check if the posted locations are not empty and the location exists in the options

  if (!empty($departure) && !empty($destination)) {
    if ($departure === $destination) {
      $table = "আপনি ইতোমধ্যে আপনার গন্তব্যে পৌছে গিয়েছেন। আপনি কি পুনরায় আপনার গন্তব্যস্থল নির্বাচন করতে চান?";
    } else {
      // Check if destination and departure are in the unique values
      if (in_array($departure, $uniqueValues) && in_array($destination, $uniqueValues)) {
        // Find the route numbers for the departure and destination
        $jsonRoutes = json_decode(file_get_contents('script/routes.json'), true);
        $routeNo = array();
        foreach ($jsonRoutes as $route => $locations) {
          if (in_array($departure, $locations) && in_array($destination, $locations)) {
            $routeNo[] = $route;
          }
        }
        if (count($routeNo) > 0) {
          // Connect to the database
          require_once './connect.php';

          // Get the bus fare for each route number from the each table of routes
          $fare = array();
          foreach ($routeNo as $route) {
            $tableName = "রুট" . $route;

            // Example: $tableName = "রুট১০";
            $sql = "SELECT `$destination` FROM `$tableName` WHERE location = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 's', $departure);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $fare[$tableName] = $row[$destination];
              }
            }
          }


          $table = "
          <span class='dd'>" . $departure . " => " . $destination . "</span>
          <table class='table'>
          <tr><th>রুট নং</th><th>ভাড়া</th></tr>";
          foreach ($routeNo as $route) {
            $fareValue = isset($fare["রুট" . $route]) ? $fare["রুট" . $route] : 'N/A';
            $table .= "<tr class='tr'><td><a href='#'>" . $route . "</a></td><td>" . $fareValue . " টাকা </td></tr>";
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
  // Display the search results in a table

  // Now $uniqueValues is a unique set of all values in the jsonRoutes array
  if ($table !== " ") {
    echo "
      <div class='welcome'>
        <span class='close'> x </span>" . $table .
      "</div>";
  } else if ($error !== " ") {
    echo "
      <div class='error'>
        <span class='close'> x </span>" . $error .
      "</div>";
  }
}

// if (isset($_POST['search'])) {
//   // Get the departure and destination locations from the form data

//   $departure = $_POST['dept'];
//   $destination = $_POST['dest'];

//   // Check if the posted locations are not empty and the location exists in the options

//   if (!empty($departure) && !empty($destination)) {
//     if ($departure === $destination) {
//       $table = "আপনি ইতোমধ্যে আপনার গন্তব্যে পৌছে গিয়েছেন। আপনি কি পুনরায় আপনার গন্তব্যস্থল নির্বাচন করতে চান?";
//     } else {
//       // Check if destination and departure are in the unique values
//       if (in_array($departure, $uniqueValues) && in_array($destination, $uniqueValues)) {
//         // Find the route numbers for the departure and destination
//         $routeNo = array();
//         foreach ($data as $key => $values) {
//           if (in_array($departure, $values) && in_array($destination, $values)) {
//             $routeNo[] = $key;
//           }
//         }
//         if (count($routeNo) > 0) {
//           // Connect to the database
//           require_once 'connect.php';
//           mysqli_set_charset($con, 'utf8');
//           // Get the bus fare for each route number from the each table of routes

//           $fare = array();
//           foreach ($routeNo as $route) {
//             $tableName = "রুট" . $route;
//             // $tableName = "রুট" . "১০";
//             $sql = "SELECT `$destination` FROM `$tableName` WHERE location = ?";
//             $stmt = mysqli_prepare($con, $sql);
//             mysqli_stmt_bind_param($stmt, 's', $departure);
//             mysqli_stmt_execute($stmt);
//             $result = mysqli_stmt_get_result($stmt);
//             if (mysqli_num_rows($result) > 0) {
//               while ($row = mysqli_fetch_assoc($result)) {
//                 $fare[$tableName] = $row[$destination];
//               }
//             }
//           }


//           $table = "
//           <span class='dd'>" . $departure . " => " . $destination . "</span>
//           <table class=\"table\">
//           <tr><th>রুট নং</th><th>ভাড়া</th></tr>";
//           foreach ($routeNo as $route) {
//             $fareValue = isset($fare["রুট" . $route]) ? $fare["রুট" . $route] : 'N/A';
//             $table .= "<tr class='tr'><td><a href='#'>" . $route . "</a></td><td>" . $fareValue . " টাকা </td></tr>";
//           }
//           $table .= "</table>";
//         } else {
//           $error = "দুঃখিত, এই দুটি লোকেশনের মধ্যে কোন রুট নম্বর পাওয়া যায়নি। দয়া করে অন্য লোকেশন নির্বাচন করুন।";
//         }
//       } else {
//         $error = "দুঃখিত, আপনি সঠিক লোকেশন নির্বাচন করেননি। দয়া করে সঠিক লোকেশন নির্বাচন করুন।";
//       }
//     }
//   } else {
//     $error = "যাত্রাস্থান এবং গন্তব্যস্থল পূরণ করুন।";
//   }
// }