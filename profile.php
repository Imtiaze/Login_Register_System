<?php
include 'lib/User.php';
include "inc/header.php";
Session::checkSession();

// $user_id='';
if (isset($_GET['id'])) {
  $user_id = $_GET['id'];
}
$user = new User();
$userdata = $user->getUserByID($user_id);

//Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $user->updateUserData($user_id, $_POST);
}
?>

<div class="panel panel-info">
  <div class="panel-heading">
    <h2>User <strong>Profile</strongs> <span class="pull-right"><a class="btn btn-primary" href="index.php">Back</a></span>
    </h2>
  </div>
  <div class="panel-body">
    <div style="max-width:600px; margin: 0 auto;">
      <?php
      if ($userdata) {
        ?>
        <form action="" method="POST">
          <?php
          if (isset($updateUser)) {
            echo $updateUser;
          }
          ?>
          <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $userdata['name']; ?>">
          </div>
          <div class="form-group">
            <label for="username">UserName</label>
            <input type="text" class="form-control" name="username" id="username" value="<?php echo $userdata['username']; ?>">
          </div>
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email" value="<?php echo $userdata['email']; ?>">
          </div>
          <?php
          $userSessionId = Session::get('id');
          if ($userSessionId == $user_id) {
            ?>
            <input type="submit" name="update" value="Update" class="btn btn-primary">
            <a class="btn btn-info" href="passwordchange.php?id=<?php echo $userdata['id'];  ?>">Password Change</a>
            <?php
          }
          ?>
        </form>
        <?php
      }
      ?>
    </div>
  </div>
</div>


<?php include 'inc/footer.php'; ?>
