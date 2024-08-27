<?php
$host = 'gerenciador-mysql'; // Update this if necessary
$user = 'root';
$password = 'senha';
$database = 'gerenciadorTarefas';
$port = '3306';

$mysqli = new mysqli($host, $user, $password, $database, $port);

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}
?>
