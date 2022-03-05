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
                //armazenando os dados na session
                $_SESSION['nome'] = $result['nome'];
                $_SESSION['cpf'] = $resul['cpf'];
                $_SESSION['endereco'] = $result['endereco'];
                $_SESSION['telefone'] = $result['telefone'];
                $_SESSION['email'] = $result['email'];
                //mensagem caso funcione
                $msg = "success";
                header("Location: clientes.php?msg=" . base64_encode($msg));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: clientes.php?msg=" . base64_encode($msg));
            }
        }
        else {
            header("Location: clientes.php");
        }
    }
    //select
    else if (isset($_POST['btnBuscar'])) {
        if ($_POST['txtNome'] != "" || $_POST['txtCpf'] != "") {
            $select = "Select * From clientes where nome='$nome' OR cpf='$cpf';";
            $query = mysqli_query($con, $select);
            $result = mysqli_fetch_assoc($query);
            if (mysqli_num_rows($query) >= 1) {
                //variavel para usar o método GET na pagina clientes.php
                $acao = "buscar";
                header("Location: clientes.php?acao=" . base64_encode($acao) .
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
                //mensagem caso funcione
                $msg = "success";
                header("Location: clientes.php?msg=" . base64_encode($msg));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: clientes.php?msg=" . base64_encode($msg));
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
                //mensagem caso funcione
                $msg = "success";
                header("Location: clientes.php?msg=" . base64_encode($msg));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: clientes.php?msg=" . base64_encode($msg));
            }
        }
        else {
            header("Location: clientes.php");
        }
    }
} catch (Exception $ex) {
    echo ("Erro!" . $ex->get_Message);
}
