<?php
include 'conexao.php';
session_start();
//variaveis do formulario de cadastro de clientes
$id = $_POST['txtId'];
$nome = $_POST['txtNome'];
$cpf = $_POST['txtCpf'];
$endereco = $_POST['txtEndereco'];
$telefone = $_POST['txtTelefone'];
$email = $_POST['txtEmail'];
//instruções SQL
try {
    if (isset($_POST['btnCadastrar'])) {
        //validando os campos obrigatórios
        if ($_POST['txtNome'] != "" && $_POST['txtCpf'] != "") {
            //insert
            $insert = "Insert into clientes(nome, cpf, endereco, telefone, email) values ('$nome','$cpf','$endereco','$telefone','$email');";
            $query = mysqli_query($con, $insert);
            $result = mysqli_fetch_assoc($query);
            $result = true;
            if ($result) {
                $acao="inserir";
                //mensagem caso funcione
                $msg = "success";
                header("Location: clientes.php?msg=" . base64_encode($msg) . "&acao=".base64_encode($acao));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: clientes.php?msg=" . base64_encode($msg) . "&acao=".base64_encode($acao));
            }
        }
        else {
            header("Location: clientes.php");
        }
    }
    //select
    else if (isset($_POST['btnBuscar'])) {
        //verifica qual o parâmetro pesquisado
        if($_POST['txtNome'] != '') {
            $varBusca = 'NOME';
        } else if($_POST['txtCpf'] != '') {
            $varBusca = 'CPF';
        } else if($_POST['txtEndereco'] != '') {
            $varBusca = 'ENDERECO';
        } else if($_POST['txtTelefone'] != '') {
            $varBusca = 'TELEFONE';
        } else if($_POST['txtEmail'] != '') {
            $varBusca = 'EMAIL';
        }
        if ($_POST['txtNome'] != "" || $_POST['txtCpf'] != "" || $_POST['txtEndereco'] != "" || $_POST['txtTelefone'] != "" || $_POST['txtEmail'] != "") {
            $select = "Select * From clientes where nome='$nome' OR cpf='$cpf' OR endereco='$endereco' OR telefone='$telefone' OR email='$email'";
            $query = mysqli_query($con, $select);
            $result = mysqli_fetch_assoc($query);
            if (mysqli_num_rows($query) >= 1) {
                //variavel para usar o método GET na pagina clientes.php
                $acao = "buscar";
                header("Location: clientes.php?acao=" . base64_encode($acao) .
                    "&varBusca=" . base64_encode($varBusca) .
                    "&id=" . base64_encode($result['id']) .
                    "&nome=" . base64_encode($result['nome']) .
                    "&cpf=" . base64_encode($result['cpf']) .
                    "&endereco=" . base64_encode($result['endereco']) .
                    "&telefone=" . base64_encode($result['telefone']) .
                    "&email=" . base64_encode($result['email']));
            } else {
                header("Location: clientes.php");
            }
        }
        else {
            header("Location: clientes.php");
        }
    }
    //update
    else if (isset($_POST['btnAlterar'])) {
        if ($_POST['txtId'] != "") {
            $update = "Update clientes Set nome='$nome', cpf='$cpf', endereco='$endereco', telefone='$telefone', email='$email' where id=$id;";
            $query = mysqli_query($con, $update);
            $result = mysqli_fetch_assoc($query);
            $result=true;
            if ($result) {
                $acao="alterar";
                //mensagem caso funcione
                $msg = "success";
                header("Location: clientes.php?msg=" . base64_encode($msg). "&acao=".base64_encode($acao));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: clientes.php?msg=" . base64_encode($msg). "&acao=".base64_encode($acao));
            }
        }
        else {
            header("Location: clientes.php");
        }
    }
    //delete
    else if (isset($_POST['btnExcluir'])) {
        if ($_POST['txtId'] != "") {
            $delete = "Delete from clientes where id= $id;";
            $query = mysqli_query($con, $delete);
            $result = mysqli_fetch_assoc($query);
            $result=true;
            if ($result) {
                $acao = "excluir";
                //mensagem caso funcione
                $msg = "success";
                header("Location: clientes.php?msg=" . base64_encode($msg). "&acao=".base64_encode($acao));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: clientes.php?msg=" . base64_encode($msg). "&acao=".base64_encode($acao));
            }
        }
        else {
            header("Location: clientes.php");
        }
    }
} catch (Exception $ex) {
    echo ("Erro!" . $ex->get_Message);
}
