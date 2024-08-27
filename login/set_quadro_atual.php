<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['quadro_id'])) {
    $quadroId = (int)$_GET['quadro_id'];


    $_SESSION['quadroAtual'] = $quadroId;

    echo 'success';
} else {
    echo 'error';
}

