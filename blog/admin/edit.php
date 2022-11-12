<?php
    session_start();
    require '../config/config.php';
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
      header('Location: login.php');
    }
    
    
    if($_POST){
      if(empty($_POST['title']) || empty($_POST['description']) || empty($_FILES['image']['name']) ){
        if(empty($_POST['title'])){
            $titleErr = "title is required!";
          }
          if(empty($_POST['description'])){
            $descriptionErr = "description is required!";
          }
          if(empty($_FILES['image']['name'])){
            $imageErr = "image is required!";
          }
    }else{
      $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        if($_FILES['image']['name'] != null){
            
            $file = '../images/'.($_FILES['image']['name']);
            $imageType = pathinfo($file,PATHINFO_EXTENSION);
            if($imageType != 'png' && $imageType != 'jpg' &&  $imageType != 'jpeg'){
                echo "<script>alert('PNG, JPG and JPEG only allow!');</script>";
            }else{
                $image = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],$file);
                $stmt = $pdo->prepare("UPDATE posts SET title='$title',description='$description',image='$image' WHERE id='$id'");
                $result = $stmt->execute();
                if($result){
                    echo "<script>alert(' Successfully Updated!');window.location.href = 'index.php';</script>";
                }
            }
        }else{
                $stmt = $pdo->prepare("UPDATE posts SET title='$title',description='$description',image='$image' WHERE id='$id'");
                $result = $stmt->execute();
    
                if($result){
                    echo "<script>alert(' Successfully Updated!');window.location.href = 'index.php';</script>";
                }
        }
    }
        
    }

    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
    $stmt->execute();

    $post = $stmt->fetch();
    // print_r($post);
?>


<?php include('header.php'); ?>

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
                    <form action="" method="post" enctype="multipart/form-data">
                      
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>" />
                        <input type="hidden" name="id" value="<?php echo $post['id'];?>" />
                        <div class="form-group">
                                <div>
                                  <label for="">Title</label>
                                  <br>
                                  <input type="text" class="form-control" name="title" value="<?php echo $post['title']; ?>" >
                                </div>
                                <span class="text-danger">
                                  <?php if(empty($titleErr)){ echo '';}else{ echo $titleErr;} ?>
                                </span>
                               
                        </div>
                        <div class="form-group">
                          <div>
                                <label for="">Description</label><br>
                                <textarea name="description" id="" cols="140" rows="7" ><?php echo $post['description']; ?></textarea>
                          </div>
                          <span class="text-danger">
                            <?php if(empty($descriptionErr)){ echo '';}else{ echo $descriptionErr;} ?>
                          </span>
                                

                        </div>
                        <div class="form-group">
                          <div>
                                <label for="">Image</label><br>
                                <img src="../images/<?php echo $post['image'] ?>" width="100">
                                <input type="file" name="image" class="form-control">
                          </div>  
                          <span class="text-danger">
                            <?php if(empty($imageErr)){ echo '';}else{ echo $imageErr;} ?>
                          </span>
                                
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Update</button>
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