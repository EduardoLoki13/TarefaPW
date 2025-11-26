<?php
include 'conexao.php';
header("Content-Type: application/json");

// Se não estiver logado → bloqueia
if(!isset($_SESSION['user_id'])){
    echo json_encode(["status"=>"error","msg"=>"Faça login para votar"]);
    exit;
}

$id_noticia = $_POST['id_noticia'];
$userId     = $_SESSION['user_id'];
$util       = $_POST['util'];

// Bloqueia voto duplicado
$check = $conn->prepare("SELECT id_vote FROM votes WHERE id_noticia=? AND id_user=? LIMIT 1");
$check->bind_param("ii",$id_noticia,$userId);
$check->execute();
$check->store_result();

if($check->num_rows > 0){
    echo json_encode(["status"=>"error","msg"=>"Você já votou nesta notícia"]);
    exit;
}

// Inserção do voto — demonstração apenas
$stmt = $conn->prepare("INSERT INTO votes(id_noticia,id_user,util) VALUES(?,?,?)");
$stmt->bind_param("iis",$id_noticia,$userId,$util);
$stmt->execute();

echo json_encode(["status"=>"ok","msg"=>"Voto registrado com sucesso!"]);

