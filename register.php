<?php
include 'conexao.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    if (!$nome || !$email || !$senha) $erro = 'Preencha todos os campos.';
    else {
        // checar se email existe
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) $erro = 'Email já cadastrado.';
        else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $ins = $conn->prepare('INSERT INTO users (nome, email, senha) VALUES (?, ?, ?)');
            $ins->bind_param('sss', $nome, $email, $hash);
            if ($ins->execute()) {
                header('Location: login.php?msg=cadastrado');
                exit;
            } else $erro = 'Erro ao cadastrar.';
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Cadastro - FakeCheck</title>
<link rel="stylesheet" href="style.css?v=2">
</head>
<body>
<div class="container">
  <h2>Cadastro</h2>
  <?php if($erro) echo "<p class='erro'>$erro</p>"; ?>
  <form method="post">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Criar conta</button>
  </form>
  <p>Já tem conta? <a href="login.php">Entrar</a></p>
</div>
</body>
</html>
