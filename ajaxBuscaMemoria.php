<?php 
session_start();
require_once('conexao/class_model.php');
$livro    = $_POST['livro'];
$capitulo = $_POST['capitulo'];
$versiculo= $_POST['versiculo'];
$nome     = $_POST['nome'];
?>
<br><br>
<h1><strong><?php echo $nome; ?></strong></h1>
    <p class="lead">
    <table class='table table-hover'>
    <?php
      $Sql    = "SELECT * FROM versiculos WHERE ver_vrs_id = ".$_SESSION['versao']." and ver_liv_id = $livro and ver_capitulo = $capitulo  and ver_versiculo = $versiculo"; 
      $objSql = new Model(); 
      $rsSql  = $objSql->conexao->query($Sql);
      if ($rsSql > 0) {
          $tabOrdem = 100;
          while ($dm = $rsSql->fetch_assoc()) {
             echo "<tr><td tabindex=".$tabOrdem."><strong><font style='font-size:190%'>".$dm['ver_versiculo']."</strong> - ".$dm['ver_texto']."</font></td></tr>";
             $tabOrdem++;
          }
        } 
      $rsSql->close;
      ?>
      </table>
    </p>
