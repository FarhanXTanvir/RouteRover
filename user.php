<?php
  // We need to use sessions, so you should always start sessions using the below code.
  session_start();
  // If the user is not logged in redirect to the login page...
  if (!isset($_SESSION["user"])) {
    header('Location: login.php');
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Home | RouteRover </title>

    <!-- Style Sheet -->
    <link rel="stylesheet" href="css/style.css">
    <?php include 'src/lib/lib.html';?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font Family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
<?php include 'src/inc/header.php'; ?>
<section class= "main">
    <div class="row">
      <div class="col">
        <div class="route-finder" id="route-finder" style="height:auto;">
          <h1>Welcome to RouteRover!</h1>
          <p class="welcome">
              Want to find your Route no., Available transports and Pricing details for going to your next destination? 
              RouteRover is here on your service!! Get everything on your fingertips with a single click. 
          </p>
          <h2>Route Finder</h2>
            <div class="form">
              <input class="input-field" name="areas" list="areas" placeholder="Where are you now?">
              <datalist id="areas">
                <option value="Agrabad">
                <option value="Bahaddarhut">
                <option value="Boropool">
                <option value="Chotopool">
                <option value="Chowmuhni">
                <option value="Chawkbazar">
                <option value="GEC Mor">
                <option value="2 No. Gate">
                <option value="Jamalkhan">
                <option value="Milermatha">
                <option value="Muradpur">
                <option value="Rastarmatha">
                <option value="Wasa">
              </datelist>
            </div> 
            <div class="form">
              <input class="input-field" name="areas" list="areas" placeholder="Your destination?">
              <datalist id="areas">
                <option value="Agrabad">
                <option value="Bahaddarhut">
                <option value="Boropool">
                <option value="Chotopool">
                <option value="Chowmuhni">
                <option value="Chawkbazar">
                <option value="GEC Mor">
                <option value="2 No. Gate">
                <option value="Jamalkhan">
                <option value="Milermatha">
                <option value="Muradpur">
                <option value="Rastarmatha">
                <option value="Wasa">
              </datelist>
            </div>
            <button> Search </button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div id="contact" class="contact">
          <h3> Contact Form </h3>
          <p>While using our services if you face any inconvenience then please inform us.</p>
          <div class="form">
            <form action="contact.php" method="post">
              <div class="input">
                <label for="email">Email: </label>
                <input type="email" placeholder="yourname@email.com" name = "email" required> <br>
              </div>
              <div class="input">
                <label for="message"> Message: </label>
                <textarea placeholder="Type here..." name="comments" cols="25" rows="10"></textarea>
              </div>
              <div class="input-btn">
                <br><input type="submit">
              </div>
            </form>
          </div>
 
        </div>
      </div>
    </div>   
  </section>
  <?php include 'src/inc/footer.php'; ?>
</body>
</html>