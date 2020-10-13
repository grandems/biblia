<?php
session_start();

/*
*  @autor: Álvaro Paniago Gonçalves
*  @email: grande.msi@terra.com.br
*  @data: 13.10.2020
*  @versão: 1.0
*
*  Compartilho com todos a bíblia para WEB (intranet ou internet)
*  Que seja uma benção na sua vida!
*
*  Agradecimentos: Deus pela sua misericórdia e bondade, que aceitou de mim
*                  um pecador, esse trabalho.
*
*                  Autores do PHP, MariaDB, Bootstrap, Jquery e HTML, que de maneira
*                  voluntária disponibilizaram essas maravilhas de ferramentas que facilitaram
*                  o desenvolvimento desse aplicativo.
*/
$_SESSION['versao'] = 2;
$_SESSION['versaoNome'] = '1969 - Almeida Revisada e Corrigida';
$_SESSION['nomeFonte'] = 'Tahoma';
require_once('conexao/class_model.php');
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Bíblia">
    <meta name="author" content="Álvaro Paniago Gonçalves - Igreja Batista Emanueal - Campo Grande-MS">
    <title>IBE - Bíblia Sagrada</title>

    <!-- Bootstrap core CSS -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap-4.5.2-dist/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">

    <!-- css personalizado -->
    <link href="css/estilos.css" rel="stylesheet">

    <style>
    .container {
      font-family: <?php echo $_SESSION['nomeFonte']; ?>
    }
    </style>
  </head>
  <body>

    <!-- Modal para escolha dos versículos -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"><strong>Seleção de Versículos</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class='row col-sm-12'>
              <div class='col-sm-5'>
                <label for='livro'>Livro</label>
                <select id="livro" name='livro' class="form-control" data-placeholder="Selecione..." onchange="limitaLivro(this.value,1)">
                  <option value=''>Selecione</option>
                      <?php
                      $Sql    = "SELECT * FROM livros"; 
                      $objSql = new Model(); 
                      $rsSql  = $objSql->conexao->query($Sql);
                      if ($rsSql > 0) {
                          while ($dm = $rsSql->fetch_assoc()) {
                            echo "<option value='".$dm['liv_id']."'>".$dm['liv_nome']."</option>";
                          }
                      }
                      $rsSql->close;
                      ?>
                  </select>
              </div>
              <div class='col-sm-2'>
                 <label for='capitulo'>Capítulo</label>
                 <select class='form-control' id='capitulo' name='capitulo' onblur="limitaVersiculo(livro.value, this.value, 1)"></select>
              </div>
                <div class='col-sm-2'>
                  <label for='versiculo'>Versículo</label>
                    <select class='form-control' id='versiculo' name='versiculo'></select>
                </div>
                <div class='col-sm-3' style='padding-top:32px'>
                    <button class='btn btn-success' id='btnAdicionar' name='adicionar'>Adicionar</button>
                </div>
                      
                
                <div class='row'>
                  <div class='col-sm-12'><br>
                        <a href='#' class='text-danger' id='apagarTudo' onclick="$('#novosVersiculos').html('')"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg> Apagar todos os versículos selecionados até o momento</a> 
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info " data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Fim Modal para escolha dos versículos -->


    <!-- Modal para escolha de 2 versões na mesma tela -->
    <div class="modal fade" id="exampleModalLong2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"><strong>Seleção de Versões</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <div class='row col-sm-12'>
          <div class='col-sm-6'>
                <label for='livroCompara'>Livro</label>
                <select id="livroCompara" name='livroCompara' class="form-control" data-placeholder="Selecione..." onchange="limitaLivro(this.value,2)">
                  <option value=''>Selecione</option>
                      <?php
                      $Sql    = "SELECT * FROM livros"; 
                      $objSql = new Model(); 
                      $rsSql  = $objSql->conexao->query($Sql);
                      if ($rsSql > 0) {
                          while ($dm = $rsSql->fetch_assoc()) {
                            echo "<option value='".$dm['liv_id']."'>".$dm['liv_nome']."</option>";
                          }
                      }
                      $rsSql->close;
                      ?>
                  </select>
              </div>
              <div class='col-sm-3'>
                 <label for='capituloCompara'>Capítulo</label>
                 <select class='form-control' id='capituloCompara' name='capituloCompara' onchange="limitaVersiculo(livroCompara.value, this.value,2)"></select>
              </div>
              <div class='col-sm-3'>
                <label for='versiculoCompara'>Versículo</label>
                  <select class='form-control' id='versiculoCompara' name='versiculoCompara'></select>
              </div>
              <br><br>
              <div class='col-sm-5'>
                <label for='versao1'>Comparar</label>
                <select id="versao1" name='versao1' class="form-control" data-placeholder="Selecione..." onchange="excluiVersaoCompara(this.value)">
                  <option value=''>Selecione</option>
                      <?php
                      $Sql    = "SELECT * FROM versoes"; 
                      $objSql = new Model(); 
                      $rsSql  = $objSql->conexao->query($Sql);
                      if ($rsSql > 0) {
                          while ($dm = $rsSql->fetch_assoc()) {
                            echo "<option value='".$dm['vrs_id']."'>".$dm['vrs_nome']."</option>";
                          }
                      }
                      $rsSql->close;
                      ?>
                  </select>
              </div>
              <div class='col-sm-5'>
              <label for='versao2'>Com a versão</label>
                <select id="versao2" name='versao2' class="form-control" data-placeholder="Selecione...">
                  
                </select>

              </div>
              <div class='col-sm-2' style='padding-top:32px'>
                  <button class='btn btn-success' id='btnComparar' name='comparar'>Mostrar</button>
              </div>
          </div>
          <br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-info " data-dismiss="modal">Fechar</button>
          </div>

          
          </div>
        </div>
      </div>
    </div>
    <!-- Fim Modal para escolha de 2 versões -->

    <!-- Modal para escolha de fontes -->
    <div class="modal fade" id="exampleModalLong3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"><strong>Mudar tipo da letra</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <div class='row col-sm-12'>
            <div class='col-sm-3'>
              <label><input type='radio' value='Calibri' name='fonte[]' id='fonte1'>&nbsp;<font style='font-family:calibri; font-size:20px' onclick="todaFonte('Calibri')">Calibri</font></label>
            </div>
            <div class='col-sm-3'>
              <label><input type='radio'   value='Calisto MT' name='fonte[]' id='fonte2'>&nbsp;<font style='font-family:"Calisto MT"; font-size:20px' onclick="todaFonte('Calisto MT')">Calisto MT</font></label>
            </div>
            <div class='col-sm-3'>
              <label><input type='radio'   value='Cambria' name='fonte[]' id='fonte3'>&nbsp;<font style='font-family:Cambria; font-size:20px' onclick="todaFonte('Cambria')">Cambria</font></label>
            </div>
            <div class='col-sm-3'>
              <label><input type='radio'   value='Candara' name='fonte[]' id='fonte4'>&nbsp;<font style='font-family:Candara; font-size:20px' onclick="todaFonte('Candara')">Candara</font></label>
            </div>
            <div class='col-sm-3'>
              <label><input type='radio'   value='Consolas' name='fonte[]' id='fonte5'>&nbsp;<font style='font-family:Consolas; font-size:20px' onclick="todaFonte('Consolas')">Consolas</font></label>
            </div>
            <div class='col-sm-3'>
              <label><input type='radio'   value='Courier New' name='fonte[]' id='fonte6'>&nbsp;<font style='font-family:"Courier New"; font-size:20px' onclick="todaFonte('Courier New')">Courier New</font></label>
            </div>
            <div class='col-sm-3'>
              <label><input type='radio'   value='Dejavu Sans' name='fonte[]' id='fonte7'>&nbsp;<font style='font-family:"Dejavu Sans"; font-size:20px' onclick="todaFonte('Dejavu Sans')">Dejavu Sans</font></label>
            </div>
            <div class='col-sm-3'>
              <label><input type='radio'   value='Garamond' name='fonte[]' id='fonte8'>&nbsp;<font style='font-family:Garamond; font-size:20px' onclick="todaFonte('Garamond')">Garamond</font></label>
            </div>            
            <div class='col-sm-3'>
              <label><input type='radio'   value='Helveticas' name='fonte[]' id='fonte9'>&nbsp;<font style='font-family:Helveticas; font-size:20px' onclick="todaFonte('Helveticas')">Helveticas</font></label>
            </div>
            <div class='col-sm-3'>
              <label><input type='radio'   value='Impact' name='fonte[]' id='fonte10'>&nbsp;<font style='font-family:Impact; font-size:20px' onclick="todaFonte('Impact')">Impact</font></label>
            </div>
            <div class='col-sm-3'>
              <label><input type='radio'   value='Optima' name='fonte[]' id='fonte11'>&nbsp;<font style='font-family:"Arial Black"; font-size:20px' checked  onclick="todaFonte('Arial Black')">Arial Black</font></label>
            </div>
            <div class='col-sm-3'>
              <label><input type='radio'   value='Tahoma' name='fonte[]' id='fonte12'>&nbsp;<font style='font-family:Tahoma; font-size:20px'  onclick="todaFonte('Tahoma')">Tahoma </font></label>
            </div>            
            <div class='col-sm-12' style='padding-top:32px'>
                <center>
                  <button class='btn btn-info' id='btnGravarFonte' name='gravarFonte'>Selecionar</button>
                </center>
            </div>

            <div class="modal-footer" style='display:none'>
                <button type="button" class="btn btn-success " data-dismiss="modal" id='fonteFechar'>Fechar</button>
             </div>
            </div>
          <br><br>
          
          </div>
        </div>
      </div>
    </div>
    <!-- Fim Modal para escolha da fonte -->



  <div class="d-flex toggled" id="wrapper">  

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper" style='margin-top:90px'>
      <div class="sidebar-heading"><strong>Opções</strong> </div>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#exampleModalLong">Lista de Versículos</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#exampleModalLong2">Comparar 2 versões</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#exampleModalLong3">Mudar Tipo da Letra</a>

        <div class='row' id='versiculos' style='padding-top:15px'>
          
          <div class="col col-sm-12" style='margin-left:35px;display:none' id='novosVersiculos'><strong>Versículos selecionados</strong></div>
        </div>

      </div>

    </div>
    <!-- /#sidebar-wrapper -->

    
    <!-- menu direito para aumentar e diminuir texto -->
    <ul id='menuDireito' style='list-style-type: none'>
      <li title='Aumentar tamanho do texto'><a href="#" onclick="tamanhoTexto('+')"><svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-file-earmark-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/> <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/><path fill-rule="evenodd" d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/></svg></a></li>
      <li title='Diminuir tamanho do texto'><a href="#" onclick="tamanhoTexto('-')"><svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-file-earmark-minus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm7.5 1.5v-2l3 3h-2a1 1 0 0 1-1-1zM6 8.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1H6z"/></svg></a></li>
      <li title='Tamanho padrão do texto'>&nbsp;<a href="#" onclick="tamanhoTexto('p')"><svg width="1.1em" height="1.1em" viewBox="0 0 16 16" class="bi bi-arrows-fullscreen" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707zm4.344 0a.5.5 0 0 1 .707 0l4.096 4.096V11.5a.5.5 0 1 1 1 0v3.975a.5.5 0 0 1-.5.5H11.5a.5.5 0 0 1 0-1h2.768l-4.096-4.096a.5.5 0 0 1 0-.707zm0-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707zm-4.344 0a.5.5 0 0 1-.707 0L1.025 1.732V4.5a.5.5 0 0 1-1 0V.525a.5.5 0 0 1 .5-.5H4.5a.5.5 0 0 1 0 1H1.732l4.096 4.096a.5.5 0 0 1 0 .707z"/></svg></a></li>
    </ul>
    <!-- fim menu direito para aumentar e diminuir texto -->

    <!-- Topo da Página -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#"><strong>Bíblia Sagrada</strong></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <span class="btn btn-default" id="menu-toggle">
        <span id='lateralEsquerda'>
          <svg width="1.6em" height="1.6em" viewBox="0 0 16 16" class="bi bi-toggle2-on" fill="currentColor" xmlns="http://www.w3.org/2000/svg" color="#ffffff">
          <path d="M7 5H3a3 3 0 0 0 0 6h4a4.995 4.995 0 0 1-.584-1H3a2 2 0 1 1 0-4h3.416c.156-.357.352-.692.584-1z"/>
          <path d="M16 8A5 5 0 1 1 6 8a5 5 0 0 1 10 0z"/>
        </svg>
        </span>
    </span>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item  active" style='font-size:90%'>
          <a class="nav-link" href="#" id="Todos" onclick="ajaxTodas(1,0)">Todos os Livros <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" id="Velho" onclick="ajaxTodas(1,1)">Velho Testamento <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" id="Novo" onclick="ajaxTodas(1,2)">Novo Testamento <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Versões</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="#" onclick='versaoBiblia(1)'>1993 - Almeida Revisada e Atualizada</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(2)'>1969 - Almeida Revisada e Corrigida</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(3)'>2009 - Almeida Revisada e Corrigida</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(4)'>2017 - Nova Almeida Aualizada</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(5)'>2000 - Nova Tradução na Linguagem de Hoje</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(6)'>Nova Versão Internacional</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(7)'>Nova Versão Transformadora</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(8)'>1848 - Almeida Antiga</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(9)'>Almeida Recebida</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(10)'>King James Atualizada</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(11)'>Basic English Bible</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(12)'>New International Version</a>
            <a class="dropdown-item" href="#" onclick='versaoBiblia(13)'>American Standard Version</a>
          </div>
        </li>
        <li class="nav-item" style='margin-top:5px'>
          <span id='versaoAtual' style='color:#ffff00;font-size:70%'>("<?php echo $_SESSION['versaoNome'];?>")</span>
        </li>      

      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Pesquisar" aria-label="Search" name='txtBusca' id='txtBusca' style='width:130px'>
        <button class="btn btn-secondary my-2 my-sm-0" type="button" onclick="btnBusca()"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3"><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg></button>
      </form>
    </div>
   </nav>
   <br>

   <!-- cenário onde o ajax trabalha -->
  <main role="main" class="container" id="page-content-wrapper">
    <div id="cenario" style='margin-top:30px'></div>
    <div id='aguarde' class='col-span-12' style='margin-top:90px;text-align:center'>
      <h1><img src='img/carregando.gif' border='0' width='30%'></h1>
    </div>
  </main><!-- /.container -->
  <!-- fim cenário onde o ajax trabalha -->
  <br><br>
  
  <!-- rodapé -->
  <footer>
    <div class="navbar navbar-inverse navbar-dark bg-dark fixed-bottom">
        <font style='color:#ffffff;font-size:80%' class='text text-warning'><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 3.293l6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/><path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/></svg> Igreja Batista Emanuel - Lugar de Paz e Comunhão
        </font>
    </div>
  </footer>
</div>
  
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="./js/jquery.min.js" ></script>
<script src="./bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>    
<script src="./js/bootstrap.bundle.min.js"></script>
<script src="./js/scripts.js"></script>

    </body>
</html>
