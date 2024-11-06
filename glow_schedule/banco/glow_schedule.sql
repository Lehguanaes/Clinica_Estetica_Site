-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/11/2024 às 17:21
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
-- Banco de dados: `glow_schedule`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `atendente`
--

CREATE TABLE `atendente` (
  `cpf_atendente` varchar(14) NOT NULL,
  `nome_atendente` varchar(100) NOT NULL,
  `foto_atendente` varchar(255) DEFAULT NULL,
  `telefone_atendente` varchar(15) NOT NULL,
  `email_atendente` varchar(50) NOT NULL,
  `senha_atendente` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `atendente`
--

INSERT INTO `atendente` (`cpf_atendente`, `nome_atendente`, `foto_atendente`, `telefone_atendente`, `email_atendente`, `senha_atendente`) VALUES
('111.111.111-10', 'Paulo nigers', 'uploads/Laura_Pereira.jpg', '(11) 11111-1111', 'maria@gmail', '12'),
('111.111.111-12', 'Leticia Guanaes', 'uploads/Maria_Souza.jpg', '(11) 11111-1111', 'maria@gmail', '101010');

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id_avaliacao` int(11) NOT NULL,
  `estrelas_avaliacao` int(11) NOT NULL CHECK (`estrelas_avaliacao` between 1 and 5),
  `comentario_avaliacao` text DEFAULT NULL,
  `data_criacao_avaliacao` date NOT NULL,
  `cpf_cliente` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `cpf_cliente` varchar(14) NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `foto_cliente` varchar(255) DEFAULT NULL,
  `telefone_cliente` varchar(15) NOT NULL,
  `email_cliente` varchar(50) NOT NULL,
  `senha_cliente` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`cpf_cliente`, `nome_cliente`, `foto_cliente`, `telefone_cliente`, `email_cliente`, `senha_cliente`) VALUES
('111.111.111-20', 'Letícia Guanaes', 'uploads/Laura_Pereira.jpg', '(11) 11111-1111', 'Leticia@gmail.com', '10'),
('111.111.111-21', 'Joao', 'uploads/Rafael_Lima.jpg', '(11) 11111-1111', 'Leticia@gmail.com', '1111');

-- --------------------------------------------------------

--
-- Estrutura para tabela `consulta`
--

CREATE TABLE `consulta` (
  `id_consulta` int(11) NOT NULL,
  `data_consulta` date NOT NULL,
  `hora_consulta` time NOT NULL,
  `cpf_esteticista` varchar(14) NOT NULL,
  `id_procedimento` int(11) NOT NULL,
  `cpf_cliente` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `esteticista`
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
  `senha_esteticista` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `esteticista`
--

INSERT INTO `esteticista` (`cpf_esteticista`, `nome_esteticista`, `foto_esteticista`, `apelido_esteticista`, `telefone_esteticista`, `formacao_esteticista`, `descricao_p_esteticista`, `descricao_g_esteticista`, `instagram_esteticista`, `facebook_esteticista`, `linkedin_esteticista`, `email_esteticista`, `senha_esteticista`) VALUES
('123.456.789-01', 'Henrique Santos', 'uploads/Henrique_Santos.jpg', 'Dr. Henrique', '(11) 91234-5678', 'Medicina Estética', 'Atua na estética há 7 anos. Especialista em procedimentos faciais.', 'Médico estético com 7 anos de experiência, Dr. Henrique oferece uma abordagem individualizada em cada procedimento. Ele utiliza as mais avançadas técnicas para garantir resultados naturais e a satisfação plena de seus pacientes. Seu foco é a saúde e a beleza da pele.', '@drhenriquesantos', 'facebook.com/drhenriquesantos', 'linkedin.com/in/drhenriquesantos', 'henrique.santos@email.com', 'senha123'),
('321.654.987-03', 'Laura Pereira', 'uploads/Laura_Pereira.jpg', 'Dermatologista Laura', '(11) 99876-5432', 'Dermatologia', 'Atua na estética há 12 anos. Especialista em limpeza de pele.', 'A Dra. Laura é uma dermatologista com 12 anos de experiência na área. Focada em cuidados faciais, ela utiliza tecnologias modernas para oferecer tratamentos eficazes que resultam em uma pele mais saudável e radiante. Cada paciente recebe um plano personalizado.', '@dermatologistalaura', 'facebook.com/dermatologistalaura', 'linkedin.com/in/dermatologistalaura', 'laura.pereira@email.com', 'senha123'),
('456.789.123-06', 'Paulo Silva', 'uploads/Paulo_Silva.jpg', 'Esteticista Paulo', '(11) 97812-3456', 'Estética', 'Atua na estética há 6 anos. Especialista em limpeza de pele.', 'Paulo se destaca em limpeza de pele e tratamentos faciais, com 6 anos de experiência. Ele oferece um atendimento personalizado, utilizando produtos de alta qualidade para garantir resultados que superam as expectativas de seus pacientes.', '@esteticistapaulo', 'facebook.com/esteticistapaulo', 'linkedin.com/in/esteticistapaulo', 'paulo.silva@email.com', 'senha123'),
('654.321.987-04', 'Maria Souza', 'uploads/Maria_Souza.jpg', 'Massagista Maria', '(11) 93456-7890', 'Massoterapia', 'Atua na estética há 8 anos. Especialista em massagem corporal.', 'Maria, com 8 anos de experiência, é uma massagista dedicada ao bem-estar e relaxamento. Suas técnicas de massoterapia são adaptadas às necessidades individuais de cada cliente, promovendo alívio do estresse e uma sensação de renovação em cada sessão.', '@massagistamaria', 'facebook.com/massagistamaria', 'linkedin.com/in/massagistamaria', 'maria.souza@email.com', 'senha123'),
('741.852.963-08', 'Rafael Lima', 'uploads/Rafael_Lima.jpg', 'Dr. Rafael', '(11) 96712-3456', 'Medicina Estética', 'Atua na estética há 10 anos. Especialista em bioestimuladores.', 'O Dr. Rafael, com 10 anos de atuação, se destaca no uso de bioestimuladores para tratamentos estéticos. Ele prioriza a saúde e a beleza da pele, sempre atento às necessidades individuais de cada paciente e buscando resultados excepcionais.', '@drrafaellima', 'facebook.com/drrafaellima', 'linkedin.com/in/drrafaellima', 'rafael.lima@email.com', 'senha123'),
('789.123.456-05', 'Nádia Oliveira', 'uploads/Paulo_Silva.jpg', 'Esteticista Nádia', '(11) 96543-2109', 'Estética', 'Experiente em radiofrequência e preenchimentos. Habilitada em pele negra.', 'A Esteticista Nádia é especialista em radiofrequência e tratamentos personalizados, especialmente para pele negra. Com uma abordagem única e técnica apurada, ela busca resultados visíveis, promovendo saúde e beleza para seus pacientes.', '@esteticistanadia', 'facebook.com/esteticistanadia', 'linkedin.com/in/esteticistanadia', 'nadia.oliveira@email.com', 'senha123'),
('963.852.741-07', 'Jane Martins', 'uploads/Jane_Martins.jpg', 'Dermatologista Jane', '(11) 98712-3456', 'Dermatologia', 'Atua na estética há 12 anos. Especialista em peeling químico.', 'A Dra. Jane é uma dermatologista com 12 anos de experiência em rejuvenescimento facial. Ela utiliza peeling químico e técnicas avançadas para tratar e melhorar a saúde da pele, sempre buscando resultados que realçam a beleza natural de cada paciente.', '@dermatologistajane', 'facebook.com/dermatologistajane', 'linkedin.com/in/dermatologistajane', 'jane.martins@email.com', 'senha123'),
('987.654.321-02', 'Silva Costa', 'uploads/Silva_Costa.jpg', 'Dr. Silva', '(11) 98765-4321', 'Medicina Estética', 'Atua na estética há 11 anos. Experiência em procedimentos labiais.', 'Com 11 anos de experiência em medicina estética, Dr. Silva é um especialista em procedimentos labiais. Ele se dedica a ajudar seus pacientes a alcançarem o sorriso perfeito, utilizando técnicas inovadoras e personalizadas, focando na beleza natural.', '@drsilvacosta', 'facebook.com/drsilvacosta', 'linkedin.com/in/drsilvacosta', 'silva.costa@email.com', 'senha123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `esteticista_procedimento`
--

CREATE TABLE `esteticista_procedimento` (
  `id` int(11) NOT NULL,
  `cpf_esteticista` varchar(14) DEFAULT NULL,
  `id_procedimento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `esteticista_procedimento`
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
-- Estrutura para tabela `procedimento`
--

CREATE TABLE `procedimento` (
  `id_procedimento` int(11) NOT NULL,
  `nome_procedimento` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `procedimento`
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

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `atendente`
--
ALTER TABLE `atendente`
  ADD PRIMARY KEY (`cpf_atendente`);

--
-- Índices de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id_avaliacao`),
  ADD KEY `fk_cliente_avaliacao` (`cpf_cliente`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cpf_cliente`);

--
-- Índices de tabela `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id_consulta`),
  ADD KEY `cpf_esteticista` (`cpf_esteticista`),
  ADD KEY `id_procedimento` (`id_procedimento`),
  ADD KEY `cpf_cliente` (`cpf_cliente`);

