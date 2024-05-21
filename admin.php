<?php
// Start the session
// $location = "admin.php";
// include './validators/auth_check';
// require_once './validators/config.php';
session_start();
include './validators/check_cookie.php';
if (isset($_SESSION["username"])) {
  if ($_SESSION['role'] === "user") {
    header('Location: user');
  }
} else {
  header('Location: login');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Dashboard | Admin </title>

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
  <link rel="manifest" href="favicon_io/site.webmanifest">

  <?php include 'src/inc.php'; ?>
  <link rel="stylesheet" href="css/admin.css">

</head>

<?php include 'src/inc/header.php'; ?>
<section id="ap">
  <h1>Admin Panel</h1>
  <?php echo "<h3 style='color: red; text-align: center; font-size: 2rem; margin: 1rem;'>Hey " . $_COOKIE['username'] . " " . $_COOKIE['id'] . "!</h3>"; ?>
  <div class="container">
    <h2>Routes</h2>
    <div class="content">
      <div class="table routes">
        <a href="./adminP/create.php"><button class="addToTable">
            <!-- <i class="fa-solid fa-plus"></i> -->
            + Add Route
          </button></a>
        <table>
          <thead>
            <tr>
              <th> Route No. </th>
              <th class='act'> Actions </th>
            </tr>
          </thead>
          <?php
          $jsonRoutes = json_decode(file_get_contents('script/routes.json'), true);
          foreach ($jsonRoutes as $route => $locations) {
            echo "<tr>";
            echo "<td> রুট$route </td>";
            echo "
            <td class='act'd> <a href='./adminP/updateRoute.php?route=$route' title='Update Record'><i class='fa-solid fa-pencil'></i></a>
            </a><a href='./adminP/delete.php?route=$route' title='Delete Record'><i class='fa-solid fa-trash'></i></a> 
            </td>";
            echo "</tr>";
          }
          ?>
        </table>
      </div>
    </div>
    <div class="operations">
      <a href="./adminP/updateRoutes.php?update" style="width: 100%; text-align:center;"><button
          id="updateRoutes">Update</button></a>
      <a href="admin.php?open" style="width: 100%; text-align:center;"><button id="openFile">See All Routes
        </button></a>
    </div>
    <div class="seeRoutes">
      <?php
      if (isset($_GET['open'])) {
        $routes = json_decode(file_get_contents('./script/routes.json'), true);
        echo "
        <h2>All Routes</h2>
        <div class='content'>
        <div class='table'>
        <table>
        <thead><tr><th> Route No. </th><th> Locations </th></tr></thead>";
        foreach ($routes as $route => $locations) {
          echo "<tr>";
          echo "<td> রুট$route </td>";
          echo "<td>";
          foreach ($locations as $location) {
            echo "$location, ";
          }
        }
        echo "</td></tr></table></div></div>";
      }
      ?>
    </div>
  </div>
</section>
<!-- ----------------- Footer Section --------------- -->
<?php include 'src/inc/footer.php'; ?>
</body>

</html>