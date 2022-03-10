<?php
include 'conexao.php';
session_start();
//variaveis do formulario de cadastro de usuários
$id = $_POST['txtId'];
$nome = $_POST['txtNome'];
$telefone = $_POST['txtTelefone'];
$email = $_POST['txtEmail'];
$login = $_POST['txtLogin'];
$senha = $_POST['txtSenha'];
$acesso = $_POST['txtAcesso'];

//instruções SQL
try {
    if (isset($_POST['btnCadastrar'])) {
        //validando os campos obrigatórios
        if ($_POST['txtLogin'] != "" && $_POST['txtSenha'] != "") {
            //insert
            $insert = "Insert into usuarios(nome, telefone, email, login, senha, acesso) values ('$nome','$telefone','$email','$login','$senha','$acesso')";
            $query = mysqli_query($con, $insert);
            $result = mysqli_fetch_assoc($query);
            $result = true;
            if ($result) {
                $acao = "inserir";
                //mensagem caso funcione
                $msg = "success";
                header("Location: usuarios.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: usuarios.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            }
        }
        else{
            header("Location: usuarios.php");
        }
    }
    //select
    else if (isset($_POST['btnBuscar'])) {
        //verifica qual o parâmetro pesquisado
        if($_POST['txtNome'] != '') {
            $varBusca = 'NOME';
        } else if($_POST['txtTelefone'] != '') {
            $varBusca = 'TELEFONE';
        } else if($_POST['txtEmail'] != '') {
            $varBusca = 'EMAIL';
        } else if($_POST['txtLogin'] != '') {
            $varBusca = 'LOGIN';
        } else if($_POST['txtSenha'] != '') {
            $varBusca = 'SENHA';
        } else if($_POST['txtAcesso'] != '') {
            $varBusca = 'ACESSO';
        }
        if ($_POST['txtNome'] != "" || $_POST['txtTelefone'] != "" || $_POST['txtEmail'] != "" || $_POST['txtLogin'] != "" || $_POST['txtSenha'] != "" || $_POST['txtAcesso'] != "") {
            $select = "Select * From usuarios where nome='$nome' OR telefone='$telefone' OR email='$email' OR login='$login' OR senha='$senha' OR acesso='$acesso';";
            $query = mysqli_query($con, $select);
            $result = mysqli_fetch_assoc($query);
            if (mysqli_num_rows($query) >= 1) {
                //variavel para usar o método GET na pagina clientes.php
                $acao = "buscar";
                header("Location: usuarios.php?acao=" . base64_encode($acao) .
                "&varBusca=" . base64_encode($varBusca) . 
                "&id=" . base64_encode($result['id']) . 
                "&nome=" . base64_encode($result['nome']) . 
                "&telefone=" . base64_encode($result['telefone']) . 
                "&email=" . base64_encode($result['email']) . 
                "&login=" . base64_encode($result['login']) . 
                "&senha=".base64_encode($result['senha']) . 
                "&acesso=" . base64_encode($result['acesso']));
            } else {
                header("Location: usuarios.php");
            }
        }
        else{
            header("Location: usuarios.php");
        }
    }
    //update
    else if (isset($_POST['btnAlterar'])) {
        if ($_POST['txtId'] != "") {
            $update = "Update usuarios Set nome='$nome', telefone='$telefone', email='$email', login='$login', senha='$senha', acesso='$acesso' where id=$id;";
            $query = mysqli_query($con, $update);
            $result = mysqli_fetch_assoc($query);
            $result = true;
            if ($result) {
                $acao = "alterar";
                //mensagem caso funcione
                $msg = "success";
                header("Location: usuarios.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: usuarios.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            }
        }
        else{
            header("Location: usuarios.php");
        }
    }
    //delete
    else if (isset($_POST['btnExcluir'])) {
        if ($_POST['txtId'] != "") {
            $delete = "Delete from usuarios where id= $id;";
            $query = mysqli_query($con, $delete);
            $result = mysqli_fetch_assoc($query);
            $result = true;
            if ($result) {
                $acao = "excluir";
                //mensagem caso funcione
                $msg = "success";
                header("Location: usuarios.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: usuarios.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            }
        }
        else{
            header("Location: usuarios.php");
        }
    }
} catch (Exception $ex) {
    echo ("Erro!" . $ex->get_Message);
}
