<?php

if (!isset($_SESSION)) {
    session_start();
}

include("conexao.php"); 

// Check if user ID is set
$id = $_SESSION['id'] ?? null;
if (!$id) {
    die("ID do usuário não definido.");
}

// Fetch quadro
$sqlQuadro = "SELECT id, nome FROM quadro WHERE usuario_id = ?";
$stmtQuadro = $mysqli->prepare($sqlQuadro);
$stmtQuadro->bind_param("i", $id);
$stmtQuadro->execute();
$resultQuadro = $stmtQuadro->get_result();

$quadrosHtml = '';
while ($row = $resultQuadro->fetch_assoc()) {
    $quadrosHtml .= '<li class="quadro" data-id="' . htmlspecialchars($row['id']) . '">
                        <a href="#" onclick="selecionarQuadro(event, this, ' . htmlspecialchars($row['id']) . ', ' . htmlspecialchars($_SESSION['id']) . ')">'
                        . htmlspecialchars($row['nome']) . 
                        '</a>
                     </li>';
}

// Fetch lists based on selected quadro
$quadroAtual = $_SESSION['quadroAtual'] ?? null;
if ($quadroAtual) {
    $sqlLista = "SELECT * FROM lista WHERE quadro_id = ? AND usuario_id = ?";
    $stmtLista = $mysqli->prepare($sqlLista);
    $stmtLista->bind_param("ii", $quadroAtual, $_SESSION['id']);
    $stmtLista->execute();
    $resultLista = $stmtLista->get_result();

    $listasHtml = '';
    while ($row = $resultLista->fetch_assoc()) {
        // Fetch tasks for each list
        $sqlTarefa = "SELECT * FROM tarefa WHERE lista_id = ? AND usuario_id = ?";
        $stmtTarefa = $mysqli->prepare($sqlTarefa);
        $stmtTarefa->bind_param("ii", $row['id'], $_SESSION['id']);
        $stmtTarefa->execute();
        $resultTarefa = $stmtTarefa->get_result();

        $tarefaHtml = '';
        while ($task = $resultTarefa->fetch_assoc()) {
            $tarefaHtml .= '<li class="itemTarefa">
                                <a href="#">
                                    <p>' . htmlspecialchars($task['nome']) . '</p>
                                    <p>' . htmlspecialchars($task['prazo']) . '</p>
                                </a> 
                                <input type="checkbox" name="concluida" id="concluida">
                            </li>';
        }

        $listasHtml .= '<div class="containerLista">
                            <div class="topLista">
                                <p class="nomeLista">' . htmlspecialchars($row['nome']) . '</p>
                                <button id="showTarefaForm" onclick="showTarefaForm()">+</button>
                            </div>
                            <ul class="lista">
                                <li class="itemLista">
                                    <ul class="tarefa">
                                        ' . $tarefaHtml . '
                                    </ul>
                                </li>
                            </ul>
                        </div>';
    }
} else {
    $listasHtml = '<p>Nenhum quadro selecionado.</p>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/stylesheets/main.css">
    <title>Página inicial</title>
</head>
<body>
    <header>
        <nav>
            <ul>
              <li class="li"><button id="showFormQuadro" onclick="showQuadroForm()">Novo Quadro</button></li>
              <li class="li"><button id="showFormLista" onclick="showListaForm()">Nova Lista</button></li>
              <li class="nav-endItems">
                <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="44px" viewBox="0 0 15 44">
                  <path d="M14.298,27.202l-3.87-3.87c0.701-0.929,1.122-2.081,1.122-3.332c0-3.06-2.489-5.55-5.55-5.55c-3.06,0-5.55,2.49-5.55,5.55 c0,3.061,2.49,5.55,5.55,5.55c1.251,0,2.403-0.421,3.332-1.122l3.87,3.87c0.151,0.151,0.35,0.228,0.548,0.228 s0.396-0.076,0.548-0.228C14.601,27.995,14.601,27.505,14.298,27.202z M1.55,20c0-2.454,1.997-4.45,4.45-4.45 c2.454,0,4.45,1.997,4.45,4.45S8.454,24.45,6,24.45C3.546,24.45,1.55,22.454,1.55,20z"></path>
                </svg>
              </li>
            </ul>
        </nav>
    </header>
    <div id="overlay" class="overlay"></div>
    <div id="containerPrincipal">
        <aside>
            <div class="topContent">
                <h1 class="nomeLogado">Yohanês</h1>
                <h2><a href="/login/logout.php">Logout</a></h2>
            </div>
            <br>
            <ul class="quadrosAside">
                <?php echo $quadrosHtml; ?>
            </ul>
        </aside>
        <main>
            <div class="containerMain">
                <?php echo $listasHtml; ?>
            </div>
        </main>
    </div>
    <div id="quadroForm" style="display: none;" class="newForm">
        <button onclick="closeForm()" id="btnClose">x</button>
        <form action="/login/save_quadro.php" method="POST">
            <label for="nomeQuadro">Nome do Quadro:</label>
            <input type="text" id="nomeQuadro" name="nomeQuadro" required>
            <button type="submit" onclick="closeForm()">Criar Quadro</button>
        </form>
    </div>
    
    <div id="listaForm" style="display: none;" class="newForm">
        <button onclick="closeForm()" id="btnClose">x</button>
        <form action="/login/save_lista.php" method="POST">
            <label for="nomeLista">Nome da Lista:</label>
            <input type="text" id="nomeLista" name="nomeLista" required>
            <button type="submit" onclick="closeForm()">Criar Lista</button>
        </form>
    </div>
    
    <div id="tarefaForm" style="display: none;" class="newForm">
        <button onclick="closeForm()" id="btnClose">x</button>
        <form action="/login/save_tarefa.php" method="POST" enctype="multipart/form-data">
            <label for="nomeTarefa">Nome da Tarefa:</label>
            <input type="text" id="nomeTarefa" name="nomeTarefa" required>
    
            <label for="descricaoTarefa">Descrição:</label>
            <textarea id="descricaoTarefa" name="descricaoTarefa" required></textarea>
    
            <label for="arquivoTarefa">Arquivo:</label>
            <input type="file" id="arquivoTarefa" name="arquivoTarefa">
    
            <label for="prazoTarefa">Prazo:</label>
            <input type="date" id="prazoTarefa" name="prazoTarefa" required>
    
            <button type="submit" onclick="closeForm()">Criar Tarefa</button>
        </form>
    </div>
    <script src="/javascript/index.js" defer></script>
</body>
</html>
