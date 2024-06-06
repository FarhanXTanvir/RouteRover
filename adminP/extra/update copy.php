<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $jsonRoutes = json_decode(file_get_contents('../script/routes.json'), true);
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
      print_r($route);
      echo "<br>\n";
      updateRoute($route);
    }
  }

  if (isset($_POST["allRoutes"])) {
    echo "allroute condition passed <br>\n";

    $allRoutes = json_decode($_POST["allRoutes"], true); // Convert the JSON string to an associative array

    if ($allRoutes) {
      updateRoutes($allRoutes);
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
    } else {
      echo "Route is empty";
    }
  }
  $jsonData = json_encode($jsonRoutes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  $jsonData = str_replace('    ', '  ', $jsonData);
  file_put_contents('../script/routes.json', $jsonData);
}


