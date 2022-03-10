<?php
include 'conexao.php';
session_start();
?>
<!DOCTYPE html5>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Relátorio de Compras</title>

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
            <h1 class="h2">Relatório de Compras</h1>
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

        <!--Área de compras-->
        <form action="buscaRelatorios.php" method="POST">
            <div class="d-flex flex-row mb-3">
                <div class="form-group p-2 col-sm-1">
                    <label for="idCompra">ID Compra:</label>
                    <input type="text" class="form-control" name="txtIdCompra">
                </div>
                <div class="form-group p-2 col-sm-2">
                    <label for="data">Data:</label>
                    <input type="text" class="form-control" name="txtDataCompra" placeholder="dd-mm-aaaa">
                </div>
                <div class="form-group p-2 col-sm-2">
                    <label for="status">Status:</label>
                    <input type="text" class="form-control" name="txtStatusCompra">
                </div>
                <div class="form-group p-2 col-sm-2">
                    <label for="fornecedor">Fornecedor:</label>
                    <input type="text" class="form-control" name="txtFornecedor">
                </div>
                <div class="form-group p-2 col-sm-2">
                    <label for="total">Total(R$):</label>
                    <input type="text" class="form-control" name="txtTotalCompra" placeholder="0.00">
                </div>
                <div class="form-group pt-3 mt-4">
                    <button type="submit" class="btn btn-primary ml-2" name="btnBuscaCompra"><span
                            data-feather="search"></button>
                </div>
            </div>
        </form>
        <h4>Tabela de Compras </h4>
        <!--Tabela com os compras inseridos(carrinho de compras)-->
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>ID Compra</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Fornecedor</th>
                        <th>Total(R$)</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        if (!isset($_GET['acao'])) {
                            $_GET['acao'] = "";
                            //instrução select
                            $select = "Select * from compras";
                            $query = mysqli_query($con, $select);
                            //retorna os dados existentes na tabela
                            while ($result = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>" . $result['idCompra'] . "</td>";
                                echo "<td>" . date("d-m-Y", strtotime($result['data'])) . "</td>";
                                echo "<td>" . $result['status'] . "</td>";
                                echo "<td>" . $result['fk_idFornecedor'] . "</td>";
                                echo "<td>" . number_format($result['total'],2,',','.') . "</td>";
                                echo "</tr>";
                            }
                        }   
                        else if (base64_decode($_GET['acao']) == "buscarCompra"){
                            $varBusca = base64_decode($_GET['varBusca']);
                            if($varBusca == 'IDCOMPRA') {
                                $select = "Select * from compras WHERE idCompra = '" . base64_decode($_GET['idCompra']) . "'";
                            } 
                            else if($varBusca == 'DATA') {
                                $select = "Select * from compras WHERE data = '" . base64_decode($_GET['data']) . "'";
                            } 
                            else if($varBusca == 'STATUS') {
                                $select = "Select * from compras WHERE status LIKE '%" . base64_decode($_GET['status']) . "%'";
                            } 
                            else if($varBusca == 'FORNECEDOR') {
                                $select = "Select * from compras WHERE fk_idFornecedor LIKE '%" . base64_decode($_GET['fk_idFornecedor']) . "%'";
                            } 
                            else if($varBusca == 'TOTAL') {
                                $select = "Select * from compras WHERE total = '" . base64_decode($_GET['totalCompra']) . "'";
                            }
                            $query = mysqli_query($con, $select);
                            //retorna os dados existentes na tabela
                            while ($result = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>" . $result['idCompra'] . "</td>";
                                echo "<td>" . date("d-m-Y", strtotime($result['data'])) . "</td>";
                                echo "<td>" . $result['status'] . "</td>";
                                echo "<td>" . $result['fk_idFornecedor'] . "</td>";
                                echo "<td>" . number_format($result['total'], 2, ',', '.') . "</td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

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

</body>

</html>