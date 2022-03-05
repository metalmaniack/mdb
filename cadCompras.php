<?php
include 'conexao.php';
//variaveis globais
$idCompra = $_POST['txtIdCompra'];
$data = date("Y-m-d");
$status = $_POST['txtStatus'];
$fornecedor = $_POST['txtFornecedor'];
$total = $_POST['txtTotal'];
$idProduto = $_POST['txtIdProduto'];
$nome = $_POST['txtNome'];
$preco = $_POST['txtPreco'];
$quantidade = $_POST['txtQuantidade'];

try {
    //botão nova compra
    if (isset($_POST['btnNovaCompra'])) {
        if ($status != "" && $fornecedor != "") {
            //instruções insert
            $total = 0;
            $insert = "Insert into compras(data, status, total, fk_idFornecedor) values ('$data','$status','$total','$fornecedor')";
            $resultInsert = mysqli_query($con, $insert);
            //instrução select
            $query = mysqli_query($con, "Select * From compras Order By idCompra Desc Limit 1");
            $result = mysqli_fetch_assoc($query);
            if ($result) {
                header('Location: compras.php?&idCompra=' . $result['idCompra'] .
                    "&data=" . date("d-m-Y", strtotime($result['data'])) .
                    "&status=" . $result['status'] .
                    "&total=" . $result['total'] .
                    "&fk_idFornecedor=" . $result['fk_idFornecedor']);
            }
        } 
        else {
            header('Location: compras.php');
        }
    }

    //botão adicionar produto
    else if (isset($_POST['btnAdicionar'])) {
        if ($quantidade != "" && $status == "aberto") {
            //instrução insert na tabela compras_items
            $insertProduto = "Insert into compras_items(fk_idCompra, fk_idProduto, preco, quantidade) values ('$idCompra', '$idProduto', '$preco', '$quantidade')";
            $result = mysqli_query($con, $insertProduto);

            //instrução select na tabela compras_items e na tabela produtos
            $queryProduto = mysqli_query($con, "Select V. *, P.nome from compras_items V, produtos P where P.id = V.fk_idProduto AND V.fk_idCompra = '$idCompra'");
            $result = mysqli_fetch_assoc($queryProduto);
            if ($result) {
                //atualizando o total na tabela compras
                $updateCompras = "Update compras Set total = (
                select SUM(preco * quantidade) from compras_items where fk_idCompra = '$idCompra'
                ) where idCompra='$idCompra'";
                $queryCompras = mysqli_query($con, $updateCompras);
                
                $msg = "aberto";
                header('Location: compras.php?msg='.base64_encode($msg).
                    "&idCompra=" . $result['fk_idCompra'] .
                    "&idProduto=" . $result['fk_idProduto'] .
                    "&preco=" . $result['preco'] .
                    "&quantidade=" . $result['quantidade'] .
                    "&total=" . $total);
            }
        }
        else if ($status == "fechado") {
            $msg = "fechado";
            header('Location: compras.php?msg=' . base64_encode($msg));
        }
        else {
            header("Location: compras.php?idCompra=" .$resultCompras['idCompra']);
        }
    }
    //botão alterar produto(apenas a quantidade pode ser alterada)
    else if (isset($_POST['btnAlterar'])) {
        if ($idProduto != "" && $quantidade != "") {
            //select na tabela compras_items
            $selectCompras_Items = ("Select * from compras_items where fk_idCompra='$idCompra' AND fk_idProduto='$idProduto'");
            $queryCompras_Items = mysqli_query($con, $selectCompras_Items);
            $resultCompras_Items = mysqli_fetch_assoc($queryCompras_Items);
            
            //alterando a quantidade do item selecionado
            $update = "Update compras_items Set quantidade = '$quantidade' where id=" . $resultCompras_Items['id'];
            $query = mysqli_query($con, $update);
            
            if ($query) {
                //atualizando o total na tabela compras
                $updateCompras = "Update compras Set total = (
                    select SUM(preco * quantidade) from compras_items where fk_idCompra = '$idCompra'
                ) where idCompra='$idCompra'";
                $queryCompras = mysqli_query($con, $updateCompras);
                
                //intrução select na tabela compras
                $select = "Select * from compras where idCompra = '$idCompra'";
                $queryCompras = mysqli_query($con,$select);
                $resultCompras = mysqli_fetch_assoc($queryCompras);
                
                //mensagem caso funcione
                $msg = "success";
                $acao = "alterar";
                header("Location: compras.php?idCompra=" .$resultCompras['idCompra'] . 
                "&msg=" . base64_encode($msg) . 
                "&acao=" . base64_encode($acao) .
                "&total=" .$total);
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: compras.php?msg=" . base64_encode($msg));
            }
        }
        else {
            header('Location: compras.php');
        }
    }
    //botão excluir produto
    else if (isset($_POST['btnExcluir'])) {
        if ($idProduto != "") {
            //buscando o id da tabela compras_items
            $selectCompras_Items = ("Select * from compras_items where fk_idCompra='$idCompra' AND fk_idProduto='$idProduto'");
            $queryCompras_Items = mysqli_query($con, $selectCompras_Items);
            $resultCompras_Items = mysqli_fetch_assoc($queryCompras_Items);

            //excluindo item selecionado
            $delete = "Delete from compras_items where id=" . $resultCompras_Items['id'] . ";";
            $query = mysqli_query($con, $delete);
            if ($query) {
                //atualizando o total na tabela compras
                $updateCompras = "Update compras Set total = (
                    select SUM(preco * quantidade) from compras_items where fk_idCompra = '$idCompra'
                ) where idCompra='$idCompra'";
                $queryCompras = mysqli_query($con, $updateCompras);

                //intrução select na tabela compras
                $select = "Select * from compras where idCompra='$idCompra'";
                $queryCompras = mysqli_query($con,$select);
                $resultCompras = mysqli_fetch_assoc($queryCompras);

                //mensagem caso funcione
                $msg = "success";
                $acao = "excluir";
                header("Location: compras.php?idCompra=" .$resultCompras['idCompra']. "&msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            } else {
                //mensagem caso de erro
                $msg = "danger";
                header("Location: compras.php?msg=" . base64_encode($msg));
            }
        }
        else {
            header('Location: compras.php');
        }
    }
    //botão finalizar compra
    else if (isset($_POST['btnFinalizar'])) {
        
        if (($idCompra != "") && ($fornecedor !="") && ($status == "aberto")) {
            //buscando os valores na tabela compras_items
            $selectCompras_Items = "Select * from compras_items where fk_idCompra = '$idCompra'";
            $queryCompras_Items = mysqli_query($con, $selectCompras_Items);
            
            //verifica se foi inserido algum item
            while($resultCompras_Items = mysqli_fetch_assoc($queryCompras_Items)) {  
                if ($resultCompras_Items['quantidade'] > 0) {
                    //atualiza o status da compra
                    $update = "Update compras set status = 'fechado' where idCompra= '$idCompra'";
                    $query = mysqli_query($con, $update);
                    
                    //atualiza o estoque 
                    $updateProdutos = "Update produtos Set estoque = (estoque + ".$resultCompras_Items['quantidade'].") where id='".$resultCompras_Items['fk_idProduto']."'";
                    $queryProdutos = mysqli_query($con, $updateProdutos);
    
                    if ($query) {
                        //mensagem caso funcione
                        $msg = "success";
                        $acao = "finalizar";
                        header("Location: compras.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
                    }
                    else {
                        //mensagem caso de erro
                        $msg = "danger";
                        $acao = "finalizar";
                        header("Location: compras.php?msg=" . base64_encode($msg));
                    }
                }
                else { 
                    header("Location: compras.php");
                }
            } 
        }
        else { 
            header("Location: compras.php");
        }
    }
} 
catch (Exception $ex) {
    echo ("Erro! " . $ex->getMessage());
}