<?php
include 'conexao.php';
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    if (!$email || !$senha) $erro = 'Preencha todos os campos.';
    else {
        $stmt = $conn->prepare('SELECT id, nome, senha FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $nome, $hash);
            $stmt->fetch();
            if (password_verify($senha, $hash)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $nome;
                header('Location: index.php');
                exit;
            } else $erro = 'Credenciais incorretas.';
        } else $erro = 'Credenciais incorretas.';
        $stmt->close();
    }
}
$msg = $_GET['msg'] ?? '';
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Login - FakeCheck</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Login</h2>
  <?php if($msg == 'cadastrado') echo "<p class='ok'>Cadastro realizado. Faça login.</p>"; ?>
  <?php if($erro) echo "<p class='erro'>$erro</p>"; ?>
  <form method="post">
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Entrar</button>
  </form>
  <p>Não tem conta? <a href="register.php">Cadastre-se</a></p>
</div>
</body>
<?php if(isset($_GET['erro']) && $_GET['erro']=="admin"): ?>
    <p style="color:red;">Você precisa estar logado para acessar o painel administrativo.</p>
<?php endif; ?>

</html>
