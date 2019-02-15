<?php
include 'Database.php';

class User
{
  private $db;

  public function __construct(){
    $this->db  = new Database();
  }

  public function userRegistration($data){
    $name 	   = $data['name'];
    $userName  = $data['username'];
    $email 	   = $data['email'];
    $password  = md5($data['password']);
    $chk_email = $this-> emailCheck($email);


    if(empty($name) || empty($userName) || empty($email) || empty($password)){

      $message = "<div class='alert alert-danger'><strong>Error ! </strong>Field Must not be empty</div>";
      return $message;
    }
    elseif (strlen($userName) < 3) {
      $message = "<div class='alert alert-danger'><strong>Error ! </strong>Username should at least 3 characters</div>";
      return $message;
    }
    elseif (preg_match('/[^a-z0-9_-]+/i',$userName)) {
      $message = "<div class='alert alert-danger'><strong>Error ! </strong>Username must only contain alphabet, numericals, dahes or underscore</div>";
      return $message;
    }
    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
      $message = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid</div>";
      return $message;
    }
    elseif($chk_email == true){
      $message = "<div class='alert alert-danger'><strong>Error! </strong>The email already exist !</div>";
      return $message;
    }

    $sql    = "INSERT INTO user( name, username, email, password ) VALUES( :name, :username, :email, :password  )";
    $stmt   = $this->db->pdo->prepare($sql);
    $stmt  -> bindValue(':name', $name);
    $stmt  -> bindValue(':username', $userName);
    $stmt  -> bindValue(':email', $email);
    $stmt  -> bindValue(':password', $password);
    $result = $stmt ->execute();

