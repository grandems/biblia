/*
* Scripts para consultas da Bíblia
* Autor: Álvaro Paniago Gonçalves
* 
* Para livre uso de todos
* Obrigado Senhor, pela oportunidade de usar A Tecncologia para torná-lo conhecido mais ainda
*
*/

// pesquisa o nome dos livros
function ajaxTodas(arg1,arg2) {
    $('#cenario').hide();
    $('#aguarde').show();
    $.ajax({
            url: 'ajaxCapa.php',
            type: 'POST',
            data: {
                    qual: arg1,
                    livro: arg2
            },
            success: function (response) { 
            $('#aguarde').hide();
            $('#cenario').hide().html(response).fadeIn(1400); 
            }
        });
    }

// busca palavras em toda a Bíblia
function btnBusca(){
    var arg =  $('#txtBusca').val();
    $('#cenario').hide();
    $('#aguarde').show();
    $.ajax({
            url: 'ajaxBusca.php',
            type: 'POST',
            data: {
                    chave: arg
            },
            success: function (response) { 
            $('#aguarde').hide();
            $('#cenario').hide().html(response).fadeIn(1400); 
            }
        });

    }

    // lista todas as versões disponíveis
    function versaoBiblia(arg){
    $('#cenario').hide();
    $('#aguarde').show();
    $.ajax({
            url: 'ajaxVersao.php',
            type: 'POST',
            data: {
                    versao: arg
            },
            success: function (response) { 
            $('#aguarde').hide();
            $('#cenario').hide().html(response).fadeIn(1400); 
            ajaxTodas(1);
            }
        });

    }

    // mostra e esconde o menu lateral esquerdo e muda a figura
    var flag = false;
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        if( flag == false){
        $('#lateralEsquerda').html('<svg width="1.6em" height="1.6em" viewBox="0 0 16 16" class="bi bi-toggle2-off" fill="currentColor" xmlns="http://www.w3.org/2000/svg" color="#ffffff"><path d="M9 11c.628-.836 1-1.874 1-3a4.978 4.978 0 0 0-1-3h4a3 3 0 1 1 0 6H9z"/><path fill-rule="evenodd" d="M5 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0 1A5 5 0 1 0 5 3a5 5 0 0 0 0 10z"/></svg>');
            flag = true;
        }
        else{
        $('#lateralEsquerda').html('<svg width="1.6em" height="1.6em" viewBox="0 0 16 16" class="bi bi-toggle2-on" fill="currentColor" xmlns="http://www.w3.org/2000/svg" color="#ffffff"><path d="M7 5H3a3 3 0 0 0 0 6h4a4.995 4.995 0 0 1-.584-1H3a2 2 0 1 1 0-4h3.416c.156-.357.352-.692.584-1z"/><path d="M16 8A5 5 0 1 1 6 8a5 5 0 0 1 10 0z"/></svg>');      
        flag = false;
        }
        $("#wrapper").toggleClass("toggled");
    });

    // mostra a capa, ou seja, a relação de todos os livros da Bíblia
    ajaxTodas(1);     


    // permite selecionar vários versículos para serem mostrados no momento do estudo/pregação
    $('#btnAdicionar').on('click', function(){
            $('#novosVersiculos').show();
            var livro = $('#livro :selected').text();
            var idLivro = $('#livro').val();
            var capitulo = $('#capitulo').val();
            var versiculo = $('#versiculo').val();
            $("#novosVersiculos").append('<li><a href="#" onclick="buscaVersiculoMemoria('+idLivro+','+capitulo+','+versiculo+',\''+livro+'\');selecionou('+idLivro+capitulo+versiculo+')" id=\''+idLivro+capitulo+versiculo+'\'>'+livro+',<strong>'+capitulo+'</strong>, <strong>'+versiculo+'</strong></a></li>');
    });


    // mostra o livro, capítulo, versículo da lista montada pelo usuário
    function buscaVersiculoMemoria(livro, capitulo, versiculo, nomeLivro){
        $('#cenario').hide();
        $('#aguarde').show();
        $.ajax({
                url: 'ajaxBuscaMemoria.php',
                type: 'POST',
                data: {
                        livro: livro,
                        capitulo: capitulo,
                        versiculo: versiculo,
                        nome:nomeLivro
                },
                success: function (response) { 
                $('#aguarde').hide();
                $('#cenario').hide().html(response).fadeIn(1400); 
                }
            });
    
        }
    
    // coloca um OK no versículo selecionado na lista da memória
    function selecionou(idElemento){
        var elemento = '#'+idElemento;
        $(elemento).after('&nbsp;<font color=green>ok</font>');
    }

    // limita a quantidade de capitulos de um livro escohido na bíblia 
    // no momento de montar a lista de memória
    function limitaLivro(arg,onde){
        $.ajax({
                url: 'limitaQtdeVersiculos.php',
                type: 'POST',
                data: {
                        livro: arg
                },
                success: function (response) { 
                    if (onde==1) // memória
                        $('#capitulo').hide().html(response).fadeIn(0);
                    else if (onde==2) // compara versão
                        $('#capituloCompara').hide().html(response).fadeIn(0);
                }
            });

    }

    // limita a quantidade de versículos de um capítulo de um livro escohido na bíblia 
    // no momento de montar a lista de memória
    function limitaVersiculo(livro,capitulo, onde){
        $.ajax({
                url: 'limitaQtdeVersiculosLivro.php',
                type: 'POST',
                data: {
                        livro: livro,
                        capitulo: capitulo
                },
                success: function (response) { 
                    if (onde==1)
                        $('#versiculo').hide().html(response).fadeIn(0);
                    else if (onde==2)
                        $('#versiculoCompara').hide().html(response).fadeIn(0);
                }
            });

    }

    //exclui um livro que será comparado para não induzir o usuário a comparar com ele mesmo
    function excluiVersaoCompara(versao){
        $.ajax({
                url: 'ajaxBibliaCompara.php',
                type: 'POST',
                data: {
                        versao: versao
                },
                success: function (response) { 
                    $('#versao2').hide().html(response).fadeIn(0);
                }
            });

    }

    //monta a div com as 2 versões
    $('#btnComparar').click(function(){
        var Versao1 = $('#versao1').val();
        var Versao2 = $('#versao2').val();
        var LivroCompara = $('#livroCompara').val();
        var CapituloCompara = $('#capituloCompara').val();
        var VersiculoCompara = $('#versiculoCompara').val();
        $.ajax({
            url: 'ajaxBibliaComparaMostraTela.php',
            type: 'POST',
            data: {
                    versao1: Versao1,
                    versao2: Versao2,
                    livroCompara: LivroCompara,
                    capituloCompara: CapituloCompara,
                    versiculoCompara: VersiculoCompara
            },
            success: function (response) { console.log(response);
                $('#aguarde').hide();
                $('#cenario').hide().html(response).fadeIn(1400); 

            }
        });
    
    });

    // função para aumentar, diminuir o tamanho do texto
    var $btnAumentar = $("#btnAumentar");
    var $elemento = $("body #cenario");

    function obterTamnhoFonte() {
        return parseFloat($elemento.css('font-size'));
    }

    function tamanhoTexto(arg){
        if (arg=='+')
        $elemento.css('font-size', obterTamnhoFonte() + 1);
        else if (arg=='-')
        $elemento.css('font-size', obterTamnhoFonte() - 1);
        else if (arg=='p')
        $elemento.css('font-size', '17px');
    }


function todaFonte(arg){
   $('.container').css('font-family',arg);    
}


$('#btnGravarFonte').click(function(){
    var NomeFonte = $('input[name="fonte[]"]:checked').val();
    $('#fonteFechar').trigger('click');
    $.ajax({
        url: 'ajaxNomeFonte.php',
        type: 'POST',
        data: {
                nomeFonte: NomeFonte
        },
        success: function (response) { console.log(response);

        }
    });

  });
  