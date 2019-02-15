<?php
include 'lib/User.php';
include "inc/header.php";
Session::checkSession();

// $user_id='';
if (isset($_GET['id'])) {
  $user_id = $_GET['id'];
}
$user = new User();
// $userdata = $user->getUserByID($user_id);

//Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change'])) {
  $changePassword = $user->changePasswordByID($user_id, $_POST);
}
?>

<div class="panel panel-info">
  <div class="panel-heading">
    <h2>User <strong>Profile</strongs> <span class="pull-right"><a class="btn btn-primary" href="index.php">Back</a></span>
    </h2>
  </div>
  <div class="panel-body">
    <div style="max-width:600px; margin: 0 auto;">

      <form action="" method="POST">
        <?php
        if (isset($changePassword)) {
          echo  $changePassword;
        }

        ?>
        <div class="form-group">
          <label for="oldpassword">Old Password</label>
          <input type="password" class="form-control" name="oldpassword" id="oldpassword" value="">
        </div>
        <div class="form-group">
          <label for="newpassword">New Password</label>
          <input type="password" class="form-control" name="newpassword" id="newpassword" value="">
        </div>

        <?php
        $userSessionId = Session::get('id');
        if ($userSessionId == $user_id) {
          ?>
          <input type="submit" name="change" value="Change Password" class="btn btn-primary">

          <?php
        }
        ?>
      </form>



    </div>
  </div>
</div>


<?php include 'inc/footer.php'; ?>
