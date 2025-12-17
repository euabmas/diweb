<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['usuario'];
    $pass = $_POST['senha'];

    // Defina seu usuário e senha aqui
    if ($user === 'admin' && $pass === '123456') {
        $_SESSION['logado'] = true;
        header("Location: pedidos.php");
    } else {
        $erro = "Usuário ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login Administrativo</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #000; color: #fff; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-box { background: #1a1a1a; padding: 40px; border-radius: 20px; border: 1px solid var(--primary); width: 320px; text-align: center; }
        input { width: 100%; padding: 12px; margin: 10px 0; background: #000; border: 1px solid #333; color: #fff; border-radius: 8px; box-sizing: border-box; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 style="color: var(--primary); margin-bottom: 25px;">Acesso Restrito</h2>
        <?php if(isset($erro)) echo "<p style='color:red; font-size:13px;'>$erro</p>"; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit" class="btn-ifood" style="margin-top: 20px;">ENTRAR NO PAINEL</button>
        </form>
        <a href="../painel.php" style="color: #555; display: block; margin-top: 20px; text-decoration: none; font-size: 12px;">Voltar ao Início</a>
    </div>
</body>
</html>