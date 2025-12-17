<?php
include_once '../config.php';
$stmt = $pdo->query("SELECT * FROM pedidos ORDER BY id DESC LIMIT 20");
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($pedidos);
?>