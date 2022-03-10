<?php
include 'conexao.php';
session_start();
//variaveis do formulario de cadastro de usuários
$id = $_POST['txtId'];
$nome = $_POST['txtNome'];
$tipo = $_POST['txtTipo'];
$estoque = $_POST['txtEstoque'];
$preco = $_POST['txtPreco'];

//instruções SQL
try {
    if (isset($_POST['btnCadastrar'])) {
        //validando os campos obrigatórios
        if ($_POST['txtNome'] != "" && $_POST['txtTipo'] != "" && $_POST['txtEstoque'] != "" && $_POST['txtPreco'] != "") {
            //insert
            $insert = "Insert into produtos(nome, tipo, estoque, preco) values ('$nome','$tipo','$estoque','$preco')";
            $query = mysqli_query($con, $insert);
            $result = mysqli_fetch_assoc($query);
            $result = true;//se não deixar true retorna false por padrão
            if ($result) {
                //mensagem caso funcione
                $msg = "success";
                $acao = "inserir";
                header("Location: produtos.php?msg=" . base64_encode($msg). "&acao=" . base64_encode($acao));
            } else {
                //mensagem caso não funcione
                $msg = "danger";
                $acao = "inserir";
                header("Location: produtos.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            }
        }
        else {
            header("Location: produtos.php");
        }
    }
    //select
    else if (isset($_POST['btnBuscar'])) {
        //verifica qual o parâmetro pesquisado
        if($_POST['txtNome'] != '') {
            $varBusca = 'NOME';
        } else if($_POST['txtTipo'] != '') {
            $varBusca = 'TIPO';
        } else if($_POST['txtEstoque'] != '') {
            $varBusca = 'ESTOQUE';
        } else if($_POST['txtPreco'] != '') {
            $varBusca = 'PRECO';
        }
        if ($_POST['txtNome'] != "" || $_POST['txtTipo'] != "" || $_POST['txtEstoque'] != "" || $_POST['txtPreco'] != "") {
            $select = "Select * From produtos where nome='$nome' OR tipo='$tipo' OR estoque='$estoque' OR preco='$preco'";
            $query = mysqli_query($con, $select);
            $result = mysqli_fetch_assoc($query);
            if (mysqli_num_rows($query) >= 1) {
                //variavel para usar o método GET na pagina produtos.php
                $acao = "buscar";
                header("Location: produtos.php?acao=" . base64_encode($acao) . 
                "&varBusca=" . base64_encode($varBusca) .
                "&id=" . base64_encode($result['id']) . 
                "&nome=" . base64_encode($result['nome']) . 
                "&tipo=" . base64_encode($result['tipo']) . 
                "&estoque=" . base64_encode($result['estoque']) . 
                "&preco=" . base64_encode($result['preco']));
            } else {
                header("Location: produtos.php");
            }
        }
        else {
            header("Location: produtos.php");
        }
    }
    //update
    else if (isset($_POST['btnAlterar'])) {
        if ($_POST['txtId'] != "") {
            $update = "Update produtos Set nome='$nome', tipo='$tipo', estoque='$estoque', preco='$preco' where id=$id;";
            $query = mysqli_query($con, $update);
            $result = mysqli_fetch_assoc($query);
            $result = true;
            if ($result) {
                 //mensagem caso funcione
                 $msg = "success";
                 $acao = "alterar";
                 header("Location: produtos.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
             } else {
                 //mensagem caso não funcione
                 $msg = "danger";
                 $acao = "alterar";
                 header("Location: produtos.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
             }
        }
        else {
            header("Location: produtos.php");
        }
    }
    //delete
    else if (isset($_POST['btnExcluir'])) {
        if ($_POST['txtId'] != "") {
            $delete = "Delete from produtos where id= $id;";
            $query = mysqli_query($con, $delete);
            $result = mysqli_fetch_assoc($query);
            $result = true;
            if ($result) {
                 //mensagem caso funcione
                 $msg = "success";
                 $acao = "excluir";
                 header("Location: produtos.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
             } else {
                 //mensagem caso não funcione
                 $msg = "danger";
                 $acao = "excluir";
                 header("Location: produtos.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
             }
        }
        else {
            header("Location: produtos.php");
        }
    }
} catch (Exception $ex) {
    echo ("Erro!" . $ex->get_Message);
}