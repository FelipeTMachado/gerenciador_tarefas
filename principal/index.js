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

