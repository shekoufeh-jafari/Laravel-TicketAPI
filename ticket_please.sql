-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 30, 2025 at 06:01 PM
-- Server version: 8.0.41-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticket_please`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_manager` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_manager`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mrs. Cecelia Schumm', 'ritchie.alexandrea@example.net', '2025-04-26 18:11:19', '$2y$12$t5nFnTAWI/1/atlcg4STgO8wEaTBzQsBqIbfMSOcEAHU8GXYIoI7q', 0, 'TffOjGymK3', '2025-04-26 18:11:20', '2025-04-26 18:11:20'),
(2, 'Mrs. Karianne Waelchi I', 'karine46@example.net', '2025-04-26 18:11:20', '$2y$12$t5nFnTAWI/1/atlcg4STgO8wEaTBzQsBqIbfMSOcEAHU8GXYIoI7q', 0, 'gzboU4DgQf', '2025-04-26 18:11:20', '2025-04-26 18:11:20'),
(3, 'Ewell Hills', 'whills@example.org', '2025-04-26 18:11:20', '$2y$12$t5nFnTAWI/1/atlcg4STgO8wEaTBzQsBqIbfMSOcEAHU8GXYIoI7q', 0, 'neAtSIfGrm', '2025-04-26 18:11:20', '2025-04-26 18:11:20'),
(4, 'Alejandra Turcotte', 'gino10@example.org', '2025-04-26 18:11:20', '$2y$12$t5nFnTAWI/1/atlcg4STgO8wEaTBzQsBqIbfMSOcEAHU8GXYIoI7q', 0, 'JEiTn9uyz1', '2025-04-26 18:11:20', '2025-04-26 18:11:20'),
(5, 'Dr. Armand Bogisich', 'berge.marc@example.org', '2025-04-26 18:11:20', '$2y$12$t5nFnTAWI/1/atlcg4STgO8wEaTBzQsBqIbfMSOcEAHU8GXYIoI7q', 0, '2chVxjwhLT', '2025-04-26 18:11:20', '2025-04-26 18:11:20'),
(6, 'Bernadette Luettgen', 'rice.tyrell@example.org', '2025-04-26 18:11:20', '$2y$12$t5nFnTAWI/1/atlcg4STgO8wEaTBzQsBqIbfMSOcEAHU8GXYIoI7q', 0, 'tYphpI27ah', '2025-04-26 18:11:20', '2025-04-26 18:11:20'),
(7, 'Prof. Ilene Parker', 'jacobs.daphnee@example.com', '2025-04-26 18:11:20', '$2y$12$t5nFnTAWI/1/atlcg4STgO8wEaTBzQsBqIbfMSOcEAHU8GXYIoI7q', 0, 'ucyPwSxDFn', '2025-04-26 18:11:20', '2025-04-26 18:11:20'),
(8, 'Mr. Jared Price DDS', 'gail55@example.net', '2025-04-26 18:11:20', '$2y$12$t5nFnTAWI/1/atlcg4STgO8wEaTBzQsBqIbfMSOcEAHU8GXYIoI7q', 0, 'PEMDYXKQPk', '2025-04-26 18:11:20', '2025-04-26 18:11:20'),
(9, 'Ariane Hegmann', 'tod.turcotte@example.net', '2025-04-26 18:11:20', '$2y$12$t5nFnTAWI/1/atlcg4STgO8wEaTBzQsBqIbfMSOcEAHU8GXYIoI7q', 0, 'DxFWhhuIze', '2025-04-26 18:11:20', '2025-04-26 18:11:20'),
(10, 'Alivia Volkman I', 'lon.wolff@example.org', '2025-04-26 18:11:20', '$2y$12$t5nFnTAWI/1/atlcg4STgO8wEaTBzQsBqIbfMSOcEAHU8GXYIoI7q', 0, 'EdZU3NAm9h', '2025-04-26 18:11:20', '2025-04-26 18:11:20'),
(11, 'The Manager', 'manager@manager.com', NULL, '$2y$12$vBCdwx.cmF.oMU2tiSGV2.OuV4/5KarwpRTn39RpPq5nsTDvu9Ggq', 1, NULL, '2025-04-26 18:11:20', '2025-04-26 18:11:20'),
(14, 'User', 'user@user.co', NULL, '$2y$12$YL65tEkvMMeCYXvc2BdSwuwH2adPBjn/leytr0zSQLc/Q.tmdZ6Hy', 1, NULL, '2025-04-27 10:37:49', '2025-04-27 12:02:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
