<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> eticket | RouteRover </title>

    <!-- Style Sheet -->
    <link rel="stylesheet" href="css/eticket.css">
    <?php include 'src/lib/lib.html'; ?>
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
  <section id="#eticket" class="et">
    <h2><span class="spane">e</span><span class="spanT">Ticket</span></h2>
    <div class="row">
      <form action="RRSearch.php" method="post">
        <div class="from">
          <input type="search" name="fromplace" id="fromplace" placeholder="From">
          <input type="time" name="fromtime" id="fromtime"> 
          <input type="date" name="fromdate" id="fromdate">
        </div>
        <div class="to">
          <input type="search" name="toplace" id="toplace" placeholder="To">
          <input type="time" name="totime" id="totime"> 
          <input type="date" name="todate" id="todate">
        </div>
        <button> Search </button>
      </form>
    </div>  
    <div class="row">
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fas fa-bus"></i>
          </div>
          <h3>Bus</h3>
          <p>
            Description
          </p>
        </div>
      </div>
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fas fa-train"></i>
          </div>
          <h3>Train</h3>
          <p>
            Description
          </p>
        </div>
      </div>
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-motorcycle"></i>
          </div>
          <h3>Bike</h3>
          <p>
            Description
          </p>
        </div>
      </div>
    </div>
  </section>
<!-- ----------------- Footer Section --------------- -->
<?php include 'src/inc/footer.php'; ?>
</body>
</html>