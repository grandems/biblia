# biblia
Biblia em PHP

Esse projeto tem por objetivo disponibilizar a Palavra de Deus para consulta em ambiente WEB.

Poderá ser utilizado tanto na internet, como também, internamente numa intranet.

Se for rodar em Windows, sugiro fazer o download do XAMPP (https://www.apachefriends.org/pt_br/index.html) e depois, baixar o projeto numa pasta por nome biblia em c:\xampp\htdocs.

Dentro da pasta principal tem um arquivo por nome biblia.sql. Esse arquivo de script sql contém 12 versões da Bíblia, inclusive uma em Inglês.

Sugiro criar um banco, por nome biblia, se valendo do phpmyadmin (geralmente o endereço é http://localhost/phpmyadmin/ )

Em seguida, acesse o prompt do dos (comando executar -> CMD) e ir até a pasta c:\xampp\mysql\bin e digitar o seguinte comando:

mysql -uroot -p biblia < c:\xampp\htdocs\biblia\biblia.sql e em seguida dar um enter

Aguarde o processo de importação dos dados (geralmente demora uns 10 minutos. Tenha paciência e não interrompa o processo).

Feito isso, abra o navegador (Firefox, Chrome, Edge.....) e digite http://localhost/biblia/ e dê um enter.

Sua Bíblia já estará funcionando.



Se você é um desenvolvedor e tiver alguma sugestão, vamos juntos nessa empreitada. Me passa um email. Se sua sugestão for boa e se você não tiver problemas em 
compartilhar conhecimento, será muito bem vindo.

Para uma versão 2.0 eu estarei remanufaturando o código e seguindo os padrões do MVC. 

A princípio iniciei o projeto por necessidade na minha igreja, mas pretendo melhorá-lo para distribuir a todos os interessados.


Como disse no cabeçalho do index.php, espero que esse trabalho seja uma benção na sua vida e dos que estão próximos de você.


Um grande abraço,

Álvaro
