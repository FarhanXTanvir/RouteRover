<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Route</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="adminRoute.css">
</head>

<body>
  <div class="form">
    <h3>New Route</h3>
    <form>
      <div class="input">
        <input type="Number" id="route" min="0" area-label="Route" placeholder="Route No.">
      </div>
      <div class="pair">
        <i class="close fas fa-times-circle"></i>
        <div class="input">
          <label for="departure">Departure</label>
          <input type="text" id="departure" class="departure">
        </div>
        <div class="input">
          <label for="destination">Destination</label>
          <input type="text" id="destination" class="destination">
        </div>
        <div class="input" class="destination">
          <label for="fare">Fare</label>
          <input type="Number" min="0" id="fare" class="fare">
        </div>
        <i class="addLocation fas fa-plus-circle"></i>
      </div>
      <input type="submit" id="createRoute" placeholder="Create">
    </form>
  </div>
  <script>
    const pairTemp = () => `
      <div class="pair">
      <i class="close fas fa-times-circle"></i>
        <div class="input">
          <label for="departure">Departure</label>
          <input type="text" id="departure">
        </div>
        <div class="input">
          <label for="destination">Destination</label>
          <input type="text" id="destination">
        </div>
        <div class="input">
          <label for="fare">Fare</label>
          <input type="Number" min="0" id="fare">
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
        const pairs = document.querySelectorAll(".pair");
        const route = parseInt(document.querySelector("#route").value);
        pairs.forEach((pair, index) => {
          const departure = pair.querySelector("#departure").value;
          const destination = pair.querySelector("#destination").value;
          const fare = parseInt(pair.querySelector("#fare").value);
          console.log(route, departure, destination, fare);
        });
      }
    });
  </script>
  <?php
  if (isset($_POST["route"])) {
    $route = $_POST['route'];
    $tableName = "রুট" . $route;
    $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (id INT AUTO_INCREMENT PRIMARY KEY, location VARCHAR(255) UNIQUE";
    $location = "INSERT IGNORE INTO `$tableName` (location) VALUES ";
  }
  ?>
</body>

</html>