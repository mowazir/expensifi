-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 01:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expensify`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_type` enum('checking','savings','credit','cash') NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `user_id`, `account_name`, `account_type`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'savings', 'savings', 1, '2025-11-01 21:42:26', '2025-11-01 21:42:26'),
(2, 2, 'my finpay', 'credit', 1, '2025-11-01 21:42:26', '2025-11-01 21:42:26');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `login_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_password`, `login_date`) VALUES
(1, 'ivy', '$2y$10$reUMEuVrmXGJ/Gsq.ZituOncY9kG/uoSUiuHbkI.gOuuevQ.wJIzm', '2025-11-03 06:24:37'),
(2, 'ivy2', '$2y$12$0J/a3ScRql2L8EQzvS4Cqev7gGvCknt1ea6gsKZ3a6GXTeS77IyIW\n', '2025-11-03 06:25:46'),
(3, 'admin', '$2y$10$cNEHfdnUafqbGfoEtLnouOXZRoLlvR09U7a.m4cecfKluvzj8m6Qe', '2025-12-11 11:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `budget_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `budget_name` varchar(100) NOT NULL,
  `amount_limit` decimal(10,2) NOT NULL,
  `period_type` enum('monthly','annual') NOT NULL,
  `start_date` date NOT NULL,
  `is_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `end_date` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budgets`
--

INSERT INTO `budgets` (`budget_id`, `user_id`, `category_id`, `budget_name`, `amount_limit`, `period_type`, `start_date`, `is_active`, `end_date`, `created_at`) VALUES
(1, 2, 3, 'food spenidng', 6000.00, 'monthly', '2025-11-05', 'no', '2025-11-07', '2025-11-05 21:22:28'),
(2, 2, 6, 'laptop internet', 5000.00, 'monthly', '2025-11-06', 'yes', '2025-11-09', '2025-11-06 19:13:57'),
(3, 2, 13, 'Tfare', 10000.00, 'monthly', '2025-11-16', 'yes', '2025-11-21', '2025-11-16 18:13:00'),
(4, 3, 14, 'Tfare', 1212.00, 'monthly', '2025-12-18', 'no', '2025-12-26', '2025-12-11 12:11:49');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_type` enum('expense','income') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `user_id`, `category_name`, `category_type`, `created_at`) VALUES
(1, 2, 'my expense for groceries', 'expense', '2025-10-31 14:50:48'),
(2, 2, 'an income for myself', 'income', '2025-10-31 14:50:48'),
(3, 2, 'food', 'income', '2025-11-01 20:58:18'),
(4, 2, 'rent and new edit', 'expense', '2025-11-01 20:59:12'),
(5, 2, 'gig', 'income', '2025-11-01 21:07:35'),
(6, 2, 'new laptop🧑‍💻', 'expense', '2025-11-01 21:08:51'),
(7, 2, 'buy a course', 'expense', '2025-11-01 21:14:31'),
(8, 2, 'gift ', 'expense', '2025-11-01 21:15:26'),
(9, 2, 'bought a new phone 🤳', 'expense', '2025-11-01 21:20:56'),
(10, 1, 'new charger hoio', 'income', '2025-11-03 22:53:14'),
(11, 1, 'phone and internet', 'income', '2025-11-04 12:39:17'),
(12, 2, 'giga', 'income', '2025-11-04 12:41:22'),
(13, 2, 'logistics', 'expense', '2025-11-12 22:24:54'),
(14, 3, 'bought land', 'income', '2025-12-11 11:56:13');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `transaction_type` enum('expense','income','transfer') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_incurred` date NOT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `account_id`, `category_id`, `transaction_type`, `amount`, `date_incurred`, `memo`, `created_at`) VALUES
(10, 2, 1, 9, 'income', 200.00, '2025-11-06', 'another not yet', '2025-11-06 20:49:39'),
(11, 2, 1, NULL, 'transfer', 5000.00, '2025-11-06', 'Transfer Out to keep going', '2025-11-06 20:50:16'),
(12, 2, 2, NULL, 'transfer', 5000.00, '2025-11-06', 'Transfer In from keep going', '2025-11-06 20:50:16'),
(21, 2, 1, 8, 'expense', 4000.00, '2025-11-12', 'gifted react to practise today, wholesome', '2025-11-12 22:24:16'),
(22, 2, 1, 13, 'expense', 1500.00, '2025-11-12', 'today tfare after vat', '2025-11-12 22:25:48'),
(23, 2, 1, 2, 'income', 3000.00, '2025-11-12', 'new income for coming in', '2025-11-12 22:56:21'),
(25, 2, 2, NULL, 'transfer', 4000.00, '2025-11-12', 'laptop charger replaced', '2025-11-12 22:57:02'),
(27, 2, 1, NULL, 'transfer', 300.00, '2025-11-12', 'new gig test', '2025-11-12 22:58:12'),
(28, 2, 1, 8, 'income', 500.00, '2025-11-12', 'gift expense from transaction income today', '2025-11-12 23:01:08'),
(29, 2, 2, NULL, 'transfer', 9000.00, '2025-11-12', 'another income category transaction transfer!', '2025-11-12 23:02:49'),
(32, 2, 1, NULL, 'transfer', 4431.00, '2025-11-12', 'test income transfer', '2025-11-12 23:34:24'),
(33, 2, 1, 5, 'expense', 4000.00, '2025-11-12', 'test expense category income', '2025-11-12 23:43:13'),
(34, 2, 1, 5, 'income', 3000.00, '2025-11-12', 'test income catgeory incoem  ', '2025-11-12 23:44:06'),
(35, 2, 2, 1, 'expense', 900.00, '2025-11-16', 'bought beans as usual', '2025-11-16 18:39:27'),
(36, 2, 2, NULL, 'transfer', 500.00, '2025-11-16', 'new note transfer', '2025-11-16 18:40:45'),
(39, 2, 1, NULL, 'transfer', 590.00, '2025-11-16', 'test', '2025-11-16 18:47:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `bio` text DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `is_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `currency` varchar(3) DEFAULT 'USD',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `bio`, `password_hash`, `role`, `is_active`, `currency`, `created_at`, `updated_at`) VALUES
(1, 'another', 'test@gmail.com', NULL, '$2y$10$7B51Ulv5tCBNsKw3LwOVbe7mmv5LFXhxw5OHuDC4vUoHUY/cQrRHi', 'user', 'yes', 'NGN', '2025-10-26 13:15:48', '2025-12-10 18:45:08'),
(2, 'Ivy', 'ivy@gmail.com', 'I love savings so much', '$2y$10$Aov.wLQssKThcVbGaGNRz.HDzwlyc/DoEL4GYcEoy2oz.2nN0Lbyy', 'admin', 'yes', 'USD', '2025-10-27 20:28:12', '2025-11-16 18:49:25'),
(3, 'test', 'weber@gmail.com', NULL, '$2y$10$1INM5bvEzoNhbuFD48X0sOOFHLDF/NxiBMkap1oV8TR5XVDnVcKNS', 'user', 'yes', 'USD', '2025-12-10 18:14:02', '2025-12-10 18:14:02'),
(5, 'blockedtest', 'test2@gmail.com', NULL, '$2y$10$j.MLiZ5iOIVBSDmO5d9PjeNMPHOEokLY.21.oYbelMH8y1neaOmN.', 'user', 'no', 'USD', '2025-12-11 13:32:43', '2025-12-11 13:41:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`budget_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `budget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budgets_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
