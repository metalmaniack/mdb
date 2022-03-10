<?php
include 'conexao.php';
session_start();
//variaveis do formulario de cadastro de usuários
$id = $_POST['txtId'];
$nome = $_POST['txtNome'];
$telefone = $_POST['txtTelefone'];
$email = $_POST['txtEmail'];
$endereco = $_POST['txtEndereco'];
$cnpj = $_POST['txtCnpj'];

//instruções SQL
try {
    if (isset($_POST['btnCadastrar'])) {
        //validando os campos obrigatórios
        if ($_POST['txtNome'] != "" && $_POST['txtCnpj'] != "") {
            //insert
            $insert = "Insert into fornecedores(nome, telefone, email, endereco, cnpj) values ('$nome','$telefone','$email','$endereco','$cnpj')";
            $query = mysqli_query($con, $insert);
            $result = mysqli_fetch_assoc($query);
            $result = true;
            if ($result) {
                $acao="inserir";
                //mensagem caso funcione
                $msg = "success";
                header("Location: fornecedores.php?msg=" . base64_encode($msg). "&acao=" . base64_encode($acao));
            } else {
                //mensagem caso não funcione
                $msg = "danger";
                header("Location: fornecedores.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            }
        }
        else {
            header("Location: fornecedores.php");
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
        } else if($_POST['txtEndereco'] != '') {
            $varBusca = 'ENDERECO';
        } else if($_POST['txtCnpj'] != '') {
            $varBusca = 'CNPJ';
        }
        if ($_POST['txtNome'] != "" || $_POST['txtTelefone'] != "" || $_POST['txtEmail'] != "" || $_POST['txtEndereco'] != "" || $_POST['txtCnpj'] != "") {
            $select = "Select * From fornecedores where nome='$nome' OR telefone='$telefone' OR email='$email' OR endereco='$endereco' OR cnpj='$cnpj';";
            $query = mysqli_query($con, $select);
            $result = mysqli_fetch_assoc($query);
            if (mysqli_num_rows($query) >= 1) {
                //variavel para usar o método GET na pagina clientes.php
                $acao = "buscar";
                header("Location: fornecedores.php?acao=" . base64_encode($acao) .
                    "&varBusca=" . base64_encode($varBusca) .
                    "&id=" . base64_encode($result['id']) .
                    "&nome=" . base64_encode($result['nome']) .
                    "&telefone=" . base64_encode($result['telefone']) .
                    "&email=" . base64_encode($result['email']) .
                    "&endereco=" . base64_encode($result['endereco']) .
                    "&cnpj=" . base64_encode($result['cnpj']));
            } else {
                header("Location: fornecedores.php");
            }
        }
        else {
            header("Location: fornecedores.php");
        }
    }
    //update
    else if (isset($_POST['btnAlterar'])) {
        if ($_POST['txtId'] != "") {
            $update = "Update fornecedores Set nome='$nome', telefone='$telefone', email='$email', endereco='$endereco', cnpj='$cnpj' where id=$id;";
            $query = mysqli_query($con, $update);
            $result = mysqli_fetch_assoc($query);
            $result = true;
            if ($result) {
                $acao="alterar";
                //mensagem caso funcione
                $msg = "success";
                header("Location: fornecedores.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            } else {
                //mensagem caso não funcione
                $msg = "danger";
                header("Location: fornecedores.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            }
        }
        else {
            header("Location: fornecedores.php");
        }
    }
    //delete
    else if (isset($_POST['btnExcluir'])) {
        if ($_POST['txtId'] != "") {
            $delete = "Delete from fornecedores where id= $id;";
            $query = mysqli_query($con, $delete);
            $result = mysqli_fetch_assoc($query);
            $result=true;
            if ($result) {
                $acao="excluir";
                //mensagem caso funcione
                $msg = "success";
                header("Location: fornecedores.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            } else {
                //mensagem caso não funcione
                $msg = "danger";
                header("Location: fornecedores.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            }
        }
        else {
            header("Location: fornecedores.php");
        }
    }
} catch (Exception $ex) {
    echo ("Erro!" . $ex->get_Message);
}