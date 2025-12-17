<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}
include_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $caminho_foto = "uploads/default.jpg";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $caminho_foto = "uploads/" . time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../" . $caminho_foto);
    }
    $sql = "INSERT INTO produtos (nome, preco_venda, descricao, periodo, imagem_url, disponivel) VALUES (?, ?, ?, ?, ?, 1)";
    $pdo->prepare($sql)->execute([$_POST['nome'], $_POST['preco'], $_POST['desc'], $_POST['periodo'], $caminho_foto]);
    header("Location: produtos.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Produto</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #000; color: #fff; padding: 20px; display: block; }
        .container { max-width: 500px; margin: 0 auto; background: #1a1a1a; padding: 30px; border-radius: 20px; border: 1px solid var(--primary); }
        input, select, textarea { width: 100%; padding: 12px; margin: 10px 0 20px 0; background: #000; color: #fff; border: 1px solid #333; border-radius: 8px; box-sizing: border-box; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color: var(--primary); margin-top: 0;">Novo Item</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nome" placeholder="Nome do Produto" required>
            <input type="number" step="0.01" name="preco" placeholder="Preço (Ex: 25.00)" required>
            <textarea name="desc" placeholder="Descrição/Ingredientes"></textarea>
            <select name="periodo">
                <option value="manha">Manhã</option>
                <option value="tarde" selected>Almoço</option>
                <option value="noite">Jantar</option>
            </select>
            <input type="file" name="foto" required>
            <button type="submit" class="btn-ifood">CADASTRAR</button>
            <a href="produtos.php" style="display:block; text-align:center; margin-top:20px; color:#555; text-decoration:none;">Cancelar</a>
        </form>
    </div>
</body>
</html>