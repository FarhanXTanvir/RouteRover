/*
function updateFare($routeNo, $fareValues)
{
$tableName = "রুট" . $routeNo;
$con = require_once '../connect.php';
$sql = "SELECT * FROM $tableName";
$result = mysqli_query($con, $sql);
$routeTable = mysqli_fetch_all($result, MYSQLI_ASSOC);
$fares = [];

if (mysqli_num_rows($result) > 0) {
echo "
<div class='content fareBlockContent'>";
  foreach ($routeTable as $row) {
  $departure = $row['location'];

  echo <<<FT <div class="group">
    <div class="header">$departure <i class="openable fa-solid fa-plus"></i></div>
    <div class="content">
      FT;

      $counter = 0;
      foreach ($row as $destination => $fare) {
      if ($counter < 2) { // Skip the first two fields $counter++; continue; } else if ($destination===$departure ||
        (isset($fareValues[$destination][$departure]))) { continue; }
        $fare=$fareValues[$departure][$destination]==='N/A' ? null : $fareValues[$departure][$destination];
        $fares[$departure][$destination]=$fare; // Update the fare for the $destination column where row=$departure
        $sql="UPDATE `$tableName` SET `$destination` = '$fare' WHERE location = '$departure'" ; mysqli_query($con,
        $sql); // Update the fare for the $departure column where row=$destination
        $sql="UPDATE `$tableName` SET `$departure` = '$fare' WHERE location = '$destination'" ; mysqli_query($con,
        $sql); echo <<<FT <div class="farePair" data-destination="$destination" data-departure="$departure">
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
*/

/*
function updateFare($routeNo, $fareValues)
{
$tableName = "রুট" . $routeNo;
$con = require_once '../connect.php';
$sql = "SELECT * FROM $tableName";
$result = mysqli_query($con, $sql);
$routeTable = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (mysqli_num_rows($result) > 0) {
echo "
<div class='content fareBlockContent'>";
  foreach ($routeTable as $row) {
  $departure = $row['location'];

  echo <<<FT <div class="group">
    <div class="header">$departure <i class="openable fa-solid fa-plus"></i></div>
    <div class="content">
      FT;

      $counter = 0;
      foreach ($row as $destination => $fare) {
      if ($counter < 2) { // Skip the first two fields $counter++; continue; } else if ($destination===$departure) {
        continue; } // Check if a fare has already been generated for the reverse pair if
        (isset($fareValues[$destination][$departure])) { // Use the existing fare
        $fare=$fareValues[$destination][$departure]; } else { // Check if a fare has been set for the current pair if
        (isset($fareValues[$departure][$destination])) { // Assign the fare from the $fareValues array
        $fare=$fareValues[$departure][$destination]; } else { // If the fare is not set, assign 'N/A' $fare='N/A' ; } }
        $fare=$fareValues[$departure][$destination]==='N/A' ? null : $fareValues[$departure][$destination]; // Update
        the fare for the $destination column where row=$departure
        $sql="UPDATE `$tableName` SET `$destination` = '$fare' WHERE location = '$departure'" ; mysqli_query($con,
        $sql); echo <<<FT <div class="farePair" data-destination="$destination" data-departure="$departure">
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
*/
/*
h1 Latest
if (mysqli_num_rows($result) > 0) {
echo "
<div class='content fareBlockContent'>";
  foreach ($routeTable as $row) {
  $departure = $row['location'];

  echo <<<FT <div class="group">
    <div class="header">$departure <i class="openable fa-solid fa-plus"></i></div>
    <div class="content">
      FT;

      $counter = 0;
      foreach ($row as $destination => $fare) {
      if ($counter < 2) { // Skip the first two fields $counter++; continue; } else if ($destination===$departure) { //
        Skip the equal pair continue; } $fare=$fareValues[$departure][$destination]==='N/A' ? null :
        $fareValues[$departure][$destination]; // $fare=$fareValues[$departure][$destination]==='N/A' ? null :
        $fareValues[$departure][$destination]; // Update the fare for the $destination column where row=$departure
        $sql="UPDATE `$tableName` SET `$destination` = '$fare' WHERE location = '$departure'" ; mysqli_query($con,
        $sql); // Update the fare for the $departure column where row=$destination //
        $sql="UPDATE `$tableName` SET `$departure` = '$fare' WHERE location = '$destination'" ; // mysqli_query($con,
        $sql); echo <<<FT <div class="farePair" data-destination="$destination" data-departure="$departure">
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
<button type='none' class='submitFare' value='submitFare'>Submit Fare</button>";
"</div>";
}
/*