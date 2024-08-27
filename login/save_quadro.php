<?php


if (!isset($_SESSION)) {
    session_start();
}

include("/var/www/html/conexao.php");


// Get form data
$nome = $_POST['nomeQuadro'];
$id = $_SESSION['id'];

// Prepare and bind
$stmt = $mysqli->prepare("INSERT INTO quadro (nome, usuario_id) VALUES (?, ?)");
$stmt->bind_param("si", $nome, $id); 

// Execute the statement
if ($stmt->execute()) {
    header("Location: /principal.php");
    exit();
} else {
    echo "Erro ao salvar o quadro: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$mysqli->close();

