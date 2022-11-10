<?php 
    require './config/config.php';
    session_start();
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
        header('Location: login.php');
    }
    // echo $authod_id;
    // exit();
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
    $stmt->execute();
    $post = $stmt->fetch();

    $blogId = $_GET['id'];

    $stmtcm = $pdo->prepare(
      "SELECT * FROM comments 
      LEFT JOIN users ON comments.author_id = users.id 
      WHERE post_id='$blogId'"
    );
    $stmtcm->execute();
    $comments = $stmtcm->fetchAll();
    // print '<pre>';
    // print_r($comments);
    // $cmtAuthorcollection=array();
    // foreach ($comments as $comment) {
    //     array_push($cmtAuthorcollection,$comment['author_id']);
    // }
    // // print_r($cmtAuthorcollection);
    // $users = array();
    // foreach($cmtAuthorcollection as $cac){

    //   $author_id = $cac;
    //   $stmtau = $pdo->prepare("SELECT * FROM users WHERE id='$author_id'");
    //   $stmtau->execute();
    //   array_push($users,$stmtau->fetch()) ;
    // }
    // print '<pre>';
    // print_r($users);
    // exit();

    if($_POST){
        $cmt = $_POST['comment'];
        $stmt = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
        $result = $stmt->execute(
            array(':content'=>$cmt,':author_id'=>$_SESSION['user_id'],':post_id'=>$blogId)
        );
        if($result){
            header('Location: blogDetail.php?id='.$blogId);
        }
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
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="text-center">Blog Site</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">

        <div class="col-md-8 offset-2">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <a href="index.php">
                <svg style="width: 30px; position:absolute" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                </svg>

                </a>
                <h1 class="text-center text-muted" style="font-size: 24px;"><?php echo $post['title'];  ?></h1>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body text-center">
                <img class="img-fluid pad" src="./images/<?php echo $post['image'];  ?>" alt="Photo" style="width:50%;">
              </div>
              <div class="card-body">
                    <p><?php echo $post['description'];  ?></p>
                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>
                    <button type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i> Like</button>
                    <span class="float-right text-muted">127 likes - 3 comments</span>
               
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">
                <?php
                    foreach ($comments as $comment) {
                        ?>
                    
                    
                <div class="card-comment">
                  <!-- User image -->
                    <img class="img-circle img-sm" src="./dist/img/user3-128x128.jpg" alt="User Image">

                    <div class="comment-text">
                        <span class="username">
                            <?php echo $comment['name']; ?>
                        <span class="text-muted float-right"><?php echo $comment['created_at']; ?></span>
                        </span><!-- /.username -->
                        <?php echo $comment['content']; ?>
                    </div>
                  <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
                <?php
                    }
                ?>
             
                <!-- /.card-comment -->
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form  method="post">
                  <img class="img-fluid img-circle img-sm" src="./dist/img/user4-128x128.jpg" alt="Alt Text">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">
                    <input name="comment" type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
        <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </a>
        <!-- =========================================================== -->
        <footer class="px-3">
            <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>
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
