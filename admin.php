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

  <!-- Font Family -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
  <link rel="manifest" href="favicon_io/site.webmanifest">

  <!-- Custom CSS -->

  <?php include 'src/inc.php'; ?>
  <link rel="stylesheet" href="css/admin.css">

</head>

<body>
  <?php include 'src/inc/header.php'; ?>
  <section id="ap">
    <h2>Admin Panel</h2>
    <?php echo "<h3 style='color: red; text-align: center; font-size: 2rem; margin: 1rem;'>Hey " . $_COOKIE['username'] . " " . $_COOKIE['id'] . "!</h3>"; ?>
    <div class="container">
      <h3>Routes</h3>
      <div class="content">
        <div class="table" style="width: 80%;">
          <button class="addToTable">
            <!-- <i class="fa-solid fa-plus"></i> -->
            + Add Route
          </button>
          <table>
            <thead>
              <tr>
                <th> Route No. </th>
                <th class='act'> Actions </th>
              </tr>
            </thead>
            <?php
            for ($i = 1; $i <= 5; $i++) {
              echo "<tr>";
              echo "<td> Route $i </td>";
              echo "<td class='act'd> <a href='admin.php?id=$i' title='Update Record'><i class='fa-solid fa-pencil'></i></a> <a href='admin.php?id=$i' title='View Record'><i class='fa-solid fa-user'></i></a> <a href='admin.php?id=$i' title='Delete Record'><i class='fa-solid fa-trash'></i></a> </td>";
              echo "</tr>";
            }
            ?>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!-- ----------------- Footer Section --------------- -->
  <?php include 'src/inc/footer.php'; ?>
</body>

</html>