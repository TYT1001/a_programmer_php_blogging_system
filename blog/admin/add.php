<?php
    session_start();
    require '../config/config.php';
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
      header('Location: login.php');
    }
    if($_POST){
        $file = '../images/'.($_FILES['image']['name']);
        $imageType = pathinfo($file,PATHINFO_EXTENSION);
        
        if($imageType != 'png' && $imageType != 'jpg' &&  $imageType != 'jpeg'){
            echo "<script>alert('PNG, JPG and JPEG only allow!');</script>";
        }else{
            $title = $_POST['title'];
            $description = $_POST['description'];
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],$file);
            $stmt = $pdo->prepare("INSERT INTO posts(title,description,author_id,image) VALUES (:title,:description,:author_id,:image)");
            $result = $stmt->execute(
                array(':title'=>$title,':description'=>$description,':author_id'=>$_SESSION['user_id'],':image'=>$image)
            );

            if($result){
                echo "<script>alert('Created Successfully!');;window.location.href = 'index.php'</script>";
            }
        }
    }
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
            <a href="add.php"><button class="btn btn-success">New Blog Post</button></a>
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
                    <form action="add.php" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                                <label for="">Title</label>
                                <br>
                                <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                                <label for="">Description</label><br>
                                <textarea name="description" id="" cols="140" rows="7" required></textarea>

                        </div>
                        <div class="form-group">
                                <label for="">Image</label><br>
                                <input type="file" class="form-control" name="image" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Create</button>
                            <a href="index.php" class="btn btn-dark">Back</a>
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