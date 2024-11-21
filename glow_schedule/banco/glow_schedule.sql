-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Nov-2024 às 19:24
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `glow_schedule`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendente`
--

CREATE TABLE `atendente` (
  `cpf_atendente` varchar(14) NOT NULL,
  `nome_atendente` varchar(100) NOT NULL,
  `foto_atendente` varchar(255) DEFAULT NULL,
  `telefone_atendente` varchar(15) NOT NULL,
  `email_atendente` varchar(50) NOT NULL,
  `senha_atendente` varchar(100) NOT NULL,
  `token_atendente` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `atendente`
--

INSERT INTO `atendente` (`cpf_atendente`, `nome_atendente`, `foto_atendente`, `telefone_atendente`, `email_atendente`, `senha_atendente`, `token_atendente`) VALUES
('123.213.212-66', 'Rogers Principal', 'uploads/atendenr.jfif', '(66) 66666-6622', 'rogers@gmail.com', '$2y$10$UXLiXc/NTKQ/ZC.zIRymue6LheiWZaCKLOJuAXqeUSuOq/T7VLH5O', '768fb20e4f35b47bf86d59a4acaaeb9376015472b1112416c494e4059d4e11579a2f45dfcf48e7f7ab686c80d7f5bde4aa43'),
('999.909.998-99', 'Antonia Carlos', 'uploads/atendendente.jfif', '(99) 99989-9089', 'antonia@gmail.com', '$2y$10$8mi6sMF4ulNEyBZN6r2GoeOL9w...obATjwFfvwDjykGiZE1HLQlW', 'ba26db2ee81d5f4c15a758f73ccc1ac48c1c7bd61c31c259ee2aef3b3acaa4806948e85d96068fb4f05cb59210eb8bcc4e8f');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id_avaliacao` int(11) NOT NULL,
  `estrelas_avaliacao` int(11) NOT NULL CHECK (`estrelas_avaliacao` between 1 and 5),
  `comentario_avaliacao` text DEFAULT NULL,
  `data_criacao_avaliacao` date NOT NULL,
  `cpf_cliente` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `cpf_cliente` varchar(14) NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `foto_cliente` varchar(255) DEFAULT NULL,
  `telefone_cliente` varchar(15) NOT NULL,
  `email_cliente` varchar(50) NOT NULL,
  `senha_cliente` varchar(100) NOT NULL,
  `token_cliente` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`cpf_cliente`, `nome_cliente`, `foto_cliente`, `telefone_cliente`, `email_cliente`, `senha_cliente`, `token_cliente`) VALUES
('123.123.122-22', 'cliente', 'uploads/PAPEL_LABORATÓRIOS.png', '(11) 91982-3912', 'cliente@gmail.com', '$2y$10$OMUPHh2eSGZJLglIcFUDKeKgQAIvIIVyoGkT8JsdjiC', 'aada8f2485e1a8157f7b2a1b775d7a48a6b68814fbdebd1b6afb704bda753323ab237e6131e9a77b8171219db53170691f46'),
('519.127.728-76', 'João Mota', 'uploads/atendendente.jfif', '(11) 93346-5766', 'mota@gmail.com', '$2y$10$s0L13Xwb2nD6k3FiyEl83ew9G6ul8ppdvnJw3n//8OZIc1GWTeiy6', '8a2b657275cf65c85e5263f249ca70f463eff4a01b341643bb2b93c241993cc41063fc7ed70804d47056402ca5d25b4e0497'),
('999.555.599-99', 'nino', 'uploads/WhatsApp Image 2024-06-19 at 21.39.52.jpeg', '(99) 95555-9999', 'ni@gmail.com', '$2y$10$8vUBCGTMDHOLc4cL3kxSDOYcgQQnoqMIWircHv88nBgsTi7fp6ze6', '95f4cde50e73b8623266b0627f80dcc622389c2214e270ab8228b17e95dc44bc0392d8924d0cbe8b66876499726ef55d7e0e');

-- --------------------------------------------------------

--
-- Estrutura da tabela `consulta`
--

