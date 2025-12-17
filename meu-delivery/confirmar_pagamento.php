<?php
include_once 'config.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sql = "INSERT INTO pedidos (cliente_nome, cliente_whatsapp, endereco_entrega, valor_total, status_pagamento) VALUES (?, ?, ?, ?, 'PAGO (PIX)')";
    $pdo->prepare($sql)->execute([$_POST['nome'], $_POST['whats'], $_POST['end'], $_POST['valor']]);
    header("Location: sucesso.php?produto_id=" . $_POST['id_produto']);
}
?>