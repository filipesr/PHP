-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 
-- Versão do Servidor: 5.5.24-log
-- Versão do PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `php_enquete`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `opcao`
--

CREATE TABLE IF NOT EXISTS `opcao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpergunta` int(11) NOT NULL DEFAULT '0',
  `nome` varchar(300) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `FK_opcao_pergunta` (`idpergunta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `opcao`
--

INSERT INTO `opcao` (`id`, `idpergunta`, `nome`) VALUES
(1, 1, 'Formulário Fale Conosco'),
(2, 1, 'Contador de Visitas'),
(3, 1, 'Criar um calendário'),
(4, 1, 'Crie uma enquete');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pergunta`
--

CREATE TABLE IF NOT EXISTS `pergunta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` text NOT NULL,
  `datahora` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `pergunta`
--

INSERT INTO `pergunta` (`id`, `nome`, `datahora`) VALUES
(1, 'O que você mais achou interessante das coisas legais para site?', '2009-10-13 07:42:18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `votos`
--

CREATE TABLE IF NOT EXISTS `votos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idopcao` int(11) NOT NULL DEFAULT '0',
  `datahora` datetime NOT NULL,
  `ip` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_votos_opcao` (`idopcao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Extraindo dados da tabela `votos`
--

INSERT INTO `votos` (`id`, `idopcao`, `datahora`, `ip`) VALUES
(1, 2, '2009-10-14 14:00:55', ''),
(2, 1, '2009-10-14 14:01:27', '127.0.0.1'),
(3, 1, '2009-10-14 14:02:04', '127.0.0.1'),
(4, 1, '2009-10-14 14:02:13', '127.0.0.1'),
(5, 3, '2009-10-14 14:02:16', '127.0.0.1'),
(6, 4, '2009-10-14 14:02:21', '127.0.0.1'),
(7, 3, '2009-10-14 14:02:24', '127.0.0.1'),
(8, 1, '2009-10-14 14:02:27', '127.0.0.1'),
(9, 2, '2009-10-14 14:02:31', '127.0.0.1'),
(11, 1, '2009-10-14 14:02:38', '127.0.0.1'),
(12, 2, '2009-10-14 14:02:43', '127.0.0.1'),
(13, 1, '2009-10-14 14:02:46', '127.0.0.1'),
(14, 1, '2009-10-14 14:02:50', '127.0.0.1'),
(15, 1, '2009-10-14 14:05:26', '127.0.0.1'),
(16, 1, '2009-10-14 14:05:29', '127.0.0.1'),
(17, 4, '2009-10-14 14:05:33', '127.0.0.1'),
(18, 2, '2009-10-14 14:05:36', '127.0.0.1'),
(19, 1, '2009-10-14 14:05:40', '127.0.0.1'),
(20, 3, '2009-10-14 14:05:46', '127.0.0.1'),
(21, 2, '2009-10-14 14:05:49', '127.0.0.1'),
(22, 2, '2009-10-14 14:21:37', '127.0.0.1'),
(23, 1, '2009-10-14 14:21:53', '127.0.0.1'),
(25, 1, '2009-10-14 14:35:27', '127.0.0.1'),
(26, 1, '2009-10-15 00:42:05', '127.0.0.1'),
(27, 3, '2009-10-15 00:49:42', '127.0.0.1'),
(28, 2, '2009-10-15 01:22:00', '127.0.0.1'),
(29, 2, '2009-10-15 01:24:51', '127.0.0.1'),
(30, 1, '2009-10-15 01:37:21', '127.0.0.1'),
(31, 1, '2009-10-15 01:38:48', '127.0.0.1'),
(32, 1, '2009-10-15 01:41:30', '127.0.0.1'),
(33, 1, '2009-10-15 01:42:21', '127.0.0.1'),
(34, 1, '2009-10-15 04:53:42', '127.0.0.1'),
(35, 3, '2009-10-15 05:09:14', '127.0.0.1'),
(36, 2, '2009-10-15 05:10:01', '127.0.0.1'),
(37, 1, '2013-02-16 15:32:38', '127.0.0.1'),
(38, 2, '2013-02-16 15:34:24', '127.0.0.1'),
(39, 4, '2013-02-16 15:36:51', '127.0.0.1');

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `opcao`
--
ALTER TABLE `opcao`
  ADD CONSTRAINT `FK_opcao_pergunta` FOREIGN KEY (`idpergunta`) REFERENCES `pergunta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para a tabela `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `FK_votos_opcao` FOREIGN KEY (`idopcao`) REFERENCES `opcao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
