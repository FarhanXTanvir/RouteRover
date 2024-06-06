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

  <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
</head>

<?php include 'src/inc/header.php'; ?>
<section id="ap">
  <h1>Admin Panel</h1>
  <div class="container">
    <!-- Collapsable Route Information List -->
    <div class="allRoutes">
      <span class='input-field'>
        <input type='text' class="myInput" id="enableButton" value='location' area-label='location' disabled>
        <!-- <input type="text" id="myInput" disabled> -->
        <!-- <button id="enableButton">Enable Input</button> -->
      </span>
    </div>
</section>
<!-- ----------------- Footer Section --------------- -->
<?php include 'src/inc/footer.php'; ?>
<script>
  const inputField = document.querySelector(".myInput");
  const enableButton = document.getElementById("enableButton");

  enableButton.addEventListener("click", function () {
    inputField.disabled = false;
    // Optional: Focus the input field after enabling
    inputField.focus();
  });
</script>

</body>

</html>