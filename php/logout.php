<?php
session_start();
setcookie("UserID", '');
setcookie("Password", '');
unset($_SESSION["UserID"]);
unset($_SESSION["Password"]);
header("Location: login.php");
