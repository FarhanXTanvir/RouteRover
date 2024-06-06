<?php
if (isset($_POST["locations"])) {
  $routeNo = $_POST["route"];
  $locations = $_POST["locations"];

  $routes = json_decode(file_get_contents('../script/routes.json'), true);

  if (array_key_exists($routeNo, $routes)) {
    // $routes[$routeNo] = array_merge($routes[$routeNo], $locations);
    // Merge one by one by checking if the location already exists
    foreach ($locations as $location) {
      if (!in_array($location, $routes[$routeNo])) {
        $routes[$routeNo][] = $location;
      }
    }
  } else {
    $routes[$routeNo] = $locations;
  }
  // Save the updated routes array to routes.json
  $jsonData = json_encode($routes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  $jsonData = str_replace('    ', '  ', $jsonData);
  file_put_contents('../script/routes.json', $jsonData);
  header("Location: ./updateRoutes.php?update");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Route</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/fontawesome/fontawesome.css" />

  <!-- Google Fonts --> <!-- Poppins -->
  <link rel="stylesheet" href="../assets/fonts/fonts.css" />

  <link rel="stylesheet" href="adminRoute.css">
</head>

<body>
  <div class="form">
    <h3>New Route</h3>
    <form>
      <div class="input">
        <input type="text" id="route" area-label="Route" placeholder="Route No.">
      </div>
      <div class="pair">
        <i class="close fas fa-times-circle"></i>
        <div class="input">
          <label for="location">Location</label>
          <input type="text" id="location">
        </div>
        <i class="addLocation fas fa-plus-circle"></i>
      </div>
      <input type="submit" id="createRoute" placeholder="Create">
    </form>
    <a href="../admin.php"><button id="back">Back</button></a>
  </div>
  <script>
    const pairTemp = () => `
      <div class="pair">
      <i class="close fas fa-times-circle"></i>
        <div class="input">
          <label for="location">Location</label>
          <input type="text" id="location">
        </div>
          <i class="addLocation fas fa-plus-circle"></i>
      </div>
    `;
    document.addEventListener("click", (event) => {
      if (event.target.matches(".close")) {
        const close = event.target.closest(".pair");
        pairs = document.querySelectorAll(".pair");
        if (pairs.length > 1) close.remove();
      }
      if (event.target.matches(".addLocation")) {
        const close = event.target.closest(".pair");
        close.insertAdjacentHTML("afterend", pairTemp());
      }
      if (event.target.matches("#createRoute")) {
        event.preventDefault();
        const routeNo = document.querySelector("#route").value;
        const pairs = document.querySelectorAll(".pair");
        const locations = [];
        pairs.forEach((pair, index) => {
          const location = pair.querySelector("#location").value;
          // Don't push empty locations and exit the forEach loop
          if (!location || !routeNo) return;

          // Add location to the locations array
          locations.push(location);
        });
        // post the route and locations to the server in create.php
        if (!locations.length) return;
        // console.log(routeNo + ": " + locations,);
        fetch('create.php', {
          method: 'POST',
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
            locations: locations,
            routeNo: routeNo
          }),
        }).then(response => {
          if (response.redirected) {
            window.location.href = response.url;
          }
        });
      }
    });
  </script>
</body>

</html>