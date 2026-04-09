-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/02/2026 às 01:59
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
-- Banco de dados: `fineart`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `acessos_ensaios`
--

CREATE TABLE `acessos_ensaios` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `ensaio_slug` varchar(100) NOT NULL,
  `data_acesso` datetime NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `acessos_ensaios`
--

INSERT INTO `acessos_ensaios` (`id`, `user_id`, `ensaio_slug`, `data_acesso`, `ip_address`, `user_agent`) VALUES
(1, 1, 'clara-m', '2026-01-18 16:53:35', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36'),
(2, 1, 'marco-santo', '2026-01-18 22:19:40', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36'),
(3, 1, 'maria', '2026-01-18 22:40:14', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36'),
(4, 1, 'auto-retrato', '2026-01-19 19:13:52', '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36'),
(5, 3, 'auto-retrato', '2026-01-19 21:32:50', '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36'),
(6, 4, 'auto-retrato', '2026-01-19 21:53:24', '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36'),
(7, 1, 'ensaiocombifurcacao', '2026-02-08 17:30:40', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36'),
(8, 1, 'estudo-de-bifurcao', '2026-02-10 16:20:56', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36'),
(9, 1, 'caminhos', '2026-02-10 16:21:59', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36'),
(10, 1, 'caminhoslaterais', '2026-02-11 11:29:27', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36');

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `group` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
(1, 1, 'user', '2026-01-18 09:11:16'),
(2, 2, 'user', '2026-01-18 09:40:02'),
(3, 1, 'superadmin', '2026-01-18 20:14:44'),
(4, 3, 'user', '2026-01-19 21:32:10'),
(5, 4, 'user', '2026-01-19 21:52:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_identities`
--

CREATE TABLE `auth_identities` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `secret` varchar(255) NOT NULL,
  `secret2` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text DEFAULT NULL,
  `force_reset` tinyint(1) NOT NULL DEFAULT 0,
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `auth_identities`
--

INSERT INTO `auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'email_password', NULL, 'marcosantofoto@gmail.com', '$2y$12$28izQcon5CCRhla.5w1Qeer9zb3YuBYEJjnMMYBA6SKm4BFSYn3GC', NULL, NULL, 0, '2026-02-11 19:08:41', '2026-01-18 09:11:15', '2026-02-11 19:08:41'),
(2, 2, 'email_password', NULL, 'maria@gmail.com', '$2y$12$rIlyPATpALc9s5MpLLKaFeiydB1visLDIHFbSzPxoouvLo76XGxJm', NULL, NULL, 0, NULL, '2026-01-18 09:40:02', '2026-01-18 09:40:02'),
(3, 3, 'email_password', NULL, 'anjosdoamor@gmail.com', '$2y$12$GzQcw7uhXP.jJF3Ob78uGOHOk.RDpCXCahyA1EK4MdTf/7qVnczS2', NULL, NULL, 0, '2026-01-19 21:33:27', '2026-01-19 21:32:10', '2026-01-19 21:33:27'),
(4, 4, 'email_password', NULL, 'vieirasan@correios.com.br', '$2y$12$mJcUkghdWmb2y0L5kANBVuvVtsdy2Z402yASLH/R58Zb4FYYrQrc.', NULL, NULL, 0, NULL, '2026-01-19 21:52:32', '2026-01-19 21:52:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `user_agent`, `id_type`, `identifier`, `user_id`, `date`, `success`) VALUES
(1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 09:37:17', 1),
(2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 09:38:09', 1),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 10:13:23', 1),
(4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 10:26:45', 1),
(5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 11:03:45', 1),
(6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 11:25:43', 1),
(7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 11:32:39', 1),
(8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 11:48:06', 1),
(9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 12:21:39', 1),
(10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 14:54:54', 1),
(11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 15:00:27', 1),
(12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 15:33:04', 1),
(13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 19:43:11', 1),
(14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-18 20:18:12', 1),
(15, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-19 18:39:10', 1),
(16, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-19 19:03:13', 1),
(17, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'email_password', 'anjosdoamor@gmail.com', NULL, '2026-01-19 20:33:48', 0),
(18, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'email_password', 'anjosdoamor@gmail.com', NULL, '2026-01-19 20:35:51', 0),
(19, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-19 20:56:04', 1),
(20, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-19 20:56:05', 1),
(21, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'anjosdoamor@gmail.com', NULL, '2026-01-19 21:16:05', 0),
(22, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'email_password', 'anjosdoamor@gmail.com', 3, '2026-01-19 21:33:27', 1),
(23, '177.50.6.189', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-20 11:57:59', 1),
(24, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-20 21:42:00', 1),
(25, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-01-29 23:36:35', 1),
(26, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-06 21:07:22', 1),
(27, '177.50.2.134', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-07 09:30:23', 1),
(28, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-07 14:51:32', 1),
(29, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-07 14:51:39', 1),
(30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-08 16:20:14', 1),
(31, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-10 11:16:15', 1),
(32, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-10 16:15:50', 1),
(33, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-10 16:20:37', 1),
(34, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-10 16:50:55', 1),
(35, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-11 10:51:36', 1),
(36, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-11 11:23:14', 1),
(37, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-11 14:16:06', 1),
(38, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-11 19:08:41', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_permissions_users`
--

CREATE TABLE `auth_permissions_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `permission` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_remember_tokens`
--

CREATE TABLE `auth_remember_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_token_logins`
--

CREATE TABLE `auth_token_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ensaios`
--

CREATE TABLE `ensaios` (
  `id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `resumo_card` text DEFAULT NULL,
  `capa_url` varchar(255) DEFAULT NULL,
  `status` enum('rascunho','publicado','arquivado') NOT NULL DEFAULT 'rascunho',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ensaios`
--

INSERT INTO `ensaios` (`id`, `titulo`, `slug`, `resumo_card`, `capa_url`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Marco Santo', 'marco-santo', 'Ensaio de marco santo, fotógrafo', NULL, 'rascunho', '2026-01-18 17:43:58', '2026-01-19 18:40:33', '2026-01-19 18:40:33'),
(2, 'Maria', 'maria', 'Essa é a maria', NULL, 'rascunho', '2026-01-18 22:35:18', '2026-01-19 18:40:36', '2026-01-19 18:40:36'),
(3, 'Auto Retrato', 'auto-retrato', 'Ensaio de Auto Retrato de Marco Santo', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768860801_24922a7cac01d9b50013.jpg', 'rascunho', '2026-01-19 19:13:21', '2026-01-19 20:51:19', NULL),
(4, 'Caminhos', 'caminhos', 'Um ensaio, vários caminhos.', 'https://fineart.test/uploads/ensaios/1770578503_cf8ad1431ec99c60ed21.jpg', 'rascunho', '2026-02-08 16:21:43', '2026-02-10 16:21:46', NULL),
(5, 'Marco Santo', 'ensaiocombifurcacao', 'Auto retrato na kitinet', 'https://fineart.test/uploads/ensaios/1770581559_619f3080a922a619a8fd.jpg', 'rascunho', '2026-02-08 17:12:39', '2026-02-10 13:43:32', NULL),
(6, 'Caminhos laterais', 'caminhoslaterais', 'Essa é uma verificação da implementação do caminho lateral correndo lateralmente nas galerias.... Vamos ver.', 'https://fineart.test/uploads/ensaios/1770820091_f88ec200f8cacefb4465.jpg', 'rascunho', '2026-02-11 11:28:11', '2026-02-11 11:28:11', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ensaio_paginas_extras`
--

CREATE TABLE `ensaio_paginas_extras` (
  `id` int(10) UNSIGNED NOT NULL,
  `ensaio_id` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `conteudo` text DEFAULT NULL,
  `configuracoes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`configuracoes`)),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ensaio_paginas_extras`
--

INSERT INTO `ensaio_paginas_extras` (`id`, `ensaio_id`, `tipo`, `titulo`, `conteudo`, `configuracoes`, `created_at`, `updated_at`) VALUES
(1, 5, 'biografia', 'Marco Santo', 'O modelo Marco Santo é também o fotógrafo nesse ensaio.', NULL, '2026-02-10 11:49:43', '2026-02-10 11:49:43'),
(2, 5, 'ficha_tecnica', 'O susto persistentes', 'Tem um momento que quebra... A consicência capta, mas a partir dali, não controla mais.', '[{\"chave\":\"Papel\",\"valor\":\"Papel algodão textrura 300 gr\"},{\"chave\":\"Dimensões\",\"valor\":\"60 x 90 cm\"},{\"chave\":\"Durabilidade\",\"valor\":\"200 anos\"}]', '2026-02-10 13:36:41', '2026-02-10 13:36:41'),
(3, 5, 'galeria', 'Galerias', 'Veja outros quadros dessa série.', '[{\"img\":\"\",\"titulo\":\"Esquentando fogão\",\"preco\":\"\",\"status\":\"disponivel\"}]', NULL, NULL),
(4, 5, 'compradores', 'Felizardos compradores dessa obra', 'Matheus Gomide Ferrança - Brasil\r\nGeoge Smith Patulaco - Brasil\r\nMarina Lima - França', '[{\"chave\":\"Valor médio da obra\",\"valor\":\"15.757,78\"},{\"chave\":\"Idade média dos compradores\",\"valor\":\"54  anos\"}]', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `etapas`
--

CREATE TABLE `etapas` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID da etapa anterior (Pai). Se NULL, é o inicio da caverna.',
  `ensaio_id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `tipo` enum('fotevista','entrevista','fineart','texto_livre') NOT NULL DEFAULT 'fotevista',
  `ordem` int(11) NOT NULL DEFAULT 1,
  `descricao` text DEFAULT NULL,
  `decisao_texto` varchar(255) DEFAULT NULL COMMENT 'Texto do botão que leva a esta etapa (Ex: Entrar na fenda escura)',
  `direcao` enum('frente','lado') DEFAULT 'frente',
  `audio_url` varchar(255) DEFAULT NULL COMMENT 'Caminho para o arquivo de áudio da sala'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `etapas`
--

INSERT INTO `etapas` (`id`, `parent_id`, `ensaio_id`, `titulo`, `tipo`, `ordem`, `descricao`, `decisao_texto`, `direcao`, `audio_url`) VALUES
(1, NULL, 2, 'nova camada de maria', 'fotevista', 1, 'Essa foi a fotevista da MARIA...', NULL, 'frente', NULL),
(2, NULL, 2, 'Olhabndndo para o chão', 'entrevista', 3, 'Aqui, maria olhou para  oo chäo', NULL, 'frente', NULL),
(3, NULL, 2, 'Nem tudo é o que parece ', 'fineart', 4, 'Essa é a madona maria', NULL, 'frente', NULL),
(4, NULL, 3, 'Testes e Brincadeiras', 'texto_livre', 1, 'Fotografar não é trabalho... ', NULL, 'frente', NULL),
(5, NULL, 3, 'Críticas as vezes é só bom senso...', 'texto_livre', 2, 'Nem sempre uma observação é uma crítica destrutiva. As vezes é só uma conversa franca que não deve nada a ninguém e não tenta enganar ninguém.', NULL, 'frente', NULL),
(6, NULL, 3, 'As sombras sempre aparecem...', 'fineart', 3, 'Um ensaio vaga a esmo e esbarra em coisas...', NULL, 'frente', NULL),
(7, NULL, 3, 'A estranhesa vira parceira e...', 'fineart', 4, 'A luz cria seus próprios contextos e histórias...', NULL, 'frente', NULL),
(8, NULL, 3, 'O sombrio...', 'fineart', 5, '...ele estava o tempo todo lá, espreitando da escuridão?', NULL, 'frente', NULL),
(9, NULL, 3, 'Uma ensio busca uma verdade', 'texto_livre', 6, 'Você está preparado para ela?', NULL, 'frente', NULL),
(10, NULL, 4, 'Primeira camada', 'entrevista', 1, 'Essa é a primeira camada, foi pelo lado da angustia', NULL, 'frente', NULL),
(11, 10, 4, 'nova camada com bifurcação.', 'texto_livre', 1, 'Quero expressar que o interesse, nesse momento do ensaio, foi para outra direção que se mostrou infrutìfera.', 'Aqui o interesse  foi para outro lado.', 'frente', NULL),
(12, NULL, 5, 'Primeira camada', 'entrevista', 1, 'Essa é a primeira sala ca caverna.', 'Essa è a primeira sala da caverna', 'frente', NULL),
(13, 12, 5, 'Segunda sala do ensaio', 'fotevista', 1, 'Estamos indo no caminho principal.', 'Esse é uma ramo principal', 'frente', NULL),
(14, 13, 5, 'Seguindo na rota principal', 'fotevista', 1, 'Aqui uma entrevista com fotos', 'Continua para a ESTRADA', 'frente', NULL),
(15, 13, 5, 'Bifurcação dsa segunda sala', 'fineart', 1, 'Essa foto poderia sera a principal', 'Tem um desvio aqui', 'frente', NULL),
(16, NULL, 6, 'A porta de entrada', 'texto_livre', 1, 'Seja bem vindo. Esse texto  é a legenda interna da porta de entrada do ensaio..', 'Seja Bem vindo', 'frente', NULL),
(17, 16, 6, 'Aqui começa a entrevista', 'fotevista', 1, 'Essa entrevista é conduzida enquanto o modelo é fotografado em momentos que o fotógrafo define. Ele não sabe como as fotos estão ficando e não vê essas fotos sendo feitas durante a entreveista  com foto...', 'Primeira entrevista', 'frente', NULL),
(18, 17, 6, 'Loucuras com flahs', 'fotevista', 1, 'Um apêndice sobre os flahses e sua portabilidade...', 'Se empolgou', 'lado', NULL),
(19, 18, 6, 'Toda loucura produz um resultado', 'fineart', 1, '', 'Loucura final', 'lado', NULL),
(20, 17, 6, 'Entrevista se aprofunda', 'fotevista', 1, 'Entrevista com foto para buscar a foto do trablalho.', 'A procura', 'frente', NULL),
(21, 19, 6, 'A luz venceu', 'fineart', 1, '', 'Ver o próximo', 'lado', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens`
--

CREATE TABLE `itens` (
  `id` int(10) UNSIGNED NOT NULL,
  `etapa_id` int(10) UNSIGNED NOT NULL,
  `tipo` enum('foto','video','texto','citacao','audio') NOT NULL DEFAULT 'foto',
  `conteudo` text NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `legenda` varchar(255) DEFAULT NULL,
  `classe_css` varchar(100) NOT NULL DEFAULT 'col-md-4',
  `ordem` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens`
--

INSERT INTO `itens` (`id`, `etapa_id`, `tipo`, `conteudo`, `titulo`, `legenda`, `classe_css`, `ordem`) VALUES
(1, 1, 'texto', 'mARIA ESCRITORA GOASTQA DE ESCRREVER E E escreveui esse insgelso pedaç o de texto', NULL, 'Essa é uma foto de maria escrevendo', 'col-12', 2),
(2, 1, 'foto', 'Que foto linda de maria', NULL, 'Eu gostei disse ela', 'col-md-8', 1),
(3, 3, 'foto', 'O simbolo da beleza', NULL, 'tudo que a natureza criou.,', 'col-12', 1),
(5, 4, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768861056_eb0ac19e0df64d8c6b25.jpg', NULL, 'Olhar para a luz e...', 'col-md-4', 2),
(7, 4, 'citacao', 'A luz não é ciência exata... Mas arte também não é!', NULL, 'Jogando o poder da visão', 'col-md-6', 4),
(10, 5, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768864614_39ab0f1b16a2a7f27aa7.jpg', NULL, '', 'col-md-4', 2),
(11, 5, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768864707_07f11255270ef5636b26.jpg', NULL, 'A fome não acaba em vida...', 'col-md-4', 1),
(12, 5, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768864854_6616343379cf5d704e6e.jpg', NULL, 'A visão é uma questão de escolha?', 'col-md-4', 1),
(13, 6, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768865155_d90e1d54eb6f0ffbf008.jpg', NULL, 'A gente vai entrando em estados que não planejamos...', 'col-12', 1),
(14, 7, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768865327_ddcb578a8058890078be.jpg', NULL, 'E  quando a gente menos espera, aquele susto está ali... ', 'col-12', 1),
(15, 8, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768865564_33a0f38ab20d08674d40.jpg', NULL, 'O que um ensaio busca?', 'col-12', 1),
(16, 9, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768866644_406fb431fe6f6f339c02.jpg', NULL, 'A verdadeira nudez não mostra pele...', 'col-md-4', 1),
(17, 9, 'citacao', 'Estar nú é não ter as proteções que escondiam...', NULL, '', 'col-12', 2),
(18, 4, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768962147_d5b33038f1f6f741433f.jpg', NULL, '', 'col-md-4', 1),
(21, 4, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768963692_2183af9cd9b1a76d40a3.jpg', NULL, '', 'col-md-4', 3),
(22, 10, 'texto', 'Aqui o ensaio se enverdou pelo lado da angustia da modelo', NULL, 'Esse testo', 'col-md-6', 1),
(23, 11, 'foto', 'https://fineart.test/uploads/ensaios/1770581212_26295ace09e81b330ff3.jpg', NULL, 'O artista mordeu a cachorrinha', 'col-md-4', 1),
(24, 11, 'foto', 'https://fineart.test/uploads/ensaios/1770581234_e15dfa30abcf1808e4d8.jpg', NULL, 'Quis comer o flahs', 'col-md-4', 2),
(25, 11, 'foto', 'https://fineart.test/uploads/ensaios/1770581271_f76a3c3a5cc6ee7f7fec.jpg', NULL, 'Depois ficou com cara de bunda', 'col-md-4', 3),
(26, 13, 'foto', 'https://fineart.test/uploads/ensaios/1770582028_000ee3e87456e2d8e82d.jpg', NULL, 'Cara de louco', 'col-md-4', 1),
(27, 13, 'foto', 'https://fineart.test/uploads/ensaios/1770582044_f119258646ccaf569ff4.jpg', NULL, 'Pucha', 'col-md-4', 2),
(28, 13, 'foto', 'https://fineart.test/uploads/ensaios/1770582065_2e8c3f3421cdcd666733.jpg', NULL, 'zoio caidos', 'col-md-4', 3),
(29, 14, 'foto', 'https://fineart.test/uploads/ensaios/1770582462_af1a228b1af75ebda129.jpg', NULL, 'Pega a visao', 'col-md-6', 1),
(30, 14, 'foto', 'https://fineart.test/uploads/ensaios/1770582483_d13e3ec1540ba6073760.jpg', NULL, 'Enquadra', 'col-md-4', 2),
(31, 12, 'foto', 'https://fineart.test/uploads/ensaios/1770582615_23fd27dadbd5a30ea647.jpg', NULL, 'Voce por aqui?', 'col-12', 1),
(32, 15, 'foto', 'https://fineart.test/uploads/ensaios/1770583009_b414b07895c5c2c6e50c.jpg', NULL, 'A modelo queria essa foto no fundo da caverna...', 'col-12', 1),
(33, 16, 'foto', 'https://fineart.test/uploads/ensaios/1770820217_c63f05cec0408aac5e06.jpg', NULL, 'Vamos tomar um café e falar desse ensaio.', 'col-md-4', 1),
(34, 17, 'foto', 'https://fineart.test/uploads/ensaios/1770820532_9d611fd36f4388474d56.jpg', NULL, 'O que é flash portátil para você?', 'col-md-4', 1),
(35, 17, 'foto', 'https://fineart.test/uploads/ensaios/1770820578_4a0a54b43c8c85abffee.jpg', 'Comendo Luz - 02', 'O que é flash portátil para você?', 'col-md-4', 2),
(36, 17, 'foto', 'https://fineart.test/uploads/ensaios/1770820628_07b8aed1df5fa54d3cc2.jpg', NULL, 'É aquele flash que me permite fazewr coisas inusitadas...', 'col-md-4', 3),
(37, 18, 'foto', 'https://fineart.test/uploads/ensaios/1770821752_efb16a49e788b3aa8c5f.jpg', 'Comendo Luz - 01', 'Qual é a sua relação com a luz?', 'col-md-4', 1),
(38, 18, 'foto', 'https://fineart.test/uploads/ensaios/1770830595_fc0f4fe7057a53153ccd.jpg', 'Comendo Luz - 03', 'Luz não è inofensiva...', 'col-md-4', 2),
(39, 18, 'foto', 'https://fineart.test/uploads/ensaios/1770831357_5642fbf87ac17d1d6f7a.jpg', 'Comendo Luz - 02', 'Começou a ficar estranho...', 'col-md-4', 3),
(41, 19, 'foto', 'https://fineart.test/uploads/ensaios/1770836712_2ed9c739cbe1ead0a1eb.jpg', 'Luz alcançável', '', 'col-12', 1),
(42, 20, 'foto', 'https://fineart.test/uploads/ensaios/1770837095_955251937d08ccf8c1a1.jpg', '', 'Os bloqueios da visão', 'col-md-4', 1),
(43, 21, 'foto', 'https://fineart.test/uploads/ensaios/1770851705_572a638ba6e781342397.jpg', 'Luz na cabeça', '', 'col-12', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2020-12-28-223112', 'CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables', 'default', 'CodeIgniter\\Shield', 1768621907, 1),
(2, '2021-07-04-041948', 'CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable', 'default', 'CodeIgniter\\Settings', 1768621907, 1),
(3, '2021-11-14-143905', 'CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn', 'default', 'CodeIgniter\\Settings', 1768621907, 1),
(4, '2026-01-18-100000', 'App\\Database\\Migrations\\CreateAcessosEnsaiosTable', 'default', 'App', 1768762569, 2),
(5, '2026-01-18-120000', 'App\\Database\\Migrations\\CreateEnsaiosStructure', 'default', 'App', 1768768005, 3),
(6, '2026-02-08-000001', 'App\\Database\\Migrations\\AddBifurcationToEtapas', 'default', 'App', 1770579348, 4),
(7, '2026-02-08-000002', 'App\\Database\\Migrations\\AddAudioToEtapas', 'default', 'App', 1770734335, 5),
(8, '2026-02-08-000003', 'App\\Database\\Migrations\\CreateEnsaioPaginasExtras', 'default', 'App', 1770734335, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos_aquisicao`
--

CREATE TABLE `pedidos_aquisicao` (
  `id` int(11) NOT NULL,
  `ensaio_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `status` enum('pendente','contatado','vendido','arquivado') DEFAULT 'pendente',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(31) NOT NULL DEFAULT 'string',
  `context` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'marcosantofoto', NULL, NULL, 1, '2026-02-11 20:12:24', '2026-01-18 09:11:15', '2026-01-18 09:11:15', NULL),
(2, 'maria', NULL, NULL, 1, NULL, '2026-01-18 09:40:02', '2026-01-18 09:40:02', NULL),
(3, 'marcosanto', NULL, NULL, 1, '2026-01-19 21:33:33', '2026-01-19 21:32:09', '2026-01-19 21:32:10', NULL),
(4, 'Vieira', NULL, NULL, 1, '2026-01-19 21:55:40', '2026-01-19 21:52:32', '2026-01-19 21:52:33', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `acessos_ensaios`
--
ALTER TABLE `acessos_ensaios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_data_acesso` (`user_id`,`data_acesso`);

--
-- Índices de tabela `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`);

--
-- Índices de tabela `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_secret` (`type`,`secret`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_permissions_users_user_id_foreign` (`user_id`);

--
-- Índices de tabela `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `auth_remember_tokens_user_id_foreign` (`user_id`);

--
-- Índices de tabela `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `ensaios`
--
ALTER TABLE `ensaios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Índices de tabela `ensaio_paginas_extras`
--
ALTER TABLE `ensaio_paginas_extras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ensaio_paginas_extras_ensaio_id_foreign` (`ensaio_id`);

--
-- Índices de tabela `etapas`
--
ALTER TABLE `etapas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etapas_ensaio_id_foreign` (`ensaio_id`);

--
-- Índices de tabela `itens`
--
ALTER TABLE `itens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itens_etapa_id_foreign` (`etapa_id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos_aquisicao`
--
ALTER TABLE `pedidos_aquisicao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acessos_ensaios`
--
ALTER TABLE `acessos_ensaios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `auth_identities`
--
ALTER TABLE `auth_identities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ensaios`
--
ALTER TABLE `ensaios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `ensaio_paginas_extras`
--
ALTER TABLE `ensaio_paginas_extras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `etapas`
--
ALTER TABLE `etapas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `itens`
--
ALTER TABLE `itens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `pedidos_aquisicao`
--
ALTER TABLE `pedidos_aquisicao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `acessos_ensaios`
--
ALTER TABLE `acessos_ensaios`
  ADD CONSTRAINT `acessos_ensaios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD CONSTRAINT `auth_identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD CONSTRAINT `auth_permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD CONSTRAINT `auth_remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `ensaio_paginas_extras`
--
ALTER TABLE `ensaio_paginas_extras`
  ADD CONSTRAINT `ensaio_paginas_extras_ensaio_id_foreign` FOREIGN KEY (`ensaio_id`) REFERENCES `ensaios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `etapas`
--
ALTER TABLE `etapas`
  ADD CONSTRAINT `etapas_ensaio_id_foreign` FOREIGN KEY (`ensaio_id`) REFERENCES `ensaios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `itens`
--
ALTER TABLE `itens`
  ADD CONSTRAINT `itens_etapa_id_foreign` FOREIGN KEY (`etapa_id`) REFERENCES `etapas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
