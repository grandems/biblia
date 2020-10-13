<?php
class Model
{

    public $conexao;

    function __construct()
    {
        
        if ($this->conexao) 
        {
            //NÃO PERMITIR CONEXÃO DESNECESSÁRIA
        }
        else
        {
            $this->conexao = $this->ConectaBancoGeral();
        }
    }

    function __destruct()
    {
        if ($this->conexao)
            $this->conexao->close();
    }


    public static function ConectaBancoGeral()
    {
        $usuario = "root";
        $senha = "";
        $servidor = "localhost";
        $nomeBD = "biblia";

        $conexao = new mysqli($servidor, $usuario, $senha, $nomeBD) or die("<p>Falha ao conectar com o banco de dados " . $nomeBD . "!<br>" . $conexao->connect_error . "<p>");
        $conexao->set_charset("utf8");

        return $conexao;

    }

    public static function  query($sql)
    {
        $conexao = self::ConectaBancoGeral();

        if ($conexao->query($sql)){
            $resp = $conexao->affected_rows;
        } 

        return $resp;

    }

}
?>
