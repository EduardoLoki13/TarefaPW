<?php
include 'conexao.php';
$busca = trim($_GET['busca'] ?? '');
$noticia = null;
if ($busca !== '') {
    // busca por título exato parcial ou link
    $sql = "SELECT * FROM noticias WHERE titulo LIKE ? OR link LIKE ? LIMIT 1";
    $param = "%{$busca}%";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $param, $param);
    $stmt->execute();
    $res = $stmt->get_result();
    $noticia = $res->fetch_assoc();
    $stmt->close();
}
$userId = $_SESSION['user_id'] ?? null;
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Resultado - FakeCheck</title>
<link rel="stylesheet" href="style.css">
<script src="script.js" defer></script>
</head>
<body>
<div class="container">
  <a href="index.php">← Voltar</a>
  <?php if (!$noticia): ?>
    <h2>Nenhuma notícia encontrada</h2>
    <p>Você pode sugerir uma notícia ao administrador ou, se for admin, cadastrá-la.</p>
  <?php else: 
      $status = $noticia['confiavel'];
      $class = $status=='sim' ? 'ok' : ($status=='suspeita' ? 'alerta' : 'erro');
  ?>
    <h2 class="<?php echo $class; ?>">
      <?php echo ($status=='sim' ? '✅ Notícia confiável' : ($status=='suspeita' ? '⚠️ Notícia suspeita' : '❌ Notícia falsa')); ?>
    </h2>
    <div class="card full">
      <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
      <?php if($noticia['link']): ?>
        <p><a href="<?php echo htmlspecialchars($noticia['link']); ?>" target="_blank">Abrir fonte</a></p>
      <?php endif; ?>
      <p><b>Fonte:</b> <?php echo htmlspecialchars($noticia['fonte']); ?></p>
      <p><b>Cadastrada em:</b> <?php echo $noticia['criado_em']; ?></p>

      <hr>
      <div id="voto-area">
        <p>Esse resultado foi útil?</p>
        <button class="vote-btn" data-id="<?php echo $noticia['id_noticia']; ?>" data-val="sim">Sim</button>
        <button class="vote-btn" data-id="<?php echo $noticia['id_noticia']; ?>" data-val="nao">Não</button>
        <div id="vote-msg"></div>
      </div>

      <hr>
      <div>
        <h4>Estatísticas de votos</h4>
        <?php
          $s = $conn->prepare("SELECT util, COUNT(*) as cnt FROM votes WHERE id_noticia = ? GROUP BY util");
          $s->bind_param('i', $noticia['id_noticia']);
          $s->execute();
          $res = $s->get_result();
          $sim=0; $nao=0;
          while($row = $res->fetch_assoc()){
            if($row['util']=='sim') $sim = $row['cnt'];
            if($row['util']=='nao') $nao = $row['cnt'];
          }
          $total = $sim + $nao;
          echo "<p>Úteis: $sim — Não úteis: $nao — Total: $total</p>";
        ?>
      </div>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
