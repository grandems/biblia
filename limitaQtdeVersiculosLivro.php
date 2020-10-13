<?php 
session_start();
require_once('conexao/class_model.php');
$livro = $_POST['livro'];
$capitulo = $_POST['capitulo'];
$Sql = "SELECT ver_versiculo as qtde FROM versiculos where ver_liv_id = $livro and ver_vrs_id = ".$_SESSION['versao']." and ver_capitulo = $capitulo ";
$objSql = new Model(); 
$rsSql  = $objSql->conexao->query($Sql);
if ($rsSql > 0) {
    $aux = "";
    while ($dm = $rsSql->fetch_assoc()) {
        $aux .= "<option value='".$dm['qtde']."'>". $dm['qtde']."</option>";
    }
} 
$rsSql->close;
echo  $aux;
?>