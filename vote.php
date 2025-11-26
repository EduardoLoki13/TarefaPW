<?php
include 'conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status'=>'error','msg'=>'Método inválido']);
    exit;
}
$id_noticia = intval($_POST['id_noticia'] ?? 0);
$util = $_POST['util'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;

if (!$id_noticia || ($util !== 'sim' && $util !== 'nao')) {
    echo json_encode(['status'=>'error','msg'=>'Dados inválidos']);
    exit;
}

// opcional: evitar múltiplos votos pelo mesmo usuário (se estiver logado)
if ($user_id) {
    $q = $conn->prepare("SELECT id_vote FROM votes WHERE id_noticia = ? AND id_user = ? LIMIT 1");
    $q->bind_param('ii', $id_noticia, $user_id);
    $q->execute();
    $q->store_result();
    if ($q->num_rows > 0) {
        echo json_encode(['status'=>'error','msg'=>'Você já votou nesta notícia.']);
        exit;
    }
}

// insere voto
$stmt = $conn->prepare("INSERT INTO votes (id_noticia, id_user, util) VALUES (?, ?, ?)");
$stmt->bind_param('iis', $id_noticia, $user_id, $util);
if ($stmt->execute()) {
    echo json_encode(['status'=>'ok','msg'=>'Voto registrado']);
} else {
    echo json_encode(['status'=>'error','msg'=>'Erro no banco']);
}
