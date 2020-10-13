<?php 
session_start();
require_once('conexao/class_model.php');
$livro = $_POST['livro'];
?>
<br><br>
<h1>Livros da Bíblia</h1>
    <p class="lead">
    <?php
      $Sql    = "SELECT * FROM livros"; 
      $objSql = new Model(); 
      $rsSql  = $objSql->conexao->query($Sql);
      if ($rsSql > 0) {
          $i=0;
          $novo = 0;
          echo "<h3><strong>Velho Testamento</strong></h3>";
          while ($dm = $rsSql->fetch_assoc()) {
              if  ($dm['liv_tes_id']==1 && ($livro==0 || $livro==1)) { // Velho Testamento
                $novo = 1;
                if ($i==8) {
                  echo "<br>";
                  $i = 0;
                } else { 
                    echo "<a style='font-size:140%' href='#' onclick='mostraLivro(".$dm['liv_id'].",\"".$dm['liv_nome']."\")'>".$dm['liv_nome']."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                } 
              } elseif ($dm['liv_tes_id'] == 2  && ($livro==0 || $livro==2)) { // Novo Testamento
                if ($novo == 1) {
                  echo "<br><br><h3><strong>Novo Testamento</strong></h3>";
                  $novo = 2;
                  $i = 0;
                }
                if ($i==8) {
                  echo "<br>";
                  $i = 0;
                } else { 
                    echo "<a style='font-size:140%'  href='#' onclick='mostraLivro(".$dm['liv_id'].",\"".$dm['liv_nome']."\")'>".$dm['liv_nome']."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                } 
                
              }
              $i++;
            }
        } 
      $rsSql->close;
      ?>
    </p>

    
<script>
function mostraLivro(arg1, arg2){
    $('#cenario').hide();
    $('#aguarde').show();
    $.ajax({
              url: 'ajaxBuscaLivro.php',
              type: 'POST',
              data: {
                      qual: arg1,
                      nome: arg2
              },
              success: function (response) { 
                $('#aguarde').hide();
                $('#cenario').hide().html(response).fadeIn(1400); 
              }
            });
}

var NomeVersao = "(<?php echo $_SESSION['versaoNome'];?>)";

$('#versaoAtual').hide().html(NomeVersao).fadeIn(3000);
</script>