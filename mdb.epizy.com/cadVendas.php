<?php
include 'conexao.php';
//variaveis globais
$idVenda = $_POST['txtIdVenda'];
$data = date("Y-m-d");
$status = $_POST['txtStatus'];
$cliente = $_POST['txtCliente'];
$total = $_POST['txtTotal'];
$idProduto = $_POST['txtIdProduto'];
$nome = $_POST['txtNome'];
$preco = $_POST['txtPreco'];
$quantidade = $_POST['txtQuantidade'];

try {
    //botão nova venda
    if (isset($_POST['btnNovaVenda'])) {
        if ($status != "" && $cliente != "") {
            //instruções insert
            $total = 0;
            $insert = "Insert into vendas(data, status, total, fk_idCliente) values ('$data','$status','$total','$cliente')";
            $resultInsert = mysqli_query($con, $insert);
            //instrução select
            $query = mysqli_query($con, "Select * From vendas Order By idVenda Desc Limit 1");
            $result = mysqli_fetch_assoc($query);
            if ($result) {
                header('Location: vendas.php?&idVenda=' . $result['idVenda'] .
                    "&data=" . date("d-m-Y", strtotime($result['data'])) .
                    "&status=" . $result['status'] .
                    "&total=" . $result['total'] .
                    "&fk_idCliente=" . $result['fk_idCliente']);
            }
        } 
        else {
            header('Location: vendas.php');
        }
    }

    //botão adicionar produto
    else if (isset($_POST['btnAdicionar'])) {
        if ($quantidade != "" && $status == "aberto") {
            //instrução insert na tabela vendas_items
            $insertProduto = "Insert into vendas_items(fk_idVenda, fk_idProduto, preco, quantidade) values ('$idVenda', '$idProduto', '$preco', '$quantidade')";
            $result = mysqli_query($con, $insertProduto);

            //instrução select na tabela vendas_items e na tabela produtos
            $queryProduto = mysqli_query($con, "Select V. *, P.nome from vendas_items V, produtos P where P.id = V.fk_idProduto AND V.fk_idVenda = '$idVenda'");
            $result = mysqli_fetch_assoc($queryProduto);
            if ($result) {
                //atualizando o total na tabela vendas
                $updateVendas = "Update vendas Set total = (
                select SUM(preco * quantidade) from vendas_items where fk_idvenda = '$idVenda'
                ) where idVenda='$idVenda'";
                $queryVendas = mysqli_query($con, $updateVendas);
                
                $msg = "aberto";
                header('Location: vendas.php?msg='.base64_encode($msg).
                    "&idVenda=" . $result['fk_idVenda'] .
                    "&idProduto=" . $result['fk_idProduto'] .
                    "&preco=" . $result['preco'] .
                    "&quantidade=" . $result['quantidade'] .
                    "&total=" . $total);
            }
        } 
        else if ($status == "fechado") {
            $msg = "fechado";
            header('Location: vendas.php?msg=' . base64_encode($msg));
        }
        else {
            header('Location: vendas.php?idVenda=' . $idVenda);
        }
    }
    //botão alterar produto(apenas a quantidade pode ser alterada)
    else if (isset($_POST['btnAlterar'])) {
        if ($idProduto != "" && $quantidade != "") {
            //select na tabela vendas_items
            $selectVendas_Items = ("Select * from vendas_items where fk_idVenda='$idVenda' AND fk_idProduto='$idProduto'");
            $queryVendas_Items = mysqli_query($con, $selectVendas_Items);
            $resultVendas_Items = mysqli_fetch_assoc($queryVendas_Items);
            
            //alterando a quantidade do item selecionado
            $update = "Update vendas_items Set quantidade = '$quantidade' where id=" . $resultVendas_Items['id'];
            $query = mysqli_query($con, $update);
            
            if ($query) {
                //atualizando o total na tabela vendas
                $updateVendas = "Update vendas Set total = (
                    select SUM(preco * quantidade) from vendas_items where fk_idvenda = '$idVenda'
                ) where idVenda='$idVenda'";
                $queryVendas = mysqli_query($con, $updateVendas);
                
                //intrução select na tabela vendas
                $select = "Select * from vendas where idVenda = '$idVenda'";
                $queryVendas = mysqli_query($con,$select);
                $resultVendas = mysqli_fetch_assoc($queryVendas);
                
                //mensagem caso funcione
                $msg = "success";
                $acao = "alterar";
                header("Location: vendas.php?idVenda=" .$resultVendas['idVenda'] . 
                "&msg=" . base64_encode($msg) . 
                "&acao=" . base64_encode($acao) .
                "&total=" .$total);
            } 
            else {
                //mensagem caso de erro
                $acao = "alterar";
                $msg = "danger";
                header("Location: vendas.php?msg=" . base64_encode($msg));
            }
        }
        else {
            header('Location: vendas.php');
        }
    }
    //botão excluir produto
    else if (isset($_POST['btnExcluir'])) {
        if ($idProduto != "") {
            //buscando o id da tabela vendas_items
            $selectVendas_Items = ("Select * from vendas_items where fk_idVenda='$idVenda' AND fk_idProduto='$idProduto'");
            $queryVendas_Items = mysqli_query($con, $selectVendas_Items);
            $resultVendas_Items = mysqli_fetch_assoc($queryVendas_Items);

            //excluindo item selecionado
            $delete = "Delete from vendas_items where id=" . $resultVendas_Items['id'] . ";";
            $query = mysqli_query($con, $delete);
            if ($query) {
                //atualizando o total na tabela vendas
                $updateVendas = "Update vendas Set total = (
                    select SUM(preco * quantidade) from vendas_items where fk_idvenda = '$idVenda'
                ) where idVenda='$idVenda'";
                $queryVendas = mysqli_query($con, $updateVendas);

                //intrução select na tabela vendas
                $select = "Select * from vendas where idVenda='$idVenda'";
                $queryVendas = mysqli_query($con,$select);
                $resultVendas = mysqli_fetch_assoc($queryVendas);

                //mensagem caso funcione
                $msg = "success";
                $acao = "excluir";
                header("Location: vendas.php?idVenda=" .$resultVendas['idVenda']. "&msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
            } 
            else {
                //mensagem caso de erro
                $msg = "danger";
                $acao = "excluir";
                header("Location: vendas.php?msg=" . base64_encode($msg));
            }
        }
        else {
            header('Location: vendas.php');
        }
    }
    else if(isset($_POST['btnExcluirVenda'])){
        if($idVenda !=""){
            //buscando o id da tabela vendas
            $selectVendas = ("Select * from vendas where idVenda='$idVenda'");
            $queryVendas = mysqli_query($con, $selectVendas);
            $resultVendas = mysqli_fetch_assoc($queryVendas);
               //excluindo item selecionado
               $delete = "Delete from vendas where idVenda=" . $resultVendas['idVenda'] . ";";
               $query = mysqli_query($con, $delete);
               if ($query) {
                   //intrução select na tabela vendas
                   $select = "Select * from vendas where idVenda='$idVenda'";
                   $queryVendas = mysqli_query($con,$select);
                   $resultVendas = mysqli_fetch_assoc($queryVendas);
   
                   //mensagem caso funcione
                   $msg = "success";
                   $acao = "excluirVenda";
                   header("Location: vendas.php?idVenda=" .$resultVendas['idVenda']. "&msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
               } 
               else {
                   //mensagem caso de erro
                   $msg = "danger";
                   $acao = "excluir";
                   header("Location: vendas.php?msg=" . base64_encode($msg));
                }
        }
        
        else {
            header('Location: vendas.php');
        }
    }
    //botão finalizar venda
    else if (isset($_POST['btnFinalizar'])) {
        //verifica de os campos estão preenchidos
        if (($idVenda != "") && ($cliente !="") && ($status=="aberto")) {
            //buscando os valores na tabela vendas_items
           $selectVendas_Items = "Select * from vendas_items where fk_idVenda = '$idVenda'";
           $queryVendas_Items = mysqli_query($con, $selectVendas_Items);
           while($resultVendas_Items = mysqli_fetch_assoc($queryVendas_Items)) {  
                //verifica se foi inserido algum item
                if ($resultVendas_Items['quantidade'] > 0) {
                    //atualiza o status da venda
                    $update = "Update vendas set status = 'fechado' where idVenda= '$idVenda'";
                    $query = mysqli_query($con, $update);
                    
                    //atualiza o estoque 
                    $updateProdutos = "Update produtos Set estoque = (estoque - ".$resultVendas_Items['quantidade'].") where id='".$resultVendas_Items['fk_idProduto']."'"; 
                    $queryProdutos = mysqli_query($con, $updateProdutos);

                    if ($query) {
                        //mensagem caso funcione
                        $msg = "success";
                        $acao = "finalizar";
                        header("Location: vendas.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
                    }
                    else {
                        //mensagem não caso funcione
                        $msg = "danger";
                        $acao = "finalizar";
                        header("Location: vendas.php?msg=" . base64_encode($msg) . "&acao=" . base64_encode($acao));
                    }
                }
                else {
                    header("Location: vendas.php");
                }
            }
        }
        else {
            header("Location: vendas.php");
        }   
    }
} catch (Exception $ex) {
    echo ("Erro! " . $ex->getMessage());
}