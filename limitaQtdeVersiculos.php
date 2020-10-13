<?php 
session_start();
require_once('conexao/class_model.php');
$livro = $_POST['livro'];
$Sql    = "SELECT count(*) as qtde FROM versiculos where ver_liv_id = $livro and ver_vrs_id = ".$_SESSION['versao']." group by ver_vrs_id, ver_liv_id, ver_capitulo" ; 
$objSql = new Model(); 
$rsSql  = $objSql->conexao->query($Sql);
if ($rsSql > 0) {
    $qtdev = 0;
    $aux = "";
    while ($dm = $rsSql->fetch_assoc()) {
        $qtdev++;
        $aux .= "<option value='".$qtdev."'>".$qtdev."</option>";
    }
} 
$rsSql->close;
echo  $aux;
?>