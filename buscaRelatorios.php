<?php

include 'conexao.php';
//variaveis globais 
$idVenda = $_POST['txtIdVenda'];
$dataVenda = date("Y-m-d",strtotime($_POST['txtDataVenda']));
$statusVenda = $_POST['txtStatusVenda'];
$cliente = $_POST['txtCliente'];
$totalVenda = $_POST['txtTotalVenda'];
$idCompra = $_POST['txtIdCompra'];
$dataCompra = date("Y-m-d",strtotime($_POST['txtDataCompra']));
$statusCompra = $_POST['txtStatusCompra'];
$fornecedor = $_POST['txtFornecedor'];
$totalCompra = $_POST['txtTotalCompra'];

try{
    //busca vendas
    if(isset($_POST['btnBuscaVenda'])){
        //verifica qual o parâmetro pesquisado
          if($_POST['txtIdVenda'] != "") {
            $varBusca = 'IDVENDA';
        } else if($_POST['txtDataVenda'] != "") {
            $varBusca = 'DATA';
        } else if($_POST['txtStatusVenda'] != "") {
            $varBusca = 'STATUS';
        } else if($_POST['txtCliente'] != "") {
            $varBusca = 'CLIENTE';
        } else if($_POST['txtTotalVenda'] != "") {
            $varBusca = 'TOTAL';
        }
        if($idVenda != "" || $dataVenda != "" || $statusVenda != "" || $cliente != "" || $totalVenda != ""){
            $selectVenda = "select * from vendas where idVenda='$idVenda' OR data='$dataVenda' OR status='$statusVenda' OR fk_idCliente='$cliente' OR total='$totalVenda'";
            $queryVenda = mysqli_query($con,$selectVenda);
            $resultVenda = mysqli_fetch_assoc($queryVenda);
            $acao="buscarVenda";
            header("Location: relatoriosVendas.php?idVenda=" . base64_encode($resultVenda['idVenda']).
            "&acao=" . base64_encode($acao) .
            "&varBusca=" . base64_encode($varBusca) .
            "&data=". base64_encode(date("Y-m-d",strtotime($resultVenda['data']))).
            "&status=" . base64_encode($resultVenda['status']).
            "&cliente=". base64_encode($resultVenda['fk_idCliente']).
            "&totalVenda=" . base64_encode($resultVenda['total']));
        }
        else{
            header("Location: relatoriosVendas.php");
        }
    }
    //busca compras
    else if(isset($_POST['btnBuscaCompra'])){
        //verifica qual o parâmetro pesquisado
        if($_POST['txtIdCompra'] != "") {
            $varBusca = 'IDCOMPRA';
        } else if($_POST['txtDataCompra'] != "") {
            $varBusca = 'DATA';
        } else if($_POST['txtStatusCompra'] != "") {
            $varBusca = 'STATUS';
        } else if($_POST['txtFornecedor'] != "") {
            $varBusca = 'FORNECEDOR';
        } else if($_POST['txtTotalCompra'] != "") {
            $varBusca = 'TOTAL';
        }
        if($idCompra != "" || $dataCompra !="" || $statusCompra !="" || $fornecedor !="" || $totalCompra != ""){
            $selectCompra = "select * from compras where idCompra='$idCompra' OR data='$dataCompra' OR status='$statusCompra' OR fk_idFornecedor='$fornecedor' OR total='$totalCompra'";
            $queryCompra = mysqli_query($con,$selectCompra);
            $resultCompra = mysqli_fetch_assoc($queryCompra);
            $acao="buscarCompra";
            header("Location: relatoriosCompras.php?idCompra=" . base64_encode($resultCompra['idCompra']).
            "&acao=" . base64_encode($acao) .
            "&varBusca=" . base64_encode($varBusca) . 
            "&data=". base64_encode(date("Y-m-d",strtotime($resultCompra['data']))).
            "&status=" . base64_encode($resultCompra['status']).
            "&fornecedor=". base64_encode($resultCompra['fk_idFornecedor']).
            "&totalCompra=" . base64_encode($resultCompra['total']));
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