<?php
 define('MYSQL_USER','root');
 define('MYSQL_PASSWORD','');
 define('MYSQL_HOST','localhost');
 define('MYSQL_DATA','shopping');
 $option=[PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION];
 $pdo =new PDO(
    "mysql:host=localhost;dbname=shopping",MYSQL_USER,MYSQL_PASSWORD,$option);
 ?>