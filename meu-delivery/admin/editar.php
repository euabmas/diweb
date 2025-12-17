<?php
include_once '../config.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $desc = $_POST['desc'];
    $periodo = $_POST['periodo'];

    // Se subir nova foto, atualiza o caminho
    if (!empty($_FILES['foto']['name'])) {
        $caminho = "uploads/" . time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../" . $caminho);
        $stmt = $pdo->prepare("UPDATE produtos SET nome=?, preco_venda=?, descricao=?, periodo=?, imagem_url=? WHERE id=?");
        $stmt->execute([$nome, $preco, $desc, $periodo, $caminho, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE produtos SET nome=?, preco_venda=?, descricao=?, periodo=? WHERE id=?");
        $stmt->execute([$nome, $preco, $desc, $periodo, $id]);
    }
    header("Location: produtos.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #000; color: #fff; padding: 20px; display: block; }
        .form-edit { max-width: 500px; margin: 0 auto; background: #1e1e1e; padding: 20px; border-radius: 15px; border: 1px solid var(--primary); }
        input, select, textarea { width: 100%; padding: 12px; margin: 10px 0; background: #111; color: #fff; border: 1px solid #333; border-radius: 8px; box-sizing: border-box; }
    </style>
</head>
<body>
    <div class="form-edit">
        <h2 style="color: var(--primary);">Editar Produto</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Nome do Prato</label>
            <input type="text" name="nome" value="<?= $p['nome'] ?>" required>
            
            <label>Preço (Ex: 29.90)</label>
            <input type="number" step="0.01" name="preco" value="<?= $p['preco_venda'] ?>" required>
            
            <label>Descrição</label>
            <textarea name="desc" rows="3"><?= $p['descricao'] ?></textarea>
            
            <label>Período</label>
            <select name="periodo">
                <option value="manha" <?= $p['periodo'] == 'manha' ? 'selected' : '' ?>>Manhã</option>
                <option value="tarde" <?= $p['periodo'] == 'tarde' ? 'selected' : '' ?>>Tarde</option>
                <option value="noite" <?= $p['periodo'] == 'noite' ? 'selected' : '' ?>>Noite</option>
            </select>

            <label>Trocar Foto (Deixe vazio para manter a atual)</label>
            <input type="file" name="foto">
            
            <button type="submit" class="btn-ifood">SALVAR ALTERAÇÕES</button>
            <a href="produtos.php" style="display:block; text-align:center; margin-top:15px; color:#777; text-decoration:none;">Cancelar</a>
        </form>
    </div>
</body>
</html>