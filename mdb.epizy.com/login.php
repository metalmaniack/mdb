<?php
    include 'conexao.php';

    //variaveis de conexão
    $login = $_POST['txtLogin'];
    $senha = $_POST['txtSenha'];

    //validação de usuário
    try {
        if (isset($_POST['btnEntrar'])) {
            $select = "Select * from usuarios where login = '$login' && senha = '$senha'";
            $query = mysqli_query($con, $select);
            $result = mysqli_fetch_assoc($query);
            if ($result) {
                session_start();
                $_SESSION['usuario'] = $result['nome'];
                //vai para a página inicial
                header("Location: home.php");
            } 
            //volta para página de login
            else {
                unset($_SESSION['usuario']);
                header("Location: index.html");
            }
        }
    } catch (Exception $ex) {
        echo ("Erro!" . $ex->get_Message);
    }
?>
