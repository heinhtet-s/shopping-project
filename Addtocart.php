<?php
session_start();
require 'config/config.php';
if($_POST){
$id=$_POST['id'];
$qty=$_POST['qty'];
$pdostatement=$pdo->prepare("SELECT * FROM products WHERE id=:id ");
$pdostatement->execute([':id'=>$id]);
$result=$pdostatement->fetch(PDO::FETCH_ASSOC);

if($qty>$result['quantity']){
    echo "<script>alert('Not enough instock');</script>";
echo "<script>window.location.href = 'product_detail.php?id=$id'</script>;";
}else{
if(isset($_SESSION['cart']['id'.$id])){
    $_SESSION['cart']['id'.$id]+=$qty;

}else{
    $_SESSION['cart']['id'.$id]=$qty;

}
header("Location: cart.php");
} }
?>

                        