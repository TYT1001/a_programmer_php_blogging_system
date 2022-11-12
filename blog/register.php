<?php
  session_start();
  require 'config/config.php';
  
  require 'config/common.php';

  if($_POST) {
    if(empty($_POST['name'])||empty($_POST['email'])||empty($_POST['password'])||strlen($_POST['name'])<6){
      if(empty($_POST['name'])){
        $nameErr = "name is required!";
      }
      if(empty($_POST['email'])){
        $emailErr = "email is required!";
      }
      if(strlen($_POST['password'])<6){
        $pwdErr = "password should be six characters at least!";
      }
      if(empty($_POST['password'])){
        $pwdErr = "password is required!";
      }

    }else{
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
      $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
      $stmt->bindValue(':email',$email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if($user){
        echo "<script>alert('User email duplicate');window.location.href = 'register.php';</script>";
        }{
          
          $stmt = $pdo->prepare("INSERT INTO users(name,email,password) VALUES (:name,:email,:password)");
          $result = $stmt->execute(
              array(':name'=>$name,':email'=>$email,':password'=>$password)
          );
          if($result){
              echo "<script>alert('Successfully Register!You can now Login');window.location.href = 'login.php';</script>";
          } 
      }
    }
    // echo "<script>alert('Incorrect credentials')</script>";
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Blog</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="./register.php" method="POST">
        
      <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>" />
        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <span class="text-danger">
          <?php 
          if(empty($nameErr)){ echo ''; }else { echo $nameErr;}
            ?>
        </span>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <span class="text-danger">
          <?php 
          if(empty($emailErr)){ echo ''; }else { echo $emailErr;}
            ?>
        </span>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          
        </div>
        <span class="text-danger">
          <?php 
          if(empty($pwdErr)){ echo ''; }else { echo $pwdErr;}
            ?>
        </span>
        
        
        <div class="row">

          <!-- /.col -->
          <div class="col-12">
            <div class="mx-auto text-center">
              <button type="submit" class="btn btn-primary">Register</button>
              <a href=""><button class="btn btn-success" type="button">Sign In</button></a>
            </div>
            
          </div>
          <!-- /.col -->
        </div>
      </form>


      <!-- /.social-auth-links -->


    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
