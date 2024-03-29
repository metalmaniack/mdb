<?php 
include 'conexao.php';
session_start();
?>
<!DOCTYPE html5>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Compras</title>

    <!-- CSS do Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="css/dashboard.css" rel="stylesheet">
</head>

<body>
    <?php include 'header.php' ?>

    <?php include 'sidemenu.php' ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Compras</h1>
            <?php
      if (!empty($_SESSION['usuario'])) {
      ?>
            <h5>Bem vindo,
                <span>
                    <?php echo $_SESSION['usuario'] ?>
                    </a>
                </span>
            </h5>
            <?php } ?>
        </div>
        <form method="post" action="cadCompras.php">
            <h4>Ponto de compras</h4>

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
                Compra encerrada!
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
            <?php } else if (base64_decode($_GET['msg']) == "success" && base64_decode($_GET['acao']) == "excluirCompra") { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Compra excluída com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "danger" && base64_decode($_GET['acao']) == "excluirCompra") { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Comprar não excluída com sucesso, tente novamente!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "success" && base64_decode($_GET['acao']) == "finalizar") { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Compra realizada com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "danger" && base64_decode($_GET['acao']) == "finalizar") { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Compra não realizada com sucesso, tente novamente!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } ?>

            <!--Verifica se foi passado o id pelo metodo GET-->
            <?php
            if (isset($_GET['idCompra'])) {
                $select = "Select * From compras where idCompra =" . $_GET['idCompra'];
                $query = mysqli_query($con, $select);
                $result = mysqli_fetch_assoc($query);
                $total = number_format($result["total"],2,',','.');
            }
            ?>

            <!--Área de compras-->
            <div class="d-flex flex-row mb-3">
                <div class="form-group p-2 col-sm-1">
                    <label for="idCompra">ID Compra:</label>
                    <input type="text" class="form-control" name="txtIdCompra"
                        value="<?php echo !isset($result['idCompra']) ? "" : $result['idCompra'] ?>" readonly>
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
                        <optgroup label="Selecione o status">
                            <!--Prenche o campo status-->
                            <?php
                        if (isset($result['status'])) {
                            echo "<option selected value=" . $result['status'] . ">" . $result['status'] . "</option>";
                        } else {
                            echo "<option value='aberto'>aberto</option>";
                            echo "<option value='fechado'>fechado</option>";
                        }
                        ?>
                        </optgroup>
                    </select>
                </div>

                <div class="form-group p-2 col-3">
                    <label for="Fornecedor">Fornecedor:</label>
                    <select class="form-control" name="txtFornecedor" require>
                        <optgroup label="Selecione o fornecedor">
                            <!--Prenche o campo fornecedors-->
                            <?php
                        if (!isset($_GET['idCompra'])) {
                            $select = "Select * From fornecedores Order By id;";
                            $query = mysqli_query($con, $select);
                            while ($result = mysqli_fetch_assoc($query)) {
                                echo "<option value=" . $result['nome'] . ">" . $result['nome'] . "</option>";
                            }
                        } else {
                            echo "<option selected value=" . $result['fk_idFornecedor'] . ">" . $result['fk_idFornecedor'] . "</option>";
                        }
                        ?>
                        </optgroup>
                    </select>
                </div>
                <div class="form-group p-2 col-2">
                    <label for="total">Total(R$):</label>
                    <input type="text" class="form-control" name="txtTotal"
                        value="<?php echo !isset($total) ? "" : $total ?>" readonly>
                </div>
            </div>
            <!--Botões de compra-->
            <div class="form-group">
                <button type="submit" class="btn btn-secondary ml-2" name="btnNovaCompra">Nova compra</button>
                <button type="button" class="btn btn-primary ml-2" name="btnBuscarCompra" data-toggle="modal"
                    data-target="#buscarCompras">Buscar Compra</button>
                <button type="submit" class="btn btn-danger ml-2" name="btnExcluirCompra">Excluir compra</button>
                <button type="submit" class="btn btn-success ml-2" name="btnFinalizar">Finalizar compra</button>
            </div>
            <!-- Modal Buscar compras-->
            <div class="modal fade" id="buscarCompras" tabindex="-1" role="dialog" aria-labelledby="Buscarcompras"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="Buscarcompras">Buscar compras</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!--Tabela com os registros de compras-->
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Data</th>
                                            <th>Status</th>
                                            <th>Fornecedor</th>
                                            <th>Total(R$)</th>
                                            <th>Selecionar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //instrução select 
                                        $select = "Select * From compras Order By idcompra;";
                                        $query = mysqli_query($con, $select);
                                        //retorna os dados existentes na tabela
                                        while ($result = mysqli_fetch_assoc($query)) {
                                            echo "<tr>";
                                            echo "<td>" . $result['idCompra'] . "</td>";
                                            echo "<td>" . $result['data'] . "</td>";
                                            echo "<td>" . $result['status'] . "</td>";
                                            echo "<td>" . $result['fk_idFornecedor'] . "</td>";
                                            echo "<td>" . $result['total'] . "</td>";
                                            echo "<td><a href=compras.php?idCompra=" . $result['idCompra'] . " type='submit' class='btn btn-info ml-3' name='btnSelecionar'><span data-feather='check-square'></a></td>";
                                            echo "</tr>";
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
            <!--Área de produtos-->
            <div class="d-flex flex-row mb-3 align-content-between flex-wrap">
                <div class="form-group p-2 col-sm-1 d-flex flex-column">
                    <label for="idProduto">ID Produto:</label>
                    <input type="text" class="form-control" name="txtIdProduto" id="txtIdProduto"
                        value="<?php echo isset($_GET['idCompra']) && isset($_GET['id'])  ? $_GET['id'] : "" ?><?php echo isset($_GET['ref']) ? $_GET['ref'] : "" ?>"
                        readonly>
                </div>
                <div class="form-group p-2 d-flex flex-column align-self-center mt-4">
                    <button type="button" class="btn btn-primary" name="btnBuscarProdutos" data-toggle="modal"
                        data-target="#buscarProdutos"><span data-feather="search"></button>
                </div>
                <div class="form-group p-2 col-3">
                    <label for="produto">Produto:</label>
                    <input type="text" class="form-control" name="txtNome" id="txtNome"
                        value="<?php echo isset($_GET['idCompra']) && isset($_GET['id']) ? $_GET['nome'] : "" ?><?php echo isset($_GET['ref']) ? $_GET['nome'] : "" ?>">
                </div>

                <div class="form-group p-2">
                    <label for="preco">Preço Unitário(R$):</label>
                    <input type="text" class="form-control" name="txtPreco" id="txtPreco"
                        value="<?php echo isset($_GET['idCompra']) && isset($_GET['id']) ? $_GET['preco'] : "" ?><?php echo isset($_GET['ref']) ? $_GET['preco'] : "" ?>"
                        readonly>
                </div>
                <div class="form-group p-2">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" class="form-control" name="txtQuantidade" id="txtQuantidade"
                        value="<?php echo isset($_GET['idCompra']) && isset($_GET['id']) ? $result['quantidade'] : "" ?><?php echo isset($_GET['ref']) ? $_GET['quantidade'] : "" ?>">
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
                                              if (!isset($_GET['idCompra'])){
                                                $_GET['idCompra'] = "";
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
                                                    echo "<td><a href=compras.php?idCompra=" . $_GET['idCompra'] . "&id=" . $result['id'] . "&nome=" . $result['nome'] . "&preco=" . $result['preco'] . " type='submit' class='btn btn-info ml-3' name='btnSelecionar'><span data-feather='check-square'></a></td>";
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
            <!--Botões de produtos-->
            <div class="form-group">
                <button type="submit" class="btn btn-warning ml-2" name="btnAlterar">Alterar item</button>
                <button type="submit" class="btn btn-danger ml-2" name="btnExcluir">Excluir item</button>
                <button type="button" class="btn btn-info ml-2" name="btnLimpar"
                    onclick="limpaDadosProdutos()">Limpar</button>
            </div>
        </form>
        <br>

        <h4>Tabela de Produtos </h4>
        <!--Tabela com os produtos inseridos(carrinho de compras)-->
        <form action="cadcompras.php" method="POST">
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
                        if(!isset($_GET['idCompra'])){
                            $_GET['idCompra']="";
                        }
                        else{ 
                            $select = "Select V. *, P.nome from compras_items V, produtos P where P.id = V.fk_idProduto AND V.fk_idCompra = " . $_GET['idCompra'] . ";";
                            $query = mysqli_query($con, $select);
                            //retorna os dados existentes na tabela
                            while ($result = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>" . $result['id'] . "</td>";
                                echo "<td>" . $result['nome'] . "</td>";
                                echo "<td>" . $result['preco'] . "</td>";
                                echo "<td>" . $result['quantidade'] . "</td>";
                                echo "<td>" . number_format($result['preco'] * $result['quantidade'],2,',','.') . "</td>";
                                echo "<td><a href=compras.php?ref=" . $result['fk_idProduto'] . "&idCompra=" . $_GET['idCompra'] . "&nome=" . $result['nome'] . "&preco=" . $result['preco'] . "&quantidade=" . $result['quantidade'] . " type='submit' class='btn btn-info ml-3' name='btnSelecionar'><span data-feather='check-square'></a></td>";
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
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
        document.getElementById('txtIdProduto').value = "";
        document.getElementById('txtNome').value = "";
        document.getElementById('txtPreco').value = "";
        document.getElementById('txtQuantidade').value = "";
    }
    </script>
</body>

</html>