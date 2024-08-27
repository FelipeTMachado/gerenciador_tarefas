<?php

if (!isset($_SESSION)) {
    session_start();
}

// Função para obter listas e tarefas
function getListsAndTasks($quadroId, $id) {
    // Configurações de conexão com o banco de dados
    $conn = new mysqli('gerenciador-mysql', 'root', 'senha', 'gerenciadorTarefas');

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Consulta SQL para pegar as listas e tarefas baseadas no quadro e usuário
    $sql = "SELECT l.id AS lista_id, l.nome AS lista_nome, 
                   t.id AS tarefa_id, t.nome AS tarefa_nome, t.descricao, t.arquivo, t.prazo
            FROM lista l
            LEFT JOIN tarefa t ON l.id = t.lista_id
            WHERE l.quadro_id = ? AND l.id IN (
                SELECT id FROM lista WHERE quadro_id = ?)
            ORDER BY l.id, t.id";

    // Prepara e executa a consulta
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param('ii', $quadroId, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Array para armazenar as listas e tarefas
    $listas = [];
    while ($row = $result->fetch_assoc()) {
        $listaId = $row['lista_id'];

        if (!isset($listas[$listaId])) {
            $listas[$listaId] = [
                'nome' => $row['lista_nome'],
                'tarefas' => []
            ];
        }

        if ($row['tarefa_id']) {
            $listas[$listaId]['tarefas'][] = [
                'id' => $row['tarefa_id'],
                'nome' => $row['tarefa_nome'],
                'descricao' => $row['descricao'],
                'arquivo' => $row['arquivo'],
                'prazo' => $row['prazo']
            ];
        }
    }

    $stmt->close();
    $conn->close();

    return $listas;
}

// Exemplo de uso
$quadroId = $_SESSION['quadroAtual'] ?? 0; // Certifique-se de que a variável da sessão está definida
$id = $_SESSION['id'] ?? 0; // Certifique-se de que a variável da sessão está definida

$listasTarefas = getListsAndTasks($quadroId, $id);

// Exibir os resultados (opcional)

print_r($listasTarefas);


