-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/05/2024 às 05:39
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `upperpro`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `razao_social` varchar(255) NOT NULL,
  `tamanho_empresa` varchar(20) NOT NULL,
  `segmento_empresa` varchar(255) NOT NULL,
  `atividade_principal` varchar(255) NOT NULL,
  `caminho_imagem` varchar(255) DEFAULT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `email`, `senha`, `cnpj`, `razao_social`, `tamanho_empresa`, `segmento_empresa`, `atividade_principal`, `caminho_imagem`, `rua`, `bairro`, `cidade`, `uf`, `cep`) VALUES
(1, 'Marcoshenrique96126638@Gmail.com', 'Sandra10', '4458893587466621', 'nada', 'Pequena', 'serviços', 'Móveis, casa e decoração', NULL, 'Rua das Flores, 101', 'Jardim', 'São Paulo', 'SP', '01001-000'),
(3, 'as8196110@gmail.com', 'Sandra10!', '45.458.741/0001-89', 'Santos ', 'Micro', 'Industria', 'Arte', NULL, 'Avenida Brasil, 202', 'Centro', 'Rio de Janeiro', 'RJ', '20010-000'),
(7, 'joao@techsolucoes.com.br', 'Sandra10!', '90123456789012', 'TechSoluções', 'Grande', 'Tecnologia', 'Desenvolvimento de Software', NULL, 'Alameda Santos, 303', 'Bela Vista', 'São Paulo', 'SP', '01311-000'),
(8, 'maria@vidasaudavel.com.br', 'Sandra10!', '23456789012345', 'Vida Saudável', 'Micro', 'Alimentício', 'Vendas de Produtos Orgânicos', NULL, 'Rua Augusta, 404', 'Centro', 'Curitiba', 'PR', '80010-000'),
(9, 'carlos@decorarte.com.br', 'Sandra10!', '45678901234567', 'DecorArte', 'Pequena', 'Decoração', 'Vendas de Artigos de Decoração', '../perfil_img/perfil_663980ba92606_D_NQ_NP_954524-MLB74393624157_022024-O.png', 'Avenida Paulista, 505', 'Paulista', 'São Paulo', 'SP', '01311-000'),
(10, 'ana@consultoriaplus.com.br', 'Sandra10!', '67890123456789', 'ConsultoriaPlus', 'Média', 'Serviços', 'Consultoria Empresarial', NULL, 'Rua das Palmeiras, 101', 'Jardim Botânico', 'Rio de Janeiro', 'RJ', '22461-030'),
(11, 'pedro@automotive.com.br', 'Sandra10!', '89012345678901', 'Automotive', 'Grande', 'Indústria', 'Fabricação de Componentes Automotivos', '../perfil_img/perfil_663d56d3d4542_D_NQ_NP_954524-MLB74393624157_022024-O.png', 'Avenida Atlântica, 202', 'Copacabana', 'Rio de Janeiro', 'RJ', '22021-001'),
(12, 'laura@fashionstyle.com.br', 'Sandra10!', '01234567890123', 'FashionStyle', 'Pequena', 'Moda', 'Vendas de Roupas e Acessórios', NULL, 'Rua XV de Novembro, 303', 'Centro', 'Curitiba', 'PR', '80020-310'),
(13, 'fernando@softinova.com.br', 'Sandra10!', '34567890123456', 'SoftInova', 'Média', 'Tecnologia', 'Desenvolvimento de Aplicativos Móveis', NULL, 'Avenida das Américas, 404', 'Barra da Tijuca', 'Rio de Janeiro', 'RJ', '22640-102'),
(14, 'julia@deliciasdavovo.com.br', 'Sandra10!', '56789012345678', 'Delícias da Vovó', 'Micro', 'Alimentício', 'Produção de Doces Artesanais', NULL, 'Rua dos Andradas, 505', 'Centro', 'Porto Alegre', 'RS', '90020-003'),
(15, 'empresa@inforpro.com.br', 'Sandra10!', '78901234567890', 'InforPro', 'Pequena', 'Tecnologia', 'Venda de Peças para Servidores', '../perfil_img/perfil_6650fa6d6a119_logo inforpro.png', 'Rua da Inovação, 101', 'Centro', 'São Paulo', 'SP', '01001-000'),
(16, '', '$2y$10$jug6OiLs0K.TDrLdVabTVe8WMrOrpYFYV/yG9Msx3973rj9tntLz.', '54562645546', '', '', '', '', NULL, '', '', '', '', ''),
(17, '', '$2y$10$.HqAHJKbjm6Utdvodkd7O.Q/UrIvV2Wa9YwAZGo.tikOAK3JT8JL2', '5456264554656', '', '', '', '', NULL, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `num_ped` int(11) NOT NULL,
  `fornecedor` varchar(255) NOT NULL,
  `comprador` varchar(255) NOT NULL,
  `cond_pagamento` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `data_compra` date NOT NULL,
  `data_recebimento` date NOT NULL,
  `data_prevista` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `num_itens` int(11) NOT NULL,
  `soma_quantidades` int(11) NOT NULL,
  `desconto_total_itens` decimal(10,2) NOT NULL,
  `total_itens` decimal(10,2) NOT NULL,
  `desconto_total_compra` decimal(10,2) NOT NULL,
  `total_compra` decimal(10,2) NOT NULL,
  `lancado_estoque` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `compras`
--

INSERT INTO `compras` (`id`, `num_ped`, `fornecedor`, `comprador`, `cond_pagamento`, `categoria`, `data_compra`, `data_recebimento`, `data_prevista`, `id_usuario`, `num_itens`, `soma_quantidades`, `desconto_total_itens`, `total_itens`, `desconto_total_compra`, `total_compra`, `lancado_estoque`) VALUES
(7, 7, 'Marcos Henrique', 'Marcos', 'Pix', 'A vista', '2024-05-24', '0000-00-00', '2024-05-31', 15, 2, 3, 150.00, 1650.00, 150.00, 1650.00, 0),
(8, 8, 'TechWave Solutions', 'Marcos', 'Pix', 'A vista', '2024-05-24', '0000-00-00', '2024-05-31', 15, 2, 4, 141.00, 1359.00, 141.00, 1359.00, 0),
(9, 9, 'Hardware Supply Co.', 'Marcos', 'Pix', 'A vista', '2024-05-25', '0000-00-00', '2024-05-31', 15, 2, 3, 127.50, 1222.50, 127.50, 1222.50, 0),
(10, 10, 'SupplierTech Inc', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 5, 50.00, 500.00, 50.00, 450.00, 0),
(11, 11, 'Hardware Supply Co.', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 3, 30.00, 300.00, 30.00, 270.00, 0),
(12, 12, 'CyberParts Ltda', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 4, 40.00, 400.00, 40.00, 360.00, 0),
(13, 13, 'NextGen Suppliers', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 5, 50.00, 500.00, 50.00, 450.00, 0),
(14, 14, 'FutureTech Distributors', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 6, 60.00, 600.00, 60.00, 540.00, 0),
(15, 15, 'Laura Menezes', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 7, 70.00, 700.00, 70.00, 630.00, 0),
(16, 16, 'Carlos Eduardo', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 8, 80.00, 800.00, 80.00, 720.00, 0),
(17, 17, 'Mariana Rocha', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 9, 90.00, 900.00, 90.00, 810.00, 0),
(18, 18, 'Felipe Pereira', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 10, 100.00, 1000.00, 100.00, 900.00, 0),
(19, 19, 'Juliana Carvalho', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 11, 110.00, 1100.00, 110.00, 990.00, 0),
(20, 20, 'NextGen Suppliers', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-27', '2024-06-01', 15, 2, 4, 0.00, 1263.16, 0.00, 1263.16, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `data_contratacao` date NOT NULL,
  `salario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `cpf`, `cargo`, `email`, `telefone`, `data_contratacao`, `salario`) VALUES
(1, 'Marcos Henrique', '548.381.388', 'Vendedor', 'Marcoshenrique96126638@Gmail.com', '(15) 99778-0834', '2024-05-27', 4500.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_del_compra`
--

CREATE TABLE `historico_del_compra` (
  `id` int(11) NOT NULL,
  `num_ped` int(11) DEFAULT NULL,
  `fornecedor` varchar(255) DEFAULT NULL,
  `comprador` varchar(255) DEFAULT NULL,
  `cond_pagamento` varchar(255) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `data_compra` date DEFAULT NULL,
  `data_recebimento` date DEFAULT NULL,
  `data_prevista` date DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `num_itens` int(11) DEFAULT NULL,
  `soma_quantidades` int(11) DEFAULT NULL,
  `desconto_total_itens` decimal(10,2) DEFAULT NULL,
  `total_itens` decimal(10,2) DEFAULT NULL,
  `desconto_total_compra` decimal(10,2) DEFAULT NULL,
  `total_compra` decimal(10,2) DEFAULT NULL,
  `lancado_estoque` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `historico_del_compra`
--

INSERT INTO `historico_del_compra` (`id`, `num_ped`, `fornecedor`, `comprador`, `cond_pagamento`, `categoria`, `data_compra`, `data_recebimento`, `data_prevista`, `id_usuario`, `num_itens`, `soma_quantidades`, `desconto_total_itens`, `total_itens`, `desconto_total_compra`, `total_compra`, `lancado_estoque`, `deleted_at`) VALUES
(1, 1, '54838138806', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', 15, 0, 0, 0.00, 0.00, 0.00, 0.00, 0, '2024-05-25 00:40:40'),
(2, 2, 'M', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', 15, 0, 0, 0.00, 0.00, 0.00, 0.00, 0, '2024-05-25 00:40:41'),
(3, 3, 'khgiy', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', 15, 0, 0, 0.00, 0.00, 0.00, 0.00, 0, '2024-05-25 00:40:42'),
(4, 4, 'Marcos Henrique', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', 15, 0, 0, 0.00, 0.00, 0.00, 0.00, 0, '2024-05-25 00:40:43'),
(5, 5, '543813886', '', '', '', '2024-05-24', '0000-00-00', '0000-00-00', 15, 0, 0, 0.00, 0.00, 0.00, 0.00, 0, '2024-05-25 00:40:44'),
(6, 6, 'Marcos Henrique', '', 'Pix', 'A vista', '2024-05-24', '2024-05-28', '2024-05-31', 15, 2, 6, 0.00, 0.00, 0.00, 0.00, 0, '2024-05-25 00:40:46');

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_del_itens_compra`
--

CREATE TABLE `historico_del_itens_compra` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `nome_item` varchar(255) DEFAULT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `desconto` decimal(10,2) DEFAULT NULL,
  `preco_total` decimal(10,2) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `historico_del_itens_compra`
--

INSERT INTO `historico_del_itens_compra` (`id`, `compra_id`, `nome_item`, `codigo`, `quantidade`, `preco`, `desconto`, `preco_total`, `deleted_at`) VALUES
(1, 1, '', '', 0, 0.00, 0.00, 0.00, '2024-05-25 00:40:40'),
(2, 1, '', '', 0, 0.00, 0.00, 0.00, '2024-05-25 00:40:40'),
(4, 2, '', '', 0, 0.00, 0.00, 0.00, '2024-05-25 00:40:41'),
(5, 2, '', '', 0, 0.00, 0.00, 0.00, '2024-05-25 00:40:41'),
(7, 3, '', '', 0, 0.00, 0.00, 0.00, '2024-05-25 00:40:42'),
(8, 3, '', '', 0, 0.00, 0.00, 0.00, '2024-05-25 00:40:42'),
(10, 4, '', '', 0, 0.00, 0.00, 0.00, '2024-05-25 00:40:43'),
(11, 4, '', '', 0, 0.00, 0.00, 0.00, '2024-05-25 00:40:43'),
(13, 5, 'Switch KVM 16 Portas', '', 0, 0.00, 0.00, 0.00, '2024-05-25 00:40:44'),
(14, 5, '', '', 0, 0.00, 0.00, 0.00, '2024-05-25 00:40:44'),
(16, 6, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 5, 0.00, 10.00, 0.00, '2024-05-25 00:40:46'),
(17, 6, 'Placa de Vídeo Nvidia Quadro P5000', 'QUADROP5000', 1, 0.00, 5.00, 0.00, '2024-05-25 00:40:46');

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_del_itens_venda`
--

CREATE TABLE `historico_del_itens_venda` (
  `id` int(11) NOT NULL,
  `venda_id` int(11) DEFAULT NULL,
  `nome_item` varchar(255) DEFAULT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `desconto` decimal(10,2) DEFAULT NULL,
  `preco_total` decimal(10,2) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `historico_del_itens_venda`
--

INSERT INTO `historico_del_itens_venda` (`id`, `venda_id`, `nome_item`, `codigo`, `quantidade`, `preco`, `desconto`, `preco_total`, `deleted_at`) VALUES
(1, 2, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 1, 0.00, 10.00, 0.00, '2024-05-25 22:12:06'),
(2, 2, 'Case para Servidor 2U', 'CASEPARASERVIDOR2U01', 5, 0.00, 10.00, 0.00, '2024-05-25 22:12:06'),
(4, 1, 'Frigideira', '123456', 4, 0.00, 10.00, 0.00, '2024-05-25 22:12:06'),
(5, 1, 'panela', '321654', 2, 0.00, 25.00, 0.00, '2024-05-25 22:12:06'),
(7, 3, 'Switch KVM 16 Portas', '', 1, 0.00, 5.00, 0.00, '2024-05-25 22:12:08'),
(8, 3, 'Cooler para Processador Cooler Master', '', 2, 0.00, 10.00, 0.00, '2024-05-25 22:12:08');

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_del_venda`
--

CREATE TABLE `historico_del_venda` (
  `id` int(11) NOT NULL,
  `num_ped` int(11) DEFAULT NULL,
  `cliente` varchar(255) DEFAULT NULL,
  `vendedor` varchar(255) DEFAULT NULL,
  `cond_pagamento` varchar(255) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `data_venda` date DEFAULT NULL,
  `data_saida` date DEFAULT NULL,
  `data_prevista` date DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `num_itens` int(11) DEFAULT NULL,
  `soma_quantidades` int(11) DEFAULT NULL,
  `desconto_total_itens` decimal(10,2) DEFAULT NULL,
  `total_itens` decimal(10,2) DEFAULT NULL,
  `desconto_total_venda` decimal(10,2) DEFAULT NULL,
  `total_venda` decimal(10,2) DEFAULT NULL,
  `lancado_estoque` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `historico_del_venda`
--

INSERT INTO `historico_del_venda` (`id`, `num_ped`, `cliente`, `vendedor`, `cond_pagamento`, `categoria`, `data_venda`, `data_saida`, `data_prevista`, `id_usuario`, `num_itens`, `soma_quantidades`, `desconto_total_itens`, `total_itens`, `desconto_total_venda`, `total_venda`, `lancado_estoque`, `deleted_at`) VALUES
(1, 2, 'Amazon', '', 'Pix', 'A vista', '2024-05-24', '2024-05-24', '2024-05-24', 15, 2, 6, 0.00, 0.00, 0.00, 0.00, 0, '2024-05-25 22:12:06'),
(2, 1, 'Outro la ', 'Marcos', 'Pix', 'A vista', '2024-05-19', '2024-05-24', '2024-05-24', 15, 2, 6, 0.00, 0.00, 0.00, 0.00, 0, '2024-05-25 22:12:06'),
(3, 3, '65432178000190', 'Marcos', 'Pix', 'A vista', '2024-05-25', '0000-00-00', '0000-00-00', 15, 0, 0, 0.00, 0.00, 0.00, 0.00, 0, '2024-05-25 22:12:08'),
(4, 0, 'TechWave Solutions', '<br /><b>Warning</b>:  Undefined array key ', '', '', '0000-00-00', '0000-00-00', '0000-00-00', 15, 0, 0, 0.00, 0.00, 0.00, 0.00, 0, '2024-05-26 07:07:14'),
(5, 0, 'Bright Future Tech', '<br /><b>Warning</b>:  Undefined array key ', '', '', '0000-00-00', '0000-00-00', '0000-00-00', 15, 0, 0, 0.00, 0.00, 0.00, 0.00, 0, '2024-05-26 07:07:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_produtos`
--

CREATE TABLE `historico_produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `preco_compra` decimal(10,2) NOT NULL,
  `unidade` varchar(10) NOT NULL,
  `condicao` enum('Novo','Usado') NOT NULL,
  `quantidade_estoque` int(11) NOT NULL DEFAULT 0,
  `imagem` varchar(255) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_compra`
--

CREATE TABLE `itens_compra` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `nome_item` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `desconto` decimal(10,2) NOT NULL,
  `preco_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_compra`
--

INSERT INTO `itens_compra` (`id`, `compra_id`, `nome_item`, `codigo`, `quantidade`, `preco`, `desconto`, `preco_total`) VALUES
(15, 7, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 1, 0.00, 5.00, 570.00),
(16, 7, 'Processador Intel Xeon E5-2690v4', 'XEONE52690V4', 2, 0.00, 10.00, 1080.00),
(17, 8, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 2, 0.00, 10.00, 1080.00),
(18, 8, 'SSD 1TB SATA III', 'SSD1TBSATAIII01', 2, 0.00, 7.00, 279.00),
(19, 9, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 2, 0.00, 10.00, 1080.00),
(20, 9, 'SSD 1TB SATA III', 'SSD1TBSATAIII01', 1, 0.00, 5.00, 142.50),
(21, 10, 'SSD 1TB SATA III', 'SSD1TBSATAIII01', 2, 150.00, 15.00, 285.00),
(22, 10, 'Placa de Vídeo Nvidia Quadro P5000', 'QUADROP5000', 1, 800.00, 80.00, 720.00),
(23, 11, 'Processador Intel Xeon E5-2690v4', 'XEONE52690V4', 2, 600.00, 60.00, 1140.00),
(24, 11, 'Fonte de Alimentação 750W', 'FONTEALIMENTACAO750W01', 1, 120.00, 12.00, 108.00),
(25, 12, 'Placa Mãe para Servidor Supermicro', 'PLACAMAESUPERMICRO01', 1, 300.00, 30.00, 270.00),
(26, 12, 'Cooler para Processador Cooler Master', 'COOLERPROCESSADORCOOLERMASTER01', 2, 50.00, 5.00, 90.00),
(27, 13, 'Gabinete Rack 4U', 'GABINETE4U01', 1, 200.00, 20.00, 180.00),
(28, 13, 'Switch Gerenciável 24 Portas Gigabit', 'SWITCHGERENCIABLE24PORTASGIGABIT01', 1, 400.00, 40.00, 360.00),
(29, 14, 'Cabo de Fibra Óptica Multimodo 10m', 'CABOFIBRAOPTICAMULTIMODO10M01', 2, 30.00, 3.00, 54.00),
(30, 14, 'Servidor Dell PowerEdge T340', 'POWEREDGET340', 1, 1500.00, 150.00, 1350.00),
(31, 15, 'HD SAS 2TB 7200RPM', 'HDSAS2TB7200RPM01', 2, 200.00, 20.00, 360.00),
(32, 15, 'Placa de Rede Gigabit Ethernet', 'PLACAREDEGIGABIT01', 1, 80.00, 8.00, 72.00),
(33, 16, 'Memória RAM DDR4 ECC 32GB', 'MEMORIARAMDDR4ECC32GB01', 1, 250.00, 25.00, 225.00),
(34, 16, 'Controladora RAID SAS/SATA', 'CONTROLADORARAIDSAS01', 1, 300.00, 30.00, 270.00),
(35, 17, 'Fonte Redundante para Servidor', 'FONTEREDUNDANTESERVIDOR01', 1, 400.00, 40.00, 360.00),
(36, 17, 'Kit de Trilhos para Rack', 'KITTRILHOSPARARACK01', 2, 50.00, 5.00, 90.00),
(37, 18, 'Cabo de Fibra Óptica Monomodo 5m', 'CABOFIBRAOPTICAMONOMODO5M01', 2, 20.00, 2.00, 36.00),
(38, 18, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 1, 600.00, 60.00, 540.00),
(39, 19, 'Case para Servidor 2U', 'CASEPARASERVIDOR2U01', 2, 150.00, 15.00, 270.00),
(40, 19, 'MODULO COOLER DELL R740', 'MODULOCOOLERDELLR740', 1, 9000.00, 900.00, 8100.00),
(41, 20, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 4, 0.00, 0.00, 1263.16),
(42, 20, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 0, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_venda`
--

CREATE TABLE `itens_venda` (
  `id` int(11) NOT NULL,
  `venda_id` int(11) NOT NULL,
  `nome_item` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `desconto` decimal(5,2) NOT NULL,
  `preco_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_venda`
--

INSERT INTO `itens_venda` (`id`, `venda_id`, `nome_item`, `codigo`, `quantidade`, `preco`, `desconto`, `preco_total`) VALUES
(7, 4, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 2, 0.00, 10.00, 1080.00),
(8, 4, 'Gabinete Rack 4U', 'GABINETE4U01', 1, 0.00, 5.00, 190.00),
(9, 5, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 1, 0.00, 10.00, 540.00),
(10, 5, 'Cooler para Processador Cooler Master', 'COOLERPROCESSADORCOOLERMASTER01', 2, 0.00, 10.00, 90.00),
(11, 10, 'SSD 1TB SATA III', 'SSD1TBSATAIII01', 2, 150.00, 15.00, 285.00),
(12, 10, 'Placa de Vídeo Nvidia Quadro P5000', 'QUADROP5000', 1, 800.00, 80.00, 720.00),
(13, 11, 'Processador Intel Xeon E5-2690v4', 'XEONE52690V4', 2, 600.00, 60.00, 1140.00),
(14, 11, 'Fonte de Alimentação 750W', 'FONTEALIMENTACAO750W01', 1, 120.00, 12.00, 108.00),
(15, 12, 'Placa Mãe para Servidor Supermicro', 'PLACAMAESUPERMICRO01', 1, 300.00, 30.00, 270.00),
(16, 12, 'Cooler para Processador Cooler Master', 'COOLERPROCESSADORCOOLERMASTER01', 2, 50.00, 5.00, 90.00),
(17, 13, 'Gabinete Rack 4U', 'GABINETE4U01', 1, 200.00, 20.00, 180.00),
(18, 13, 'Switch Gerenciável 24 Portas Gigabit', 'SWITCHGERENCIABLE24PORTASGIGABIT01', 1, 400.00, 40.00, 360.00),
(19, 14, 'Cabo de Fibra Óptica Multimodo 10m', 'CABOFIBRAOPTICAMULTIMODO10M01', 2, 30.00, 3.00, 54.00),
(20, 14, 'Servidor Dell PowerEdge T340', 'POWEREDGET340', 1, 1500.00, 150.00, 1350.00),
(21, 15, 'HD SAS 2TB 7200RPM', 'HDSAS2TB7200RPM01', 2, 200.00, 20.00, 360.00),
(22, 15, 'Placa de Rede Gigabit Ethernet', 'PLACAREDEGIGABIT01', 1, 80.00, 8.00, 72.00),
(23, 16, 'Memória RAM DDR4 ECC 32GB', 'MEMORIARAMDDR4ECC32GB01', 1, 250.00, 25.00, 225.00),
(24, 16, 'Controladora RAID SAS/SATA', 'CONTROLADORARAIDSAS01', 1, 300.00, 30.00, 270.00),
(25, 17, 'Fonte Redundante para Servidor', 'FONTEREDUNDANTESERVIDOR01', 1, 400.00, 40.00, 360.00),
(26, 17, 'Kit de Trilhos para Rack', 'KITTRILHOSPARARACK01', 2, 50.00, 5.00, 90.00),
(27, 18, 'Cabo de Fibra Óptica Monomodo 5m', 'CABOFIBRAOPTICAMONOMODO5M01', 2, 20.00, 2.00, 36.00),
(28, 18, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 1, 600.00, 60.00, 540.00),
(29, 19, 'Case para Servidor 2U', 'CASEPARASERVIDOR2U01', 2, 150.00, 15.00, 270.00),
(30, 19, 'MODULO COOLER DELL R740', 'MODULOCOOLERDELLR740', 1, 9000.00, 900.00, 8100.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa_fisica`
--

CREATE TABLE `pessoa_fisica` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `orgao_emissor` varchar(20) DEFAULT NULL,
  `tipo` varchar(10) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `fone` varchar(15) NOT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `banco` varchar(100) DEFAULT NULL,
  `agencia` varchar(20) DEFAULT NULL,
  `conta` varchar(20) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pessoa_fisica`
--

INSERT INTO `pessoa_fisica` (`id`, `nome`, `cpf`, `rg`, `orgao_emissor`, `tipo`, `rua`, `bairro`, `numero`, `cidade`, `uf`, `cep`, `complemento`, `fone`, `celular`, `email`, `banco`, `agencia`, `conta`, `observacoes`, `id_cliente`) VALUES
(14, 'Laura Menezes', '123.456.789-00', '12345678', 'SSP', 'cliente', 'Rua das Flores, 101', 'Jardim', '101', 'Floripa', 'SP', '01001-000', 'Apto 1', '12 3456-7890', '12 91111-2222', 'laura.menezes@techmail.com', 'Banco do Brasil', '0001', '123456-7', '', 15),
(15, 'Carlos Eduardo', '234.567.890-11', '23456789', 'SSP', 'cliente', 'Avenida Brasil, 202', 'Centro', '202', 'Porto Alegre', 'RS', '90010-000', 'Casa 2', '51 2233-4455', '51 92222-3333', 'carlos.eduardo@techmail.com', 'Bradesco', '0002', '234567-8', '', 15),
(16, 'Mariana Rocha', '345.678.901-22', '34567890', 'SSP', 'cliente', 'Alameda Santos, 303', 'Bela Vista', '303', 'São Paulo', 'SP', '01418-000', 'Apto 3', '11 3344-5566', '11 93333-4444', 'mariana.rocha@techmail.com', 'Itaú', '0003', '345678-9', '', 15),
(17, 'Felipe Pereira', '456.789.012-33', '45678901', 'SSP', 'cliente', 'Rua Augusta, 404', 'Centro', '404', 'Curitiba', 'PR', '80010-000', 'Casa 4', '41 4455-6677', '41 94444-5555', 'felipe.pereira@techmail.com', 'Santander', '0004', '456789-0', '', 15),
(18, 'Juliana Carvalho', '567.890.123-44', '56789012', 'SSP', 'cliente', 'Avenida Paulista, 505', 'Paulista', '505', 'São Paulo', 'SP', '01311-000', 'Apto 5', '11 5566-7788', '11 95555-6666', 'juliana.carvalho@techmail.com', 'Caixa', '0005', '567890-1', '', 15),
(19, 'Ricardo Monteiro', '678.901.234-55', '67890123', 'SSP', 'fornecedor', 'Rua das Palmeiras, 101', 'Jardim Botânico', '101', 'Rio de Janeiro', 'RJ', '22461-030', 'Apto 1', '21 6677-8899', '21 96666-7777', 'ricardo.monteiro@supplies.com', 'Banco do Brasil', '0001', '678901-2', '', 15),
(20, 'Fernanda Alves', '789.012.345-66', '78901234', 'SSP', 'fornecedor', 'Avenida Atlântica, 202', 'Copacabana', '202', 'Rio de Janeiro', 'RJ', '22021-001', 'Casa 2', '21 7788-9900', '21 97777-8888', 'fernanda.alves@supplies.com', 'Bradesco', '0002', '789012-3', '', 15),
(21, 'Gabriel Dias', '890.123.456-77', '89012345', 'SSP', 'fornecedor', 'Rua XV de Novembro, 303', 'Centro', '303', 'Curitiba', 'PR', '80020-310', 'Apto 3', '41 8899-0011', '41 98888-9999', 'gabriel.dias@supplies.com', 'Itaú', '0003', '890123-4', '', 15),
(22, 'Isabela Fernandes', '901.234.567-88', '90123456', 'SSP', 'fornecedor', 'Avenida das Américas, 404', 'Barra da Tijuca', '404', 'Rio de Janeiro', 'RJ', '22640-102', 'Casa 4', '21 9900-1122', '21 99999-0000', 'isabela.fernandes@supplies.com', 'Santander', '0004', '901234-5', '', 15),
(23, 'José Martins', '012.345.678-99', '01234567', 'SSP', 'fornecedor', 'Rua dos Andradas, 505', 'Centro', '505', 'Porto Alegre', 'RS', '90020-003', 'Apto 5', '51 0011-2233', '51 90000-1111', 'jose.martins@supplies.com', 'Caixa', '0005', '012345-6', '', 15);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa_juridica`
--

CREATE TABLE `pessoa_juridica` (
  `id` int(11) NOT NULL,
  `razao_social` varchar(255) NOT NULL,
  `nome_fantasia` varchar(255) NOT NULL,
  `cnpj` varchar(14) NOT NULL,
  `tipo_pessoa` varchar(20) NOT NULL,
  `inscricao_estadual` varchar(20) DEFAULT NULL,
  `ie_isento` tinyint(1) NOT NULL DEFAULT 0,
  `tipo` varchar(20) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `contato` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `email_nfe` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pessoa_juridica`
--

INSERT INTO `pessoa_juridica` (`id`, `razao_social`, `nome_fantasia`, `cnpj`, `tipo_pessoa`, `inscricao_estadual`, `ie_isento`, `tipo`, `rua`, `bairro`, `numero`, `cidade`, `uf`, `cep`, `complemento`, `contato`, `telefone`, `celular`, `email`, `email_nfe`, `website`, `id_cliente`) VALUES
(2, 'TechWave Solutions', 'TechWave', '65432178000190', 'Juridica', '123456789', 0, 'cliente', 'Rua da Inovação, 101', 'Centro', '101', 'Tecnópolis', 'SP', '12345-678', 'Prédio A', 'Lucas Silva', '11 1122-3344', '11 91111-2222', 'contact@techwave.com', 'nfe@techwave.com', 'www.techwave.com', 15),
(3, 'Bright Future Tech', 'Bright Future', '65432178000280', 'Juridica', '987654321', 0, 'cliente', 'Avenida da Tecnologia, 202', 'TecBairro', '202', 'InfoVille', 'SP', '87654-321', 'Bloco B', 'Mariana Costa', '11 2233-4455', '11 92222-3333', 'support@brightfuture.com', 'nfe@brightfuture.com', 'www.brightfuture.com', 15),
(4, 'Digital Horizon Corp', 'Digital Horizon', '65432178000370', 'Juridica', '567890123', 0, 'cliente', 'Alameda dos Bits, 303', 'Infotech', '303', 'CompTown', 'SP', '76543-210', 'Sala 3', 'Pedro Souza', '11 3344-5566', '11 93333-4444', 'info@digitalhorizon.com', 'nfe@digitalhorizon.com', 'www.digitalhorizon.com', 15),
(5, 'TechNova Solutions', 'TechNova', '65432178000460', 'Juridica', '432109876', 0, 'cliente', 'Estrada da Inovação, 404', 'HighTech', '404', 'NetCity', 'SP', '65432-109', 'Prédio C', 'Ana Clara', '11 4455-6677', '11 94444-5555', 'sales@technova.com', 'nfe@technova.com', 'www.technova.com', 15),
(6, 'Innovative Systems Ltd', 'Innovative Systems', '65432178000550', 'Juridica', '345678901', 0, 'cliente', 'Rodovia dos Bytes, 505', 'Digitown', '505', 'FonteVille', 'SP', '54321-098', 'Bloco D', 'Ricardo Oliveira', '11 5566-7788', '11 95555-6666', 'contact@innovativesystems.com', 'nfe@innovativesystems.com', 'www.innovativesystems.com', 15),
(7, 'SupplierTech Inc', 'SupplierTech', '76432178000190', 'Juridica', '123456789', 0, 'fornecedor', 'Avenida das Soluções, 606', 'Centro', '606', 'TechCity', 'SP', '01001-000', 'Prédio E', 'Carlos Almeida', '21 6677-8899', '21 96666-7777', 'supplier@suppliertech.com', 'nfe@suppliertech.com', 'www.suppliertech.com', 15),
(8, 'Hardware Supply Co.', 'Hardware Supply', '76432178000280', 'Juridica', '987654321', 0, 'fornecedor', 'Rua dos Componentes, 707', 'TecBairro', '707', 'InfoVille', 'SP', '90010-000', 'Sala F', 'Fernanda Lima', '21 7788-9900', '21 97777-8888', 'hardware@hardwaresupply.com', 'nfe@hardwaresupply.com', 'www.hardwaresupply.com', 15),
(9, 'CyberParts Ltda', 'CyberParts', '76432178000370', 'Juridica', '567890123', 0, 'fornecedor', 'Alameda dos Chips, 808', 'Infotech', '808', 'CompTown', 'SP', '01418-000', 'Galpão G', 'Gabriel Ferreira', '41 8899-0011', '41 98888-9999', 'parts@cyberparts.com', 'nfe@cyberparts.com', 'www.cyberparts.com', 15),
(10, 'NextGen Suppliers', 'NextGen', '76432178000460', 'Juridica', '432109876', 0, 'fornecedor', 'Estrada dos Gadgets, 909', 'HighTech', '909', 'NetCity', 'SP', '80010-000', 'Prédio H', 'Isabela Nunes', '21 9900-1122', '21 99999-0000', 'nextgen@suppliers.com', 'nfe@suppliers.com', 'www.suppliers.com', 15),
(11, 'FutureTech Distributors', 'FutureTech', '76432178000550', 'Juridica', '345678901', 0, 'fornecedor', 'Rodovia dos Widgets, 1010', 'Digitown', '1010', 'FonteVille', 'SP', '01311-000', 'Bloco I', 'José Martins', '51 0011-2233', '51 90000-1111', 'futuretech@distributors.com', 'nfe@distributors.com', 'www.futuretech.com', 15);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `preco_compra` decimal(10,2) NOT NULL,
  `unidade` varchar(10) NOT NULL,
  `condicao` enum('Novo','Usado') NOT NULL,
  `quantidade_estoque` int(11) NOT NULL DEFAULT 0,
  `imagem` varchar(255) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `sku`, `preco`, `preco_compra`, `unidade`, `condicao`, `quantidade_estoque`, `imagem`, `id_cliente`) VALUES
(4, 'COOLER FAN PARA SWITCH CISCO 3560X ', 'COOLERFANPARASWITCHCISCO3560X3750X', 1200.00, 631.58, 'UN', 'Usado', 8, '../produto_img/produto_66383e639f6b0_D_NQ_NP_954524-MLB74393624157_022024-O.png', 3),
(7, 'MODULO COOLER DUAL FAN EMC VNX5200', 'MODULOCOOLERDUALFANEMCVNX5200', 2500.00, 1315.79, 'UN', 'Usado', 11, '../produto_img/produto_663854470c3a4_EMC-100-563-685-00-SP-Dual-Fan-Module-VNX5200-VNX5400-VNX5600-VNX5800-VNX7600-cooler_500x500.png', 3),
(10, 'Notebook Dell Inspiron 15', 'DELLINSPIRON15', 2500.00, 1315.79, 'UN', 'Novo', 10, '../produto_img/notebook_dell_inspiron_15.png', 7),
(11, 'Teclado Gamer Logitech G Pro', 'LOGITECHGPRO', 150.00, 78.95, 'UN', 'Novo', 15, '../produto_img/teclado_gamer_logitech_g_pro.png', 7),
(12, 'Monitor Dell Ultrasharp 27\"', 'DELLULTRASHARP27', 500.00, 263.16, 'UN', 'Novo', 8, '../produto_img/monitor_dell_ultrasharp_27.png', 7),
(13, 'Mousepad Gamer HyperX Fury S', 'HYPERXFURYS', 30.00, 15.79, 'UN', 'Novo', 20, '../produto_img/mousepad_gamer_hyperx_fury_s.png', 7),
(14, 'Webcam Logitech C920', 'LOGITECHC920', 100.00, 52.63, 'UN', 'Novo', 12, '../produto_img/webcam_logitech_c920.png', 7),
(15, 'Caixa de Som Bluetooth JBL Flip 5', 'JBLFLIP5', 150.00, 78.95, 'UN', 'Novo', 18, '../produto_img/caixa_som_bluetooth_jbl_flip_5.png', 7),
(16, 'Roteador TP-Link Archer C7', 'TPLINKARCHERC7', 80.00, 42.11, 'UN', 'Novo', 25, '../produto_img/roteador_tplink_archer_c7.png', 7),
(17, 'Impressora Multifuncional Epson EcoTank L3150', 'EPSONECOTANKL3150', 300.00, 157.89, 'UN', 'Novo', 22, '../produto_img/impressora_epson_ecotank_l3150.png', 7),
(18, 'Fone de Ouvido Sony WH-1000XM4', 'SONYWH1000XM4', 300.00, 157.89, 'UN', 'Novo', 20, '../produto_img/fone_ouvido_sony_wh1000xm4.png', 7),
(19, 'Câmera de Segurança Intelbras Multi HD 1010', 'INTELBRASMULTIHD1010', 80.00, 42.11, 'UN', 'Novo', 30, '../produto_img/camera_seguranca_intelbras_multi_hd_1010.png', 7),
(20, 'Cesta de Frutas Orgânicas sem fruta', 'CESTAORGANICA01', 50.00, 26.32, 'UN', 'Novo', 10, '../produto_img/cesta_frutas_organicas.png', 8),
(21, 'Saco de Quinoa Integral', 'QUINOA01', 15.00, 7.89, 'KG', 'Novo', 15, '../produto_img/saco_quinoa_integral.png', 8),
(22, 'Kit Detox - Suco Verde', 'KITDETOXSUCOVERDE01', 30.00, 15.79, 'UN', 'Novo', 8, '../produto_img/kit_detox_suco_verde.png', 8),
(23, 'Óleo de Coco Extra Virgem', 'OLEOCOCO01', 20.00, 10.53, 'ML', 'Novo', 20, '../produto_img/oleo_coco_extra_virgem.png', 8),
(24, 'Pote de Mel Orgânico', 'MELORGANICO01', 25.00, 13.16, 'KG', 'Novo', 12, '../produto_img/pote_mel_organico.png', 8),
(25, 'Mix de Castanhas Premium', 'MIXCASTANHAS01', 18.00, 9.47, 'KG', 'Novo', 18, '../produto_img/mix_castanhas_premium.png', 8),
(26, 'Barra de Cereal Integral', 'BARRACEREAL01', 5.00, 2.63, 'UN', 'Novo', 25, '../produto_img/barra_cereal_integral.png', 8),
(27, 'Suplemento de Colágeno Hidrolisado', 'SUPLEMENTOCOLAGENO01', 40.00, 21.05, 'UN', 'Novo', 22, '../produto_img/suplemento_colageno_hidrolisado.png', 8),
(28, 'Pote de Chá Verde em Pó', 'CHAVEP01', 12.00, 6.32, 'UN', 'Novo', 20, '../produto_img/pote_cha_verde_po.png', 8),
(29, 'Pacote de Semente de Chia', 'SEMENTECHIA01', 8.00, 4.21, 'KG', 'Novo', 30, '../produto_img/pacote_semente_chia.png', 8),
(30, 'Vaso Decorativo de Cerâmica', 'VASOCERAMICA01', 25.00, 13.16, 'UN', 'Novo', 10, '../produto_img/vaso_decorativo_ceramica.png', 9),
(31, 'Espelho Decorativo Redondo', 'ESPELHOREDONDO01', 40.00, 21.05, 'UN', 'Novo', 15, '../produto_img/espelho_decorativo_redondo.png', 9),
(32, 'Quadro Abstrato em Canvas', 'QUADROABSTRATO01', 60.00, 31.58, 'UN', 'Novo', 8, '../produto_img/quadro_abstrato_canvas.png', 9),
(33, 'Tapete Felpudo para Sala', 'TAPETEFELPUDO01', 80.00, 42.11, 'UN', 'Novo', 20, '../produto_img/tapete_felpudo_sala.png', 9),
(34, 'Luminária de Mesa Estilo Industrial', 'LUMINARIAINDUSTRIAL01', 35.00, 18.42, 'UN', 'Novo', 12, '../produto_img/luminaria_mesa_estilo_industrial.png', 9),
(35, 'Almofada Decorativa Geométrica', 'ALMOFADAGEOMETRICA01', 20.00, 10.53, 'UN', 'Novo', 18, '../produto_img/almofada_decorativa_geometrica.png', 9),
(36, 'Cortina de Voil Branca', 'CORTINAVOIL01', 30.00, 15.79, 'UN', 'Novo', 25, '../produto_img/cortina_voil_branca.png', 9),
(37, 'Relógio de Parede Silencioso', 'RELOGIOPAREDESILENCIOSO01', 25.00, 13.16, 'UN', 'Novo', 22, '../produto_img/relogio_parede_silencioso.png', 9),
(38, 'Porta-Retrato de Madeira Rústica', 'PORTARETRATOMADEIRA01', 15.00, 7.89, 'UN', 'Novo', 20, '../produto_img/porta_retrato_madeira_rustica.png', 9),
(39, 'Cachepot de Metal Dourado', 'CACHEPOTMETALDOURADO01', 18.00, 9.47, 'UN', 'Novo', 30, '../produto_img/cachepot_metal_dourado.png', 9),
(40, 'Livro de Gestão Empresarial', 'LIVROGESTAOEMPRESARIAL01', 30.00, 15.79, 'UN', 'Novo', 10, '../produto_img/livro_gestao_empresarial.png', 10),
(41, 'Pacote de Consultoria Financeira', 'PACOTECONSULTORIAFINANCEIRA01', 500.00, 263.16, 'UN', 'Novo', 15, '../produto_img/pacote_consultoria_financeira.png', 10),
(42, 'Curso Online de Liderança', 'CURSOONLINELEADERSHIP01', 100.00, 52.63, 'UN', 'Novo', 8, '../produto_img/curso_online_lideranca.png', 10),
(43, 'Serviço de Análise de Mercado', 'SERVICOANALISEMERCADO01', 300.00, 157.89, 'UN', 'Novo', 20, '../produto_img/servico_analise_mercado.png', 10),
(44, 'Palestra sobre Inovação Corporativa', 'PALESTRAINOVACAOCORPORATIVA01', 200.00, 105.26, 'UN', 'Novo', 12, '../produto_img/palestra_inovacao_corporativa.png', 10),
(45, 'Assessoria em Estratégia de Marketing', 'ASSESSORIAESTRATEGIAMARKETING01', 150.00, 78.95, 'UN', 'Novo', 18, '../produto_img/assessoria_estrategia_marketing.png', 10),
(46, 'Workshop de Gestão de Projetos', 'WORKSHOPGESTAOPROJETOS01', 80.00, 42.11, 'UN', 'Novo', 25, '../produto_img/workshop_gestao_projetos.png', 10),
(47, 'Plano de Desenvolvimento de Negócios', 'PLANODESENVOLVIMENTONEGOCIOS01', 250.00, 131.58, 'UN', 'Novo', 22, '../produto_img/plano_desenvolvimento_negocios.png', 10),
(48, 'Treinamento em Atendimento ao Cliente', 'TREINAMENTOATENDIMENTOCLIENTE01', 120.00, 63.16, 'UN', 'Novo', 20, '../produto_img/treinamento_atendimento_cliente.png', 10),
(49, 'Consultoria em Gestão de Recursos Humanos', 'CONSULTORIAGESTAORECURSOSHUMANOS01', 180.00, 94.74, 'UN', 'Novo', 30, '../produto_img/consultoria_gestao_recursos_humanos.png', 10),
(50, 'Pneu Aro 17 Bridgestone', 'PNEUARO17BRIDGESTONE01', 200.00, 105.26, 'UN', 'Novo', 10, '../produto_img/pneu_aro_17_bridgestone.png', 11),
(51, 'Óleo Lubrificante Sintético 5W30', 'OLEOLUBRIFICANTESINTETICO01', 50.00, 26.32, 'L', 'Novo', 15, '../produto_img/oleo_lubrificante_sintetico_5w30.png', 11),
(52, 'Pastilha de Freio Bosch', 'PASTILHAFREIOBOSCH01', 80.00, 42.11, 'JG', 'Novo', 8, '../produto_img/pastilha_freio_bosch.png', 11),
(53, 'Lâmpada Super Branca H4', 'LAMPADASUPERBRANCAH401', 30.00, 15.79, 'UN', 'Novo', 20, '../produto_img/lampada_super_branca_h4.png', 11),
(54, 'Aditivo para Radiador 1L', 'ADITIVORADIADOR01', 20.00, 10.53, 'UN', 'Novo', 12, '../produto_img/aditivo_radiador_1l.png', 11),
(55, 'Filtro de Ar Esportivo K&N', 'FILTROARESPORTIVOKN01', 100.00, 52.63, 'UN', 'Novo', 18, '../produto_img/filtro_ar_esportivo_kn.png', 11),
(56, 'Tapetes Automotivos de Borracha', 'TAPETESAUTOMOTIVOSBORRACHA01', 40.00, 21.05, 'JG', 'Novo', 25, '../produto_img/tapetes_automotivos_borracha.png', 11),
(57, 'Cera Protetora para Pintura', 'CERAPROTETORAPINTURA01', 25.00, 13.16, 'UN', 'Novo', 22, '../produto_img/cera_protetora_pintura.png', 11),
(58, 'Cabos de Vela de Ignição NGK', 'CABOSVELAIGNICAONGK01', 35.00, 18.42, 'JG', 'Novo', 20, '../produto_img/cabos_vela_ignicao_ngk.png', 11),
(59, 'Capa Protetora para Carro', 'CAPAPROTECTORACARRO01', 60.00, 31.58, 'UN', 'Novo', 30, '../produto_img/capa_protetora_carro.png', 11),
(60, 'Vestido Midi Floral', 'VESTIDOMIDIFLORAL01', 50.00, 26.32, 'UN', 'Novo', 10, '../produto_img/vestido_midi_floral.png', 12),
(61, 'Blusa de Manga Longa Listrada', 'BLUSAMANGALONGLISTRADA01', 30.00, 15.79, 'UN', 'Novo', 15, '../produto_img/blusa_manga_longa_listrada.png', 12),
(62, 'Calça Jeans Skinny', 'CALCAJEANSSKINNY01', 40.00, 21.05, 'UN', 'Novo', 8, '../produto_img/calca_jeans_skinny.png', 12),
(63, 'Tênis Casual Branco', 'TENISCASUALBRANCO01', 60.00, 31.58, 'UN', 'Novo', 20, '../produto_img/tenis_casual_branco.png', 12),
(64, 'Bolsa de Couro Crossbody', 'BOLSACOUROCROSSBODY01', 50.00, 26.32, 'UN', 'Novo', 12, '../produto_img/bolsa_couro_crossbody.png', 12),
(65, 'Óculos de Sol Aviador', 'OCULOSOLSOLAVIADOR01', 20.00, 10.53, 'UN', 'Novo', 18, '../produto_img/oculos_sol_aviador.png', 12),
(66, 'Relógio Analógico Dourado', 'RELOGIOANALOGICODOURADO01', 35.00, 18.42, 'UN', 'Novo', 25, '../produto_img/relogio_analogico_dourado.png', 12),
(67, 'Lenço Estampado de Seda', 'LENCOESTAMPADOSILK01', 25.00, 13.16, 'UN', 'Novo', 22, '../produto_img/lenco_estampado_seda.png', 12),
(68, 'Brinco Ear Cuff Prateado', 'BRINCOEARCUFFPRATEADO01', 15.00, 7.89, 'PAR', 'Novo', 20, '../produto_img/brinco_ear_cuff_prateado.png', 12),
(69, 'Colar de Pérolas Naturais', 'COLARPEROLASNATURAIS01', 30.00, 15.79, 'UN', 'Novo', 30, '../produto_img/colar_perolas_naturais.png', 12),
(70, 'Notebook Ultrabook Dell XPS 13', 'DELLXPS13', 1500.00, 789.47, 'UN', 'Novo', 10, '../produto_img/notebook_ultrabook_dell_xps_13.png', 13),
(71, 'Smartphone Apple iPhone 13 Pro', 'IPHONE13PRO', 1200.00, 631.58, 'UN', 'Novo', 15, '../produto_img/smartphone_apple_iphone_13_pro.png', 13),
(72, 'Tablet Samsung Galaxy Tab S7', 'GALAXYTAB7', 800.00, 421.05, 'UN', 'Novo', 8, '../produto_img/tablet_samsung_galaxy_tab_s7.png', 13),
(73, 'Smartwatch Garmin Fenix 6', 'GARMINFENIX6', 600.00, 315.79, 'UN', 'Novo', 20, '../produto_img/smartwatch_garmin_fenix_6.png', 13),
(74, 'Monitor Ultrawide LG 34\"', 'LGULTRAWIDE34', 700.00, 368.42, 'UN', 'Novo', 12, '../produto_img/monitor_ultrawide_lg_34.png', 13),
(75, 'Caixa de Som Bluetooth JBL Charge 5', 'JBLCHARGE5', 200.00, 105.26, 'UN', 'Novo', 18, '../produto_img/caixa_som_bluetooth_jbl_charge_5.png', 13),
(76, 'Teclado Mecânico Corsair K95 RGB', 'CORSAIRK95RGB', 250.00, 131.58, 'UN', 'Novo', 25, '../produto_img/teclado_mecanico_corsair_k95_rgb.png', 13),
(77, 'Mouse Gamer Logitech G502', 'LOGITECHG502', 80.00, 42.11, 'UN', 'Novo', 22, '../produto_img/mouse_gamer_logitech_g502.png', 13),
(78, 'Headset HyperX Cloud II', 'HYPERXCLOUDII', 100.00, 52.63, 'UN', 'Novo', 20, '../produto_img/headset_hyperx_cloud_ii.png', 13),
(79, 'Cadeira Gamer DXRacer', 'DXRACER', 300.00, 157.89, 'UN', 'Novo', 30, '../produto_img/cadeira_gamer_dxracer.png', 13),
(80, 'Bolo de Chocolate Caseiro', 'BOLOCHOCOLATECASEIRO01', 20.00, 10.53, 'UN', 'Novo', 10, '../produto_img/bolo_chocolate_caseiro.png', 14),
(81, 'Torta de Limão com Merengue', 'TORTALIMAO01', 25.00, 13.16, 'UN', 'Novo', 15, '../produto_img/torta_limao_merengue.png', 14),
(82, 'Pão de Queijo Mineiro', 'PAOQUEIJOMINEIRO01', 15.00, 7.89, 'KG', 'Novo', 8, '../produto_img/pao_queijo_mineiro.png', 14),
(83, 'Doce de Abóbora com Coco', 'DOCEABOBORACOCO01', 10.00, 5.26, 'UN', 'Novo', 20, '../produto_img/doce_abobora_coco.png', 14),
(84, 'Pudim de Leite Condensado', 'PUDIMLEITECONDENSADO01', 18.00, 9.47, 'UN', 'Novo', 12, '../produto_img/pudim_leite_condensado.png', 14),
(85, 'Brigadeiro Gourmet', 'BRIGADEIROGOURMET01', 1.50, 0.79, 'UN', 'Novo', 18, '../produto_img/brigadeiro_gourmet.png', 14),
(86, 'Biscoito de Polvilho', 'BISCOITOPOLVILHO01', 5.00, 2.63, 'KG', 'Novo', 25, '../produto_img/biscoito_polvilho.png', 14),
(87, 'Coxinha de Frango', 'COXINHAFRANGO01', 3.00, 1.58, 'UN', 'Novo', 22, '../produto_img/coxinha_frango.png', 14),
(88, 'Empadão de Palmito', 'EMPADAOPALMITO01', 30.00, 15.79, 'UN', 'Novo', 20, '../produto_img/empadao_palmito.png', 14),
(89, 'Torta de Morango', 'TORTAMORANGO01', 28.00, 14.74, 'UN', 'Novo', 30, '../produto_img/torta_morango.png', 14),
(90, 'Memória RAM DDR4 16GB', 'MEMORIARAMDDR416GB01', 100.00, 52.63, 'UN', 'Novo', 10, '../produto_img/memoria_ram_ddr4_16gb.png', 15),
(91, 'SSD 1TB SATA III', 'SSD1TBSATAIII01', 150.00, 78.95, 'UN', 'Novo', 18, '../produto_img/ssd_1tb_sata_iii.png', 15),
(92, 'Placa de Vídeo Nvidia Quadro P5000', 'QUADROP5000', 800.00, 421.05, 'UN', 'Novo', 8, '../produto_img/placa_video_nvidia_quadro_p5000.png', 15),
(93, 'Processador Intel Xeon E5-2690v4', 'XEONE52690V4', 600.00, 315.79, 'UN', 'Novo', 20, '../produto_img/processador_intel_xeon_e5_2690v4.png', 15),
(94, 'Fonte de Alimentação 750W', 'FONTEALIMENTACAO750W01', 120.00, 63.16, 'UN', 'Novo', 12, '../produto_img/fonte_alimentacao_750w.png', 15),
(95, 'Placa Mãe para Servidor Supermicro', 'PLACAMAESUPERMICRO01', 300.00, 157.89, 'UN', 'Novo', 18, '../produto_img/placa_mae_servidor_supermicro.png', 15),
(96, 'Cooler para Processador Cooler Master', 'COOLERPROCESSADORCOOLERMASTER01', 50.00, 26.32, 'UN', 'Novo', 25, '../produto_img/cooler_processador_cooler_master.png', 15),
(97, 'Gabinete Rack 4U', 'GABINETE4U01', 200.00, 105.26, 'UN', 'Novo', 22, '../produto_img/gabinete_rack_4u.png', 15),
(98, 'Switch Gerenciável 24 Portas Gigabit', 'SWITCHGERENCIABLE24PORTASGIGABIT01', 400.00, 210.53, 'UN', 'Novo', 20, '../produto_img/switch_gerenciavel_24_portas_gigabit.png', 15),
(99, 'Cabo de Fibra Óptica Multimodo 10m', 'CABOFIBRAOPTICAMULTIMODO10M01', 30.00, 15.79, 'UN', 'Novo', 30, '../produto_img/cabo_fibra_optica_multimodo_10m.png', 15),
(100, 'Servidor Dell PowerEdge T340', 'POWEREDGET340', 1500.00, 789.47, 'UN', 'Novo', 10, '../produto_img/servidor_dell_poweredge_t340.png', 15),
(101, 'HD SAS 2TB 7200RPM', 'HDSAS2TB7200RPM01', 200.00, 105.26, 'UN', 'Novo', 15, '../produto_img/hd_sas_2tb_7200rpm.png', 15),
(102, 'Placa de Rede Gigabit Ethernet', 'PLACAREDEGIGABIT01', 80.00, 42.11, 'UN', 'Novo', 8, '../produto_img/placa_rede_gigabit_ethernet.png', 15),
(103, 'Memória RAM DDR4 ECC 32GB', 'MEMORIARAMDDR4ECC32GB01', 250.00, 131.58, 'UN', 'Novo', 20, '../produto_img/memoria_ram_ddr4_ecc_32gb.png', 15),
(104, 'Controladora RAID SAS/SATA', 'CONTROLADORARAIDSAS01', 300.00, 157.89, 'UN', 'Novo', 12, '../produto_img/controladora_raid_sas_sata.png', 15),
(105, 'Fonte Redundante para Servidor', 'FONTEREDUNDANTESERVIDOR01', 400.00, 210.53, 'UN', 'Novo', 18, '../produto_img/fonte_redundante_servidor.png', 15),
(106, 'Kit de Trilhos para Rack', 'KITTRILHOSPARARACK01', 50.00, 26.32, 'UN', 'Novo', 25, '../produto_img/kit_trilhos_para_rack.png', 15),
(107, 'Cabo de Fibra Óptica Monomodo 5m', 'CABOFIBRAOPTICAMONOMODO5M01', 20.00, 10.53, 'UN', 'Novo', 22, '../produto_img/cabo_fibra_optica_monomodo_5m.png', 15),
(108, 'Switch KVM 16 Portas', 'SWITCHKVM16PORTAS01', 600.00, 315.79, 'UN', 'Novo', 24, '../produto_img/switch_kvm_16_portas.png', 15),
(109, 'Case para Servidor 2U', 'CASEPARASERVIDOR2U01', 150.00, 78.95, 'UN', 'Novo', 30, '../produto_img/case_para_servidor_2u.png', 15),
(111, 'MODULO COOLER DELL R740', 'MODULOCOOLERDELLR740', 9000.00, 4736.84, 'UN', 'Usado', 1, '../produto_img/produto_665286fb813e5_servidor-dell-r740-poweredge-data-center-001-lpsdsw.webp', 15);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabela_cliente_fornecedor`
--

CREATE TABLE `tabela_cliente_fornecedor` (
  `Nome` varchar(255) DEFAULT NULL,
  `CPF/CNPJ` varchar(20) DEFAULT NULL,
  `Cidade` varchar(100) DEFAULT NULL,
  `Telefone` varchar(20) DEFAULT NULL,
  `Tipo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tabela_cliente_fornecedor`
--

INSERT INTO `tabela_cliente_fornecedor` (`Nome`, `CPF/CNPJ`, `Cidade`, `Telefone`, `Tipo`) VALUES
('TechWave Solutions', '65432178000190', 'Tecnópolis', '11 1122-3344', 'cliente'),
('Bright Future Tech', '65432178000280', 'InfoVille', '11 2233-4455', 'cliente'),
('Digital Horizon Corp', '65432178000370', 'CompTown', '11 3344-5566', 'cliente'),
('TechNova Solutions', '65432178000460', 'NetCity', '11 4455-6677', 'cliente'),
('Innovative Systems Ltd', '65432178000550', 'FonteVille', '11 5566-7788', 'cliente'),
('SupplierTech Inc', '76432178000190', 'TechCity', '21 6677-8899', 'fornecedor'),
('Hardware Supply Co.', '76432178000280', 'InfoVille', '21 7788-9900', 'fornecedor'),
('CyberParts Ltda', '76432178000370', 'CompTown', '41 8899-0011', 'fornecedor'),
('NextGen Suppliers', '76432178000460', 'NetCity', '21 9900-1122', 'fornecedor'),
('FutureTech Distributors', '76432178000550', 'FonteVille', '51 0011-2233', 'fornecedor'),
('Laura Menezes', '123.456.789-00', 'Floripa', '12 3456-7890', 'cliente'),
('Carlos Eduardo', '234.567.890-11', 'Porto Alegre', '51 2233-4455', 'cliente'),
('Mariana Rocha', '345.678.901-22', 'São Paulo', '11 3344-5566', 'cliente'),
('Felipe Pereira', '456.789.012-33', 'Curitiba', '41 4455-6677', 'cliente'),
('Juliana Carvalho', '567.890.123-44', 'São Paulo', '11 5566-7788', 'cliente'),
('Ricardo Monteiro', '678.901.234-55', 'Rio de Janeiro', '21 6677-8899', 'fornecedor'),
('Fernanda Alves', '789.012.345-66', 'Rio de Janeiro', '21 7788-9900', 'fornecedor'),
('Gabriel Dias', '890.123.456-77', 'Curitiba', '41 8899-0011', 'fornecedor'),
('Isabela Fernandes', '901.234.567-88', 'Rio de Janeiro', '21 9900-1122', 'fornecedor'),
('José Martins', '012.345.678-99', 'Porto Alegre', '51 0011-2233', 'fornecedor');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `num_ped` int(11) NOT NULL,
  `cliente` varchar(255) NOT NULL,
  `vendedor` varchar(255) NOT NULL,
  `cond_pagamento` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `data_venda` date NOT NULL,
  `data_saida` date NOT NULL,
  `data_prevista` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `num_itens` int(11) NOT NULL,
  `soma_quantidades` int(11) NOT NULL,
  `desconto_total_itens` decimal(10,2) NOT NULL,
  `total_itens` decimal(10,2) NOT NULL,
  `desconto_total_venda` decimal(10,2) NOT NULL,
  `total_venda` decimal(10,2) NOT NULL,
  `lancado_estoque` tinyint(1) DEFAULT 0,
  `frete_por_conta` varchar(255) DEFAULT NULL,
  `largura` decimal(10,2) DEFAULT NULL,
  `comprimento` decimal(10,2) DEFAULT NULL,
  `altura` decimal(10,2) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `prazo_entrega` date DEFAULT NULL,
  `valor_frete` decimal(10,2) DEFAULT NULL,
  `status_aprovacao` enum('Pendente','Aprovado','Reprovado') DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id`, `num_ped`, `cliente`, `vendedor`, `cond_pagamento`, `categoria`, `data_venda`, `data_saida`, `data_prevista`, `id_usuario`, `num_itens`, `soma_quantidades`, `desconto_total_itens`, `total_itens`, `desconto_total_venda`, `total_venda`, `lancado_estoque`, `frete_por_conta`, `largura`, `comprimento`, `altura`, `peso`, `prazo_entrega`, `valor_frete`, `status_aprovacao`) VALUES
(4, 4, '65432178000280', 'Marcos', 'Pix', 'A vista', '2024-05-25', '0000-00-00', '0000-00-00', 15, 2, 3, 130.00, 1270.00, 130.00, 1270.00, 0, 'Cliente', 8.00, 16.00, 12.00, 0.50, '2024-05-31', 0.00, 'Pendente'),
(5, 5, 'TechWave Solutions', 'Marcos', 'Pix', 'A vista', '2024-05-25', '0000-00-00', '0000-00-00', 15, 2, 3, 70.00, 630.00, 70.00, 630.00, 0, 'Cliente', 8.00, 16.00, 12.00, 0.50, '0000-00-00', 0.00, 'Pendente'),
(8, 0, 'TechWave Solutions', 'Marcos Henrique', '', '', '2024-05-26', '0000-00-00', '0000-00-00', 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pendente'),
(9, 0, 'TechWave Solutions', 'Marcos Henrique', '', '', '2024-05-26', '0000-00-00', '0000-00-00', 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pendente'),
(10, 10, 'TechWave Solutions', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 5, 50.00, 500.00, 50.00, 450.00, 0, 'Cliente', 8.00, 16.00, 12.00, 0.50, '2024-06-02', 0.00, 'Pendente'),
(11, 11, 'Bright Future Tech', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 4, 40.00, 400.00, 40.00, 360.00, 0, 'Cliente', 10.00, 20.00, 15.00, 0.60, '2024-06-02', 0.00, 'Pendente'),
(12, 12, 'Digital Horizon Corp', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 6, 60.00, 600.00, 60.00, 540.00, 0, 'Cliente', 12.00, 24.00, 18.00, 0.70, '2024-06-02', 0.00, 'Pendente'),
(13, 13, 'TechNova Solutions', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 3, 30.00, 300.00, 30.00, 270.00, 0, 'Cliente', 6.00, 12.00, 9.00, 0.40, '2024-06-02', 0.00, 'Pendente'),
(14, 14, 'Innovative Systems Ltd', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 7, 70.00, 700.00, 70.00, 630.00, 0, 'Cliente', 14.00, 28.00, 21.00, 0.80, '2024-06-02', 0.00, 'Pendente'),
(15, 15, 'Laura Menezes', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 8, 80.00, 800.00, 80.00, 720.00, 0, 'Cliente', 16.00, 32.00, 24.00, 0.90, '2024-06-02', 0.00, 'Pendente'),
(16, 16, 'Carlos Eduardo', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 5, 50.00, 500.00, 50.00, 450.00, 0, 'Cliente', 8.00, 16.00, 12.00, 0.50, '2024-06-02', 0.00, 'Pendente'),
(17, 17, 'Mariana Rocha', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 9, 90.00, 900.00, 90.00, 810.00, 0, 'Cliente', 18.00, 36.00, 27.00, 1.00, '2024-06-02', 0.00, 'Pendente'),
(18, 18, 'Felipe Pereira', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 6, 60.00, 600.00, 60.00, 540.00, 0, 'Cliente', 12.00, 24.00, 18.00, 0.70, '2024-06-02', 0.00, 'Pendente'),
(19, 19, 'Juliana Carvalho', 'Marcos', 'Pix', 'A vista', '2024-05-26', '2024-05-26', '2024-06-02', 15, 2, 7, 70.00, 700.00, 70.00, 630.00, 0, 'Cliente', 14.00, 28.00, 21.00, 0.80, '2024-06-02', 0.00, 'Pendente');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historico_del_compra`
--
ALTER TABLE `historico_del_compra`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historico_del_itens_compra`
--
ALTER TABLE `historico_del_itens_compra`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historico_del_itens_venda`
--
ALTER TABLE `historico_del_itens_venda`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historico_del_venda`
--
ALTER TABLE `historico_del_venda`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historico_produtos`
--
ALTER TABLE `historico_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `itens_compra`
--
ALTER TABLE `itens_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compra_id` (`compra_id`);

--
-- Índices de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venda_id` (`venda_id`);

--
-- Índices de tabela `pessoa_fisica`
--
ALTER TABLE `pessoa_fisica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices de tabela `pessoa_juridica`
--
ALTER TABLE `pessoa_juridica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `historico_del_compra`
--
ALTER TABLE `historico_del_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `historico_del_itens_compra`
--
ALTER TABLE `historico_del_itens_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `historico_del_itens_venda`
--
ALTER TABLE `historico_del_itens_venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `historico_del_venda`
--
ALTER TABLE `historico_del_venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `historico_produtos`
--
ALTER TABLE `historico_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens_compra`
--
ALTER TABLE `itens_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `pessoa_fisica`
--
ALTER TABLE `pessoa_fisica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `pessoa_juridica`
--
ALTER TABLE `pessoa_juridica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `itens_compra`
--
ALTER TABLE `itens_compra`
  ADD CONSTRAINT `itens_compra_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`);

--
-- Restrições para tabelas `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD CONSTRAINT `itens_venda_ibfk_1` FOREIGN KEY (`venda_id`) REFERENCES `vendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `pessoa_fisica`
--
ALTER TABLE `pessoa_fisica`
  ADD CONSTRAINT `pessoa_fisica_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);

--
-- Restrições para tabelas `pessoa_juridica`
--
ALTER TABLE `pessoa_juridica`
  ADD CONSTRAINT `pessoa_juridica_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
