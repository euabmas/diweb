<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}
include_once '../config.php';

// Lógica de exclusão e toggle (ativar/desativar) permanecem aqui...
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM produtos WHERE id = ?")->execute([$_GET['delete']]);
    header("Location: produtos.php");
}
if (isset($_GET['toggle'])) {
    $pdo->prepare("UPDATE produtos SET disponivel = NOT disponivel WHERE id = ?")->execute([$_GET['toggle']]);
    header("Location: produtos.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Produtos</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #000; color: #fff; padding: 20px; display: block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #111; }
        th { border-bottom: 2px solid var(--primary); padding: 15px; text-align: left; color: var(--primary); }
        td { padding: 15px; border-bottom: 1px solid #222; }
        .btn-acao { padding: 8px; border-radius: 5px; color: #fff; text-decoration: none; margin-right: 5px; }
    </style>
</head>
<body>
    <div style="max-width: 1000px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="color: var(--primary);">Gerenciar Itens</h2>
            <div>
                <a href="adicionar.php" class="btn-ifood" style="width: auto; padding: 10px 20px;">+ Novo Produto</a>
                <a href="pedidos.php" style="color: #777; margin-left: 20px; text-decoration: none;">Voltar aos Pedidos</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
                while($p = $stmt->fetch()):
                ?>
                <tr>
                    <td><img src="../<?= $p['imagem_url'] ?>" width="50" height="50" style="object-fit: cover; border-radius: 5px;"></td>
                    <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                    <td>R$ <?= number_format($p['preco_venda'], 2, ',', '.') ?></td>
                    <td><?= $p['disponivel'] ? '<span style="color:#2ecc71">Ativo</span>' : '<span style="color:#e74c3c">Pausado</span>' ?></td>
                    <td>
                        <a href="?toggle=<?= $p['id'] ?>" class="btn-acao" style="background:#444" title="Ligar/Desligar"><i class="fa fa-power-off"></i></a>
                        <a href="editar.php?id=<?= $p['id'] ?>" class="btn-acao" style="background:var(--primary); color:#000" title="Editar"><i class="fa fa-edit"></i></a>
                        <a href="?delete=<?= $p['id'] ?>" class="btn-acao" style="background:#e74c3c" onclick="return confirm('Apagar produto?')" title="Excluir"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>