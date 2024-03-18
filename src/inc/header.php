<!-- -----------Header Section---------- -->
  <header>
    <!-- ----------- Header Cover---------- -->
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
                  <a href='profile.php?username=" . $_SESSION["admin"] . "'><button><i class='fas fa-user-circle'></i> Profile </button></a>
                  <a href='logout.php'><button><i class='fas fa-sign-out-alt'></i> Logout </button></a>
                </div>
              </ul>
            </nav>";
          }
          elseif (isset($_SESSION["user"])) {
            echo "
            <nav class='top-nav'>
              <ul>
                <li><a href='index.php'>Home</a></li>
                <li><a href='services.php'>Services</a></li>
                <li><a href='about.php'>About</a></li>
                <li><a href='index.php#contact'>Contact</a></li>
                <div class='nv-button'>
                  <a href='profile.php?id=" . $_SESSION["user"] . "'><button><i class='fas fa-user-circle'></i> Profile </button></a>
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
