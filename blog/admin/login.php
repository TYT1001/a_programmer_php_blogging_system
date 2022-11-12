<?php
  session_start();
  require '../config/config.php';
  if($_POST) {
      //validation
      if(empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password'])<6 ){
        if(empty($_POST['email'])){
          $emailError = '*Email is required.';
        }
        if(strlen($_POST['password'])<6){
          $passwordError = '*Password should be 6 characters at least';
        }
        if(empty($_POST['password'])){
          $passwordError = '*Password is required.';
        }
    }
    else{
      $email = $_POST['email'];
      $password = $_POST['password'];

      $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');

      $stmt->bindValue(':email',$email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if($user){

          if(password_verify($password,$user['password'])){
              $_SESSION['user_id'] = $user['id'];
              $_SESSION['user_name'] = $user['name'];
              $_SESSION['logged_in'] = time();
              
              header('Location: index.php');
          }
      }

      echo "<script>alert('Incorrect credentials')</script>";
      }
    
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
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Blog</b> Admin</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="login.php" method="post">
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
            if (empty($emailError)) {
                    echo '';
            }else{ echo $emailError; }  
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
            if (empty($passwordError)) {
                    echo '';
            }else{ echo $passwordError; }  
            ?>
          </span>
        <div class="row">

          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
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
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
