<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  
  <!-- Font Family -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <title>Document</title>
</head>
<body>
  <header>
    <div class="cover">
      <h1>R<span>oute</span> R<span>over</span></h1>
      <p>Your one-stop travel companion</p>
    </div>
 
        <?php
          if(isset($_SESSION["admin"])){
            echo "
            <nav class='top-nav'>
              <ul>
                <li><a href='index.php'>Home</a></li>
                <li><a href='services.php'>Services</a></li>
                <li><a href='about.php'>About</a></li>
                <li><a href='index.php#contact'>Contact</a></li>
                <div class='nv-button'>
                  <a href='profile.php'><button><i class='fas fa-user-circle'></i> Profile </button></a>
                  <a href='logout.php'><button><i class='fas fa-sign-out-alt'></i> Logout </button></a>
                </div>
              </ul>
            </nav>";
          }
          elseif(isset($_SESSION["user"])){
            echo "
            <nav class='top-nav'>
              <ul>
                <li><a href='index.php'>Home</a></li>
                <li><a href='services.php'>Services</a></li>
                <li><a href='about.php'>About</a></li>
                <li><a href='index.php#contact'>Contact</a></li>
                <div class='nv-button'>
                  <a href='profile.php'><button><i class='fas fa-user-circle'></i> Profile </button></a>
                  <a href='logout.php'><button><i class='fas fa-sign-out-alt'></i> Logout </button></a>
                </div>
              </ul>
            </nav>";
          }
          else{
            echo "
            <nav class='top-nav'>
              <ul>
                <li><a href='index.php'>Home</a></li>
                <li><a href='services.php'>Services</a></li>
                <li><a href='about.php'>About</a></li>
                <li><a href='index.php#contact'>Contact</a></li>
                <div class='nv-button'>
                  <a href='login.php'><button class='custom-button'>Login</button></a>
                  <a href='register.php'><button class='custom-button'>Register</button></a>
                </div>
              </ul>
            </nav>";
          }
        ?>
    <!-- Navigation bar -->
    
  </header>
  </body>
