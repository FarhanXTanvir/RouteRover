<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $fareTable = "";
  require_once ('../connect.php');
  $route = $_GET['route'];
  $tableName = "রুট" . $route;
  $sql = "SELECT * FROM `$tableName`";
  $result = mysqli_query($con, $sql);
  $routeTable = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $fares = [];
  if (isset($_GET['update'])) {
    $inputFares = $_GET['inputFares'];
    $result = mysqli_query($con, $sql);
    $routeTable = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $i = 0;
    foreach ($routeTable as $row) {
      $departure = $row['location'];
      $counter = 0;
      foreach ($row as $destination => $fare) {
        if ($counter < 2) { // Skip the first two fields
          $counter++;
          continue;
        } else if ($destination === $departure || (isset($fares[$destination][$departure]))) {
          continue;
        }
        $fare = ($fare === null) ? 'N/A' : $inputFares[$i];
        $fares[$departure][$destination] = $fare; // Store fare in 2D array
        $i++;
      }
    }
    foreach ($fares as $departure => $destinations) {
      foreach ($destinations as $destination => $fare) {
        $sql = "UPDATE routes SET fare = '$fare' WHERE location = '$departure' AND destination = '$destination'";
        if (!mysqli_query($con, $sql)) {
          $fareTable = "Error updating record: " . mysqli_error($con);
        }
      }
    }
  } else if (isset($_GET['route'])) {

  }
  $con->close();
}
?>
<?php
function getRouteTable($route)
{
$con = include '../connect.php';
$tableName = "রুট" . $route;
$sql = "SELECT * FROM `$tableName`";
$result = mysqli_query($con, $sql);
$routeTable = mysqli_fetch_all($result, MYSQLI_ASSOC);
$con->close();
return $routeTable;
}
function getDbFare($routeTable)
{
foreach ($routeTable as $row) {
$departure = $row['location'];
$counter = 0;
foreach ($row as $destination => $fare) {
if ($counter < 2) { // Skip the first two fields $counter++; continue; } else if ($destination===$departure ||
  (isset($fares[$destination][$departure]))) { continue; } $fare=($fare===null) ? 'N/A' : $fare;
  $fares[$departure][$destination]=$fare; // Store fare in 2D array } } return $fares; } function updateRoute($route,
  $fares) { $con=include '../connect.php' ; $tableName="রুট" . $route; foreach ($fares as $departure=> $destinations) {
  foreach ($destinations as $destination => $fare) {
  $sql = "UPDATE `$tableName` SET `$destination` = '$fare' WHERE `location` = '$departure'";
  mysqli_query($con, $sql);
  }
  }
  $con->close();
  }
  if (isset($_GET['route']) && !isset($_GET['update'])) {
  $route = $_GET['route'];
  $routeTable = getRouteTable($route);
  $fares = getDbFare($routeTable);
  $fareTable .= "Current Route: $route <br>";
  }
  if (isset($_GET['update'])) {
  $route = $_GET['route'];
  $inputFares = isset($_GET['inputFares']) ? $_GET['inputFares'] : array();
  updateRoute($route, $inputFares);
  $routeTable = getRouteTable($route);
  $fareTable .= "Route $route updated successfully!";
  }
  ?>
  <?php
$fareTable = "";
function getRouteTable($route)
{
  $con = include '../connect.php';
  $tableName = "রুট" . $route;
  $sql = "SELECT * FROM `$tableName`";
  $result = mysqli_query($con, $sql);
  $routeTable = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $con->close();
  return $routeTable;
}
function getDbFare($routeTable)
{
  foreach ($routeTable as $row) {
    $departure = $row['location'];
    $counter = 0;
    foreach ($row as $destination => $fare) {
      if ($counter < 2) { // Skip the first two fields
        $counter++;
        continue;
      } else if ($destination === $departure || (isset($fares[$destination][$departure]))) {
        continue;
      }
      $fare = ($fare === null) ? 'N/A' : $fare;
      $fares[$departure][$destination] = $fare; // Store fare in 2D array
    }
  }
  return $fares;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $route = $_GET['route'];
  $routeTable = getRouteTable($route);
  if (isset($_GET['route']) && !isset($_GET['update'])) {
    $fares = getDbFare($routeTable);
    $fareTable = "Current Route: $route <br>";
  }
  /*
  if (isset($_GET['update'])) {
    $route = $_GET['route'];
    $con = include '../connect.php';
    $fareTable = "Update Route: $route <br>";
    $inputFares = isset($_GET['inputFares']) ? $_GET['inputFares'] : [];
    $fareTable = "Edit: $route <br>";
    $routeTable = getRouteTable($route);
    $fares = [];
    $i = 0;
    foreach ($routeTable as $row) {
      $departure = $row['location'];
      $counter = 0;
      foreach ($row as $destination => $fare) {
        if ($counter < 2) { // Skip the first two fields
          $counter++;
          continue;
        } else if ($destination === $departure || (isset($fares[$destination][$departure]))) {
          continue;
        }
        $fare = ($fare === null) ? 'N/A' : $fare;
        $fares[$departure][$destination] = $fare; // Store fare in 2D array
        $fare = $inputFares[$i] ?? $fare;
        $fareTable .= "$departure to $destination: $fare <br>";
        $sql = "UPDATE `রুট$route` SET `$destination` = '$fare' WHERE `location` = '$departure'";
        mysqli_query($con, $sql);
        $i++;
      }
    }
  } */
}
?>