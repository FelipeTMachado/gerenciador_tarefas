document.getElementById('overlay').addEventListener('click', closeForm);

function closeForm() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('quadroForm').style.display = 'none';
    document.getElementById('listaForm').style.display = 'none';
    document.getElementById('tarefaForm').style.display = 'none';
    document.getElementById('containerPrincipal').style.filter = 'none';
}

function showQuadroForm() {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('quadroForm').style.display = 'block';
    document.getElementById('listaForm').style.display = 'none';
    document.getElementById('tarefaForm').style.display = 'none';
    document.getElementById('containerPrincipal').style.filter = 'blur(4px)';
}

function showListaForm() {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('listaForm').style.display = 'block';
    document.getElementById('quadroForm').style.display = 'none';
    document.getElementById('tarefaForm').style.display = 'none';
    document.getElementById('containerPrincipal').style.filter = 'blur(4px)';
}

function showTarefaForm() {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('tarefaForm').style.display = 'block';
    document.getElementById('quadroForm').style.display = 'none';
    document.getElementById('listaForm').style.display = 'none';
    document.getElementById('containerPrincipal').style.filter = 'blur(4px)';
}

function selecionarQuadro(event, elemento, quadroId, usuarioId) {
    event.preventDefault();

    // Remove a classe 'active' de todos os quadros
    const quadros = document.querySelectorAll('.quadro');
    quadros.forEach(quadro => quadro.classList.remove('active'));

    // Adiciona a classe 'active' ao quadro clicado
    elemento.parentElement.classList.add('active');

    // Faz a requisição AJAX para definir o quadroAtual na sessão
    fetch(`set_quadro_atual.php?quadro_id=${quadroId}`)
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                console.log("Quadro atual definido com sucesso");
                // Atualiza o conteúdo das listas e tarefas
                showAll(quadroId, usuarioId);
            } else {
                console.error('Erro ao definir o quadro atual:', data);
            }
        })
        .catch(error => console.error('Erro:', error));
}

function showAll(quadroId, usuarioId) {
    console.log("Entrou no showAll com quadroId:", quadroId);
    fetch(`get_lists_and_tasks.php?quadroId=${quadroId}&usuarioId=${usuarioId}`)
        .then(response => response.json())
        .then(data => {
            const contentDiv = document.getElementById('content');
            contentDiv.innerHTML = '';

            for (const [listaId, lista] of Object.entries(data)) {
                let listaHtml = `<h2>${lista.nome}</h2><ul>`;
                lista.tarefas.forEach(tarefa => {
                    listaHtml += `<li>${tarefa.nome} - ${tarefa.descricao} - ${tarefa.prazo}</li>`;
                });
                listaHtml += `</ul>`;
                contentDiv.innerHTML += listaHtml;
            }
        })
        .catch(error => console.error('Erro ao buscar dados:', error));
}
