<?php
// conexao.php
$host = 'localhost';
$user = 'root';
$pass = ''; // ajuste conforme seu ambiente
$dbname = 'fakecheck_db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('Erro de conexão: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
session_start();
?>
