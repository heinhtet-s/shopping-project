<?php 
$id=$_GET['p_id'];
session_start();
unset($_SESSION['cart']['id'.$id]);
header("Location: cart.php");
