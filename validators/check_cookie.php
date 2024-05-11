<?php
if (isset($_COOKIE["role"], $_COOKIE["username"], $_COOKIE["email"], $_COOKIE["id"])) {
  $_SESSION["username"] = $_COOKIE["username"];
  $_SESSION["email"] = $_COOKIE["email"];
  $_SESSION["id"] = $_COOKIE["id"];
  $_SESSION["role"] = $_COOKIE["role"];
}