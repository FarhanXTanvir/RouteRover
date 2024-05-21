<?php
$fareTable = "";
function getRouteTable($route, $con)
{
  $tableName = "রুট" . $route;
  $sql = "SELECT * FROM `$tableName`";
  $result = mysqli_query($con, $sql);
  $routeTable = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
  $con = require_once '../connect.php';
  $routeTable = getRouteTable($route, $con);
  if (isset($_GET['route']) && !isset($_GET['update'])) {
    $fares = getDbFare($routeTable);
    $fareTable = "Current Route: $route <br>";
    // $con->close();
  }
  if (isset($_GET['update'])) {
    $fareTable = "Update Route: $route <br>";
    $inputFares = isset($_GET['inputFares']) ? $_GET['inputFares'] : [];
    $fareTable = "Edit: $route <br>";
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
        // Update fare where location equals departure
        $sql = "UPDATE `রুট$route` SET `$destination` = '$fare' WHERE `location` = '$departure'";
        mysqli_query($con, $sql);

        // Update fare where location equals destination
        $sql = "UPDATE `রুট$route` SET `$departure` = '$fare' WHERE `location` = '$destination'";
        mysqli_query($con, $sql);
        $i++;
        // $con->close();
      }
    }
    $routeTable = getRouteTable($route, $con);
    $con->close();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Route</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/fontawesome/fontawesome.css" />

  <!-- Google Fonts --> <!-- Poppins -->
  <link rel="stylesheet" href="../assets/fonts/fonts.css" />

  <link rel="stylesheet" href="adminRoute.css">

</head>

<body>
  <h1>Update Route</h1>
  <div class="route">
    <?php
    $i = 1;
    echo "
    <form>
    <h3>রুট <input type='text' name='route' value='$route' readonly></h3>
    <table>
    <tr><th>id</th><th>Departure</th><th>Destination</th><th>Fare</th></tr>";
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
        echo <<<FT
        <tr>
          <td>$i</td>
          <td>$departure</td>
          <td>$destination</td>
          <td class='fare' onclick='input(this)'>$fare</td>
        </tr>
        FT;

        $i++;
        $fares[$departure][$destination] = $fare; // Store fare in 2D array
      }
    }
    echo "</table>";
    ?>
    <button type="submit" id="updateRoutes" name="update" onclick="location.href='<?php echo $url; ?>'">Update</button>
    <?php echo "</form>" ?>
    <a href="../admin.php"><button id="back">Back</button></a>
    <?php echo "<p>$fareTable</p>"; ?>
  </div>
  <script>
    function input(element) {
      if (element.innerHTML.includes('input')) return;
      let fare = element.innerText;
      element.innerHTML = `
      <input type='text' name='inputFares[]' placeholder='${fare}'> 
      <table style="display: inline-block;">
        <tr><td><i class="fa-solid fa-xmark"></i></td></tr>
        <tr><td><i class="fa-solid fa-check"></i></td></tr>
      </table>`;
    }
  </script>
</body>

</html>