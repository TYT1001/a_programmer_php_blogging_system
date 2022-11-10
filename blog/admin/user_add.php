<?php
    session_start();
    require '../config/config.php';
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
      header('Location: login.php');
    }

    if($_POST){
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      if($_POST['role']=='on'){
        $role = 1;
      }else{
        $role = 0;
      }
      $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES (:name,:email,:password,:role)");
      $result = $stmt->execute(
        array(':name'=>$name,':email'=>$email,':password'=>$password,':role'=>$role)
      );
      if($result){
        echo "<script>alert(' Successfully added!');window.location.href = 'user_list.php';</script>";
    }          

    }
?>
<?php include('header.php')?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12 d-flex justify-content-between">
            <h1 class="m-0">Starter Page</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="user_add.php" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                                <label for="">Name</label>
                                <br>
                                <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                                <label for="">Email</label><br>
                                <input type="email" name="email" id="" class="form-control">

                        </div>
                        <div class="form-group">
                                <label for="">Password</label><br>
                                <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="role"  id="flexCheckDefault" >
                            <label for="flexCheckDefault" class="form-check-label">Admin</label>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Create</button>
                            <a href="user_list.php" class="btn btn-dark">Back</a>
                        </div>
                            
                            
                        


                    </form>
                </div>
                
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col -->
          
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <?php include('footer.html')?>