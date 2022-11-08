<?php
session_start();
require '../config/config.php';
if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
  header('Location: login.php');
}


function subwords( $str, $max = 24, $char = ' ', $end = '...' ) {
  $str = trim( $str ) ;
  $str = $str . $char ;
  $len = strlen( $str ) ;
  $words = '' ;
  $w = '' ;
  $c = 0 ;
  for ( $i = 0; $i < $len; $i++ )
      if ( $str[$i] != $char )
          $w = $w . $str[$i] ;
      else
          if ( ( $w != $char ) and ( $w != '' ) ) {
              $words .= $w . $char ;
              $c++ ;
              if ( $c >= $max ) {
                  break ;
              }
              $w = '' ;
          }
  if ( $i+1 >= $len ) {
      $end = '' ;
  }
  return trim( $words ) . $end ;
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
              <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div>
              <!-- /.card-header -->

              <?php

                $stmt = $pdo->prepare('SELECT * FROM posts ORDER BY id DESC');
                $stmt -> execute();
                $posts = $stmt->fetchAll();
                // var_dump($posts);
              ?>

              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    
                      if($posts){

                        $i=1;
                        foreach($posts as $post){
                          
                          ?>
                            <tr class="">
                              <td><?php echo $i ?></td>
                              <td><?php echo $post['title'] ?></td>
                              <td>
                                    <?php echo subwords($post['description'],10).'...' ?>
                              </td>
                              <td class="">
                                <div class="btn-group">
                                <div class="container">
                                <a href="edit.php?id=<?php echo $post['id']; ?>"><button class="btn btn-warning me-2 ">Edit</button></a>
                                

                                </div>
                                <div class="container">
                                <a href="delete.php?id=<?php echo $post['id']; ?>">
                              
                                  <button class="btn btn-danger ">Delete</button>
                                </a>

                                </div>
                                </div>
                                
                              </td>
                            </tr> 
                          <?php
                          $i++;
                        }
                        
                      }
                     
                      ?>
                    
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
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
