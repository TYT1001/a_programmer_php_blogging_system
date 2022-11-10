<?php
    session_start();
    require '../config/config.php';
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
      header('Location: login.php');
    }
    if($_POST){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if(!empty($_POST['role'])){
            $role = 1;
          }else{
            $role = 0;
          }
        // print '<pre>';
        // print_r($_POST);
        // exit();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email AND id!=:id');
        $stmt->execute(array(':email'=>$email,':id'=>$id));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($user)){
            echo "<script>alert('Email duplicated!');</script>";
        }else{
            $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',password='$password',role='$role' WHERE id='$id'");
            $result = $stmt->execute();
    
                if($result){
                    echo "<script>alert(' Successfully Updated!');window.location.href = 'user_list.php';</script>";
                }
        }
    }
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
    $stmt->execute();

    $user = $stmt->fetch();
    // print_r($post);
?>


<?php include('header.html'); ?>

  <!-- Content Wrapper. Contains page content -->
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
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $user['id'];?>" />
                        <div class="form-group">
                                <label for="">Name</label>
                                <br>
                                <input type="text" class="form-control" name="name" value="<?php echo $user['name']; ?>" required>
                        </div>
                        <div class="form-group">
                                <label for="">Email</label><br>
                                <input type="email" name="email" id="" class="form-control" value="<?php echo $user['email']; ?>" required>

                        </div>
                        <div class="form-group">
                                <label for="">Password</label><br>
                                <input type="password" class="form-control" name="password" value="<?php echo $user['password']; ?>" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="role"  id="flexCheckDefault" <?php if($user['role']=='1'){echo "checked";} ?>>
                            <label for="flexCheckDefault" class="form-check-label">Admin</label>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Update</button>
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
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
    <?php include('footer.html') ?>