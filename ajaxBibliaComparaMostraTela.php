<?php 
session_start();
require_once('conexao/class_model.php');

$versao1 = $_POST['versao1'];
$versao2 = $_POST['versao2'];
$livroCompara = $_POST['livroCompara'];
$capituloCompara = $_POST['capituloCompara'];
$versiculoCompara = $_POST['versiculoCompara'];

$aux = "<div class='container' style='margin-top:60px'><div class='row'><div class='col-sm-6' id='divComparaUm'>";
$Sql = "select * from versoes where vrs_id = $versao1";
$objSql = new Model(); 
$rsSql  = $objSql->conexao->query($Sql);
if ($rsSql > 0) {
    while ($dm = $rsSql->fetch_assoc()) {
       $aux .= "<h2 style='color:#808080'>Versão  <strong>".$dm['vrs_nome']."</strong></h2>";
    }
}
$rsSql->close;

//versão 1
$Sql    = "SELECT DISTINCT c.tes_nome, b.liv_nome, a.ver_liv_id, a.ver_capitulo, a.ver_versiculo, a.ver_texto FROM versiculos a inner join livros b on a.ver_liv_id = b.liv_id inner join testamentos c on b.liv_tes_id = c.tes_id where a.ver_capitulo = $capituloCompara  and ver_liv_id = $livroCompara and a.ver_vrs_id = $versao1"; 
$objSql = new Model(); 
$rsSql  = $objSql->conexao->query($Sql);
$i = 0;
$aux .= "<span id='titulo1'></span><table class='table table-hover'>";
if ($rsSql > 0) {
    while ($dm = $rsSql->fetch_assoc()) {
        $aux .= "<tr><td>";
        if ($dm['ver_capitulo'] == $capituloCompara && $dm['ver_versiculo'] == $versiculoCompara){
            $aux .= "<font style='font-size:190%;color:red'>". $dm['ver_versiculo']." - ". $dm['ver_texto']."</font>";
        } else {
            $aux .= "<font style='font-size:190%'>". $dm['ver_versiculo']." - ". $dm['ver_texto']."</font>";
        }
        $aux .= "</td></tr>";
        $i++;
    }
} 
$aux .= "</table></div>";
$rsSql->close;

$aux .= "<div class='col-sm-6'>";
$Sql = "select * from versoes where vrs_id = $versao2";
$objSql = new Model(); 
$rsSql  = $objSql->conexao->query($Sql);
if ($rsSql > 0) {
    while ($dm = $rsSql->fetch_assoc()) {
        $aux .= "<h2 style='color:#808080'>Versão  <strong>".$dm['vrs_nome']."</strong></h2>";
    }
}
$rsSql->close;


//versão 2
$Sql    = "SELECT DISTINCT c.tes_nome, b.liv_nome, a.ver_liv_id, a.ver_capitulo, a.ver_versiculo, a.ver_texto FROM versiculos a inner join livros b on a.ver_liv_id = b.liv_id inner join testamentos c on b.liv_tes_id = c.tes_id where a.ver_capitulo = $capituloCompara  and ver_liv_id = $livroCompara and a.ver_vrs_id = $versao2"; 
$objSql = new Model(); 
$rsSql  = $objSql->conexao->query($Sql);
$i = 0;
$aux .= "<span id='titulo2'></span><table class='table table-hover'>";
if ($rsSql > 0) {
    while ($dm = $rsSql->fetch_assoc()) {
        $nomeLivro = $dm['liv_nome'];
        $capituloNumero = $dm['ver_capitulo'];
        $aux .= "<tr><td>";
        if ($dm['ver_capitulo'] == $capituloCompara && $dm['ver_versiculo'] == $versiculoCompara){
            $aux .= "<font style='font-size:190%;color:red'>". $dm['ver_versiculo']." - ". $dm['ver_texto']."</font>";
        } else {
            $aux .= "<font style='font-size:190%'>". $dm['ver_versiculo']." - ". $dm['ver_texto']."</font>";
        }
        $aux .= "</td></tr>";
        $i++;
    }
} 
$aux .= "</table></div></div></div>";

$aux .= " 
<script>
$('#titulo1, #titulo2').html('<font style=font-size:95%>Livro: ". $nomeLivro ." - Cap: ". $capituloNumero. " </font>');
</script>";

$rsSql->close;
echo $aux;
?>

