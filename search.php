<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['searchData'])) {
    $searchData = json_decode($_POST["searchData"], true);
    $searchResult = " ";
    // Get the departure and destination locations from the form data
    $departure = $searchData['departure'];
    $destination = $searchData['destination'];

    // echo $departure . " " . $destination;
    // exit();

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


      $searchResult = <<<FT
            <span class="dd"> $departure => $destination </span>
            <table class="table">
            <tr><th>রুট নং</th><th>ভাড়া</th></tr> 
          FT;
      foreach ($routeNo as $route) {
        $fareValue = isset($fare["রুট" . $route]) ? $fare["রুট" . $route] : 'N/A';
        $searchResult .= "<tr class='tr'><td><a href='#'>" . $route . "</a></td><td>" . $fareValue . " টাকা </td></tr>";
      }
      $searchResult .= "</table>";
    } else {
      echo "
      <div class='error'>
      <i class='fa-regular fa-times close'></i>
      দুঃখিত, এই দুটি লোকেশনের মধ্যে কোন রুট নম্বর পাওয়া যায়নি। দয়া করে অন্য লোকেশন নির্বাচন করুন।
      </div>";
      exit();
    }

    // Display the search results in a table
    if ($searchResult !== " ") {
      echo $searchResult;
    }
  }
}
/*
<?php include './search.php' ?>
else if ($error !== " ") {
    echo <<<FT
      <div class="error">
        <span class="close"> x </span> $error
      </div> 
      FT;
  }
*/
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