<?php
include 'conexao.php';
$userName = $_SESSION['user_name'] ?? null;
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>FakeCheck - Home</title>
<link rel="stylesheet" href="style.css">
<script src="script.js" defer></script>
</head>
<body>
<div class="container">
  <header class="top">
    <h1>📰 FakeCheck</h1>
    <div>
      <?php if($userName): ?>
        Olá, <?php echo htmlspecialchars($userName); ?> — <a href="logout.php">Sair</a>
      <?php else: ?>
        <a href="login.php">Entrar</a> | <a href="register.php">Cadastrar</a>
      <?php endif; ?>
    </div>
  </header>
  <main>
    <p>Cole o título ou link de uma notícia para verificar.</p>
    <form action="resultado.php" method="get">
      <input type="text" name="busca" placeholder="Título ou link..." required>
      <button type="submit">Verificar</button>
    </form>
    <?php
if(!isset($_SESSION)) session_start();
$userId = $_SESSION['user_id'] ?? null;
?>

<?php if($userId): ?>
    <a href="admin.php" class="btn-admin" style="
        padding:10px;
        background:#0077ff;
        color:white;
        border-radius:6px;
        text-decoration:none;
        font-weight:bold;
        margin-top:10px;
        display:inline-block;
    ">
        Painel Admin ⚙
    </a>
<?php endif; ?>

    <hr>
    <h3>Últimas notícias cadastradas</h3>
    <div class="lista">
      <?php
      $q = $conn->query("SELECT id_noticia, titulo, fonte, confiavel FROM noticias ORDER BY criado_em DESC LIMIT 6");
      while ($r = $q->fetch_assoc()) {
        $badge = $r['confiavel']=='sim' ? 'ok' : ($r['confiavel']=='suspeita' ? 'alerta' : 'erro');
        echo "<div class='card'><h4>".htmlspecialchars($r['titulo'])."</h4><small>".htmlspecialchars($r['fonte'])."</small><div class='badge $badge'>".$r['confiavel']."</div><a class='btnlink' href='resultado.php?busca=".urlencode($r['titulo'])."'>Ver</a></div>";
      }
      ?>
    </div>
  </main>
</div>
</body>
</html>
