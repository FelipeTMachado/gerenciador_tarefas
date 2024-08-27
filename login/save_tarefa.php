<?php
session_start();
include("/var/www/html/conexao.php"); // Atualize o caminho para seu arquivo de conexão

// Obtém dados do formulário
$nome = $_POST['nomeTarefa'];
$descricao = $_POST['descricao'];
$arquivo = !empty($_POST['arquivo']) ? $_POST['arquivo'] : null; // Torna o arquivo opcional
$listaId = $_POST['listaId']; // Inclua o lista_id no formulário
$prazo = !empty($_POST['prazo']) ? date('Y-m-d', strtotime($_POST['prazo'])) : null; // Formata a data
$usuarioId = $_SESSION['id']; // Supondo que o ID do usuário esteja na sessão

// Prepara e vincula
$sql = "INSERT INTO tarefa (nome, descricao, arquivo, lista_id, prazo, usuario_id) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssisi", $nome, $descricao, $arquivo, $listaId, $prazo, $usuarioId); // Nota: Parametro 'arquivo' pode ser NULL

// Executa a instrução
if ($stmt->execute()) {
    header("Location: /principal.php");
    exit();
} else {
    echo "Erro ao salvar a tarefa: " . $stmt->error;
}

// Fecha a instrução e a conexão
$stmt->close();
$mysqli->close();

