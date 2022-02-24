<?php
include 'conexao.php';
session_start();
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vendas</title>

    <!-- CSS do Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="css/dashboard.css" rel="stylesheet">
</head>

<body>
    <?php include 'header.php' ?>

    <?php include 'sidemenu.php' ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Vendas</h1>
            <!--Exibe o nome do usuário loggado no sistema-->
            <?php
            if (!empty($_SESSION['usuario'])) {
            ?>
            <h5>Bem vindo,
                <span>
                    <?php echo $_SESSION['usuario'] ?>
                </span>
            </h5>
            <?php } ?>
        </div>

        <form method="post" action="cadVendas.php">
            <h4>Ponto de vendas</h4>

            <!--Alertas de sucesso ou fracasso-->
            <?php if (!isset($_GET['msg'])){
                $msg="";
            ?>
            <?php }else if (base64_decode($_GET['msg']) == "aberto") { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Produto adicionado com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "fechado") { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Venda encerrada!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "success" && base64_decode($_GET['acao']) == "alterar") { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Item alterado com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "danger" && base64_decode($_GET['acao']) == "alterar") { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Item não alterado com sucesso. Tente novamente!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "success" && base64_decode($_GET['acao']) == "excluir") { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Item excluído com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "danger" && base64_decode($_GET['acao']) == "excluir") { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Item não excluído com sucesso. Tente novamente!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "success" && base64_decode($_GET['acao']) == "finalizar") { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Venda realizada com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "danger" && base64_decode($_GET['acao']) == "finalizar") { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Venda não realizada com sucesso, tente novamente!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } ?>

            <!--Verifica se foi passado o id pelo metodo GET-->
            <?php
            if (isset($_GET['idVenda'])) {
                $select = "Select * From vendas where idVenda =" . $_GET['idVenda'];
                $query = mysqli_query($con, $select);
                $result = mysqli_fetch_assoc($query);
                $total = number_format($result["total"],2,',','.');
            }
            ?>

            <!--Área de vendas-->
            <div class="d-flex flex-row mb-3">
                <div class="form-group p-2 col-sm-1">
                    <label for="idVenda">ID Venda:</label>
                    <input type="text" class="form-control" name="txtIdVenda"
                        value="<?php echo !isset($result['idVenda']) ? "" : $result['idVenda'] ?>" readonly>
                </div>

                <div class="form-group p-2 col-2">
                    <label for="data">Data:</label>
                    <input type="text" class="form-control" name="txtData"
                        value="<?php echo !isset($result['data']) ? "" : date("d/m/Y", strtotime($result['data'])) ?>"
                        readonly>
                </div>

                <div class="form-group p-2 col-2">
                    <label for="status">Status:</label>
                    <select class="form-control" name="txtStatus" require>
                        <option class="label">Selecione o status</option>
                        <!--Prenche o campo status-->
                        <?php
                        if (isset($result['status'])) {
                            echo "<option selected value=" . $result['status'] . ">" . $result['status'] . "</option>";
                        } else {
                            echo "<option value='aberto'>aberto</option>";
                            echo "<option value='fechado'>fechado</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group p-2 col-3">
                    <label for="cliente">Cliente:</label>
                    <select class="form-control" name="txtCliente" require>
                        <option class="label">Selecione o cliente</option>
                        <!--Prenche o campo clientes-->
                        <?php
                        if (!isset($_GET['idVenda'])) {
                            $select = "Select * From clientes Order By id;";
                            $query = mysqli_query($con, $select);
                            while ($result = mysqli_fetch_assoc($query)) {
                                echo "<option value=" . $result['nome'] . ">" . $result['nome'] . "</option>";
                            }
                        } else {
                            echo "<option selected value=" . $result['fk_idCliente'] . ">" . $result['fk_idCliente'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group p-2 col-2">
                    <label for="total">Total(R$):</label>
                    <input type="text" class="form-control" name="txtTotal"
                        value="<?php echo !isset($total) ? "" : $total ?>" readonly>
                </div>
            </div>
            <!-- Modal Buscar Vendas-->
            <div class="modal fade" id="buscarVendas" tabindex="-1" role="dialog" aria-labelledby="BuscarVendas"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="BuscarVendas">Buscar Vendas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!--Tabela com os registros de vendas-->
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Data</th>
                                            <th>Status</th>
                                            <th>Cliente</th>
                                            <th>Total(R$)</th>
                                            <th>Selecionar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //instrução select 
                                        $select = "Select * From vendas Order By idVenda;";
                                        $query = mysqli_query($con, $select);
                                        //retorna os dados existentes na tabela
                                        while ($result = mysqli_fetch_assoc($query)) {
                                            echo "<tr>";
                                            echo "<td>" . $result['idVenda'] . "</td>";
                                            echo "<td>" . $result['data'] . "</td>";
                                            echo "<td>" . $result['status'] . "</td>";
                                            echo "<td>" . $result['fk_idCliente'] . "</td>";
                                            echo "<td>" . $result['total'] . "</td>";
                                            echo "<td><a href=vendas.php?idVenda=" . $result['idVenda'] . " type='submit' class='btn btn-info ml-3' name='btnSelecionar'><span data-feather='check-square'></a></td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="btnNovaVenda">Nova Venda</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Área de produtos-->
            <div class="d-flex flex-row mb-3 align-content-between flex-wrap">
                <div class="form-group p-2 col-sm-1 d-flex flex-column">
                    <label for="idProduto">ID Produto:</label>
                    <input type="text" class="form-control" name="txtIdProduto" id="txtIdProduto"
                        value="<?php echo isset($_GET['idVenda']) && isset($_GET['id'])  ? $_GET['id'] : "" ?><?php echo isset($_GET['ref']) ? $_GET['ref'] : "" ?>"
                        readonly>
                </div>
                <div class="form-group p-2 d-flex flex-column align-self-center mt-4">
                    <button type="button" class="btn btn-primary" name="btnBuscarProdutos" data-toggle="modal"
                        data-target="#buscarProdutos"><span data-feather="search"></button>
                </div>
                <div class="form-group p-2 col-3">
                    <label for="produto">Produto:</label>
                    <input type="text" class="form-control" name="txtNome" id="txtNome"
                        value="<?php echo isset($_GET['idVenda']) && isset($_GET['id']) ? $_GET['nome'] : "" ?><?php echo isset($_GET['ref']) ? $_GET['nome'] : "" ?>">
                </div>

                <div class="form-group p-2">
                    <label for="preco">Preço Unitário(R$):</label>
                    <input type="text" class="form-control" name="txtPreco" id="txtPreco"
                        value="<?php echo isset($_GET['idVenda']) && isset($_GET['id']) ? $_GET['preco'] : "" ?><?php echo isset($_GET['ref']) ? $_GET['preco'] : "" ?>"
                        readonly>
                </div>
                <div class="form-group p-2">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" class="form-control" name="txtQuantidade" id="txtQuantidade"
                        value="<?php echo isset($_GET['idVenda']) && isset($_GET['id']) ? $result['quantidade'] : "" ?><?php echo isset($_GET['ref']) ? $_GET['quantidade'] : "" ?>">
                </div>
                <div class="form-group p-2 d-flex flex-column align-self-center mt-4">
                    <button type="submit" class="btn btn-primary" name="btnAdicionar"
                        onclick()="limpaDadosProdutos()"><span data-feather="plus-square"></span></button>
                </div>
                <!-- Modal Buscar produtos-->
                <div class="modal fade" id="buscarProdutos" tabindex="-1" role="dialog" aria-labelledby="BuscarProdutos"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="BuscarProdutos">Buscar Produtos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!--Tabela com os produtos a serem inseridos-->
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>Tipo</th>
                                                <th>Estoque</th>
                                                <th>Preço(R$)</th>
                                                <th>Selecionar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!isset($_GET['idVenda'])){
                                                $_GET['idVenda'] = "";
                                            }
                                            else{
                                                //instrução select 
                                                $select = "Select * From produtos Order By id;";
                                                $query = mysqli_query($con, $select);
                                                //retorna os dados existentes na tabela
                                                while ($result = mysqli_fetch_assoc($query)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $result['id'] . "</td>";
                                                    echo "<td>" . $result['nome'] . "</td>";
                                                    echo "<td>" . $result['tipo'] . "</td>";
                                                    echo "<td>" . $result['estoque'] . "</td>";
                                                    echo "<td>" . number_format($result["preco"],2,',','.') . "</td>";
                                                    echo "<td><a href=vendas.php?idVenda=" . $_GET['idVenda'] . "&id=" . $result['id'] . "&nome=" . $result['nome'] . "&preco=" . $result['preco'] . " type='submit' class='btn btn-info ml-3' name='btnSelecionar'><span data-feather='check-square'></a></td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Botões do formulário-->
            <div class="form-group">
                <button type="button" class="btn btn-primary ml-2" name="btnBuscarVenda" data-toggle="modal"
                    data-target="#buscarVendas">Buscar venda</button>
                <button type="submit" class="btn btn-warning ml-3" name="btnAlterar">Alterar item</button>
                <button type="submit" class="btn btn-danger ml-3" name="btnExcluir">Excluir item</button>
                <button type="submit" class="btn btn-secondary ml-3" name="btnFinalizar">Finalizar venda</button>
                <button type="submit" class="btn btn-info ml-3" name="btnLimpar">Limpar</button>
            </div>
        </form>
        <br>

        <h4>Tabela de Produtos </h4>
        <!--Tabela com os produtos inseridos(carrinho de compras)-->
        <form action="cadVendas.php" method="POST">
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço(R$)</th>
                            <th>Quantidade</th>
                            <th>Sub Total(R$)</th>
                            <th>Selecionar</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        //instrução select
                        if(empty($_GET['idVenda'])){
                            $_GET['idVenda']="";
                        }
                        else{ 
                            $select = "Select V. *, P.nome from vendas_items V, produtos P where P.id = V.fk_idProduto AND V.fk_idVenda = " . $_GET['idVenda'] . "";
                            $query = mysqli_query($con, $select);
                            //retorna os dados existentes na tabela
                            while ($result = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>" . $result['id'] . "</td>";
                                echo "<td>" . $result['nome'] . "</td>";
                                echo "<td>" . $result['preco'] . "</td>";
                                echo "<td>" . $result['quantidade'] . "</td>";
                                echo "<td>" . number_format($result['preco'] * $result['quantidade'],2,',','.') . "</td>";
                                echo "<td><a href=vendas.php?ref=" . $result['fk_idProduto'] . "&idVenda=" . $_GET['idVenda'] . "&nome=" . $result['nome'] . "&preco=" . $result['preco'] . "&quantidade=" . $result['quantidade'] . " type='submit' class='btn btn-info ml-3' name='btnSelecionar'><span data-feather='check-square'></a></td>";
                                echo "</tr>";
                            }
                            
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </main>
    <br>
    <?php include 'footer.php' ?>

    <!-- JavaScript do Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')
    </script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>

    <!-- Ícones -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
    feather.replace()
    </script>

    <!--Limpa os dados dos produtos-->
    <script>
    function limpaDadosProdutos() {
        document.getElementById('txtIdProduto').value = '';
        document.getElementById('txtProduto').value = '';
        document.getElementById('txtPreco').value = '';
        document.getElementById('txtQuantidade').value = '';
    }
    </script>

</body>

</html>