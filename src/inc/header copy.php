<!-- -----------Header Section---------- -->
<header>
  <!-- ----------- Header Cover---------- -->
  <div class="cover">
    <h1>R<span>oute</span> R<span>over</span></h1>
    <p>Your one-stop travel companion</p>
  </div>
  <div class="nav-binder">
    <nav class='top-nav'>
      <ul>
        <?php if (!isset($_COOKIE["super"])) : ?>
          <li><a href='index'>Home</a></li>
          <li><a href='services'>Services</a></li>
          <li><a href='about'>About</a></li>
          <?php
          if (isset($_COOKIE["role"])) {
            if ($_COOKIE["role"] === "admin") {
              echo "
        <li class='nv-button'>
          <a href='profile?id=" . $_COOKIE["id"] . "'><button><i class='fas fa-user-circle'></i></button></a>
          <a href='logout'><button><i class='fas fa-sign-out-alt'></i> Logout </button></a>
        </li>
        ";
            } elseif ($_COOKIE["role"] === "user") {
              echo "
        <li><a href='index#contact'>Contact</a></li>
        <li class='nv-button'>
          <a href='profile?id=" . $_COOKIE["id"] . "'><button><i class='fas fa-user-circle'></i></button></a>
          <a href='logout'><button><i class='fas fa-sign-out-alt'></i> Logout </button></a>
        </li>
        ";
            }
          } else {
            echo "
        <li><a href='index#contact'>Contact</a></li>
        <li class='nv-button'>
          <a href='login'><button class='custom-button'>Login</button></a>
          <a href='register'><button class='custom-button'>Register</button></a>
        </li>
        ";
          }
          ?>
        <?php else : ?>
          <li><a href='index'>Home</a></li>
          <li><a href='services'>Services</a></li>
          <li><a href='about'>About</a></li>
          <li class='nv-button'>
            <a href='super/logout.php'><button><i class='fas fa-sign-out-alt'></i> Logout </button></a>
          </li>
          ";
        <?php endif; ?>
      </ul>
    </nav>
    <i class="fa-solid fa-caret-right slider hidden"></i>
  </div>
  <!-- Navigation bar -->
</header>