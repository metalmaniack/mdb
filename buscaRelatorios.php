<?php

include 'conexao.php';
//variaveis globais
$idVenda = $_POST['txtIdVenda'];
$idCompra = $_POST['txtIdCompra'];


try{
    //busca vendas
    if(isset($_POST['btnBuscaVenda'])){
        if($idVenda!= ""){
            $selectVenda = "select * from vendas where idVenda='$idVenda'";
            $queryVenda = mysqli_query($con,$selectVenda);
            $resultVenda = mysqli_fetch_assoc($queryVenda);
            

            header("Location: relatoriosVendas.php?idVenda=" . $resultVenda['idVenda']);
        }
        else{
            header("Location: relatoriosVendas.php");
        }
    }
    //busca compras
    else if(isset($_POST['btnBuscaCompra'])){
        if($idCompra!= ""){
            $selectCompra = "select * from compras where idCompra='$idCompra' OR data='$dataCompra'";
            $queryCompra = mysqli_query($con,$selectCompra);
            $resultCompra = mysqli_fetch_assoc($queryCompra);
            
            header("Location: relatoriosCompras.php?idCompra=" . $resultCompra['idCompra']);
        }
        else{
            header("Location: relatoriosCompras.php");
        }
    }
}
catch(Exception $ex){
    echo ("Erro" . $ex->getMessage());
}
?>