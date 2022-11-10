<?php
    require './config/config.php';
    session_start();
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
        header('Location: login.php');
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Widgets</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    
        
    

<div class="wrapper">
  <!-- Navbar -->
  
  <a href="logout.php" class="float-right mx-3 mt-3">
            <button class="btn btn-sm btn-danger">Logout</button>
    </a>
  
    
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  
    <!-- Content Header (Page header) -->
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="text-center mt-5">Blog Site</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
        
        if(!empty($_GET['pageno'])){
          $pageno = $_GET['pageno'];
        }else{
          $pageno = 1;
        }
        $numOfrecs = 3;
        $offset = ($pageno - 1) * $numOfrecs;

        // if(empty($_POST['search'])){
          
          $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
          $stmt->execute();
          $rawResult = $stmt->fetchAll();

          $totalpages = ceil(count($rawResult)/$numOfrecs);

          $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs");
          $stmt->execute();
          $posts = $stmt->fetchAll();
        // }else{
          

        //   $searchKey = $_POST['search'];
        //   $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
        //   $stmt->execute();
        //   $rawResult = $stmt->fetchAll();

        //   $totalpages = ceil(count($rawResult)/ $numOfrecs);

        //   $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
        //   $stmt->execute();
        //   $posts = $stmt->fetchAll();  
        // }
        
        
    ?>
        <div class="row mx-5">
            <?php
                    
                    if($posts){

                      $i=1;
                      foreach($posts as $post){
                        
                        ?>
                <div class="col-md-4">
                <!-- Box Comment -->
                    <div class="card card-widget">
                        <div class="card-header ">
                                <h1 class="text-muted text-center" style="font-size: 24px;"><?php echo $post['title'] ?></h1>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body text-center" style="height:350px;">
                        <a href="blogDetail.php?id=<?php echo $post['id']; ?>">
                            <img class="img-fluid pad mb-3" src="./images/<?php echo $post['image'];?>" alt="Photo" style="width:60%;">
                        </a>
                            

                        </div>
                        <div class="card-footer">
                            <p><?php echo $post['description'] ?></p>

                        </div>
                    
                    </div>
                <!-- /.card -->
                </div>

            <?php
                          $i++;
                        }
                        
                      }
                     
                      ?>
            
           
        </div>
        <!-- /.row -->
        
        <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                  <li class="page-item <?php if($pageno<=1) { echo "disabled";}  ?> ">
                    <a class="page-link" href="<?php if($pageno<=1) { echo "#";} else { echo "?pageno=".($pageno-1);}  ?>">Previous</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                  <li class="page-item <?php if($pageno>=$totalpages) { echo "disabled";}  ?>">
                    <a class="page-link" href="<?php if($pageno>=$totalpages) { echo "#";} else { echo "?pageno=".($pageno+1);}  ?>">Next</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="?pageno=<?php echo $totalpages; ?>">Last</a></li>
                </ul>
              </div>

        <!-- =========================================================== -->
        
        <!-- /.row -->

        
      <!-- /.container-fluid -->
    
    <!-- /.content -->

    <!-- <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a> -->
  
  <!-- /.content-wrapper -->

  <footer class="px-3">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
</body>
</html>
