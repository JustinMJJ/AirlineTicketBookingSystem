<?php
session_start();
if (isset($_SESSION["UserID"]) && isset($_COOKIE["UserID"])){
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Airline System Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
<form class="" action="process.php" method="post">
    <h1>Login</h1>
    <input type="text" name="UserID" placeholder="UserID">
    <input type="password" name="Password" placeholder="Password">
    <input type="submit" name="Login" placeholder="Sign in">

        <div id="text">
            Don't have account? <a href="register.php">Sign up</a>
        </div>
</form>
</body>
</html>