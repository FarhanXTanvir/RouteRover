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
  <script src="./assets/jquery.js"></script>
</head>

<?php include 'src/inc/header.php'; ?>
<section id="ap">
  <h1>Admin Panel</h1>
  <?php echo "<h3 style='color: red; text-align: center; font-size: 2rem; margin: 1rem;'>Hey " . $_COOKIE['username'] . "!</h3>"; ?>
  <div class="container">
    <!-- Collapsable Route Information List -->
    <div class="allRoutes">
      <div class="group open">
        <div class="header">All Routes <i class="closable fa-solid fa-minus"></i> </div>
        <div class="content">
          <?php
          $jsonRoutes = json_decode(file_get_contents('script/routes.json'), true);
          foreach ($jsonRoutes as $route => $locations) : ?>
            <div class="group">
              <div class="header"><?php echo "রুট$route"; ?> <i class="openable fa-solid fa-plus"></i></div>
              <div class="content">
                <i class="fa-solid fa-trash-alt deleteRoute" title="Delete Route"></i>
                <div class="break"></div>
                <form method="post" data-route="<?php echo $route; ?>">
                  <?php
                  foreach ($locations as $location) {
                    echo "
                    <span class='input-field' tabindex='0'>
                      <input type='text' name='location' class='location' value='$location' area-label='location' title='Click to Edit'>
                    </span>";
                  }
                  ?>
                  <i class="fa-regular fa-square-plus addLocation" title="Add Location"></i>
                </form>
                <div class="group fareBlock">
                  <div class="fareBlockHeader" name="showFare" class="showFare">Set/Show Fares <i class="openable fa-solid fa-plus"></i>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          <div class="group">
            <div class="header addRoute"><i class="fa-solid fa-square-plus"></i></div>
          </div>
        </div>
        <input class="submitRoute" type="submit" name="submitRoute" value="Submit">
      </div>
      <input type="submit" value="Update DB" name="updateDb" class="updateDb">
      <input type="submit" value="Generate Random Values" name="generateRandomValues" class="generateRandomValues">
    </div>
  </div>
</section>
<!-- ----------------- Footer Section --------------- -->
<?php include 'src/inc/footer.php'; ?>
<script src="./script/admin.js"></script>
</body>

</html>