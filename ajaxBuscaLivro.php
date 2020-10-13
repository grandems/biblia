<?php 
session_start();
require_once('conexao/class_model.php');
$id = $_POST['qual'];
$nome= $_POST['nome'];
?>
<br><br>
<h1><strong><?php echo $nome; ?></strong> - Capítulos</h1>
<?php

      $Sql    = "SELECT ver_capitulo, ver_liv_id FROM versiculos WHERE ver_vrs_id = ".$_SESSION['versao']." and ver_liv_id = $id GROUP BY ver_capitulo "; 
      $objSql = new Model(); 
      $rsSql  = $objSql->conexao->query($Sql);
      $i = 0;
      if ($rsSql > 0) {
          while ($dm = $rsSql->fetch_assoc()) {
             echo "<a style='font-size:140%' href='#' onclick='buscaCapituloLivro($id,".$dm['ver_capitulo'].",\"".$nome."\")'><strong>".$dm['ver_capitulo']."</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;";
             if ($dm['ver_liv_id']!='19'){
                if ($i==26){
                    echo "<br>";
                    $i=0;
                }
             } else {
              if ($i==20){
                echo "<br>";
                $i=0;
              }
             }
             $i++;
          }
        } 
      $rsSql->close;
      ?>
    
    <p class="lead">
    <table class='table table-hover'>
    <?php
      $Sql    = "SELECT * FROM versiculos WHERE ver_vrs_id = ".$_SESSION['versao']." and ver_liv_id = $id and ver_capitulo = 1 "; 
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

    <script>

function buscaCapituloLivro(arg1, arg2, arg3){
    $('#cenario').hide();
    $('#aguarde').show();
    $.ajax({
              url: 'ajaxBuscaCapituloLivro.php',
              type: 'POST',
              data: {
                      livro: arg1,
                      capitulo: arg2,
                      nome: arg3
              },
              success: function (response) { 
                $('#aguarde').hide();
                $('#cenario').hide().html(response).fadeIn(1400); 
              }
            });
      
    
}
</script>