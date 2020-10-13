<?php
session_start();
$escolha = $_POST['nomeFonte'];
$_SESSION['nomeFonte'] = $escolha;
?>
