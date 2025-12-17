<?php
include_once 'config.php';
$produto_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Busca produto para exibir a foto e nome no topo
$stmt = $pdo->prepare("SELECT nome, imagem_url FROM produtos WHERE id = ?");
$stmt->execute([$produto_id]);
$produto = $stmt->fetch();

if (!$produto) die("Pedido não localizado para avaliação.");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $foto = "";
    if (isset($_FILES['foto_aval']) && $_FILES['foto_aval']['error'] == 0) {
        $foto = "uploads/aval_" . time() . ".jpg";
        move_uploaded_file($_FILES['foto_aval']['tmp_name'], $foto);
    }

    $sql = "INSERT INTO avaliacoes (produto_id, cliente_nome, estrelas, comentario, foto_aval) VALUES (?, ?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([$produto_id, $_POST['nome'], $_POST['estrelas'], $_POST['comentario'], $foto]);
    echo "<script>alert('Avaliação enviada com sucesso!'); window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliar Pedido</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css"> <style>
        body { background: #000; color: #fff; padding: 20px; display: block; }
        .header { text-align: center; margin-bottom: 30px; }
        .product-circle { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary); }
        
        /* Estrelas em Amarelo Queimado */
        .star-rating { display: flex; justify-content: center; gap: 12px; margin: 20px 0; font-size: 38px; color: #333; cursor: pointer; }
        .star-rating .active { color: var(--primary); }
        
        .box { background: #1a1a1a; padding: 25px; border-radius: 20px; border: 1px solid #333; max-width: 450px; margin: 0 auto; }
        
        input[type="text"], textarea { 
            width: 100%; 
            background: #000; 
            border: 1px solid #444; 
            color: #fff; 
            border-radius: 10px; 
            padding: 12px; 
            margin-bottom: 15px; 
            box-sizing: border-box; 
            font-family: inherit;
        }
        
        textarea { height: 120px; resize: none; }
        input:focus, textarea:focus { border-color: var(--primary); outline: none; }
        
        label { display: block; margin-bottom: 8px; font-size: 14px; color: #888; }
        .btn-send { background: var(--primary); color: #000; border: none; width: 100%; padding: 18px; border-radius: 12px; font-weight: bold; font-size: 1rem; cursor: pointer; transition: 0.3s; }
        .btn-send:hover { background: #d87d17; }
    </style>
</head>
<body>

<div class="header">
    <img src="<?= $produto['imagem_url'] ?>" class="product-circle">
    <h2 style="margin: 15px 0 5px 0;">O que você achou?</h2>
    <p style="color: var(--primary); margin: 0; font-weight: bold;"><?= htmlspecialchars($produto['nome']) ?></p>
</div>

<div class="box">
    <form method="POST" enctype="multipart/form-data">
        <div class="star-rating" id="stars">
            <i class="fa fa-star active" data-v="1"></i>
            <i class="fa fa-star active" data-v="2"></i>
            <i class="fa fa-star active" data-v="3"></i>
            <i class="fa fa-star active" data-v="4"></i>
            <i class="fa fa-star active" data-v="5"></i>
        </div>
        <input type="hidden" name="estrelas" id="estrelas_input" value="5">
        
        <label>Seu Nome</label>
        <input type="text" name="nome" placeholder="Como quer ser chamado?" required>
        
        <label>Sua Opinião</label>
        <textarea name="comentario" placeholder="Conte detalhes do sabor, temperatura e entrega..." required></textarea>
        
        <label><i class="fa fa-camera"></i> Foto do prato (opcional)</label>
        <input type="file" name="foto_aval" accept="image/*" style="margin-bottom: 20px; color: #777; font-size: 0.8rem;">

        <button type="submit" class="btn-send">PUBLICAR AVALIAÇÃO</button>
        <a href="index.php" style="display:block; text-align:center; margin-top:20px; color:#555; text-decoration:none; font-size:0.8rem;">Agora não, voltar ao início</a>
    </form>
</div>

<script>
    const stars = document.querySelectorAll('.star-rating i');
    stars.forEach(s => {
        s.onclick = function() {
            let val = this.dataset.v;
            document.getElementById('estrelas_input').value = val;
            stars.forEach(st => {
                st.classList.toggle('active', st.dataset.v <= val);
            });
        }
    });
</script>

</body>
</html>