<?php 
session_start();
require_once('conexao/class_model.php');
$chave = $_POST['chave'];
$nome = "";
$id = "";
?>
<br><br>
<h1>Pesquisando por <strong><?php echo $chave; ?></strong><span id='qtde'></span></h1>
<?php
      $Sql    = "SELECT DISTINCT c.tes_nome, b.liv_nome, a.ver_liv_id, a.ver_capitulo, a.ver_versiculo, a.ver_texto FROM versiculos a inner join livros b on a.ver_liv_id = b.liv_id inner join testamentos c on b.liv_tes_id = c.tes_id where a.ver_texto like '%$chave%' and a.ver_vrs_id = ".$_SESSION['versao']; 
      $objSql = new Model(); 
      $rsSql  = $objSql->conexao->query($Sql);
      $i = 0;
      echo "<table class='table table-hover'>";
      if ($rsSql > 0) {
          while ($dm = $rsSql->fetch_assoc()) {
             echo "<tr><td>";
             $texto = $dm['ver_texto'];
             $procurar = $chave;
             $trocar = "<font color=red>".$procurar."</font>";

             $destaqueBusca = str_ireplace($procurar, $trocar, $texto);
             
             echo "<font style='font-size:190%'>". $dm['tes_nome']." - ". $dm['liv_nome']." - Cap: <strong>" . $dm['ver_capitulo']. "</strong> - Vers: <strong>". $dm['ver_versiculo']. "</strong> - <a href='#' onclick='buscaCapituloLivro(".$dm['ver_liv_id'].",".$dm['ver_capitulo'].",".$dm['ver_versiculo'].",\"".$dm['liv_nome']."\")'>". $destaqueBusca."</a></font>";
             echo "</td></tr>";
             $i++;
          }
        } 
      echo "</table>";
      $rsSql->close;
      ?>

    <script>
$('#qtde').html(' <font style="font-size:50%">- Encontrou: ' + <?php echo $i; ?> + ' ocorrências</font>');
function buscaCapituloLivro(arg1, arg2, arg3, arg4){
    $('#cenario').hide();
    $('#aguarde').show();
    $.ajax({
              url: 'ajaxBuscaCapituloLivro.php',
              type: 'POST',
              data: {
                      livro: arg1,
                      capitulo: arg2,
                      nome: arg4,
                      versiculo: arg3
              },
              success: function (response) { 
                $('#aguarde').hide();
                $('#cenario').hide().html(response).fadeIn(1400); 
              }
            });
      
    
}
</script>