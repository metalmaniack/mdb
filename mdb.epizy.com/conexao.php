<?php
//variaveis para conexão com o BD
$db='mdb';
$user='root';
$pass='';
$host='localhost';

try{
//comando para conexão
$con = new mysqli($host, $user, $pass,$db);

}
//tratamento de erros
catch(Exception $ex){
    echo("Erro ao conectar com o banco de dados" . $ex->get_Message);
}
?>