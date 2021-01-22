<?php
//NA EGZAMIN ZAWODOWY TAK!
//$id = 1;
//$connection = new PDO("mysql:host=172.17.0.2:3306;dbname=gallery", "root", "root");
//
//$query = $connection->query("Select * from user where id=$id");
//
//$result = $query->fetch();


use App\Main;

require __DIR__ . '/vendor/autoload.php';


$mainClass = new Main();

$mainClass->run();

?>
