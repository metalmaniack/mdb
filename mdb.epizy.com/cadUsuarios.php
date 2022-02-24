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
                //armazenando os dados na session
                $_SESSION['nome'] = $nome;
                $_SESSION['telefone'] = $telefone;
                $_SESSION['email'] = $email;
                $_SESSION['acesso'] = $acesso;
                //mensagem caso funcione
                $msg = "success";
                header("Location: usuarios.php?msg=" . base64_encode($msg));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: usuarios.php?msg=" . base64_encode($msg));
            }
        }
    }
    //select
    else if (isset($_POST['btnBuscar'])) {
        if ($_POST['txtNome'] != "" || $_POST['txtTelefone'] != "" || $_POST['txtEmail'] != "" || $_POST['txtLogin'] != "" || $_POST['txtAcesso'] != "") {
            $select = "Select * From usuarios where nome='$nome' OR telefone='$telefone' OR email='$email' OR login='$login' OR acesso='$acesso';";
            $query = mysqli_query($con, $select);
            $result = mysqli_fetch_assoc($query);
            if (mysqli_num_rows($query) >= 1) {
                //variavel para usar o método GET na pagina clientes.php
                $acao = "buscar";
                header("Location: usuarios.php?acao=" . base64_encode($acao) . "&id=" . base64_encode($result['id']) . "&nome=" . base64_encode($result['nome']) . "&telefone=" . base64_encode($result['telefone']) . "&email=" . base64_encode($result['email']) . "&login=" . base64_encode($result['login']) . "&acesso=" . base64_encode($result['acesso']));
            } else {
                header("Location: usuarios.php");
            }
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
                //mensagem caso funcione
                $msg = "success";
                header("Location: usuarios.php?msg=" . base64_encode($msg));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: usuarios.php?msg=" . base64_encode($msg));
            }
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
                //mensagem caso funcione
                $msg = "success";
                header("Location: usuarios.php?msg=" . base64_encode($msg));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: usuarios.php?msg=" . base64_encode($msg));
            }
        }
    }
} catch (Exception $ex) {
    echo ("Erro!" . $ex->get_Message);
}