CREATE TABLE `consulta` (
  `id_consulta` int(11) NOT NULL,
  `data_consulta` date NOT NULL,
  `hora_consulta` time NOT NULL,
  `cpf_esteticista` varchar(14) NOT NULL,
  `id_procedimento` int(11) NOT NULL,
  `cpf_cliente` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `esteticista`
--

CREATE TABLE `esteticista` (
  `cpf_esteticista` varchar(14) NOT NULL,
  `nome_esteticista` varchar(100) NOT NULL,
  `foto_esteticista` varchar(255) DEFAULT NULL,
  `apelido_esteticista` varchar(50) DEFAULT NULL,
  `telefone_esteticista` varchar(15) NOT NULL,
  `formacao_esteticista` varchar(200) NOT NULL,
  `descricao_p_esteticista` varchar(80) DEFAULT NULL,
  `descricao_g_esteticista` varchar(300) DEFAULT NULL,
  `instagram_esteticista` varchar(50) DEFAULT NULL,
  `facebook_esteticista` varchar(50) DEFAULT NULL,
  `linkedin_esteticista` varchar(50) DEFAULT NULL,
  `email_esteticista` varchar(50) NOT NULL,
  `senha_esteticista` varchar(100) NOT NULL,
  `token_esteticista` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `esteticista`
--

INSERT INTO `esteticista` (`cpf_esteticista`, `nome_esteticista`, `foto_esteticista`, `apelido_esteticista`, `telefone_esteticista`, `formacao_esteticista`, `descricao_p_esteticista`, `descricao_g_esteticista`, `instagram_esteticista`, `facebook_esteticista`, `linkedin_esteticista`, `email_esteticista`, `senha_esteticista`, `token_esteticista`) VALUES
('123.456.789-01', 'Henrique Santos', 'uploads/Doutor 1.jpg', 'Dr. Henrique', '(11) 91234-5678', 'Medicina Estética na Mackenzie.', 'Atua na estética há 7 anos. Especialista em procedimentos faciais.', 'Médico estético com 7 anos de experiência, Dr. Henrique oferece uma abordagem individualizada em cada procedimento. Ele utiliza as mais avançadas técnicas para garantir resultados naturais e a satisfação plena de seus pacientes. Seu foco é a saúde e a beleza da pele.', '@drhenriquesantos', 'facebook.com/drhenriquesantos', 'linkedin.com/in/drhenriquesantos', 'silva.costa@email.com', '$2y$10$SXBUebjerF/Fpg840CsTsugGi/i1TPlKhduCTV4Rli9//xpEYBaPK', '2e80f41c6f12670c931fdb56112c6742722c2774fd7916d068a0b9603ed0069a9ca918d4af958588cf714e5a39a1e5360ae5'),
('321.654.987-03', 'Laura Pereira', 'uploads/Doutora 3.jpg', 'Dermatologista Laura', '(11) 99876-5432', 'Dermatologia no Arquenia.', 'Atua na estética há 12 anos. Especialista em limpeza de pele.', 'A Dra. Laura é uma dermatologista com 12 anos de experiência na área. Focada em cuidados faciais, ela utiliza tecnologias modernas para oferecer tratamentos eficazes que resultam em uma pele mais saudável e radiante. Cada paciente recebe um plano personalizado.', '@dermatologistalaura', 'facebook.com/dermatologistalaura', 'linkedin.com/in/dermatologistalaura', 'laura.pereira@email.com', '$2y$10$LWdwGNBr5V9uTbbjdiENbORqcgQwdTOmyKNkEUZCIdZ4DZPW/0DJW', '2582c1a741f5caa2f29b1885d49cb287e86c7949538fac7db6973c1142e87deaa76590efafb9bab33d0e3f4eef05c935f580'),
('456.789.123-06', 'Paulo Silva', 'uploads/Doutor 6.jpg', 'Esteticista Paulo', '(11) 97812-3456', 'Estética', 'Atua na estética há 6 anos. Especialista em limpeza de pele.', 'Paulo se destaca em limpeza de pele e tratamentos faciais, com 6 anos de experiência. Ele oferece um atendimento personalizado, utilizando produtos de alta qualidade para garantir resultados que superam as expectativas de seus pacientes.', '@esteticistapaulo', 'facebook.com/dermatologistajane', 'linkedin.com/in/dermatologistajane', 'jane.martins@email.com', '$2y$10$yNE7ulSCBwMuxy7XR9GQ9uQG8QTzi3VkGB7oBe0fCQacq94x2IWPC', '528e93f2c46c805ff0fc7a725ec35cd9f0f1032155f142101d397a8efa45761c02bf3bb7f721a54936c2e165666da146272f'),
('654.321.987-04', 'Maria Souza', 'uploads/Doutora 4.jpg', 'Massagista Maria', '(11) 93456-7890', 'Massoterapia quântica na UFRJ.', 'Atua na estética há 8 anos. Especialista em massagem corporal.', 'Maria, com 8 anos de experiência, é uma massagista dedicada ao bem-estar e relaxamento. Suas técnicas de massoterapia são adaptadas às necessidades individuais de cada cliente, promovendo alívio do estresse e uma sensação de renovação em cada sessão.', '@massagistamaria', 'facebook.com/massagistamaria', 'linkedin.com/in/massagistamaria', 'maria.souza@email.com', '$2y$10$.Cofh9AiCiP5ADCJlUSEMOguHM.Y2/5HJab1slzqjpYlgLpi4QAAS', '5e2f78b8a24a2b8dfe0c2337c1574cf1ddc9ea2fe825c3a6dd6f80fa2574b9cefc2fc000d529e9fc220042825222007a6b2d'),
('741.852.963-08', 'Rafael Lima', 'uploads/Doutor 8.jpg', 'Dr. Rafael', '(11) 96712-3456', 'Medicina Estética', 'Atua na estética há 10 anos. Especialista em bioestimuladores.', 'O Dr. Rafael, com 10 anos de atuação, se destaca no uso de bioestimuladores para tratamentos estéticos. Ele prioriza a saúde e a beleza da pele, sempre atento às necessidades individuais de cada paciente e buscando resultados excepcionais.', '@drrafaellima', 'facebook.com/drrafaellima', 'linkedin.com/in/drrafaellima', 'rafael.lima@email.com', '$2y$10$rQyHyxxLeKsj237x8yLNKe.sotid5gyhdw/LAdIiajm9WB2sRZZ86', '19083ada18b7d4c100b7aefe2b441db07514330ce5277dd56f4cba47d47e494201740fee3119189720688913a466f1767f70'),
('789.123.456-05', 'Nádia Oliveira', 'uploads/Doutora 5.jpg', 'Esteticista Nádia', '(11) 96543-2109', 'Estética', 'Experiente em radiofrequência e preenchimentos. Habilitada em pele negra.', 'A Esteticista Nádia é especialista em radiofrequência e tratamentos personalizados, especialmente para pele negra. Com uma abordagem única e técnica apurada, ela busca resultados visíveis, promovendo saúde e beleza para seus pacientes.', '@esteticistanadia', 'facebook.com/esteticistanadia', 'linkedin.com/in/esteticistanadia', 'nadia.oliveira@email.com', '$2y$10$zmeIG/aAZSO4DM56mABYzewTToX0FO.uwbk/unSVfssM8rqYjrbWi', '43a2cce2d679c9a12070bd430080067daf7d7b190bea5fa88d1bff82fc7f20bd91d11c2754548672ddff460b8723666b248d'),
('963.852.741-07', 'Jane Martins', 'uploads/Doutora 7.jpg', 'Dermatologista Jane', '(11) 98712-3456', 'Dermatologia', 'Atua na estética há 12 anos. Especialista em peeling químico.', 'A Dra. Jane é uma dermatologista com 12 anos de experiência em rejuvenescimento facial. Ela utiliza peeling químico e técnicas avançadas para tratar e melhorar a saúde da pele, sempre buscando resultados que realçam a beleza natural de cada paciente.', '@dermatologistajane', 'facebook.com/dermatologistajane', 'linkedin.com/in/dermatologistajane', 'jane.martins@email.com', '$2y$10$d47HLMJ6.3/wRPVoYbmhfurntCuqTkqes7hY1G22RyrfBOOAN.d9.', '2274ed1d3d86961a0a916f25c464fdcfcfdf424ae6e7908e484079904ad00487f21160dd185d2d392c572754ce3821851684'),
('987.654.321-02', 'Silva Costa', 'uploads/Doutora 2.jpg', 'Dr. Silva', '(11) 98765-4321', 'Medicina Estética na USP.', 'Atua na estética há 11 anos. Experiência em procedimentos labiais.', 'Com 11 anos de experiência em medicina estética, Dr. Silva é um especialista em procedimentos labiais. Ele se dedica a ajudar seus pacientes a alcançarem o sorriso perfeito, utilizando técnicas inovadoras e personalizadas, focando na beleza natural.', '@drsilvacosta', 'facebook.com/drsilvacosta', 'linkedin.com/in/drsilvacosta', 'silva.costa@email.com', '$2y$10$Ek64sFrjZfFeFCr/5XDfmepn5PjavZyd3tMFl7hayhjg5y6a9y8X2', '431d648f58150cd6cf8b25f12f68b4af29a27cd4c39a1a73e92df5cc3ab3eef33f800c5e3c2c049e0490c9106606cc244836');

-- --------------------------------------------------------

--
-- Estrutura da tabela `esteticista_procedimento`
--

CREATE TABLE `esteticista_procedimento` (
  `id` int(11) NOT NULL,
  `cpf_esteticista` varchar(14) DEFAULT NULL,
  `id_procedimento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `esteticista_procedimento`
--

INSERT INTO `esteticista_procedimento` (`id`, `cpf_esteticista`, `id_procedimento`) VALUES
(1, '123.456.789-01', 1),
(2, '123.456.789-01', 4),
(3, '987.654.321-02', 1),
(4, '987.654.321-02', 4),
(5, '321.654.987-03', 2),
(6, '321.654.987-03', 5),
(7, '321.654.987-03', 8),
(8, '654.321.987-04', 7),
(9, '789.123.456-05', 3),
(10, '789.123.456-05', 4),
(11, '789.123.456-05', 5),
(12, '789.123.456-05', 8),
(13, '456.789.123-06', 4),
(14, '456.789.123-06', 5),
(15, '456.789.123-06', 8),
(16, '963.852.741-07', 6),
(17, '963.852.741-07', 8),
(18, '741.852.963-08', 3),
(19, '741.852.963-08', 4),
(20, '741.852.963-08', 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `procedimento`
--

CREATE TABLE `procedimento` (
  `id_procedimento` int(11) NOT NULL,
  `nome_procedimento` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `procedimento`
--

INSERT INTO `procedimento` (`id_procedimento`, `nome_procedimento`) VALUES
(1, 'Botox'),
(2, 'Hidratação'),
(3, 'Radiofrequência'),
(4, 'Redução de rugas'),
(5, 'Limpeza de Pele'),
(6, 'Peeling químico'),
(7, 'Massagem corporal'),
(8, 'Bio-estimulador de colágeno');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prontuario`
--

CREATE TABLE `prontuario` (
  `id_prontuario` int(11) NOT NULL,
  `cpf_cliente` varchar(14) NOT NULL,
  `cor_pele` varchar(50) NOT NULL,
  `tipo_pele` varchar(50) NOT NULL,
  `observacoes_cliente` varchar(300) NOT NULL,
  `alergias` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `prontuario`
--

INSERT INTO `prontuario` (`id_prontuario`, `cpf_cliente`, `cor_pele`, `tipo_pele`, `observacoes_cliente`, `alergias`) VALUES
(1, '111.111.111-20', 'Branco', 'Mista', 'Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha Eu amo Pamonha ', ''),
(11, '999.555.599-99', 'Amarelo', 'Mista', 'eww', 'teerqw'),
(12, '999.555.599-99', 'Amarelo', 'Mista', 'eww', 'teerqw');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `atendente`
--
ALTER TABLE `atendente`
  ADD PRIMARY KEY (`cpf_atendente`),
  ADD UNIQUE KEY `token_atendente` (`token_atendente`);

--
-- Índices para tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id_avaliacao`),
  ADD KEY `fk_cliente_avaliacao` (`cpf_cliente`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cpf_cliente`),
  ADD UNIQUE KEY `token_cliente` (`token_cliente`);

--
-- Índices para tabela `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id_consulta`),
  ADD KEY `cpf_esteticista` (`cpf_esteticista`),
  ADD KEY `id_procedimento` (`id_procedimento`),
  ADD KEY `cpf_cliente` (`cpf_cliente`);

--
-- Índices para tabela `esteticista`
--
ALTER TABLE `esteticista`
  ADD PRIMARY KEY (`cpf_esteticista`),
  ADD UNIQUE KEY `token_esteticista` (`token_esteticista`);

--
-- Índices para tabela `esteticista_procedimento`
--
ALTER TABLE `esteticista_procedimento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cpf_esteticista` (`cpf_esteticista`),
  ADD KEY `id_procedimento` (`id_procedimento`);

--
-- Índices para tabela `procedimento`
--
ALTER TABLE `procedimento`
  ADD PRIMARY KEY (`id_procedimento`);

--
-- Índices para tabela `prontuario`
--
ALTER TABLE `prontuario`
  ADD PRIMARY KEY (`id_prontuario`),
  ADD KEY `cpf_cliente` (`cpf_cliente`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `esteticista_procedimento`
--
ALTER TABLE `esteticista_procedimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `procedimento`
--
ALTER TABLE `procedimento`
  MODIFY `id_procedimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `prontuario`
--
ALTER TABLE `prontuario`
  MODIFY `id_prontuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `fk_cliente_avaliacao` FOREIGN KEY (`cpf_cliente`) REFERENCES `cliente` (`cpf_cliente`);

--
-- Limitadores para a tabela `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`cpf_esteticista`) REFERENCES `esteticista` (`cpf_esteticista`),
  ADD CONSTRAINT `consulta_ibfk_2` FOREIGN KEY (`id_procedimento`) REFERENCES `procedimento` (`id_procedimento`),
  ADD CONSTRAINT `consulta_ibfk_3` FOREIGN KEY (`cpf_cliente`) REFERENCES `cliente` (`cpf_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
