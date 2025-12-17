<?php
include_once 'config.php';

// Verifica se o ID do produto foi enviado
if (!isset($_POST['produto_id'])) {
    header("Location: index.php");
    exit;
}

$p_id = $_POST['produto_id'];

// Busca todos os dados do produto, incluindo a imagem
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$p_id]);
$produto = $stmt->fetch();

if (!$produto) {
    die("Produto não encontrado.");
}

$valor = $produto['preco_venda'];
// Geramos a chave Pix dinâmica com o valor do produto
$chave_pix = "00020126580014BR.GOV.BCB.PIX0136suachaveaqui12345678905204000053039865405" . number_format($valor, 2, '.', '') . "5802BR5913MEU_DELIVERY6009SAO_PAULO62070503***6304ABCD";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Pix</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #000; color: #fff; }
        .checkout-header { padding: 20px; text-align: center; border-bottom: 1px solid #333; }
        .product-preview { display: flex; align-items: center; gap: 15px; background: #1a1a1a; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #333; }
        .product-preview img { width: 80px; height: 80px; border-radius: 10px; object-fit: cover; border: 1px solid var(--primary); }
        .pix-box { background: #fff; padding: 20px; border-radius: 15px; margin: 20px 0; display: inline-block; }
    </style>
</head>
<body>
<div class="app-container">
    <div class="checkout-header">
        <h2 style="color: var(--primary); margin: 0;">Finalizar Pedido</h2>
    </div>

    <div style="padding: 20px;">
        <div class="product-preview">
            <img src="<?= htmlspecialchars($produto['imagem_url']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
            <div>
                <h3 style="margin: 0; font-size: 1rem;"><?= htmlspecialchars($produto['nome']) ?></h3>
                <p style="margin: 5px 0; color: var(--primary); font-weight: bold;">R$ <?= number_format($valor, 2, ',', '.') ?></p>
            </div>
        </div>

        <div class="card" style="text-align: center;">
            <p style="color: #ccc; font-size: 0.9rem;">Escaneie o QR Code abaixo para pagar:</p>
            
            <div class="pix-box">
                <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?= urlencode($chave_pix) ?>" style="width: 180px;">
            </div>

            <button onclick="copyPix()" class="btn-pix" style="margin-bottom: 15px;">
                <i class="fa fa-copy"></i> Copiar Código Pix
            </button>
            
            <form action="confirmar_pagamento.php" method="POST">
                <input type="hidden" name="nome" value="<?= htmlspecialchars($_POST['cliente_nome']) ?>">
                <input type="hidden" name="whats" value="<?= htmlspecialchars($_POST['cliente_whats']) ?>">
                <input type="hidden" name="end" value="<?= htmlspecialchars($_POST['cliente_end']) ?>">
                <input type="hidden" name="valor" value="<?= $valor ?>">
                <button type="submit" class="btn-ifood">JÁ REALIZEI O PAGAMENTO</button>
            </form>
            
            <a href="index.php" style="display:block; margin-top:20px; color:#666; text-decoration:none; font-size: 0.8rem;">Cancelar e voltar</a>
        </div>
    </div>
</div>

<script>
function copyPix() {
    const text = "<?= $chave_pix ?>";
    navigator.clipboard.writeText(text).then(() => {
        alert("Código Pix copiado para a área de transferência!");
    });
}
</script>
</body>
</html>