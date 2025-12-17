<?php include_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Delivery - Amarelo & Preto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="manifest" href="manifest.json">
    <style>
        .header { padding: 25px 20px; text-align: center; border-bottom: 1px solid #333; background: #000; }
        .header h1 { font-size: 1.6rem; margin: 0; color: #fff; }
        .header span { color: var(--primary); }
        .filter-container { display: flex; overflow-x: auto; padding: 15px; gap: 10px; background: var(--bg); position: sticky; top: 0; z-index: 10; border-bottom: 1px solid #333; }
        .filter-btn { background: #222; border: 1px solid #444; padding: 8px 20px; border-radius: 20px; color: #fff; white-space: nowrap; cursor: pointer; font-weight: 600; }
        .filter-btn.active { background: var(--primary); color: #000; border-color: var(--primary); }
        .product-card { background: var(--card); border-radius: 15px; margin-bottom: 20px; padding: 15px; border: 1px solid #333; }
        .product-name { font-size: 1.1rem; font-weight: 700; color: var(--primary); margin: 0; }
        .product-desc { font-size: 0.85rem; color: var(--text-muted); margin: 8px 0; }
        .product-price { font-weight: 700; color: #fff; font-size: 1.1rem; }
        .product-img { width: 90px; height: 90px; border-radius: 12px; object-fit: cover; }
        #modal-order { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:100; }
        .modal-body { background: var(--card); margin: 15% auto; padding: 25px; width: 85%; border-radius: 20px; border: 1px solid var(--primary); }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #444; background: #111; color: #fff; border-radius: 8px; box-sizing: border-box; }
    </style>
</head>
<body>
<div class="app-container">
    <div class="header">
        <h1>Meu <span>Delivery</span></h1>
    </div>
    <div class="filter-container">
        <button class="filter-btn active" onclick="filtrar('todos', this)">Todos</button>
        <button class="filter-btn" onclick="filtrar('manha', this)">Manhã</button>
        <button class="filter-btn" onclick="filtrar('tarde', this)">Almoço</button>
        <button class="filter-btn" onclick="filtrar('noite', this)">Jantar</button>
    </div>
    <div style="padding: 10px;">
        <?php
        $stmt = $pdo->query("SELECT * FROM produtos WHERE disponivel = 1 ORDER BY id DESC");
        while($p = $stmt->fetch()):
        ?>
        <div class="product-card" data-periodo="<?= $p['periodo'] ?>">
            <div style="display: flex; justify-content: space-between; gap: 10px;">
                <div style="flex: 1;">
                    <h3 class="product-name"><?= htmlspecialchars($p['nome']) ?></h3>
                    <p class="product-desc"><?= htmlspecialchars($p['descricao']) ?></p>
                    <span class="product-price">R$ <?= number_format($p['preco_venda'], 2, ',', '.') ?></span>
                </div>
                <img src="<?= $p['imagem_url'] ?>" class="product-img">
            </div>
            <button class="btn-ifood" style="margin-top: 15px; padding: 10px;" onclick="abrirModal(<?= $p['id'] ?>, '<?= $p['nome'] ?>')">Adicionar ao Pedido</button>
            
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #333;">
                <?php
                $stmt_av = $pdo->prepare("SELECT * FROM avaliacoes WHERE produto_id = ? ORDER BY id DESC LIMIT 2");
                $stmt_av->execute([$p['id']]);
                $feedbacks = $stmt_av->fetchAll(PDO::FETCH_ASSOC);
                if (count($feedbacks) > 0):
                    foreach($feedbacks as $av):
                ?>
                    <div style="display: flex; gap: 10px; margin-bottom: 12px;">
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between;">
                                <span style="font-size: 0.8rem; font-weight: 700; color: #fff;"><?= htmlspecialchars($av['cliente_nome']) ?></span>
                                <div style="color: var(--primary); font-size: 0.7rem;"><?= str_repeat('★', $av['estrelas']) ?></div>
                            </div>
                            <p style="font-size: 0.8rem; color: #ccc; margin: 4px 0;">"<?= htmlspecialchars($av['comentario']) ?>"</p>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <p style="font-size: 0.75rem; color: #666; font-style: italic;">Sem avaliações ainda.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<div id="modal-order"><div class="modal-body">
    <h3 style="color: var(--primary); margin-top: 0;">Finalizar Pedido</h3>
    <form action="checkout.php" method="POST">
        <input type="hidden" name="produto_id" id="m-id">
        <input type="text" name="cliente_nome" placeholder="Seu Nome" required>
        <input type="text" name="cliente_whats" placeholder="Seu WhatsApp" required>
        <input type="text" name="cliente_end" placeholder="Endereço Completo" required>
        <button type="submit" class="btn-ifood">CONFIRMAR E PAGAR</button>
        <button type="button" onclick="fecharModal()" style="background:none; border:none; color:#777; width:100%; margin-top:15px; cursor:pointer;">Voltar</button>
    </form>
</div></div>
<script>
    function filtrar(p, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.product-card').forEach(c => {
            c.style.display = (p === 'todos' || c.dataset.periodo === p) ? 'block' : 'none';
        });
    }
    function abrirModal(id, nome) { document.getElementById('m-id').value = id; document.getElementById('modal-order').style.display = 'block'; }
    function fecharModal() { document.getElementById('modal-order').style.display = 'none'; }
</script>
</body>
</html>