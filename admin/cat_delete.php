<?php
require '../config/config.php';

    $id=$_GET['id'];
$pdostatement=$pdo->prepare("DELETE FROM categories WHERE id=:id ");
$pdostatement->execute([":id"=>$id]);
header('Location: category.php' );

?>