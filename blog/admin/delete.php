<?php

    session_start();
    require '../config/config.php';
    if(empty($_SESSION['user_id']&&$_SESSION['logged_in'])){
      header('Location: login.php');
    }
    
    $post_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id='$post_id'");
    $stmt->execute();
    header("Location: index.php");