<?php

$filepath = realpath(dirname(__FILE__));
include_once $filepath.'/../lib/Session.php';
Session::init();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Login Register System PHP</title>
  <link rel="stylesheet" href="inc/css/bootstrap.min.css">
  <script src="inc/js/jquery.min.js"/></script>
  <script  src="inc/css/bootstrap.min.js"/></script>


  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"> -->
</head>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  Session::destroy();
}
?>

<body>
  <div class="container">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">WebSiteName</a>
        </div>
        <ul class="nav navbar-nav pull-right">
          <?php
          $id = Session::get("id");
          $userLogin = Session::get("login");
          if ($userLogin == true) {
            ?>
            <li><a href="index.php">Home</a></li>
            <li><a href="profile.php?id=<?php echo $id; ?>">profile</a></li>
            <li><a href="?action=logout">Logout</a></li>
            <?php
          }
          else{
            ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="registration.php">Register</a></li>
            <?php
          }
          ?>
        </ul>
      </div>
    </nav>
