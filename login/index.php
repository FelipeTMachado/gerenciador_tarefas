<?php
include("/var/www/html/login/conexao.php");

$caminhoRelativo = "/login/";

$wrongPassword = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['email'])) {
        $wrongPassword = "Preencha seu email!";
    } elseif (empty($_POST['senha'])) {
        $wrongPassword = "Preencha sua senha!";
    } else {
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        if ($sql_query->num_rows == 1) {
            $usuario = $sql_query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['nome'] = $usuario['nome'];

						header("Location: " . $caminhoRelativo . "painel.php");
            exit();
        } else {
            $wrongPassword = "Falha ao logar, E-mail ou senha incorretos";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo $caminhoRelativo . 'style.css'; ?>">
    <link rel="stylesheet" href="<?php echo $caminhoRelativo . 'modal.css'; ?>">
    <script>
        function showModal(message) {
            document.getElementById("modal-message").textContent = message;
            document.getElementById("myModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Mostra o modal se a variável PHP indicar um erro após o envio do formulário
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($wrongPassword) { ?>
                showModal('<?php echo addslashes($wrongPassword); ?>');
            <?php } ?>
        });
    </script>
</head>
<body>
    <div class="page">
        <form action="index.php" method="POST" class="formLogin">
            <h1 class="title">Login</h1>

            <label for="email">E-mail:</label>
            <input
                type="email"
                name="email"
                id="email"
                placeholder="Digite seu e-mail"
                required
            /> 

            <label for="senha">Senha:</label>
            <input
                type="password"
                name="senha"
                id="senha"
                placeholder="Digite sua senha"
                required
            />
            <button type="submit" class="btn">Entrar</button>
            <a href="cadastro.php">Cadastre-se</a>
        </form>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p id="modal-message"></p>
        </div>
    </div>
</body>
</html>
