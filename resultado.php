<?php
include('conexao.php');

$busca = $_GET['busca'] ?? '';
$userId = $_SESSION['user_id'] ?? null;

$sql = $conn->prepare("SELECT * FROM noticias WHERE titulo LIKE ? OR link LIKE ? LIMIT 1");
$like = "%$busca%";
$sql->bind_param("ss", $like, $like);
$sql->execute();
$resultado = $sql->get_result();
$noticia = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado - FakeCheck</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <a href="index.php">⬅ Voltar</a>
    <h1>Resultado da Verificação</h1>

    <?php if(!$noticia): ?>
        <p class="erro">⚠ Nenhuma notícia encontrada no sistema.</p>
    
    <?php else: 
        $status = $noticia['confiavel'];
        $classe = $status == "sim" ? "ok" : ($status == "suspeita" ? "alerta" : "erro");
        $texto = $status == "sim" ? "✅ Notícia confiável" : ($status == "suspeita" ? "⚠ Notícia suspeita" : "❌ Notícia falsa");
    ?>

        <div class="resultado <?= $classe ?>">
            <h2><?= $texto ?></h2>
            <p><b>Título:</b> <?= $noticia['titulo'] ?></p>
            <p><b>Fonte:</b> <?= $noticia['fonte'] ?></p>
            <p><b>Data:</b> <?= $noticia['criado_em'] ?></p>
        </div>

        <hr><br>

        <!-- ================= SISTEMA DE VOTO ================= -->

        <div id="voto-area">

<?php if(!$userId): ?>
    <p class="alerta">🔒 Faça <a href='login.php'>login</a> para votar</p>

<?php else: 
    $check = $conn->prepare("SELECT id_vote FROM votes WHERE id_noticia=? AND id_user=? LIMIT 1");
    $check->bind_param("ii", $noticia['id_noticia'], $userId);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0): ?>
        <p class='ok'>✔ Você já votou nesta notícia</p>

    <?php else: ?>
        <button onclick="votar(<?= $noticia['id_noticia'] ?>,'sim')" class="vote">Sim</button>
        <button onclick="votar(<?= $noticia['id_noticia'] ?>,'nao')" class="vote">Não</button>
        <p id="retorno"></p>
    <?php endif; ?>

<?php endif; ?>
</div>

        <!-- ================= GRÁFICO DE VOTOS ================= -->

        <?php
            $v = $conn->prepare("SELECT util, COUNT(*) AS total FROM votes WHERE id_noticia=? GROUP BY util");
            $v->bind_param("i",$noticia['id_noticia']);
            $v->execute();
            $res = $v->get_result();

            $sim=0; $nao=0;
            while($r=$res->fetch_assoc()){
                if($r['util']=="sim") $sim=$r['total'];
                if($r['util']=="nao") $nao=$r['total'];
            }
        ?>

        <h3>📊 Resultados da votação</h3>
        <p>Sim: <?= $sim ?> | Não: <?= $nao ?> | Total: <?= $sim+$nao ?></p>

        <canvas id="graficoVotos" style="width:100%; max-width:380px;"></canvas>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        new Chart(document.getElementById("graficoVotos"), {
            type: "pie",
            data: {
                labels: ["Útil", "Não útil"],
                datasets: [{
                    data: [<?= $sim ?>, <?= $nao ?>],
                    backgroundColor: ["#00ff9d","#ff6b6b"]
                }]
            }
        });
        </script>

    <?php endif; ?>

</div>
</body>
<script>
function votar(id,val){
    fetch("vote.php",{
        method:"POST",
        headers:{ "Content-Type":"application/x-www-form-urlencoded" },
        body:`id_noticia=${id}&util=${val}`
    })
    .then(r=>r.json())
    .then(d=>{
        document.getElementById("retorno").innerText = d.msg;

        // Atualiza gráfico sem sair da página
        setTimeout(()=>location.reload(),800)
    });
}
</script>

</html>

