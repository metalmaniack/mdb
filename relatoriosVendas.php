<?php
include 'conexao.php';
session_start();
?>
<!DOCTYPE html5>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Relátorio de Vendas</title>

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
            <h1 class="h2">Relatório de Vendas</h1>
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
        <!--Área de vendas-->
        <form action="buscaRelatorios.php" method="POST">
            <div class="d-flex flex-row mb-3">
                <div class="form-group p-2 col-sm-1">
                    <label for="idVenda">ID Venda:</label>
                    <input type="text" class="form-control" name="txtIdVenda">
                </div>
                <div class="form-group pt-3 mt-4">
                    <button type="submit" class="btn btn-primary ml-2" name="btnBuscaVenda"><span
                            data-feather="search"></button>
                </div>
            </div>
        </form>
        <h4>Tabela de vendas </h4>
        <!--Tabela de vendas-->
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>ID Venda</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Cliente</th>
                        <th>Total(R$)</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if (!isset($_GET['idVenda'])) {
                        $_GET['idVenda'] = "";
                        //instrução select
                        $select = "Select * from vendas order by data ASC";
                        $query = mysqli_query($con, $select);
                        //retorna os dados existentes na tabela
                        while ($result = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>" . $result['idVenda'] . "</td>";
                            echo "<td>" . date("d-m-Y", strtotime($result['data'])) . "</td>";
                            echo "<td>" . $result['status'] . "</td>";
                            echo "<td>" . $result['fk_idCliente'] . "</td>";
                            echo "<td>" . number_format($result['total'], 2, ',', '.') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        //instrução select
                        $selectVenda = "Select * from vendas where idVenda= ".$_GET['idVenda']."";
                        $queryVenda = mysqli_query($con, $selectVenda);
                        //retorna os dados existentes na tabela
                        while ($resultVenda = mysqli_fetch_assoc($queryVenda)) {
                            echo "<tr>";
                            echo "<td>" . $resultVenda['idVenda'] . "</td>";
                            echo "<td>" . date("d-m-Y", strtotime($resultVenda['data'])) . "</td>";
                            echo "<td>" . $resultVenda['status'] . "</td>";
                            echo "<td>" . $resultVenda['fk_idCliente'] . "</td>";
                            echo "<td>" . number_format($resultVenda['total'], 2, ',', '.') . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
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

</body>

</html>