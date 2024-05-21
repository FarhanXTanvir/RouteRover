<?php
if (isset($_GET['update'])) {
  $sqlAll = " ";
  // Decode the JSON data into a PHP array
  $jsonData = file_get_contents('../script/routes.json');
  // Decode the JSON data into a PHP array
  $routes = json_decode($jsonData, true);
  // If the file doesn't exist, compute the unique values

  // Initialize an associative array to hold unique values
  $uniqueValues = array();
  require_once '../connect.php';
  // Loop through each item in the data array
  foreach ($routes as $route => $locations) {
    $tableName = "রুট" . $route;

    // Start the SQL query
    $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (id INT AUTO_INCREMENT PRIMARY KEY, location VARCHAR(255) UNIQUE";

    $insert = "INSERT IGNORE INTO `$tableName` (location) VALUES ";
    foreach ($locations as $location) {
      // Add a column for each value in the data array
      $sql .= ", `$location` VARCHAR(255)";
      $insert .= "('$location'), ";

      // Use the value as the key in the associative array
      // This will automatically remove duplicates
      $uniqueValues[$location] = true;
    }
    $insert = rtrim($insert, ", ") . ";";
    // End the SQL query
    $sql .= "); " . $insert . " ";

    $sqlAll .= $sql . " ";

    // Execute the SQL query
    if ($con->multi_query($sql) === TRUE) {
      do {
        if ($result = $con->store_result()) {
          $result->free();
        }
      } while ($con->more_results() && $con->next_result());
      $sqlAll .= "<br>Table $tableName created successfully<br><br>";
    } else {
      $sqlAll .= "Error creating table $tableName: " . $con->error;
    }
  }
  // Close the connection
  $con->close();

  // Get the keys of the associative array, which are the unique values
  $uniqueValues = array_keys($uniqueValues);

  // Sort the unique values
  sort($uniqueValues);

  // Save the unique values to a file
  $jsonData = json_encode($uniqueValues, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  $jsonData = str_replace('    ', '  ', $jsonData);
  file_put_contents('../script/unique_values.json', $jsonData);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Updated Locations</title>
  <style>
    body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    h1 {
      text-align: center;
      width: 100%;
      /* background: red; */
    }

    div.container {
      display: flex;
      justify-content: center;
      width: 80%;
      /* background: red; */
    }

    div {
      width: 20%;
      /* background: green; */
      text-align: justify;
    }
  </style>
</head>

<body>
  <h1>Updated Locations</h1>
  <div class="container">
    <div>
      <?php
      // If the file exists, read the unique values from the file
      if (file_exists('../script/unique_values.json')) {
        $count = 0;
        $uniqueValuesJson = json_decode(file_get_contents('../script/unique_values.json'), true);
        foreach ($uniqueValuesJson as $location) {
          echo $count . ". " . $location . "<br>";
          $count++;
        }
      } else {
        echo "<h3 style='text-align:center;'>No Unique locations found!</h3>";
      }
      ?>
    </div>
  </div>
  <a href="../admin.php"><button id="back">Back</button></a>
</body>

</html>