<?php
include "inc/header.php";
include "lib/User.php";
Session::loginSession();
?>

<?php
$user = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
  $userLogin = $user->userLogin($_POST);
}

?>

<div class="panel panel-success">
  <div class="panel-heading">
    <h2>User<strong> Login</strong></h2>
  </div>

  <div class="panel-body">
    <div style="max-width:600px; margin: 0 auto;">
      <?php
      if (isset($userLogin)) {
        echo $userLogin;
      }
      ?>
      <form class="" action="" method="post">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" name="email" id="email" value="" placeholder="Email"  class="form-control" >
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" value="" placeholder="Password" class="form-control" >
        </div>
        <input type="submit" name="login" value="Login" class="btn btn-success">
      </form>
    </div>
  </div>
</div>


<?php include 'inc/footer.php'; ?>
