<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}
include_once '../config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Pedidos - Admin</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #000; color: #fff; padding: 20px; display: block; }
        .order-card { background: #1e1e1e; border-left: 5px solid var(--primary); margin-bottom: 15px; padding: 20px; border-radius: 10px; }
        .status-badge { background: #2ecc71; color: #000; padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 0.8rem; }
    </style>
</head>
<body>
    <div style="max-width: 800px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 style="color: var(--primary); margin: 0;">📦 Pedidos Recentes</h2>
            <div>
                <a href="produtos.php" class="btn-ifood" style="padding: 10px 20px; text-decoration: none;">Ver Produtos</a>
                <a href="logout.php" style="color: #ff4d4d; margin-left: 20px; text-decoration: none;"><i class="fa fa-sign-out-alt"></i> Sair</a>
            </div>
        </div>

        <div id="lista-pedidos">
            <?php
            $stmt = $pdo->query("SELECT * FROM pedidos ORDER BY id DESC LIMIT 20");
            while($p = $stmt->fetch()):
            ?>
            <div class="order-card">
                <div style="display: flex; justify-content: space-between;">
                    <strong>#<?= $p['id'] ?> - <?= htmlspecialchars($p['cliente_nome']) ?></strong>
                    <span class="status-badge"><?= $p['status_pagamento'] ?></span>
                </div>
                <p style="margin: 10px 0; font-size: 0.9rem; color: #aaa;">
                    <i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($p['endereco_entrega']) ?><br>
                    <i class="fa fa-whatsapp"></i> <?= htmlspecialchars($p['cliente_whatsapp']) ?>
                </p>
                <div style="font-size: 1.1rem; font-weight: bold; color: var(--primary);">
                    Total: R$ <?= number_format($p['valor_total'], 2, ',', '.') ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <audio id="audioNotificacao" src="../notificacao.mp3"></audio>

    <script>
        // Atualiza a página a cada 30 segundos para checar novos pedidos
        setTimeout(() => { location.reload(); }, 30000);
        
        // Lógica para tocar som (opcional: pode ser disparada via AJAX em sistemas reais)
        // document.getElementById('audioNotificacao').play();
    </script>
</body>
</html>