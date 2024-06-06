// ---------------
/*
if (isset($_POST["route"])) {
$routeNo = $_POST["route"];
echo ">> Route No.:" . $routeNo . "<br>";
$routes = json_decode(file_get_contents('../script/routes.json'), true);

if (array_key_exists($routeNo, $routes)) {
echo ">> Route No. already exists <br>";

// As route already exists then check if locations are posted for modifications
if (isset($_POST["submitLocation"])) {
echo ">> Locations Update Requested <br>";
if (!isset($_POST["locations"])) {
echo ">> But Locations not found... <br>";
} else {
$locations = $_POST["locations"];
foreach ($locations as $location) {
if (!in_array($location, $routes[$routeNo])) {
// push the location to the routes[$routeNo]
$routes[$routeNo][] = $location;
echo $location . " ";
} else {
echo $location . ">> Location already exists<br>";
}
}
echo ">> Locations Updated <br>";
$jsonData = json_encode($routes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
$jsonData = str_replace(' ', ' ', $jsonData);
file_put_contents('../script/routes.json', $jsonData);
}
} else if (isset($_POST["submitRoute"])) {
echo "Route Update Requested <br>";
}
} else {
echo "Route No. does not exists <br>";
// Create a new route and push the locations
if (isset($_POST["submitLocation"])) {
echo ">> Locations Update Requested for new route<br>";
if (!isset($_POST["locations"])) {
$routes[$routeNo] = [];
echo ">> But Locations not found, null value initiated... <br>";
} else {
$locations = $_POST["locations"];
$routes[$routeNo] = $locations;

$jsonData = json_encode($routes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
$jsonData = str_replace(' ', ' ', $jsonData);
file_put_contents('../script/routes.json', $jsonData);
echo ">> Locations Updated <br>";
}
exit();
} else if (isset($_POST["submitRoute"])) {
echo "Route Update Requested <br>";
exit();
}
}
// Access all the locations of the routes and find unique values and sort them then put them in
../script/uniqueLocations.json
$uniqueValues = [];
foreach ($routes as $route) {
foreach ($route as $location) {
if (!in_array($location, $uniqueValues)) {
$uniqueValues[] = $location;
}
}
}
sort($uniqueValues);

// Then put them in ../script/unique_values.
$jsonData = json_encode($uniqueValues, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
$jsonData = str_replace(' ', ' ', $jsonData);
file_put_contents('../script/uniqueLocations.json', $jsonData);

echo ">> Unique Values Updated <br>";
}
*/
// -------------

/*
This one works too! Sending as json data and decoding it in PHP
// Get the raw POST data
$rawData = file_get_contents('php://input');

// Decode the JSON string
$routeData = json_decode($rawData, true);

if ($routeData) {
// Get the route, locations, and removedLocations data
$route = $routeData['route'] ?? null;
$locations = $routeData['locations'] ?? null;
$removedLocations = $routeData['removedLocations'] ?? null;

echo "Route: $route, Locations: ";
print_r($locations);
echo ", Removed Locations: ";
print_r($removedLocations);
echo "<br>";
} else {
echo "RouteData not found<br>";
// header("Location: ../admin.php");
exit();
}
*/