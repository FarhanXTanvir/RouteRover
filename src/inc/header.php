<!-- -----------Header Section---------- -->
<header>
  <!-- ----------- Header Cover---------- -->
  <div class="cover">
    <h1>R<span>oute</span> R<span>over</span></h1>
    <p>Your one-stop travel companion</p>
  </div>
  <?php
  if (isset($_SESSION["admin"])) {
    echo "
            <nav class='top-nav'>
              <ul>
                <li><a href='index'>Home</a></li>
                <li><a href='services'>Services</a></li>
                <li><a href='about'>About</a></li>
                <li><a href='index#contact'>Contact</a></li>
                <div class='nv-button'>
                  <a href='profile?id=" . $_SESSION["id"] . "'><button><i class='fas fa-user-circle'></i> Profile </button></a>
                  <a href='logout'><button><i class='fas fa-sign-out-alt'></i> Logout </button></a>
                </div>
              </ul>
            </nav>";
  } elseif (isset($_SESSION["user"])) {
    echo "
            <nav class='top-nav'>
              <ul>
                <li><a href='index'>Home</a></li>
                <li><a href='services'>Services</a></li>
                <li><a href='about'>About</a></li>
                <li><a href='index#contact'>Contact</a></li>
                <div class='nv-button'>
                  <a href='profile?id=" . $_SESSION["id"] . "'><button><i class='fas fa-user-circle'></i> Profile </button></a>
                  <a href='logout'><button><i class='fas fa-sign-out-alt'></i> Logout </button></a>
                </div>
              </ul>
            </nav>";
  } else {
    echo "
            <nav class='top-nav'>
              <ul>
                <li><a href='index'>Home</a></li>
                <li><a href='services'>Services</a></li>
                <li><a href='about'>About</a></li>
                <li><a href='index#contact'>Contact</a></li>
                <div class='nv-button'>
                  <a href='login'><button class='custom-button'>Login</button></a>
                  <a href='register'><button class='custom-button'>Register</button></a>
                </div>
              </ul>
            </nav>";
  }
  ?>
  <!-- Navigation bar -->
</header>