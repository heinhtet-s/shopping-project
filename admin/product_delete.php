<?php
require '../config/config.php';

    $id=$_GET['id'];
$pdostatement=$pdo->prepare("DELETE FROM products WHERE id=:id ");
$pdostatement->execute([":id"=>$id]);

header('Location: index.php' );

?>