    if ($result) {
      $message = "<div class='alert alert-success'><strong>Thank your! </strong>You have been successfully registered!</div>";
      return $message;
    } else {
      $message = "<div class='alert alert-danger'><strong>Sorry! </strong>there has been problem with your data!</div>";
      return $message;
    }

  }

  public function emailCheck($email){
    $sql   = "SELECT email FROM user WHERE email=:email";
    $stmt  = $this->db->pdo->prepare($sql);
    $stmt ->bindValue(':email', $email);
    $stmt ->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  // end of registration


  //login area start from here

  public function userLogin($data){
    $email     = $data['email'];
    $password  = $data['password'];
    $chk_email = $this->loginCheckEmail($email);
    $chk_lgn_password = $this->loginCheckPassword($password);

    if ($email == '' || $password=='') {
      $message = "<div class='alert alert-danger'><strong>Error! </strong>Field should not be empty.</div>";
      return $message;
    }
    elseif ($chk_email==false) {
      $message = "<div class='alert alert-danger'><strong>Error! </strong>The email you entered doesn't exist!</div>";
      return $message;
    }
    elseif ($chk_email==true) {
      if($chk_lgn_password == false){
        $message = "<div class='alert alert-danger'><strong>Error! </strong>The Password you entered is wrong!</div>";
        return $message;
      }
    }
    else {
      $message = "<div class='alert alert-danger'><strong>Error! </strong>Problem with the data!</div>";
    }

    $result = $this->getLoginUser($email, $password);

    if($result){
      Session::init();
      Session::set('login',true);
      Session::set('id',$result->id);
      Session::set('name',$result->name);
      Session::set('username',$result->username);
      Session::set('lgnmsg', "<div class='alert alert-success'><strong>Succes! </strong>You are logged in!</div>");
      header("location:index.php");
    }
  }
  public function getLoginUser($email, $password){
    $sql  = "SELECT * FROM user WHERE email=:email && password=:password LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', md5($password));
    $stmt->execute();
    return $result = $stmt -> fetch(PDO::FETCH_OBJ);
  }
  public function loginCheckEmail($email){
    $sql  = "SELECT email FROM user WHERE email=:email";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function loginCheckPassword($oldPassword) {
    $chkOP = md5($oldPassword);
    $sql   = "SELECT password FROM user WHERE password=:password";
    $stmt  = $this->db->pdo->prepare($sql);
    $stmt -> bindParam(':password', $chkOP);
    $stmt ->execute();
    $result= $stmt->fetch();
    if($result['password'] == $chkOP){
      return true;
    }
    else{
      return false;
    }
  }
  // end login area


  // all the information for the index
  public function getUserData() {
    $sql    = "SELECT * FROM user ORDER BY id DESC";
    $stmt   = $this->db->pdo->prepare($sql);
    $stmt  -> execute();
    $result = $stmt->fetchAll();

    if ($stmt->rowCount() > 0) {
      return $result;
    }
    else{
      return false;
    }
  }

  //get user data by Id for edit
  public function getUserByID($id){
    $sql    = "SELECT * FROM user WHERE id=:id LIMIT 1";
    $stmt   = $this->db->pdo->prepare($sql);
    $stmt  -> bindParam(':id', $id);
    $stmt  -> execute();
    $result = $stmt->fetch();
    return $result;
  }

  // update user data
  public function updateUserData($user_id, $data) {
    $name 	  = $data['name'];
    $userName = $data['username'];
    $email 	  = $data['email'];

    if(empty($name) || empty($userName) || empty($email)){
      $message = "<div class='alert alert-danger'><strong>Error ! </strong>Field Must not be empty</div>";
      return $message;
    }

    elseif (strlen($userName) < 3) {
      $message = "<div class='alert alert-danger'><strong>Error ! </strong>Username should at least 3 characters</div>";
      return $message;
    }

    elseif (preg_match('/[^a-z0-9_-]+/i',$userName)) {
      $message = "<div class='alert alert-danger'><strong>Error ! </strong>Username must only contain alphabet, numericals, dahes or underscore</div>";
      return $message;
    }

    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
      $message = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid</div>";
      return $message;
    }


    $sql  = "UPDATE user SET name=:name, username=:username, email=:email WHERE id=:id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':username', $userName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $user_id);
    $result =  $stmt ->execute();

    if ($result) {
      $message = "<div class='alert alert-success'><strong>Thank you ! </strong>You information successfully Updated!</div>";
      return $message;
    } else {
      $message = "<div class='alert alert-danger'><strong>Sorry! </strong>User data Not updated!</div>";
      return $message;
    }

  }

  //password change area
  public function changePasswordByID($user_id, $data){
    $oldPassword 	= $data['oldpassword'];
    $newPassword  = $data['newpassword'];
    $chk_password = $this->checkPassword($oldPassword, $user_id);


    if(empty($oldPassword) || empty($newPassword)){
      $message = "<div class='alert alert-danger'><strong>Error ! </strong>Field Must not be empty</div>";
      return $message;
    }
    if (strlen($newPassword) <= 3) {
      $message = "<div class='alert alert-danger'><strong>Error ! </strong>Password should at least 3 characters</div>";
      return $message;
    }
    if ($chk_password == false) {
      $message = "<div class='alert alert-danger'><strong>Error ! </strong>Old Password not Matched</div>";
      return $message;
    }

    $newPassword  = md5($newPassword);
    $sql  = "UPDATE user SET password=:password WHERE id=:id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt -> bindParam(':password', $newPassword);
    $stmt -> bindParam(':id', $user_id);
    $result =  $stmt ->execute();

    if ($result) {
      $message = "<div class='alert alert-success'><strong>Thank you ! </strong>You Password successfully Updated!</div>";
      return $message;
    } else {
      $message = "<div class='alert alert-danger'><strong>Sorry! </strong>Password Not updated!</div>";
      return $message;
    }
  }

  public function checkPassword($oldPassword,  $user_id) {
    $chkOP = md5($oldPassword);
    $sql  = "SELECT password FROM user WHERE id=:id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt -> bindParam(':id', $user_id);
    $stmt ->execute();
    $result= $stmt -> fetch();
    if($result['password'] == $chkOP){
      return true;
    }
    else{
      return false;
    }
  }


}
