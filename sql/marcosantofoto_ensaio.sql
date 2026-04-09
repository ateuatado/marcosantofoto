-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 15/03/2026 às 04:03
-- Versão do servidor: 8.4.7-7
-- Versão do PHP: 8.1.34

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
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `ensaio_slug` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `data_acesso` datetime NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(512) COLLATE utf8mb4_general_ci DEFAULT NULL
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
(10, 1, 'caminhoslaterais', '2026-02-11 11:29:27', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36'),
(11, 1, 'autoretrato', '2026-02-13 21:13:43', '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36'),
(12, 5, 'autoretrato', '2026-02-14 21:35:54', '187.56.125.223', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/23C71 Instagram 416.1.0.27.68 (iPhone15,3; iOS 26_2_1; pt_BR; pt; scale=3.00; 1290x2796; IABMV/1; 881475720) Safari/604.1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
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
(5, 4, 'user', '2026-01-19 21:52:33'),
(6, 5, 'user', '2026-02-14 21:35:08');

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_identities`
--

CREATE TABLE `auth_identities` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `secret` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `secret2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text COLLATE utf8mb4_general_ci,
  `force_reset` tinyint(1) NOT NULL DEFAULT '0',
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `auth_identities`
--

INSERT INTO `auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'email_password', NULL, 'marcosantofoto@gmail.com', '$2y$12$28izQcon5CCRhla.5w1Qeer9zb3YuBYEJjnMMYBA6SKm4BFSYn3GC', NULL, NULL, 0, '2026-03-12 11:07:12', '2026-01-18 09:11:15', '2026-03-12 11:07:12'),
(2, 2, 'email_password', NULL, 'maria@gmail.com', '$2y$12$rIlyPATpALc9s5MpLLKaFeiydB1visLDIHFbSzPxoouvLo76XGxJm', NULL, NULL, 0, NULL, '2026-01-18 09:40:02', '2026-01-18 09:40:02'),
(3, 3, 'email_password', NULL, 'anjosdoamor@gmail.com', '$2y$12$GzQcw7uhXP.jJF3Ob78uGOHOk.RDpCXCahyA1EK4MdTf/7qVnczS2', NULL, NULL, 0, '2026-02-13 12:25:18', '2026-01-19 21:32:10', '2026-02-13 12:25:18'),
(4, 4, 'email_password', NULL, 'vieirasan@correios.com.br', '$2y$12$mJcUkghdWmb2y0L5kANBVuvVtsdy2Z402yASLH/R58Zb4FYYrQrc.', NULL, NULL, 0, NULL, '2026-01-19 21:52:32', '2026-01-19 21:52:33'),
(5, 5, 'email_password', NULL, 'fotografantonini@gmail.com', '$2y$12$OWTvAX1rQMlO6Y.Z1qx0.ueT7PE4xuBE8Aj5uK01xukVWxpctWErK', NULL, NULL, 0, NULL, '2026-02-14 21:35:08', '2026-02-14 21:35:08');

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
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
(38, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-11 19:08:41', 1),
(39, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-11 22:09:28', 1),
(40, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-11 22:20:31', 1),
(41, '177.50.9.255', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-12 14:30:47', 1),
(42, '177.50.9.255', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-12 16:32:52', 1),
(43, '177.50.10.180', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-12 16:38:22', 1),
(44, '177.50.9.251', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'anjosdoamor@gmail.com', 3, '2026-02-13 12:25:18', 1),
(45, '177.50.9.251', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-13 12:25:41', 1),
(46, '177.50.11.35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-13 17:13:15', 1),
(47, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-13 21:04:11', 1),
(48, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-14 10:42:03', 1),
(49, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-14 12:20:32', 1),
(50, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-14 17:35:21', 1),
(51, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-14 18:48:33', 1),
(52, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 15; 2311DRK48G Build/AP3A.240905.015.A2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/145.0.7632.49 Mobile Safari/537.36 Instagram 416.0.0.47.66 Android (35/15; 480dpi; 1220x2712; Xiaomi/POCO; 2311DRK48G; ducha', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-14 19:32:20', 1),
(53, '187.56.125.223', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/23C71 Instagram 416.1.0.27.68 (iPhone15,3; iOS 26_2_1; pt_BR; pt; scale=3.00; 1290x2796; IABMV/1; 881475720) Safari/604.1', 'email_password', 'fotografantonini@gmail.com', NULL, '2026-02-14 21:33:33', 0),
(54, '187.56.125.223', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/23C71 Instagram 416.1.0.27.68 (iPhone15,3; iOS 26_2_1; pt_BR; pt; scale=3.00; 1290x2796; IABMV/1; 881475720) Safari/604.1', 'email_password', 'fotografantonini@gmail.com', NULL, '2026-02-14 21:34:20', 0),
(55, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-17 15:49:29', 1),
(56, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-17 15:55:26', 1),
(57, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'fotografantonini@gmail.com', NULL, '2026-02-17 17:00:44', 0),
(58, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'fotografantonini@gmail.com', NULL, '2026-02-17 17:00:54', 0),
(59, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-17 17:00:59', 1),
(60, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-17 22:23:30', 1),
(61, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-17 23:04:54', 1),
(62, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-18 09:43:30', 1),
(63, '177.50.14.234', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-18 12:01:39', 1),
(64, '177.50.14.234', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-18 15:01:33', 1),
(65, '189.62.47.82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-19 20:02:53', 1),
(66, '189.62.47.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-19 21:13:15', 1),
(67, '177.50.8.88', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-20 06:50:20', 1),
(68, '177.50.4.232', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-02-28 18:27:20', 1),
(69, '177.50.9.246', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-03-12 10:59:51', 1),
(70, '177.50.9.246', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'email_password', 'marcosantofoto@gmail.com', 1, '2026-03-12 11:07:12', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_permissions_users`
--

CREATE TABLE `auth_permissions_users` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_remember_tokens`
--

CREATE TABLE `auth_remember_tokens` (
  `id` int UNSIGNED NOT NULL,
  `selector` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hashedValidator` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_token_logins`
--

CREATE TABLE `auth_token_logins` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ensaios`
--

CREATE TABLE `ensaios` (
  `id` int UNSIGNED NOT NULL,
  `titulo` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `resumo_card` text COLLATE utf8mb4_general_ci,
  `capa_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `largura_orig` int DEFAULT NULL,
  `altura_orig` int DEFAULT NULL,
  `status` enum('rascunho','publicado','arquivado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'rascunho',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ensaios`
--

INSERT INTO `ensaios` (`id`, `titulo`, `slug`, `resumo_card`, `capa_url`, `largura_orig`, `altura_orig`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Marco Santo', 'marco-santo', 'Ensaio de marco santo, fotógrafo', NULL, NULL, NULL, 'rascunho', '2026-01-18 17:43:58', '2026-01-19 18:40:33', '2026-01-19 18:40:33'),
(2, 'Maria', 'maria', 'Essa é a maria', NULL, NULL, NULL, 'rascunho', '2026-01-18 22:35:18', '2026-01-19 18:40:36', '2026-01-19 18:40:36'),
(3, 'Auto Retrato', 'auto-retrato', 'Ensaio de Auto Retrato de Marco Santo', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768860801_24922a7cac01d9b50013.jpg', NULL, NULL, 'rascunho', '2026-01-19 19:13:21', '2026-02-13 17:14:49', '2026-02-13 17:14:49'),
(4, 'Caminhos', 'caminhos', 'Um ensaio, vários caminhos.', 'https://fineart.test/uploads/ensaios/1770578503_cf8ad1431ec99c60ed21.jpg', NULL, NULL, 'rascunho', '2026-02-08 16:21:43', '2026-02-13 17:14:54', '2026-02-13 17:14:54'),
(5, 'Marco Santo', 'ensaiocombifurcacao', 'Auto retrato na kitinet', 'https://fineart.test/uploads/ensaios/1770581559_619f3080a922a619a8fd.jpg', NULL, NULL, 'rascunho', '2026-02-08 17:12:39', '2026-02-13 17:14:57', '2026-02-13 17:14:57'),
(6, 'Caminhos laterais', 'caminhoslaterais', 'Essa é uma verificação da implementação do caminho lateral correndo lateralmente nas galerias.... Vamos ver.', 'https://fineart.test/uploads/ensaios/1770820091_f88ec200f8cacefb4465.jpg', NULL, NULL, 'rascunho', '2026-02-11 11:28:11', '2026-02-13 17:15:02', '2026-02-13 17:15:02'),
(7, 'Auto Retrato na Pandemia', 'autoretrato', 'Auto Retrato realizado em agosto de 2021, saindo da pandemia.', 'https://www.marcosantofoto.com.br/uploads/ensaios/1771106551_2cd3b8f58c759fd50b75.jpg', NULL, NULL, 'rascunho', '2026-02-13 21:07:47', '2026-02-14 19:02:31', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ensaio_paginas_extras`
--

CREATE TABLE `ensaio_paginas_extras` (
  `id` int UNSIGNED NOT NULL,
  `ensaio_id` int UNSIGNED NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `conteudo` text COLLATE utf8mb4_general_ci,
  `configuracoes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ;

--
-- Despejando dados para a tabela `ensaio_paginas_extras`
--

INSERT INTO `ensaio_paginas_extras` (`id`, `ensaio_id`, `tipo`, `titulo`, `conteudo`, `configuracoes`, `created_at`, `updated_at`) VALUES
(1, 5, 'biografia', 'Marco Santo', 'O modelo Marco Santo é também o fotógrafo nesse ensaio.', NULL, '2026-02-10 11:49:43', '2026-02-10 11:49:43'),
(2, 5, 'ficha_tecnica', 'O susto persistentes', 'Tem um momento que quebra... A consicência capta, mas a partir dali, não controla mais.', '[{\"chave\":\"Papel\",\"valor\":\"Papel algodão textrura 300 gr\"},{\"chave\":\"Dimensões\",\"valor\":\"60 x 90 cm\"},{\"chave\":\"Durabilidade\",\"valor\":\"200 anos\"}]', '2026-02-10 13:36:41', '2026-02-10 13:36:41'),
(3, 5, 'galeria', 'Galerias', 'Veja outros quadros dessa série.', '[{\"img\":\"\",\"titulo\":\"Esquentando fogão\",\"preco\":\"\",\"status\":\"disponivel\"}]', NULL, NULL),
(4, 5, 'compradores', 'Felizardos compradores dessa obra', 'Matheus Gomide Ferrança - Brasil\r\nGeoge Smith Patulaco - Brasil\r\nMarina Lima - França', '[{\"chave\":\"Valor médio da obra\",\"valor\":\"15.757,78\"},{\"chave\":\"Idade média dos compradores\",\"valor\":\"54  anos\"}]', NULL, NULL),
(5, 7, 'ficha_tecnica', 'Por mais que a luz exitiu, a escuridão deixou marcas', 'A pandemia  de COVID-19 foi um evento terrível que se abateu sobre o mundo. Especialmente aqui no Brasil, estávamos reféns de uma famìlia de milicianos que havia atingido o poder federal. Especialmente o Capitão, que infelizmente não está preso por esse crime, fizeram esse período ser de medo, raiva, ódio, insegurança, negacionismo, obscurantismo.\r\n\r\nNossa sociedade não parou para anotar a placa desse caminhão que atropelou nosso país. Porque o caminhão continua rodando, infelizmente.', '[{\"chave\":\"Tipo\",\"valor\":\"Quadro\"},{\"chave\":\"Qualidade\",\"valor\":\"Museológica\"},{\"chave\":\"Dimensões\",\"valor\":\"1.20 x 1.50 m\"}]', NULL, NULL),
(6, 7, 'biografia', 'Marco Santo', 'O Autor e o Dispositivo: Da Asfixia ao Aprendizado\r\nMeu trabalho não nasce da busca pela estética, mas da urgência do testemunho. Em agosto de 2021, diante de um país em colapso, voltei a lente para mim mesmo para processar a asfixia. Hoje, aos 50 anos, entendo que esse processo foi o início de um deslocamento necessário: o de reconhecer os limites da minha própria visão e buscar os letramentos que a vida me exigia.\r\n\r\nO Lugar do Aliado\r\n\r\nReconheço que não luto a mesma luta stricto senso, mas coloco meu dispositivo — minha luz, meu áudio e meu silêncio — como aliado de quem foi forjado na resistência. Sou um homem em processo de desaprendizado, atento à geometria estranha de existências que não me pertencem, mas que merecem ser documentadas com o máximo rigor e respeito.\r\n\r\nCompromisso Antirracista, Antimachista e Antihomofóbico: Meu estúdio não é um lugar de julgamento, mas um laboratório de Reparação Simbólica. Aqui, a autoridade é sempre de quem narra a própria história.', NULL, NULL, NULL),
(7, 7, 'texto_livre', 'Ensaio na Pandemia', 'A Pandemia foi um período estranho para muita gente. Quem pode ficar em casa ficou. Quem não teve opção saiu. E muitos que saíram trouxeram a morte para dentro de casa, para os pais, para o conjuge, para os filhos ou pra si mesmo.\r\n\r\nUm movimento de negação às ciências, puxado e estimulado pelo próprio presidente da república, empurrou muitos outros cidadãos para a morte, mesmo quando já existia vacina. Esse ensaio é desse período. Vi conhecidos morrerem e elevaram a familia junto, especialmente os pais mais velhos, enquanto mimetizavam as grosseirias e estupidez do então presidente.\r\n\r\nEssa foto, representa esse medo, principalmente. Um medo difuso, da doÊnça, de morrer, mas principalmente dos conhecidos que tomaram partido desse presidente nefasto mesmo depois de tudo isso.\r\n\r\nNesse período eu tomei a decisão de me afastar de conhecidos e até familiares que se identificassem com o monstro que causou tudo isso. Essa foto, representa essa ruptura. Ela tem descrença, descrédito, nojo,aversão.\r\n\r\nEsse ensaio foi feito no dia 15  de agosto de 2021, na kitnet onde morava.', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `etapas`
--

CREATE TABLE `etapas` (
  `id` int UNSIGNED NOT NULL,
  `parent_id` int UNSIGNED DEFAULT NULL COMMENT 'ID da etapa anterior (Pai). Se NULL, é o inicio da caverna.',
  `ensaio_id` int UNSIGNED NOT NULL,
  `titulo` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo` enum('fotevista','entrevista','fineart','texto_livre') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'fotevista',
  `ordem` int NOT NULL DEFAULT '1',
  `descricao` text COLLATE utf8mb4_general_ci,
  `decisao_texto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Texto do botão que leva a esta etapa (Ex: Entrar na fenda escura)',
  `direcao` enum('frente','lado') COLLATE utf8mb4_general_ci DEFAULT 'frente',
  `audio_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Caminho para o arquivo de áudio da sala'
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
(21, 19, 6, 'A luz venceu', 'fineart', 1, '', 'Ver o próximo', 'lado', NULL),
(22, NULL, 7, 'Ajustanto a visão', 'texto_livre', 1, 'Depois da pandemia, o medo ainda era uma presença constante. Sair na rua ainda era uma aflição.', 'Próximo', 'frente', NULL),
(23, 22, 7, 'As visões vão se derretendo...', 'texto_livre', 1, 'Ter certeza no meio do medo não é uma estrutura rígida.', 'Visão escorregadia', 'frente', NULL),
(24, 23, 7, 'A luz dos pensamentos', 'fineart', 1, 'Tinha morrido 700 mil pessoas...', 'Luzes do desespero', 'lado', NULL),
(25, 24, 7, 'Comendo luzes', 'texto_livre', 1, 'Sozinho e isolado, o desejo de luz se materializa em fome de luz. Literalmente...', 'Comendo luz', 'lado', NULL),
(26, 25, 7, 'Sobrevivendo de luz? Não.', 'texto_livre', 1, 'A luz vem sempre de fora.', '', 'lado', NULL),
(27, 26, 7, 'Inanição', 'texto_livre', 1, 'A fome tinha voltado no meu pais... E a gente se escondendo em casa com medo de um virus...', 'A fome tinha votado...', 'lado', NULL),
(29, 23, 7, 'Ainda  havia escuridão', 'texto_livre', 1, 'Há uma escuridão intrínseca em cada um.', 'Continue', 'frente', NULL),
(30, 29, 7, 'Se perdendo no escuro', 'texto_livre', 1, 'Naqueles dias, parecia que em algum momento a escuridão ia pegar um de nós...', 'Continue...', 'frente', NULL),
(31, 30, 7, 'Respirando', 'texto_livre', 1, 'Eu sorvia um ar pesado.  Apenas para garantir que estava respirando.', 'Continue...', 'frente', 'audios/1771091956_7b01af64bad7968572f8.jpg'),
(32, 31, 7, 'A tampa', 'texto_livre', 1, 'Sempre tem uma tampa que nos serve... A nossa, naqueles dias se chamava esperança. E a esperança se chamava vacina.', 'Continue...', 'frente', NULL),
(33, 32, 7, 'O Demolidor', 'texto_livre', 1, 'Sem ver, o corpo adquire outras habilidades.', 'Continue', 'frente', NULL),
(34, 33, 7, 'A magia', 'texto_livre', 1, 'Um golpe de magia sera o que eu gostaria de ter naqueles dias... Para limpar certas figuras nefastas da face da terra... Mas a realidade não é ficção...', 'Continue...', 'frente', NULL),
(35, 34, 7, 'A sombra da pandemia', 'texto_livre', 1, 'A Sombra da pandemia continuou impressa. Não foi um impressão que passou. Mais de um milhão de famílias choraram por seus entes queridos. Mesmo que algunms rissem e outros negassem.', 'Continue...', 'frente', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens`
--

CREATE TABLE `itens` (
  `id` int UNSIGNED NOT NULL,
  `etapa_id` int UNSIGNED NOT NULL,
  `tipo` enum('foto','video','texto','citacao','audio') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'foto',
  `conteudo` text COLLATE utf8mb4_general_ci NOT NULL,
  `largura_orig` int DEFAULT NULL,
  `altura_orig` int DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `legenda` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `classe_css` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'col-md-4',
  `ordem` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens`
--

INSERT INTO `itens` (`id`, `etapa_id`, `tipo`, `conteudo`, `largura_orig`, `altura_orig`, `titulo`, `legenda`, `classe_css`, `ordem`) VALUES
(1, 1, 'texto', 'mARIA ESCRITORA GOASTQA DE ESCRREVER E E escreveui esse insgelso pedaç o de texto', NULL, NULL, NULL, 'Essa é uma foto de maria escrevendo', 'col-12', 2),
(2, 1, 'foto', 'Que foto linda de maria', NULL, NULL, NULL, 'Eu gostei disse ela', 'col-md-8', 1),
(3, 3, 'foto', 'O simbolo da beleza', NULL, NULL, NULL, 'tudo que a natureza criou.,', 'col-12', 1),
(5, 4, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768861056_eb0ac19e0df64d8c6b25.jpg', NULL, NULL, NULL, 'Olhar para a luz e...', 'col-md-4', 2),
(7, 4, 'citacao', 'A luz não é ciência exata... Mas arte também não é!', NULL, NULL, NULL, 'Jogando o poder da visão', 'col-md-6', 4),
(10, 5, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768864614_39ab0f1b16a2a7f27aa7.jpg', NULL, NULL, NULL, '', 'col-md-4', 2),
(11, 5, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768864707_07f11255270ef5636b26.jpg', NULL, NULL, NULL, 'A fome não acaba em vida...', 'col-md-4', 1),
(12, 5, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768864854_6616343379cf5d704e6e.jpg', NULL, NULL, NULL, 'A visão é uma questão de escolha?', 'col-md-4', 1),
(13, 6, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768865155_d90e1d54eb6f0ffbf008.jpg', NULL, NULL, NULL, 'A gente vai entrando em estados que não planejamos...', 'col-12', 1),
(14, 7, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768865327_ddcb578a8058890078be.jpg', NULL, NULL, NULL, 'E  quando a gente menos espera, aquele susto está ali... ', 'col-12', 1),
(15, 8, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768865564_33a0f38ab20d08674d40.jpg', NULL, NULL, NULL, 'O que um ensaio busca?', 'col-12', 1),
(16, 9, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768866644_406fb431fe6f6f339c02.jpg', NULL, NULL, NULL, 'A verdadeira nudez não mostra pele...', 'col-md-4', 1),
(17, 9, 'citacao', 'Estar nú é não ter as proteções que escondiam...', NULL, NULL, NULL, '', 'col-12', 2),
(18, 4, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768962147_d5b33038f1f6f741433f.jpg', NULL, NULL, NULL, '', 'col-md-4', 1),
(21, 4, 'foto', 'https://www.marcosantofoto.com.br/uploads/ensaios/1768963692_2183af9cd9b1a76d40a3.jpg', NULL, NULL, NULL, '', 'col-md-4', 3),
(22, 10, 'texto', 'Aqui o ensaio se enverdou pelo lado da angustia da modelo', NULL, NULL, NULL, 'Esse testo', 'col-md-6', 1),
(23, 11, 'foto', 'https://fineart.test/uploads/ensaios/1770581212_26295ace09e81b330ff3.jpg', NULL, NULL, NULL, 'O artista mordeu a cachorrinha', 'col-md-4', 1),
(24, 11, 'foto', 'https://fineart.test/uploads/ensaios/1770581234_e15dfa30abcf1808e4d8.jpg', NULL, NULL, NULL, 'Quis comer o flahs', 'col-md-4', 2),
(25, 11, 'foto', 'https://fineart.test/uploads/ensaios/1770581271_f76a3c3a5cc6ee7f7fec.jpg', NULL, NULL, NULL, 'Depois ficou com cara de bunda', 'col-md-4', 3),
(26, 13, 'foto', 'https://fineart.test/uploads/ensaios/1770582028_000ee3e87456e2d8e82d.jpg', NULL, NULL, NULL, 'Cara de louco', 'col-md-4', 1),
(27, 13, 'foto', 'https://fineart.test/uploads/ensaios/1770582044_f119258646ccaf569ff4.jpg', NULL, NULL, NULL, 'Pucha', 'col-md-4', 2),
(28, 13, 'foto', 'https://fineart.test/uploads/ensaios/1770582065_2e8c3f3421cdcd666733.jpg', NULL, NULL, NULL, 'zoio caidos', 'col-md-4', 3),
(29, 14, 'foto', 'https://fineart.test/uploads/ensaios/1770582462_af1a228b1af75ebda129.jpg', NULL, NULL, NULL, 'Pega a visao', 'col-md-6', 1),
(30, 14, 'foto', 'https://fineart.test/uploads/ensaios/1770582483_d13e3ec1540ba6073760.jpg', NULL, NULL, NULL, 'Enquadra', 'col-md-4', 2),
(31, 12, 'foto', 'https://fineart.test/uploads/ensaios/1770582615_23fd27dadbd5a30ea647.jpg', NULL, NULL, NULL, 'Voce por aqui?', 'col-12', 1),
(32, 15, 'foto', 'https://fineart.test/uploads/ensaios/1770583009_b414b07895c5c2c6e50c.jpg', NULL, NULL, NULL, 'A modelo queria essa foto no fundo da caverna...', 'col-12', 1),
(33, 16, 'foto', 'https://fineart.test/uploads/ensaios/1770820217_c63f05cec0408aac5e06.jpg', NULL, NULL, NULL, 'Vamos tomar um café e falar desse ensaio.', 'col-md-4', 1),
(34, 17, 'foto', 'https://fineart.test/uploads/ensaios/1770820532_9d611fd36f4388474d56.jpg', NULL, NULL, NULL, 'O que é flash portátil para você?', 'col-md-4', 1),
(35, 17, 'foto', 'https://fineart.test/uploads/ensaios/1770820578_4a0a54b43c8c85abffee.jpg', NULL, NULL, 'Comendo Luz - 02', 'O que é flash portátil para você?', 'col-md-4', 2),
(36, 17, 'foto', 'https://fineart.test/uploads/ensaios/1770820628_07b8aed1df5fa54d3cc2.jpg', NULL, NULL, NULL, 'É aquele flash que me permite fazewr coisas inusitadas...', 'col-md-4', 3),
(37, 18, 'foto', 'https://fineart.test/uploads/ensaios/1770821752_efb16a49e788b3aa8c5f.jpg', NULL, NULL, 'Comendo Luz - 01', 'Qual é a sua relação com a luz?', 'col-md-4', 1),
(38, 18, 'foto', 'https://fineart.test/uploads/ensaios/1770830595_fc0f4fe7057a53153ccd.jpg', NULL, NULL, 'Comendo Luz - 03', 'Luz não è inofensiva...', 'col-md-4', 2),
(39, 18, 'foto', 'https://fineart.test/uploads/ensaios/1770831357_5642fbf87ac17d1d6f7a.jpg', NULL, NULL, 'Comendo Luz - 02', 'Começou a ficar estranho...', 'col-md-4', 3),
(41, 19, 'foto', 'https://fineart.test/uploads/ensaios/1770836712_2ed9c739cbe1ead0a1eb.jpg', NULL, NULL, 'Luz alcançável', '', 'col-12', 1),
(42, 20, 'foto', 'https://fineart.test/uploads/ensaios/1770837095_955251937d08ccf8c1a1.jpg', NULL, NULL, '', 'Os bloqueios da visão', 'col-md-4', 1),
(43, 21, 'foto', 'https://fineart.test/uploads/ensaios/1770851705_572a638ba6e781342397.jpg', NULL, NULL, 'Luz na cabeça', '', 'col-12', 1),
(44, 22, 'citacao', 'No cenário político o Brasil parecia um navio sem rumo. Pior: parecia uma fragata cujo o capitão endoidou... A gente nem imaginava como era doido aquilo. ', NULL, NULL, 'Legenda', '', 'col-md-6', 2),
(45, 22, 'foto', 'ensaios/1771380278_e9b6e857edcb00d1dfc2.jpg', NULL, NULL, 'Desepero Controlado', 'O desespero tem um limite...', 'col-md-4', 1),
(46, 22, 'citacao', 'Foi o momento em que escolhi o que queria ver e ouvir... Porque tocar, abraçar, comemorar juntos a gente não podia. Estávamos presos. Nossos sonhos estavam presos. Nossos líderes estavam presos... ', NULL, NULL, 'Sobrevivendo', 'Sobrevivendo sem olhar tudo.', 'col-md-8', 3),
(47, 22, 'foto', 'ensaios/1771437727_85a3943bf235e94eb7c9.jpg', NULL, NULL, 'Cegueira seletiva', 'Cegueira seletiva.', 'col-md-4', 4),
(49, 24, 'foto', 'ensaios/1771437908_584ecbd5ef566201b75f.jpg', NULL, NULL, 'Luz do desespero', 'As notícias que chegavam pela tela não eram apaziguadoras.as...', 'col-12', 1),
(50, 25, 'foto', 'ensaios/1771438063_0011796832d77ddf4c34.jpg', NULL, NULL, 'Comendo luz 01', '', 'col-md-4', 1),
(51, 25, 'foto', 'ensaios/1771438661_c9babdb31b3cf5ec3892.jpg', NULL, NULL, 'Comendo luz 02', '', 'col-md-4', 2),
(52, 25, 'foto', 'ensaios/1771438747_801841b020fdd054b343.jpg', NULL, NULL, 'Comendo luz 03', '', 'col-md-4', 3),
(53, 26, 'foto', 'ensaios/1771438915_e1b16fb089d2836cd159.jpg', NULL, NULL, 'Comendo Luz - 04', '', 'col-md-4', 1),
(54, 26, 'foto', 'ensaios/1771438981_e66fbc771f0fa33e19e7.jpg', NULL, NULL, 'Comendo Luz - 05', '', 'col-md-4', 2),
(55, 26, 'foto', 'ensaios/1771439578_b356b161a26010e78f68.jpg', NULL, NULL, 'Comendo Luz - 06', '', 'col-md-4', 3),
(57, 27, 'foto', 'ensaios/1771440562_c421d5d7058559dff48f.jpg', NULL, NULL, 'Sorvendo a última gota', '', 'col-12', 1),
(58, 29, 'foto', 'ensaios/1771436009_014e1435e1267f0d8a7d.jpg', NULL, NULL, 'Por dentro, escuridão', '', 'col-md-6', 1),
(59, 29, 'citacao', 'Cada um tem sua escuridão interna...', NULL, NULL, '', '', 'col-md-4', 2),
(60, 30, 'foto', 'ensaios/1771436150_5e4708e8aeab5b224b65.jpg', NULL, NULL, 'Se perdendo no escuro', '', 'col-12', 1),
(61, 31, 'foto', 'ensaios/1771436267_3fb6910c949af0866e75.jpg', NULL, NULL, ' Puxando Fôlego', '', 'col-12', 1),
(63, 33, 'foto', 'ensaios/1771437331_e82a128f38597b2527fd.jpg', NULL, NULL, 'O Demolidor', '', 'col-12', 1),
(64, 34, 'foto', 'ensaios/1771437456_9647188f40e72a3386f4.jpg', NULL, NULL, 'Mestre dos magos', '', 'col-12', 1),
(66, 35, 'foto', 'ensaios/1771437515_2cacb7efbf63a6f1adae.jpg', NULL, NULL, 'Sombras', '', 'col-12', 1),
(70, 23, 'foto', 'ensaios/1771435754_bdfd51a2251f0518ae18.jpg', NULL, NULL, 'Visão derretendo', '', 'col-md-6', 1),
(72, 32, 'foto', 'ensaios/1771436996_6a42cbf6a871e92db514.jpg', NULL, NULL, 'A tampa', '', 'col-12', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
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
  `id` int NOT NULL,
  `ensaio_id` int NOT NULL COMMENT 'ID do Ensaio Geral',
  `item_id` int NOT NULL COMMENT 'ID da Obra Específica',
  `user_id` int NOT NULL COMMENT 'ID do Usuário Logado',
  `nome_contato` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meio_contato` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'E-mail principal',
  `telefone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'WhatsApp ou Telefone opcional',
  `mensagem` text COLLATE utf8mb4_unicode_ci,
  `observacoes_internas` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pendente','em_negociacao','vendido','arquivado') COLLATE utf8mb4_unicode_ci DEFAULT 'pendente',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL COMMENT 'Data de exclusão lógica (Soft Delete)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pedidos_aquisicao`
--

INSERT INTO `pedidos_aquisicao` (`id`, `ensaio_id`, `item_id`, `user_id`, `nome_contato`, `meio_contato`, `telefone`, `mensagem`, `observacoes_internas`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 6, 33, 1, 'Marcos Vieira Dos Santos', 'marcosantofoto@gmail.com', NULL, 'aswefdwe4', NULL, 'pendente', '2026-02-11 23:02:45', '2026-02-11 23:02:45', NULL),
(2, 6, 33, 1, 'marcosantofoto', 'marcosantofoto@gmail.com', '(11) 96432-2103', 'Olá. Tenho interesse nesta obra e gostaria de receber detalhes sobre valores e aquisição.', NULL, 'pendente', '2026-02-11 23:15:02', '2026-02-11 23:15:02', NULL),
(3, 6, 33, 1, 'marcosantofoto', 'marcosantofoto@gmail.com', '(11) 96432-2103', 'Olá. Tenho interesse nesta obra e gostaria de receber detalhes sobre valores e aquisição.', NULL, 'pendente', '2026-02-11 23:23:53', '2026-02-11 23:23:53', NULL),
(4, 6, 38, 1, 'marcosantofoto', 'marcosantofoto@gmail.com', '(11) 96432-2103', 'Olá. Tenho interesse nesta obra e gostaria de receber detalhes sobre valores e aquisição.', NULL, 'em_negociacao', '2026-02-11 23:26:46', '2026-02-11 23:50:59', NULL),
(5, 6, 33, 1, 'marcosantofoto', 'marcosantofoto@gmail.com', '(11) 95586-3244', 'Olá. Tenho interesse nesta obra e gostaria de receber detalhes sobre valores e aquisição.', NULL, 'pendente', '2026-02-12 14:31:30', '2026-02-12 14:31:30', NULL),
(6, 7, 48, 1, 'marcosantofoto', 'marcosantofoto@gmail.com', '11964322103', 'Olá. Tenho interesse nesta obra e gostaria de receber detalhes sobre valores e aquisição.', NULL, 'pendente', '2026-02-14 12:22:42', '2026-02-14 12:22:42', NULL),
(7, 7, 45, 1, 'marcosantofoto', 'marcosantofoto@gmail.com', '', 'Olá. Tenho interesse nesta obra e gostaria de receber detalhes.', NULL, 'pendente', '2026-02-17 16:35:28', '2026-02-17 16:35:28', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text COLLATE utf8mb4_general_ci,
  `type` varchar(31) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'string',
  `context` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_message` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'marcosantofoto', NULL, NULL, 1, '2026-03-12 11:36:45', '2026-01-18 09:11:15', '2026-01-18 09:11:15', NULL),
(2, 'maria', NULL, NULL, 1, NULL, '2026-01-18 09:40:02', '2026-01-18 09:40:02', NULL),
(3, 'marcosanto', NULL, NULL, 1, '2026-02-13 12:25:18', '2026-01-19 21:32:09', '2026-01-19 21:32:10', NULL),
(4, 'Vieira', NULL, NULL, 1, '2026-01-19 21:55:40', '2026-01-19 21:52:32', '2026-01-19 21:52:33', NULL),
(5, 'Julia', NULL, NULL, 1, '2026-02-14 23:18:27', '2026-02-14 21:35:08', '2026-02-14 21:35:08', NULL);

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
  ADD KEY `etapas_ensaio_id_foreign` (`ensaio_id`),
  ADD KEY `fk_etapas_parent` (`parent_id`);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `auth_identities`
--
ALTER TABLE `auth_identities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de tabela `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ensaios`
--
ALTER TABLE `ensaios`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `ensaio_paginas_extras`
--
ALTER TABLE `ensaio_paginas_extras`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `etapas`
--
ALTER TABLE `etapas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `itens`
--
ALTER TABLE `itens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `pedidos_aquisicao`
--
ALTER TABLE `pedidos_aquisicao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `etapas_ensaio_id_foreign` FOREIGN KEY (`ensaio_id`) REFERENCES `ensaios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_etapas_parent` FOREIGN KEY (`parent_id`) REFERENCES `etapas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `itens`
--
ALTER TABLE `itens`
  ADD CONSTRAINT `itens_etapa_id_foreign` FOREIGN KEY (`etapa_id`) REFERENCES `etapas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
