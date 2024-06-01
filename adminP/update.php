<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $jsonRoutes = json_decode(file_get_contents('../script/routes.json'), true);

  function updateJson($jsonRoutes)
  {
    $jsonData = json_encode($jsonRoutes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    $jsonData = str_replace('    ', '  ', $jsonData);
    file_put_contents('../script/routes.json', $jsonData);
  }
  function updateUniqueLocations($jsonRoutes)
  {
    // Find the unique locations from the jsonRoutes and sort them alphabetically
    $uniqueLocations = [];
    foreach ($jsonRoutes as $route => $locations) {
      $uniqueLocations = array_merge($uniqueLocations, $locations);
    }
    $uniqueLocations = array_unique($uniqueLocations);
    sort($uniqueLocations);

    // Save the unique locations to a file
    if (file_exists('../script/uniqueLocations.json')) {
      $jsonRoutes = json_decode(file_get_contents('../script/uniqueLocations.json'), true);
    }

    $jsonRoutes = $uniqueLocations;
    $jsonData = json_encode($jsonRoutes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    $jsonData = str_replace('    ', '  ', $jsonData);
    file_put_contents('../script/uniqueLocations.json', $jsonData);
  }
  function showFare($routeNo, $con)
  {
    $tableName = "রুট" . $routeNo;
    $sql = "SELECT * FROM $tableName";
    $result = mysqli_query($con, $sql);
    $routeTable = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (mysqli_num_rows($result) > 0) {
      $i = 0;
      echo "
      <div class='content fareBlockContent'>";
      foreach ($routeTable as $row) {
        $departure = $row['location'];

        echo <<<FT
        <div class="group">
          <div class="header">$departure <i class="openable fa-solid fa-plus"></i></div>
          <div class="content">
        FT;

        $counter = 0;
        foreach ($row as $destination => $fare) {
          if ($counter < 2) { // Skip the first two fields
            $counter++;
            continue;
          } else if ($destination === $departure) {
            continue;
          }
          $fare = ($fare === null) ? 'N/A' : $fare;

          $i++;
          echo <<<FT
              <div class="farePair" data-destination="$destination" data-departure="$departure">
                  $departure <i class="fa-solid fa-left-right fa-fw"></i> $destination : 
                  <input class="fare" name="fare" value="$fare">
              </div>
            FT;
        }
        echo "
          </div>
        </div>";
      }
      echo "
        <button type='none' class='submitFare' value='submitFare'>Submit Fare</button>
      </div>";
    }
  }

  function convertToBengali($number)
  {
    $find = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $replace = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    $bengaliNumber = str_replace($find, $replace, $number);

    return $bengaliNumber;
  }
  function randStep($min, $max, $step)
  {
    // Calculate the number of steps
    $steps = floor(($max - $min) / $step);

    // Generate a random step
    $randStep = rand(0, $steps);

    // Calculate the random number
    $randNumber = $min + $randStep * $step;

    return $randNumber;
  }

  function generateRandomFare($routeNo, $con)
  {
    $tableName = "রুট" . $routeNo;
    $sql = "SELECT * FROM $tableName";
    $result = mysqli_query($con, $sql);
    $routeTable = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (mysqli_num_rows($result) > 0) {
      foreach ($routeTable as $row) {
        $departure = $row['location'];

        $counter = 0;
        foreach ($row as $destination => $fare) {
          if ($counter < 2) { // Skip the first two fields
            $counter++;
            continue;
          } else if ($destination === $departure) {
            continue;
          }

          $fare = convertToBengali(randStep(5, 50, 5));

          $sql = "UPDATE $tableName SET `$destination` = '$fare' WHERE location = '$departure'";
          mysqli_query($con, $sql);
          $sql = "UPDATE $tableName SET `$departure` = '$fare' WHERE location = '$destination'";
          mysqli_query($con, $sql);
        }
      }
    }
  }
  function updateFare($routeNo, $fareValues, $con)
  {
    $tableName = "রুট" . $routeNo;
    // $con = require_once '../connect.php';

    // for each value of fareValues, update the fare in the database as routeTable[departure][destination] = fareValues[departure][destination] and routeTable[destination][departure] = fareValues[departure][destination]

    foreach ($fareValues as $departure => $destinationFares) {
      foreach ($destinationFares as $destination => $fare) {
        $fare = ($fare === '') ? null : $fare;

        // echo "<p style='text-align: center; color: green;'>Fare from $departure to $destination: $fare </p>\n";

        $sql = "UPDATE $tableName SET `$destination` = '$fare' WHERE location = '$departure'";
        mysqli_query($con, $sql);
        $sql = "UPDATE $tableName SET `$departure` = '$fare' WHERE location = '$destination'";
        mysqli_query($con, $sql);
      }
    }
    showFare($routeNo, $con);
  }


  function updateDb($jsonRoutes)
  {
    $con = require_once '../connect.php';
    foreach ($jsonRoutes as $route => $locations) {
      $routeNo = $route;
      $tableName = "রুট" . $routeNo;

      $columns = [];

      foreach ($locations as $location) {
        // Escape the location string to prevent SQL injection
        $location = mysqli_real_escape_string($con, $location);
        $columns[] = "`$location` VARCHAR(191)";
      }

      $columnsString = '';
      if (!empty($columns)) {
        $columnsString = ', ' . implode(', ', $columns); // Convert the array to a string
      }

      $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (id INT AUTO_INCREMENT PRIMARY KEY, location VARCHAR(191) UNIQUE $columnsString)";

      if (mysqli_query($con, $sql)) {
        echo "Table $tableName created successfully with location fields <br>\n";
      } else {
        echo "Error creating table $tableName: " . mysqli_error($con) . "<br>\n";
      }

      // check if the $locations is empty
      if (empty($locations)) {
        continue;
      } else {
        $values = [];
        foreach ($locations as $location) {
          // Escape the location string to prevent SQL injection
          $location = mysqli_real_escape_string($con, $location);
          $values[] = "('$location')";
        }
        $values = implode(', ', $values); // Convert the array to a string
        $sql = "INSERT IGNORE INTO `$tableName` (location) VALUES $values";
        if (mysqli_query($con, $sql)) {
          echo "Locations added successfully in location field <br>\n";
        } else {
          echo "Error adding locations in location field: " . mysqli_error($con) . "<br>\n";
        }
      }
    }
  }
  function updateRoute($route)
  {
    global $jsonRoutes;
    $routeNo = $route['routeNo'];
    $modifiedLocations = $route['modifiedLocations'];
    $newLocations = $route['newLocations'];
    $removedLocations = $route['removedLocations'];

    if ($routeNo) {
      if (!isset($jsonRoutes[$routeNo])) {
        $jsonRoutes[$routeNo] = [];
      }
      echo ">> Updating Route $routeNo <br>\n";
    }
    if ($newLocations && $removedLocations) {
      $commonLocations = array_intersect($newLocations, $removedLocations);
      $newLocations = array_diff($newLocations, $commonLocations);
      $removedLocations = array_diff($removedLocations, $commonLocations);
    }
    if ($newLocations) {
      echo "<br>\n>> Adding New Locations: <br>\n";
      // if newLocations contains a value that is not in the jsonRoutes, then add that value to the jsonRoutes
      foreach ($newLocations as $location) {
        if (!in_array($location, $jsonRoutes[$routeNo])) {
          array_push($jsonRoutes[$routeNo], $location);
          echo "$location || ";
        }
      }
      echo "<br>\n>> New Locations Added <br>\n";
    }
    if ($removedLocations) {
      echo ">> Removing Locations: <br>\n";
      foreach ($removedLocations as $location) {
        $index = array_search($location, $jsonRoutes[$routeNo]);
        if ($index !== false) {
          unset($jsonRoutes[$routeNo][$index]);
          echo "$location || ";
        }
      }
      echo "<br>\n>> Locations Removed <br>\n";
    }
    if ($modifiedLocations) {
      echo ">> Modifying Locations: <br>\n";
      foreach ($modifiedLocations as $location) {
        $initialLocation = $location["initial"];
        $modifiedLocation = $location["modified"];

        $key = array_search($initialLocation, $jsonRoutes[$routeNo]);
        if ($key !== false) {
          $jsonRoutes[$routeNo][$key] = $modifiedLocation;
          echo "$initialLocation to $modifiedLocation || ";
        }
      }
      echo "<br>\n>> Locations Modified <br>\n";
    }
    // Unique the locations
    $jsonRoutes[$routeNo] = array_unique($jsonRoutes[$routeNo]);
    $jsonRoutes[$routeNo] = array_values($jsonRoutes[$routeNo]);
  }
  function updateRoutes($allRoutes)
  {
    global $jsonRoutes;
    // if newRoutes exists then assign
    if (isset($allRoutes['newRoutes']) || isset($allRoutes['removedRoutes'])) {
      $newRoutes = isset($allRoutes['newRoutes']) ? $allRoutes['newRoutes'] : [];
      $removedRoutes = isset($allRoutes['removedRoutes']) ? $allRoutes['removedRoutes'] : [];

      // if newRoutes and removedRoutes have equal values, then remove those values from newRoutes and removedRoutes then add the newRoutes to the jsonRoutes and remove the removedRoutes from the jsonRoutes
      if ($newRoutes && $removedRoutes) {
        $commonRoutes = array_intersect($newRoutes, $removedRoutes);
        $newRoutes = array_diff($newRoutes, $commonRoutes);
        $removedRoutes = array_diff($removedRoutes, $commonRoutes);
      }

      if ($newRoutes) {
        echo ">> Adding New Routes: ";
        foreach ($newRoutes as $routeNo) {
          $jsonRoutes[$routeNo] = [];
          echo "$routeNo";
        }
        unset($allRoutes['newRoutes']);
        echo "<br>\n >> New Routes Added <br>\n";
      }

      if ($removedRoutes) {
        echo ">> Removing Routes: ";
        foreach ($removedRoutes as $routeNo) {
          unset($jsonRoutes[$routeNo]);
          echo "$routeNo";
        }
        unset($allRoutes['removedRoutes']);
        echo "<br>\n >> Routes Removed <br>\n";
      }
    }
    echo "Routes to be Updated: <br>\n";
    foreach ($allRoutes as $route) {
      print_r($route['routeNo']);
      echo "<br>\n";
      updateRoute($route);
    }
    // Unique the locations
    $jsonRoutes = array_unique($jsonRoutes);
    $jsonRoutes = array_values($jsonRoutes);
  }

  if (isset($_POST["allRoutes"])) {
    echo "allroute condition passed <br>\n";

    $allRoutes = json_decode($_POST["allRoutes"], true); // Convert the JSON string to an associative array

    if ($allRoutes) {
      updateRoutes($allRoutes);
      updateJson($jsonRoutes);
    } else {
      echo "All Routes is empty";
    }
  } else if (isset($_POST["route"])) {
    echo "route condition passed <br> \n";

    $route = json_decode($_POST["route"], true); // Convert the JSON string to an associative array

    if ($route) {
      updateRoute($route);
      $routeNo = $route['routeNo'];
      echo ">> Locations of $routeNo Updated <br>\n";
      updateJson($jsonRoutes);
    } else {
      echo "Route is empty";
    }
  } else if (isset($_POST['updateDb'])) {
    updateUniqueLocations($jsonRoutes);
    updateDb($jsonRoutes);
  } else if (isset($_POST['showFare'])) {
    $routeNo = $_POST['showFare'];
    $con = require_once '../connect.php';
    showFare($routeNo, $con);
  } else if (isset($_POST['submitFare'])) {

    $routeNo = $_POST['submitFare'];
    if (isset($_POST['fareValues'])) {
      $fareValues = $_POST['fareValues'];
      // $fareValues = $fare = rand(5, 50);

      $con = require_once '../connect.php';
      updateFare($routeNo, $fareValues, $con);
    }
  } else if (isset($_POST['generateRandomValues'])) {
    $con = require_once '../connect.php';
    $routeList = $_POST['generateRandomValues'];
    foreach ($routeList as $routeNo) {
      generateRandomFare($routeNo, $con);
    }
  }
}


