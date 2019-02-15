<?php
include "inc/header.php";
include "lib/User.php";
Session::checkSession();
$user = new User();

$lgnmsg = Session::get('lgnmsg');
if(isset($lgnmsg)){
  echo $lgnmsg;
}
Session::set('lgnmsg', NULL);
?>

<div class="panel panel-info">
  <div class="panel-heading">
    <h2>User List<span class="pull-right">Welcome!
      <strong>
        <?php
        $name = Session::get('username');
        if (isset($name)) {
          echo $name;
        }
        ?>
      </strong></span>
    </h2>
  </div>
  <div class="panel-body">
    <table class="table table-striped">
      <tr>
        <th width="20%">serial</th>
        <th width="20%">Name</th>
        <th width="20%">User Name</th>
        <th width="20%">Email</th>
        <th style="text-align:center;" width="20%">Action</th>
      </tr>
      <?php
      $result = $user->getUserData();
      if($result){
        $i = 0;
        foreach ($result as $data) {
          $i++;
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $data['name']; ?></td>
            <td><?php echo $data['username']; ?></td>
            <td><?php echo $data['email']; ?></td>
            <td style="text-align:center;"> <a class="btn btn-primary" href="profile.php?id=<?php echo $data['id']; ?>">View</a></td>
          </tr>
          <?php
        }
      }
      ?>
    </table>
  </div>
</div>


<?php include 'inc/footer.php'; ?>
