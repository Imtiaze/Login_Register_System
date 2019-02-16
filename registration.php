<?php
include "inc/header.php";
include "lib/User.php";
?>

<?php
$user = new User();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
  $userRegi = $user->userRegistration($_POST);
}
?>

<div class="panel panel-info">
  <div class="panel-heading">
    <h2>User <strong>Registration</strongs></h2>
    </div>
    <div class="panel-body">
      <div style="max-width:600px; margin: 0 auto;">
        <?php if (isset($userRegi)) {
          echo $userRegi;
        } ?>
        <form action="" method="POST">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name"  class="form-control" id="name" placeholder="Enter name">
          </div>
          <div class="form-group">
            <label for="username">UserName</label>
            <input type="text" name="username"  class="form-control" id="username" placeholder="Enter Username">
          </div>
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="text" name="email"  class="form-control" id="email" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
          </div>

          <input type="submit" name="register" value="Register" class="btn btn-primary">
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'inc/footer.php'; ?>
