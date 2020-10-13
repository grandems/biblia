<?php
session_start();
require_once('conexao/class_model.php');
$escolha = $_POST['versao'];
$_SESSION['versao'] = $escolha;


$Sql    = "SELECT * FROM versoes where vrs_id = $escolha";  
$objSql = new Model(); 
$rsSql  = $objSql->conexao->query($Sql);
if ($rsSql > 0) {
    while ($dm = $rsSql->fetch_assoc()) {
        $nomeVersao = $dm['vrs_nome'];
    }
}

$_SESSION['versaoNome'] = $nomeVersao;


$rsSql->close;

?>
