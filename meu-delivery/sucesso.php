<?php 
// Captura o ID vindo da URL
$produto_id = isset($_GET['produto_id']) ? $_GET['produto_id'] : ''; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado!</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #000; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .success-box { text-align: center; padding: 20px; width: 100%; }
        .icon-check { font-size: 60px; color: #2ecc71; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="app-container" style="display: flex; align-items: center; justify-content: center;">
        <div class="success-box">
            <div class="icon-check"><i class="fa fa-circle-check"></i></div>
            <h1 style="color: var(--primary); margin: 0; font-size: 1.8rem;">Pedido Recebido!</h1>
            <p style="color: #eee; margin: 15px 0;">Seu pagamento foi confirmado. Já estamos preparando tudo com muito carinho!</p>
            
            <?php if($produto_id): ?>
            <div class="card" style="border: 1px solid var(--primary); margin-top: 30px; background: #1a1a1a;">
                <h3 style="color: #fff; margin-top: 0;">O que achou do prato?</h3>
                <p style="color: #aaa; font-size: 0.85rem;">Sua avaliação ajuda outros clientes e nos faz melhorar!</p>
                
                <a href="avaliar.php?id=<?= $produto_id ?>" class="btn-ifood" style="display: block; text-decoration: none; margin-top: 15px;">
                   <i class="fa fa-star"></i> DEIXAR UM COMENTÁRIO
                </a>
            </div>
            <?php endif; ?>

            <a href="index.php" style="color: #777; display: block; margin-top: 25px; text-decoration: none; font-size: 0.9rem;">
                <i class="fa fa-house"></i> Voltar ao Início
            </a>
        </div>
    </div>
</body>
</html>