<?php
session_start();
require_once('conexao/class_model.php');
$escolha = $_POST['versao'];


$Sql    = "SELECT * FROM versoes where vrs_id <> $escolha";
$objSql = new Model(); 
$rsSql  = $objSql->conexao->query($Sql);
if ($rsSql > 0) {
    $aux = "<option value=''>Selecione</option>";
    while ($dm = $rsSql->fetch_assoc()) {
        $aux .= "<option value='".$dm['vrs_id']."'>".$dm['vrs_nome']."</option>";
    }
}
$rsSql->close;
echo $aux;
?>
