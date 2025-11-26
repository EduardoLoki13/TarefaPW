<?php
include "conexao.php";

// Permite só logado (simples)
if(!isset($_SESSION['user_id'])){
    die("<p style='color:white;'>Você precisa estar logado para cadastrar notícias.</p><a href='login.php'>Entrar</a>");
}

$msg = "";

if(isset($_POST['cadastrar'])){
    $titulo = $_POST['titulo'];
    $link   = $_POST['link'];
    $fonte  = $_POST['fonte'];
    $status = $_POST['status'];

    $sql = $conn->prepare("INSERT INTO noticias (titulo,link,fonte,confiavel) VALUES (?,?,?,?)");
    $sql->bind_param("ssss",$titulo,$link,$fonte,$status);

    if($sql->execute()){
        $msg = "<p class='ok'>Notícia cadastrada com sucesso!</p>";
    } else {
        $msg = "<p class='erro'>Erro ao cadastrar.</p>";
    }
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

<?= $msg ?>

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
