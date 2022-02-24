-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 07-Fev-2022 às 09:09
-- Versão do servidor: 5.7.37-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mdb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` char(150) NOT NULL,
  `cpf` char(15) NOT NULL,
  `endereco` char(150) NOT NULL,
  `telefone` char(20) NOT NULL,
  `email` char(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `cpf`, `endereco`, `telefone`, `email`) VALUES
(1, 'avulso', '1234567890', 'rua qualquer, 001', '1234567890', 'avulso@avulso.com'),
(2, 'teste', '9876543210', 'rua teste, 123', '0123456789', 'teste@teste.com.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `total` double NOT NULL,
  `status` varchar(30) NOT NULL,
  `fk_idfornecedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `compras_items`
--

CREATE TABLE `compras_items` (
  `id` int(11) NOT NULL,
  `fk_idcompra` int(11) NOT NULL,
  `fk_idproduto` int(11) NOT NULL,
  `preco` double NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id` int(11) NOT NULL,
  `nome` char(150) NOT NULL,
  `telefone` char(14) NOT NULL,
  `email` char(150) NOT NULL,
  `endereco` char(150) NOT NULL,
  `cnpj` char(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id`, `nome`, `telefone`, `email`, `endereco`, `cnpj`) VALUES
(1, 'Fornecedor', '(12)12345-6789', 'fornecedor@fornecedor.com', 'Rua teste', '11.111.111/0001-11'),
(3, 'teste', '1234567890', 'teste@teste.com', 'Rua teste,12345', '1234567890/0001-11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` char(150) NOT NULL,
  `tipo` char(150) NOT NULL,
  `estoque` int(11) NOT NULL,
  `preco` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `tipo`, `estoque`, `preco`) VALUES
(1, 'Petra', 'Bebidas', 5000, 2.39),
(2, 'Catchup', 'Alimentos', 2000, 3.99),
(3, 'Alvejante', 'Limpeza', 500, 4.89),
(4, 'Picanha', 'AÃ§ougue', 250, 99.99);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `telefone` varchar(30) NOT NULL,
  `email` varchar(150) NOT NULL,
  `login` varchar(150) NOT NULL,
  `senha` varchar(150) NOT NULL,
  `acesso` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `telefone`, `email`, `login`, `senha`, `acesso`) VALUES
(1, 'admin', '1234567890', 'admin@admin.com', 'admin', '12345', 'acesso total'),
(2, 'teste', '1234567890', 'teste@teste.com', 'teste', '123', 'acesso restrito');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `idVenda` int(11) NOT NULL,
  `data` date NOT NULL,
  `status` char(30) NOT NULL,
  `total` double NOT NULL,
  `fk_idCliente` char(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`idVenda`, `data`, `status`, `total`, `fk_idCliente`) VALUES
(1, '1969-12-31', 'aberto', 0, 'avulso'),
(21, '2022-02-03', 'aberto', 0, 'avulso'),
(22, '2022-02-04', 'aberto', 1, 'teste'),
(23, '2022-02-04', 'aberto', 0, 'avulso'),
(24, '2022-02-04', 'fechado', 0, 'teste'),
(25, '2022-02-04', 'aberto', 0, 'teste'),
(26, '2022-02-04', 'aberto', 0, 'avulso');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas_items`
--

CREATE TABLE `vendas_items` (
  `id` int(11) NOT NULL,
  `fk_idVenda` int(11) NOT NULL,
  `fk_idProduto` int(11) NOT NULL,
  `preco` double NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compras_items`
--
ALTER TABLE `compras_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`idVenda`);

--
-- Indexes for table `vendas_items`
--
ALTER TABLE `vendas_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `compras_items`
--
ALTER TABLE `compras_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `vendas`
--
ALTER TABLE `vendas`
  MODIFY `idVenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `vendas_items`
--
ALTER TABLE `vendas_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
