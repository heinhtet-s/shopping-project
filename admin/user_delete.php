<?php
require '../config/config.php';
session_start();
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');
}
$pdostatement=$pdo->prepare("DELETE FROM users WHERE id=".$_GET['id']);
$result=$pdostatement->execute();
if($result){
    echo "<script>alert('Successful DELETE'); </script>";
  
    echo"<script>document.location.href = 'user_index.php',true;</script>";
}
