<?php
include "conexao.php";
if(!isset($_SESSION)) session_start();

if(!isset($_SESSION['user_id'])) {
    echo "<script>alert('Você não está logado!');window.location='index.php';</script>";
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<link rel="stylesheet" href="style.css?v=2">
<meta charset="UTF-8">
<title>Cadastro de Notícias</title>
</head>
<body>
<div class="container">
<h2>Cadastrar Notícias</h2>

<form method="post">
    <input type="text" name="titulo" placeholder="Título da notícia" required>
    <input type="text" name="link" placeholder="Link da matéria (opcional)">
    <input type="text" name="fonte" placeholder="Nome da fonte" required>

    <select name="status" required>
        <option value="sim">Confiável</option>
        <option value="suspeita">Suspeita</option>
        <option value="nao">Falsa</option>
    </select>

    <button type="submit" name="cadastrar">Salvar notícia</button>
</form>

<br>
<a href="index.php">⬅ Voltar</a>
</div>
</body>
</html>
