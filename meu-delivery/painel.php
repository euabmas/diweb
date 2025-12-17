<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle - Delivery</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #000; color: #fff; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .hub-container { text-align: center; width: 100%; max-width: 400px; padding: 20px; }
        .hub-card { 
            background: #1e1e1e; 
            padding: 30px; 
            border-radius: 20px; 
            border: 1px solid #333; 
            margin-bottom: 20px;
            transition: 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: block;
        }
        .hub-card:hover { border-color: var(--primary); transform: translateY(-5px); }
        .hub-card i { font-size: 40px; color: var(--primary); margin-bottom: 15px; }
        .hub-card h2 { margin: 0; color: #fff; font-size: 1.4rem; }
        .hub-card p { color: #777; font-size: 0.9rem; margin-top: 10px; }
    </style>
</head>
<body>

<div class="hub-container">
    <h1 style="color: var(--primary); margin-bottom: 40px;">Sistema <span style="color:#fff">Delivery</span></h1>

    <a href="index.php" class="hub-card">
        <i class="fa fa-utensils"></i>
        <h2>Visão do Cliente</h2>
        <p>Acesse o cardápio, faça pedidos e realize avaliações.</p>
    </a>

    <a href="admin/login.php" class="hub-card">
        <i class="fa fa-user-shield"></i>
        <h2>Visão Administrador</h2>
        <p>Gerenciar produtos, ver pedidos e relatórios de vendas.</p>
    </a>
</div>

</body>
</html>