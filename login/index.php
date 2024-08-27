<?php
session_start();
include("/var/www/html/conexao.php");

$caminhoRelativo = "/login/";
$wrongPassword = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['email'])) {
        $wrongPassword = "Preencha seu email!";
    } elseif (empty($_POST['senha'])) {
        $wrongPassword = "Preencha sua senha!";
    } else {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Use prepared statements to prevent SQL injection
        $stmt = $mysqli->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $sql_query = $stmt->get_result();

        if ($sql_query->num_rows == 1) {
            $usuario = $sql_query->fetch_assoc();

            // Check hashed password
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['nome'] = $usuario['nome'];

                header("Location: " . $caminhoRelativo . "painel.php");
                exit();
            } else {
                $wrongPassword = "Falha ao logar, E-mail ou senha incorretos";
            }
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
