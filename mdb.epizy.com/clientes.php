<?php
include 'conexao.php';
session_start();
?>
<!DOCTYPE html5>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Clientes</title>

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
            <h1 class="h2">Clientes</h1>
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
        <form method="post" action="cadClientes.php">

            <h4>Cadastrar novo cliente</h4>
            <!--Alerta de sucesso ou fracasso ao cadastrar-->
            <?php if(!isset($_GET['msg'])){
                $_GET['msg']="";
            ?>
            <?php } else if (base64_decode($_GET['msg']) == "success" && base64_decode($_GET['acao']) == "inserir") { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Cliente cadastrado com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "danger" && base64_decode($_GET['acao']) == "inserir") { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Cliente não foi cadastrado com sucesso,tente novamente!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "success" && base64_decode($_GET['acao']) == "alterar") { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Cliente alterado com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "danger" && base64_decode($_GET['acao']) == "alterar") { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Cliente não foi alterado com sucesso,tente novamente!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "success" && base64_decode($_GET['acao']) == "excluir") { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Cliente excluído com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } else if (base64_decode($_GET['msg']) == "danger" && base64_decode($_GET['acao']) == "excluir") { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Cliente não foi excluído com sucesso,tente novamente!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } ?>
            <!--Verifica se foi passado o id pelo metodo GET-->
            <?php
             if (!isset($_GET['ref'])) {
                $_GET['ref'] = "";
            }
            else {
                $select = "Select * From clientes where id=" . base64_decode($_GET['ref']);
                $query = mysqli_query($con, $select);
                $result = mysqli_fetch_assoc($query);
            }
            ?>
            <!--Formulário cliente-->
            <div class="form-group col-2">
                <label for="id">ID:</label>
                <input type="text" class="form-control" name="txtId"
                    value="<?php echo base64_decode($_GET['ref']) ? $result['id'] : "" ?>" readonly>
            </div>

            <div class="form-group col-6">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" placeholder="Nome" name="txtNome"
                    value="<?php echo base64_decode($_GET['ref']) ? $result['nome'] : "" ?>">
            </div>
            <div class="form-group col-6">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" placeholder="CPF" name="txtCpf"
                    value="<?php echo base64_decode($_GET['ref']) ? $result['cpf'] : "" ?>">
            </div>
            <div class="form-group col-6">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" placeholder="Endereço"
                    value="<?php echo base64_decode($_GET['ref']) ? $result['endereco'] : "" ?>" name="txtEndereco">
            </div>
            <div class="form-group col-6">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" placeholder="Telefone"
                    value="<?php echo base64_decode($_GET['ref']) ? $result['telefone'] : "" ?>" name="txtTelefone">
            </div>
            <div class="form-group col-6">
                <label for="email">Email:</label>
                <input type="email" class="form-control" placeholder="Email"
                    value="<?php echo base64_decode($_GET['ref']) ? $result['email'] : "" ?>" name="txtEmail">
            </div>

            <button type="submit" class="btn btn-primary ml-3" name="btnCadastrar">Cadastrar</button>
            <button type="submit" class="btn btn-secondary ml-3" name="btnBuscar">Buscar</button>
            <button type="submit" class="btn btn-warning ml-3" name="btnAlterar">Alterar</button>
            <button type="submit" class="btn btn-danger ml-3" name="btnExcluir">Excluir</button>
            <button type="reset" class="btn btn-info ml-3" name="btnLimpar">Limpar</button>
        </form>
        <br>

        <h4>Clientes cadastrados</h4>
        <!--Tabela com os registros dos clientes-->
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>id</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Endereço</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th class="pl-5">Ação</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if(!isset($_GET['acao'])){
                        $_GET['acao']="";
                    
                        //instrução select 
                        $select = "Select * from clientes;";
                        $query = mysqli_query($con, $select);
                        //retorna os dados existentes na tabela
                        while ($result = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>" . $result['id'] . "</td>";
                            echo "<td>" . $result['nome'] . "</td>";
                            echo "<td>" . $result['cpf'] . "</td>";
                            echo "<td>" . $result['endereco'] . "</td>";
                            echo "<td>" . $result['telefone'] . "</td>";
                            echo "<td>" . $result['email'] . "</td>";
                            echo "<td><a href=clientes.php?ref=" . base64_encode($result['id']) . " type='submit' class='btn btn-info ml-3' name='btnSelecionar'>Selecionar</a></td>";
                            echo "</tr>";
                        }
                    }
                    else if (base64_decode($_GET['acao']) == "inserir") {
                        //instrução select 
                        $select = "Select * from clientes;";
                        $query = mysqli_query($con, $select);
                        //retorna os dados existentes na tabela
                        while ($result = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>" . $result['id'] . "</td>";
                            echo "<td>" . $result['nome'] . "</td>";
                            echo "<td>" . $result['cpf'] . "</td>";
                            echo "<td>" . $result['endereco'] . "</td>";
                            echo "<td>" . $result['telefone'] . "</td>";
                            echo "<td>" . $result['email'] . "</td>";
                            echo "<td><a href=clientes.php?ref=" . base64_encode($result['id']) . " type='submit' class='btn btn-info ml-3' name='btnSelecionar'>Selecionar</a></td>";
                            echo "</tr>";
                        }
                    }
                    else if (base64_decode($_GET['acao']) == "buscar") {
                        $varBusca = base64_decode($_GET['varBusca']);
                        if($varBusca == 'NOME') {
                            $select = "Select * from clientes WHERE nome='" . base64_decode($_GET['nome']) . "'";
                        } else if($varBusca == 'CPF') {
                            $select = "Select * from clientes WHERE cpf = '" . base64_decode($_GET['cpf']) . "'";
                        } else if($varBusca == 'ENDERECO') {
                            $select = "Select * from clientes WHERE endereco = '" . base64_decode($_GET['endereco']) . "'";
                        } else if($varBusca == 'TELEFONE') {
                            $select = "Select * from clientes WHERE telefone ='" . base64_decode($_GET['telefone']) . "'";
                        } else if($varBusca == 'EMAIL') {
                            $select = "Select * from clientes WHERE email= '" . base64_decode($_GET['email']) . "'";
                        } 
                        $query = mysqli_query($con, $select);
                        //retorna os dados existentes na tabela
                        while ($result = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>" . $result['id'] . "</td>";
                            echo "<td>" . $result['nome'] . "</td>";
                            echo "<td>" . $result['cpf'] . "</td>";
                            echo "<td>" . $result['endereco'] . "</td>";
                            echo "<td>" . $result['telefone'] . "</td>";
                            echo "<td>" . $result['email'] . "</td>";
                            echo "<td><a href=clientes.php?ref=" . base64_encode($result['id']) . " type='submit' class='btn btn-info ml-3' name='btnSelecionar'>Selecionar</a></td>";
                            echo "</tr>";
                        }
                    }
                    else if (base64_decode($_GET['acao']) == "alterar") {
                        //instrução select 
                        $select = "Select * from clientes;";
                        $query = mysqli_query($con, $select);
                        //retorna os dados existentes na tabela
                        while ($result = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>" . $result['id'] . "</td>";
                            echo "<td>" . $result['nome'] . "</td>";
                            echo "<td>" . $result['cpf'] . "</td>";
                            echo "<td>" . $result['endereco'] . "</td>";
                            echo "<td>" . $result['telefone'] . "</td>";
                            echo "<td>" . $result['email'] . "</td>";
                            echo "<td><a href=clientes.php?ref=" . base64_encode($result['id']) . " type='submit' class='btn btn-info ml-3' name='btnSelecionar'>Selecionar</a></td>";
                            echo "</tr>";
                        }
                    }
                    else if (base64_decode($_GET['acao']) == "excluir") {
                        //instrução select 
                        $select = "Select * from clientes;";
                        $query = mysqli_query($con, $select);
                        //retorna os dados existentes na tabela
                        while ($result = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>" . $result['id'] . "</td>";
                            echo "<td>" . $result['nome'] . "</td>";
                            echo "<td>" . $result['cpf'] . "</td>";
                            echo "<td>" . $result['endereco'] . "</td>";
                            echo "<td>" . $result['telefone'] . "</td>";
                            echo "<td>" . $result['email'] . "</td>";
                            echo "<td><a href=clientes.php?ref=" . base64_encode($result['id']) . " type='submit' class='btn btn-info ml-3' name='btnSelecionar'>Selecionar</a></td>";
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
</body>

</html>