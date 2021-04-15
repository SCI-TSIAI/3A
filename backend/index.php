<?php
//NA EGZAMIN ZAWODOWY TAK!
//$id = 1;
//$connection = new PDO("mysql:host=172.17.0.2:3306;dbname=gallery", "root", "root");
//
//$query = $connection->query("Select * from user where id=$id");
//
//$result = $query->fetch();


//Przebieg danych w systemie:
// Żądanie->Controller->Service(Services)->Repository->DB->Repository->Service(Services)->Controller->Odpowiedź

require __DIR__ . '/vendor/autoload.php';

use App\Main;

$mainClass = new Main();

$mainClass->run();

?>
