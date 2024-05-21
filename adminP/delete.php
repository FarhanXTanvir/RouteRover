<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete!</title>
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      height: 100vh;
    }

    form {
      box-shadow: 0 0 0.5rem black;
      padding: 1rem;
      background: whitesmoke;
      border-radius: 0.4rem;
      font-size: 1.3rem;
      text-align: center;
    }

    .afterMsg {
      box-shadow: 0 0 0.5rem black;
      padding: 1rem;
      background: whitesmoke;
      border-radius: 0.4rem;
      font-size: 1.3rem;
      text-align: center;
      margin-top: 1rem;
    }

    input {
      padding: 0.4rem;
      margin-right: 0.3rem;
      font-size: 1.3rem;
      background: red;
    }
  </style>
</head>

<body>
  <?php if (isset($_GET["route"])): ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="warning">
        <input type="hidden" name="delete" value="<?php echo isset($_GET["route"]) ? trim($_GET["route"]) : 0; ?>" />
        <p>Are you sure you want to delete this route?</p>
        <p>
          <input type="submit" value="Yes">
          <a href="../admin.php">No</a>
        </p>
      </div>
    </form>
  <?php endif; ?>
  <?php
  if (isset($_POST['delete'])) {
    $tableName = "রুট" . $_POST['delete'];
    require_once '../connect.php';
    $sql = "DROP TABLE IF EXISTS `$tableName`";
    $result = mysqli_query($con, $sql);
    echo "<div class='afterMsg'>";
    if ($result) {
      echo "Table deleted successfully<br>";
    } else {
      echo "Error deleting table: " . mysqli_error($con);
    }
    echo "<a href='../admin.php'><button>Back</button></a></div>";
    $con->close();
    $routes = json_decode(file_get_contents('../script/routes.json'), true);
    unset($routes[$_POST['delete']]);
    $jsonData = json_encode($routes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    $jsonData = str_replace('    ', '  ', $jsonData);
    file_put_contents('../script/routes.json', $jsonData);
  }
  ?>
</body>

</html>