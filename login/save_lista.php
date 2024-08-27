<?php

if (!isset($_SESSION)) {
    session_start();
}

include("/var/www/html/conexao.php");


// Get form data
$nome = $_POST['nomeLista'];
$id = $_SESSION['quadroAtual'];
$idUSR = $_SESSION['id'];

// Prepare and bind
$stmt = $mysqli->prepare("INSERT INTO lista (nome, quadro_id, usuario_id) VALUES (?, ?, ?)");
$stmt->bind_param("sii", $nome, $id, $idUSR); 

// Execute the statement
if ($stmt->execute()) {
    header("Location: /principal.php");
    exit();
} else {
    echo "Erro ao salvar a lista: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$mysqli->close();