--
-- Índices de tabela `esteticista`
--
ALTER TABLE `esteticista`
  ADD PRIMARY KEY (`cpf_esteticista`);

--
-- Índices de tabela `esteticista_procedimento`
--
ALTER TABLE `esteticista_procedimento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cpf_esteticista` (`cpf_esteticista`),
  ADD KEY `id_procedimento` (`id_procedimento`);

--
-- Índices de tabela `procedimento`
--
ALTER TABLE `procedimento`
  ADD PRIMARY KEY (`id_procedimento`);

--
-- AUTO_INCREMENT para tabelas despejadas
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
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `fk_cliente_avaliacao` FOREIGN KEY (`cpf_cliente`) REFERENCES `cliente` (`cpf_cliente`);

--
-- Restrições para tabelas `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`cpf_esteticista`) REFERENCES `esteticista` (`cpf_esteticista`),
  ADD CONSTRAINT `consulta_ibfk_2` FOREIGN KEY (`id_procedimento`) REFERENCES `procedimento` (`id_procedimento`),
  ADD CONSTRAINT `consulta_ibfk_3` FOREIGN KEY (`cpf_cliente`) REFERENCES `cliente` (`cpf_cliente`);

--
-- Restrições para tabelas `esteticista_procedimento`
--
ALTER TABLE `esteticista_procedimento`
  ADD CONSTRAINT `esteticista_procedimento_ibfk_1` FOREIGN KEY (`cpf_esteticista`) REFERENCES `esteticista` (`cpf_esteticista`),
  ADD CONSTRAINT `esteticista_procedimento_ibfk_2` FOREIGN KEY (`id_procedimento`) REFERENCES `procedimento` (`id_procedimento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
