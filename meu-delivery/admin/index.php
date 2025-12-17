<?php
session_start();
if (!isset($_SESSION['admin_logado'])) { header("Location: login.php"); exit(); }
include_once '../config.php';

// BUSCAR ESTATÍSTICAS REAIS DO BANCO
$total_pedidos = $pdo->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
$faturamento = $pdo->query("SELECT SUM(valor_total) FROM pedidos WHERE status_pagamento = 'pago'")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: sans-serif; margin: 0; display: flex; background: #f0f2f5; }
        .sidebar { width: 250px; background: #2c3e50; color: white; min-height: 100vh; padding: 20px; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 15px 0; border-bottom: 1px solid #34495e; }
        .main { flex: 1; padding: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
        .stat-card h3 { color: #666; margin: 0; }
        .stat-card p { font-size: 2rem; font-weight: bold; color: #f7931e; margin: 10px 0; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>MEU DELIVERY</h2>
    <a href="index.php"><i class="fas fa-chart-line"></i> Resumo</a>
    <a href="produtos.php"><i class="fas fa-utensils"></i> Gerenciar Cardápio</a>
    <a href="pedidos.php"><i class="fas fa-shopping-cart"></i> Pedidos Recebidos</a>
    <a href="logout.php" style="color: #e74c3c;"><i class="fas fa-sign-out-alt"></i> Sair</a>
</div>

<div class="main">
    <h1>Bem-vindo ao seu Controle</h1>
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total de Pedidos</h3>
            <p><?= $total_pedidos ?></p>
        </div>
        <div class="stat-card">
            <h3>Faturamento Total</h3>
            <p>R$ <?= number_format($faturamento, 2, ',', '.') ?></p>
        </div>
    </div>
    
    <div style="margin-top: 40px; background: white; padding: 20px; border-radius: 10px;">
        <h3>Dica do Sistema</h3>
        <p>Sempre que um novo pedido aparecer na aba <strong>Pedidos Recebidos</strong>, gere a guia para o restaurante imediatamente para evitar atrasos na entrega.</p>
    </div>
</div>

</body>
</html>