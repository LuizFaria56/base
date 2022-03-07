-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 11-Dez-2021 às 18:45
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `base`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` int(11) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `nome`, `email`, `senha`, `endereco`, `cidade`, `estado`, `cep`, `telefone`, `nivel`) VALUES
(2, 'Luiz Antonio Faria', 'luiz.antonio.faria@gmail.com', '$2y$10$BRPYMp.xeSub6lURaMTUOe5y.Cqun0XQOlVrzknUttBxK4CTgS95a', '', 'Campinas', 'SP', 13101664, '', 9),
(3, 'Joaquina2', 'canalwdev@gmail.com', '$2y$10$eKo8lwP5LsFyfYIUeJQtleQPenh3dCJietzlR7tstFNk10Dt2hwvG', '', 'Belo Horizonte', 'MG', 0, '', 0),
(4, 'Carlos Drummond', 'carlos@gmail.com', '$2y$10$4tE0nK.iBNOOw1FFR4uTRuO4E4NrDcllew/7Fle5PE37SqMDbFU3i', '', 'Rio de Janeiro', 'RJ', 0, '', 0),
(5, 'Joaquim', 'joaquim@gmail.com', '$2y$10$LLCOj6yaKten0Xz8T/aSaO9fRvyHcXVl2eYdt6qrbc1HX6lmklFfu', '???', 'São Paulo', 'SP', 0, '', 0),
(6, 'Aluisio', 'aluisio@gmail.com', '$2y$10$SqDTeeRZxbxXY3E9f6kXHe0kWVpS5e6GIT62Ou7usobTDSFnD5cIG', '', 'Porto Feliz', 'SP', 0, '', 0),
(7, 'Antonio', 'antonio@gmail.com', '$2y$10$PKfUOGyaSi8nWlhuixAcfeLj6KGHiJzH8YOS90il9vDqF/QoYQc9m', '', 'Feira de Santana', 'BA', 0, '', 0),
(8, 'Berenice', 'berenice@gmail.com', '$2y$10$t1Vc9Nnhd5QIkzKQO87kmeYkT09kMOWo3WturuP04DdJ18vvSeBbG', '', 'Vitória', 'ES', 0, '', 0),
(9, 'Beatriz', 'beatriz@hotmail.com', '$2y$10$PpKYx16bltxtXtWqGLr.x.ekPeL9bwTd7JH8BZDtOOloMUcATFXBi', '', '', '', 0, '', 0),
(10, 'Augusto', 'augusto@hotmail.com', '$2y$10$bG6LRa.6xeyR1.Z9U1bZhuQLsJWv/za0mis0YCtSQNhMXbaNFLW0K', NULL, NULL, NULL, NULL, NULL, 0),
(11, 'Elvira', 'elvira@gmail.com', '$2y$10$01q1I9oze7YMEKziNs4Mv.mf7pNgUR35TnFitWDDLbDvSJZuTePNS', NULL, NULL, NULL, NULL, NULL, 0),
(12, 'Mariana', 'mariana@gmail.com', '$2y$10$8OvK3vAjtg016LuewRd1z.6dgznRaq6cUA1MW5f4YiVrjkfx.V6be', NULL, NULL, NULL, NULL, NULL, 0),
(13, 'Jussara', 'jussara@gmail.com', '$2y$10$vWY4/qc/6pcezGSp1MuCNOXT5bz0AzA.pxmxk2IdmI5l8a3Q/93YW', '', 'Petrópolis', 'RJ', 0, '', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
