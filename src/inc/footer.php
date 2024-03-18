
<!-- ----------------- Footer Section --------------- -->
  <!-- ----------------- Footer Section --------------- -->
<?php
if(isset($_SESSION['user'])){
  echo "
  <footer>
    <!-- ----------------- Footer Top --------------- -->
      <div class='ftop'>
      <h2>Hi user</h2>
        <div class='footer-col'>
            <h4>Company</h4>
            <ul>
                <li><a href='#'>About us</a></li>
                <li><a href='#'>Our Services</a></li>
                <li><a href='#'>Privacy Policy</a></li>
                <li><a href='#'>Affiliate Programme</a></li>
            </ul>
        </div>
        <div class='footer-col'>
            <h4>Get Help</h4>
            <ul>
                <li><a href='#'>FAQ</a></li>
                <li><a href='#'>Shipping</a></li>
                <li><a href='#'>Returns</a></li>
                <li><a href='#'>Order Status</a></li>
                <li><a href='#'>Payment Options</a></li>
            </ul>
        </div>
        <div class='footer-col'>
            <h4>Online Shop</h4>
            <ul>
                <li><a href='#'>Watch</a></li>
                <li><a href='#'>Bag</a></li>
                <li><a href='#'>Shoes</a></li>
                <li><a href='#'>Dress</a></li>
            </ul>
        </div>
        <div class='footer-col'>
            <h4>Follow us</h4>
            <div class ='social-links'>
              <ul>
                <li><a href='https://www.facebook.com/RouteRover/' target='_blank'>
                  <i class='fab fa-facebook' tabindex='0'></i>
                </a></li>
                <li><a href='https://www.instagram.com/RouteRover/' target='_blank'>
                  <i class='fab fa-instagram' tabindex='0'></i>
                </a></li>
                <li><a href='#'>
                  <i class='fab fa-pinterest' tabindex='0' target='_blank'></i>
                </a></li>
                <li><a href='#'>
                  <i class='fab fa-youtube' tabindex='0' target='_blank'></i>
                </a></li>
                <li><a href='https://github.com/RouteRover' target='_blank'>
                  <i class='fab fa-github' tabindex='0'></i>
                </a></li>                                                      
                <li><a href='https://codepen.io/RouteRover' target='_blank'>
                  <i class='fab fa-codepen' tabindex='0'></i>
                </a></li>
              </ul>
            </div>
        </div>
    </div> 
    <!------------------- Footer Bottom --------------------->
    <div class='fbtm'>
      <div class='copyright'>
        <p>
          &copy; 2024 Route Rover. All rights reserved
        </p>
      </div>
      <div class='legal'>
        <ul>
          <li><a href='#'>Privacy Policy</a></li>
          <li><a href='#'>Terms & Condition</a></li>
          <li><a href='#'>Payment Methods</a></li>
        </ul>
      </div>
    </div>
  </footer>
  ";
}
elseif(isset($_SESSION['admin'])){
  echo "
  <footer>
    <!-- ----------------- Footer Top --------------- -->
      <div class='ftop'>
      <h2>Hi Admin</h2>
        <div class='footer-col'>
            <h4>Company</h4>
            <ul>
                <li><a href='#'>About us</a></li>
                <li><a href='#'>Our Services</a></li>
                <li><a href='#'>Privacy Policy</a></li>
                <li><a href='#'>Affiliate Programme</a></li>
            </ul>
        </div>
        <div class='footer-col'>
            <h4>Get Help</h4>
            <ul>
                <li><a href='#'>FAQ</a></li>
                <li><a href='#'>Shipping</a></li>
                <li><a href='#'>Returns</a></li>
                <li><a href='#'>Order Status</a></li>
                <li><a href='#'>Payment Options</a></li>
            </ul>
        </div>
        <div class='footer-col'>
            <h4>Online Shop</h4>
            <ul>
                <li><a href='#'>Watch</a></li>
                <li><a href='#'>Bag</a></li>
                <li><a href='#'>Shoes</a></li>
                <li><a href='#'>Dress</a></li>
            </ul>
        </div>
        <div class='footer-col'>
            <h4>Follow us</h4>
            <div class ='social-links'>
              <ul>
                <li><a href='https://www.facebook.com/RouteRover/' target='_blank'>
                  <i class='fab fa-facebook' tabindex='0'></i>
                </a></li>
                <li><a href='https://www.instagram.com/RouteRover/' target='_blank'>
                  <i class='fab fa-instagram' tabindex='0'></i>
                </a></li>
                <li><a href='#'>
                  <i class='fab fa-pinterest' tabindex='0' target='_blank'></i>
                </a></li>
                <li><a href='#'>
                  <i class='fab fa-youtube' tabindex='0' target='_blank'></i>
                </a></li>
                <li><a href='https://github.com/RouteRover' target='_blank'>
                  <i class='fab fa-github' tabindex='0'></i>
                </a></li>                                                      
                <li><a href='https://codepen.io/RouteRover' target='_blank'>
                  <i class='fab fa-codepen' tabindex='0'></i>
                </a></li>
              </ul>
            </div>
        </div>
    </div> 
    <!------------------- Footer Bottom --------------------->
    <div class='fbtm'>
      <div class='copyright'>
        <p>
          &copy; 2024 Route Rover. All rights reserved
        </p>
      </div>
      <div class='legal'>
        <ul>
          <li><a href='#'>Privacy Policy</a></li>
          <li><a href='#'>Terms & Condition</a></li>
          <li><a href='#'>Payment Methods</a></li>
        </ul>
      </div>
    </div>
  </footer>
  ";
}
else{
  echo "
  <footer>
    <!-- ----------------- Footer Top --------------- -->
      <div class='ftop'>
        <div class='footer-col'>
            <h4>Company</h4>
            <ul>
                <li><a href='#'>About us</a></li>
                <li><a href='#'>Our Services</a></li>
                <li><a href='#'>Privacy Policy</a></li>
                <li><a href='#'>Affiliate Programme</a></li>
            </ul>
        </div>
        <div class='footer-col'>
            <h4>Get Help</h4>
            <ul>
                <li><a href='#'>FAQ</a></li>
                <li><a href='#'>Shipping</a></li>
                <li><a href='#'>Returns</a></li>
                <li><a href='#'>Order Status</a></li>
                <li><a href='#'>Payment Options</a></li>
            </ul>
        </div>
        <div class='footer-col'>
            <h4>Online Shop</h4>
            <ul>
                <li><a href='#'>Watch</a></li>
                <li><a href='#'>Bag</a></li>
                <li><a href='#'>Shoes</a></li>
                <li><a href='#'>Dress</a></li>
            </ul>
        </div>
        <div class='footer-col'>
            <h4 class='sl'>Follow us</h4>
            <div class ='social-links'>
              <ul>
                  <li><a href='https://www.facebook.com/RouteRover/' target='_blank'>
                    <i class='fab fa-facebook' tabindex='0'></i>
                  </a></li>
                  <li><a href='https://www.instagram.com/RouteRover/' target='_blank'>
                    <i class='fab fa-instagram' tabindex='0'></i>
                  </a></li>
                  <li><a href='#'>
                    <i class='fab fa-pinterest' tabindex='0' target='_blank'></i>
                  </a></li>
                  <li><a href='#'>
                    <i class='fab fa-youtube' tabindex='0' target='_blank'></i>
                  </a></li>
                  <li><a href='https://github.com/RouteRover' target='_blank'>
                    <i class='fab fa-github' tabindex='0'></i>
                  </a></li>                                                      
                  <li><a href='https://codepen.io/RouteRover' target='_blank'>
                    <i class='fab fa-codepen' tabindex='0'></i>
                  </a></li>
              </ul>
            </div>
        </div>
    </div> 
    <!------------------- Footer Bottom --------------------->
    <div class='fbtm'>
      <div class='copyright'>
        <p>
          &copy; 2024 Route Rover. All rights reserved
        </p>
      </div>
      <div class='legal'>
        <ul>
          <li><a href='#'>Privacy Policy</a></li>
          <li><a href='#'>Terms & Condition</a></li>
          <li><a href='#'>Payment Methods</a></li>
        </ul>
      </div>
    </div>
  </footer>
  ";
}
?>