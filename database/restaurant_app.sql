-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 28 jan. 2026 à 14:49
-- Version du serveur :  10.4.8-MariaDB
-- Version de PHP :  7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `restaurant_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `branches`
--

CREATE TABLE `branches` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `restaurant_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_line` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'XAF',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `branches`
--

INSERT INTO `branches` (`id`, `restaurant_id`, `name`, `address_line`, `city`, `country`, `phone`, `default_currency`, `is_active`, `created_at`, `updated_at`) VALUES
('d0170196-f865-11f0-ac5e-54ee75ccda61', '7b3b1dea-f865-11f0-ac5e-54ee75ccda61', 'Don Salvadore - Principal', 'Olembe', 'Milan', 'Cameroun', '+237600000000', 'XAF', 1, '2026-01-23 14:14:21', '2026-01-23 14:14:21');

-- --------------------------------------------------------

--
-- Structure de la table `dining_areas`
--

CREATE TABLE `dining_areas` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dining_areas`
--

INSERT INTO `dining_areas` (`id`, `branch_id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
('053029d4-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'Salle principale', 1, '2026-01-23 14:15:50', '2026-01-23 14:15:50'),
('0534da9d-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'Terrasse', 1, '2026-01-23 14:15:50', '2026-01-23 14:15:50');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menu_categories`
--

INSERT INTO `menu_categories` (`id`, `branch_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
('2d2d3b87-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'Pizzas', 1, 1, '2026-01-23 14:16:57', '2026-01-23 14:16:57', NULL),
('2d3bd81c-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'Pâtes', 2, 1, '2026-01-23 14:16:57', '2026-01-23 14:16:57', NULL),
('2d4dacd6-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'Boissons', 3, 1, '2026-01-23 14:16:57', '2026-01-23 14:16:57', NULL),
('2d5ce760-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'Desserts', 4, 1, '2026-01-23 14:16:57', '2026-01-23 14:16:57', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_23_133308_create_restaurants_table', 2),
(6, '2026_01_23_133727_create_branches_table', 2),
(7, '2026_01_23_133743_add_branch_fields_to_users_table', 2),
(8, '2026_01_23_133755_create_dining_areas_table', 2),
(9, '2026_01_23_133809_create_restaurant_tables_table', 2),
(10, '2026_01_23_133820_create_menu_categories_table', 2),
(11, '2026_01_23_133829_create_tax_rules_table', 2),
(12, '2026_01_23_133840_create_products_table', 2),
(13, '2026_01_23_133850_create_product_variants_table', 2),
(14, '2026_01_23_133901_create_option_groups_table', 2),
(15, '2026_01_23_133910_create_option_items_table', 2),
(16, '2026_01_23_133919_create_product_option_groups_table', 2),
(17, '2026_01_23_133927_create_orders_table', 2),
(18, '2026_01_23_133937_create_order_items_table', 2),
(19, '2026_01_23_133949_create_order_item_options_table', 2),
(20, '2026_01_23_133957_create_payment_methods_table', 2),
(21, '2026_01_23_134007_create_payments_table', 2),
(22, '2026_01_27_145910_create_roles_table', 3),
(23, '2026_01_27_150143_create_role_user_table', 3);

-- --------------------------------------------------------

--
-- Structure de la table `option_groups`
--

CREATE TABLE `option_groups` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_select` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `max_select` int(10) UNSIGNED NOT NULL DEFAULT 99,
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `option_groups`
--

INSERT INTO `option_groups` (`id`, `branch_id`, `name`, `min_select`, `max_select`, `is_required`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
('53ebff8b-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'Extras Pizza', 0, 3, 0, 1, '2026-01-23 14:18:02', '2026-01-23 14:18:02', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `option_items`
--

CREATE TABLE `option_items` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_group_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `option_items`
--

INSERT INTO `option_items` (`id`, `option_group_id`, `name`, `price`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
('6217e9b1-f866-11f0-ac5e-54ee75ccda61', '53ebff8b-f866-11f0-ac5e-54ee75ccda61', 'Extra fromage', '500.00', 1, '2026-01-23 14:18:26', '2026-01-23 14:18:26', NULL),
('621f7347-f866-11f0-ac5e-54ee75ccda61', '53ebff8b-f866-11f0-ac5e-54ee75ccda61', 'Champignons', '300.00', 1, '2026-01-23 14:18:26', '2026-01-23 14:18:26', NULL),
('621f75e8-f866-11f0-ac5e-54ee75ccda61', '53ebff8b-f866-11f0-ac5e-54ee75ccda61', 'Olives', '300.00', 1, '2026-01-23 14:18:26', '2026-01-23 14:18:26', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `restaurant_table_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opened_by_user_id` bigint(20) UNSIGNED NOT NULL,
  `closed_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `opened_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `closed_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'XAF',
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discounts_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `taxes_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `service_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `delivery_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `branch_id`, `order_number`, `channel`, `status`, `restaurant_table_id`, `customer_id`, `opened_by_user_id`, `closed_by_user_id`, `opened_at`, `closed_at`, `notes`, `cancellation_reason`, `currency`, `subtotal`, `discounts_total`, `taxes_total`, `service_fee`, `delivery_fee`, `grand_total`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0be65a4a-d4e4-4179-9310-77119611af44', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'DS-20260127-0001', 'TAKEAWAY', 'OPEN', NULL, NULL, 1, NULL, '2026-01-27 11:49:59', NULL, NULL, NULL, 'XAF', '4000.00', '0.00', '770.00', '0.00', '0.00', '4770.00', '2026-01-27 10:49:58', '2026-01-27 10:49:59', NULL),
('19e850cf-e489-4c34-9de3-e1e12e8676c3', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'DS-20260124-0001', 'TAKEAWAY', 'PAID', NULL, NULL, 1, 1, '2026-01-24 12:18:43', '2026-01-24 11:18:43', NULL, NULL, 'XAF', '8000.00', '0.00', '1540.00', '0.00', '0.00', '9540.00', '2026-01-24 08:59:01', '2026-01-24 11:18:43', NULL),
('61f8f275-f7f6-4dc1-bd09-4be105593c27', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'DS-20260127-0002', 'TAKEAWAY', 'OPEN', NULL, NULL, 1, NULL, '2026-01-27 12:13:07', NULL, NULL, NULL, 'XAF', '4000.00', '0.00', '770.00', '0.00', '0.00', '4770.00', '2026-01-27 11:13:06', '2026-01-27 11:13:07', NULL),
('9052e643-fb9b-4624-b330-ecb0d697cb7f', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'DS-20260127-0003', 'TAKEAWAY', 'PAID', NULL, NULL, 1, 1, '2026-01-27 14:31:54', '2026-01-27 13:31:53', NULL, NULL, 'XAF', '4000.00', '0.00', '770.00', '0.00', '0.00', '4770.00', '2026-01-27 13:29:18', '2026-01-27 13:31:53', NULL),
('c06eea96-5761-40bb-9536-9502e455bae4', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'DS-20260123-0001', 'TAKEAWAY', 'PAID', NULL, NULL, 1, 1, '2026-01-23 15:51:53', '2026-01-23 14:51:53', NULL, NULL, 'XAF', '8000.00', '0.00', '1540.00', '0.00', '0.00', '9540.00', '2026-01-23 14:36:12', '2026-01-23 14:51:53', NULL),
('d5a351e9-7673-4475-87fe-e5955f7415d3', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'DS-20260124-0002', 'TAKEAWAY', 'PAID', NULL, NULL, 1, 1, '2026-01-24 13:31:19', '2026-01-24 12:31:19', NULL, NULL, 'XAF', '8000.00', '0.00', '1540.00', '0.00', '0.00', '9540.00', '2026-01-24 12:29:55', '2026-01-24 12:31:19', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_variant_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name_snapshot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variant_name_snapshot` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price_snapshot` decimal(12,2) NOT NULL,
  `tax_rate_snapshot` decimal(6,3) NOT NULL DEFAULT 0.000,
  `qty` decimal(10,2) NOT NULL DEFAULT 1.00,
  `line_subtotal` decimal(12,2) NOT NULL,
  `line_tax` decimal(12,2) NOT NULL DEFAULT 0.00,
  `line_total` decimal(12,2) NOT NULL,
  `kitchen_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kitchen_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'QUEUED',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_variant_id`, `product_name_snapshot`, `variant_name_snapshot`, `unit_price_snapshot`, `tax_rate_snapshot`, `qty`, `line_subtotal`, `line_tax`, `line_total`, `kitchen_notes`, `kitchen_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('2a5d8aeb-f9a6-492a-876e-152cef63deb8', '9052e643-fb9b-4624-b330-ecb0d697cb7f', '38f2a435-f866-11f0-ac5e-54ee75ccda61', NULL, 'Pizza Margherita', NULL, '3500.00', '19.250', '1.00', '4000.00', '770.00', '4770.00', NULL, 'QUEUED', '2026-01-27 13:29:19', '2026-01-27 13:29:19', NULL),
('3a2f0114-eb0c-4f56-b39f-5fe5cac69d57', '61f8f275-f7f6-4dc1-bd09-4be105593c27', '38f2a435-f866-11f0-ac5e-54ee75ccda61', NULL, 'Pizza Margherita', NULL, '3500.00', '19.250', '1.00', '4000.00', '770.00', '4770.00', NULL, 'QUEUED', '2026-01-27 11:13:07', '2026-01-27 11:13:07', NULL),
('7743407e-a73a-4ec1-9c0b-96b14f2b958b', 'd5a351e9-7673-4475-87fe-e5955f7415d3', NULL, NULL, 'Pizza Margherita', NULL, '3500.00', '19.250', '2.00', '8000.00', '1540.00', '9540.00', NULL, 'SERVED', '2026-01-24 12:29:55', '2026-01-27 10:08:16', NULL),
('aa507db6-98fb-4390-aa8e-8588c09ea3ae', '0be65a4a-d4e4-4179-9310-77119611af44', NULL, NULL, 'Pizza Margherita', NULL, '3500.00', '19.250', '1.00', '4000.00', '770.00', '4770.00', NULL, 'IN_PROGRESS', '2026-01-27 10:49:59', '2026-01-27 12:25:18', NULL),
('c2ec4b4c-f4b3-462e-af5c-bc0d3bb0630b', 'c06eea96-5761-40bb-9536-9502e455bae4', NULL, NULL, 'Pizza Margherita', NULL, '3500.00', '19.250', '2.00', '8000.00', '1540.00', '9540.00', NULL, 'QUEUED', '2026-01-23 14:36:12', '2026-01-23 14:36:12', NULL),
('dc883ce5-3a28-48a3-b707-54eef4bd2ec8', '19e850cf-e489-4c34-9de3-e1e12e8676c3', NULL, NULL, 'Pizza Margherita', NULL, '3500.00', '19.250', '2.00', '8000.00', '1540.00', '9540.00', NULL, 'QUEUED', '2026-01-24 08:59:03', '2026-01-24 08:59:03', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `order_item_options`
--

CREATE TABLE `order_item_options` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_item_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_group_name_snapshot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_item_name_snapshot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_price_snapshot` decimal(12,2) NOT NULL DEFAULT 0.00,
  `qty` decimal(10,2) NOT NULL DEFAULT 1.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_item_options`
--

INSERT INTO `order_item_options` (`id`, `order_item_id`, `option_group_name_snapshot`, `option_item_name_snapshot`, `option_price_snapshot`, `qty`, `created_at`, `updated_at`) VALUES
('078f743e-952a-4b5c-b269-aaeac0d4f674', '7743407e-a73a-4ec1-9c0b-96b14f2b958b', 'Extras Pizza', 'Extra fromage', '500.00', '1.00', '2026-01-24 12:29:55', '2026-01-24 12:29:55'),
('325a4a2b-6013-49d5-9783-b8b7c251965a', '2a5d8aeb-f9a6-492a-876e-152cef63deb8', 'Extras Pizza', 'Extra fromage', '500.00', '1.00', '2026-01-27 13:29:19', '2026-01-27 13:29:19'),
('5709efd3-14d4-44e3-ad7d-f500e84f449f', 'dc883ce5-3a28-48a3-b707-54eef4bd2ec8', 'Extras Pizza', 'Extra fromage', '500.00', '1.00', '2026-01-24 08:59:03', '2026-01-24 08:59:03'),
('6c74ca5c-0e5e-4bef-ab8e-7ad3cc52db63', 'aa507db6-98fb-4390-aa8e-8588c09ea3ae', 'Extras Pizza', 'Extra fromage', '500.00', '1.00', '2026-01-27 10:49:59', '2026-01-27 10:49:59'),
('8c985faf-8315-4570-87cf-9ff3e6f01dd0', 'c2ec4b4c-f4b3-462e-af5c-bc0d3bb0630b', 'Extras Pizza', 'Extra fromage', '500.00', '1.00', '2026-01-23 14:36:12', '2026-01-23 14:36:12'),
('edf82cf9-9fc6-4b02-9d4e-6d3cea081c4c', '3a2f0114-eb0c-4f56-b39f-5fe5cac69d57', 'Extras Pizza', 'Extra fromage', '500.00', '1.00', '2026-01-27 11:13:07', '2026-01-27 11:13:07');

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'XAF',
  `provider_reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_by_customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taken_by_user_id` bigint(20) UNSIGNED NOT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `payments`
--

INSERT INTO `payments` (`id`, `branch_id`, `order_id`, `payment_method_id`, `status`, `amount`, `currency`, `provider_reference`, `paid_by_customer_name`, `taken_by_user_id`, `paid_at`, `created_at`, `updated_at`) VALUES
('18f39c3d-7aca-461b-86e8-4d30bc71f466', 'd0170196-f865-11f0-ac5e-54ee75ccda61', '9052e643-fb9b-4624-b330-ecb0d697cb7f', '7cd237b8-f866-11f0-ac5e-54ee75ccda61', 'SUCCESS', '2770.00', 'XAF', 'MTN-TEST-0001', NULL, 1, '2026-01-27 13:31:53', '2026-01-27 13:31:53', '2026-01-27 13:31:53'),
('2c84b2eb-a339-4227-8bfb-9e637c8fe484', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'd5a351e9-7673-4475-87fe-e5955f7415d3', '7cca553b-f866-11f0-ac5e-54ee75ccda61', 'SUCCESS', '2000.00', 'XAF', NULL, 'Client comptoir', 1, '2026-01-24 12:30:51', '2026-01-24 12:30:51', '2026-01-24 12:30:51'),
('561cab67-72de-47f1-9078-ded112d65c39', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'c06eea96-5761-40bb-9536-9502e455bae4', '7cca553b-f866-11f0-ac5e-54ee75ccda61', 'SUCCESS', '9540.00', 'XAF', NULL, NULL, 1, '2026-01-23 14:51:52', '2026-01-23 14:51:52', '2026-01-23 14:51:52'),
('60060e79-c9a1-4e89-ba68-6aa264468e76', 'd0170196-f865-11f0-ac5e-54ee75ccda61', '19e850cf-e489-4c34-9de3-e1e12e8676c3', '7cd237b8-f866-11f0-ac5e-54ee75ccda61', 'SUCCESS', '7540.00', 'XAF', 'MTN-TEST-0001', NULL, 1, '2026-01-24 11:18:43', '2026-01-24 11:18:43', '2026-01-24 11:18:43'),
('ab70664a-fa2f-4229-8399-2ea12192f21b', 'd0170196-f865-11f0-ac5e-54ee75ccda61', '9052e643-fb9b-4624-b330-ecb0d697cb7f', '7cca553b-f866-11f0-ac5e-54ee75ccda61', 'SUCCESS', '2000.00', 'XAF', NULL, NULL, 1, '2026-01-27 13:31:33', '2026-01-27 13:31:33', '2026-01-27 13:31:33'),
('cc393bcf-02cc-4fb1-9c66-2db78e200b95', 'd0170196-f865-11f0-ac5e-54ee75ccda61', '19e850cf-e489-4c34-9de3-e1e12e8676c3', '7cca553b-f866-11f0-ac5e-54ee75ccda61', 'SUCCESS', '2000.00', 'XAF', NULL, NULL, 1, '2026-01-24 11:18:04', '2026-01-24 11:18:04', '2026-01-24 11:18:04'),
('e3d1e923-c9ad-40e7-8de6-656b7f713ebe', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'd5a351e9-7673-4475-87fe-e5955f7415d3', '7cd237b8-f866-11f0-ac5e-54ee75ccda61', 'SUCCESS', '7540.00', 'XAF', 'MTN-TEST-0002', 'Client comptoir', 1, '2026-01-24 12:31:19', '2026-01-24 12:31:19', '2026-01-24 12:31:19'),
('f2473200-9c93-44e3-bdf8-7fce0b496b15', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'c06eea96-5761-40bb-9536-9502e455bae4', '7cca553b-f866-11f0-ac5e-54ee75ccda61', 'SUCCESS', '9540.00', 'XAF', NULL, NULL, 1, '2026-01-23 15:04:41', '2026-01-23 15:04:41', '2026-01-23 15:04:41');

-- --------------------------------------------------------

--
-- Structure de la table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `branch_id`, `type`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
('7cca553b-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'CASH', 'Espèces', 1, '2026-01-23 14:19:11', '2026-01-23 14:19:11'),
('7cd235bf-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'CARD', 'Carte bancaire', 1, '2026-01-23 14:19:11', '2026-01-23 14:19:11'),
('7cd237b8-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'MOBILE_MONEY', 'MTN MoMo', 1, '2026-01-23 14:19:11', '2026-01-23 14:19:11'),
('7cd238f0-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'MOBILE_MONEY', 'Orange Money', 1, '2026-01-23 14:19:11', '2026-01-23 14:19:11');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'postman', '1a996c124f0da21f4f825c4ac6c28ee23cad49c3e22b1096c6e93e60f2740db5', '[\"*\"]', NULL, '2026-01-27 14:38:37', '2026-01-27 14:38:37'),
(2, 'App\\Models\\User', 1, 'web', '3b8a926303fad5273ae259fe79563ec6ec4097e9d55f2669b60e9db67746cff0', '[\"*\"]', NULL, '2026-01-28 11:04:10', '2026-01-28 11:04:10'),
(3, 'App\\Models\\User', 1, 'web', '1b1745733a735a032e6b8fcfab4b584cc8a476370d96d22e20981af77d2e42f4', '[\"*\"]', NULL, '2026-01-28 11:15:32', '2026-01-28 11:15:32'),
(4, 'App\\Models\\User', 1, 'web', 'b3c59b57edbad2200a868359cee7b773ffdda52eaeba8fde3c20e2aaa178c835', '[\"*\"]', NULL, '2026-01-28 11:48:14', '2026-01-28 11:48:14');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_category_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rule_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_price` decimal(12,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `branch_id`, `menu_category_id`, `tax_rule_id`, `sku`, `name`, `description`, `base_price`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
('38f2a435-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', '2d2d3b87-f866-11f0-ac5e-54ee75ccda61', '22dff6f3-f866-11f0-ac5e-54ee75ccda61', NULL, 'Pizza Margherita', 'Tomate, mozzarella, basilic', '3500.00', 1, '2026-01-23 14:17:17', '2026-01-23 14:17:17', NULL),
('3905ee41-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', '2d4dacd6-f866-11f0-ac5e-54ee75ccda61', '22dff6f3-f866-11f0-ac5e-54ee75ccda61', NULL, 'Coca-Cola', '33cl', '1000.00', 1, '2026-01-23 14:17:17', '2026-01-23 14:17:17', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `product_option_groups`
--

CREATE TABLE `product_option_groups` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_group_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_option_groups`
--

INSERT INTO `product_option_groups` (`id`, `product_id`, `option_group_id`, `created_at`, `updated_at`) VALUES
('708ec32a-f866-11f0-ac5e-54ee75ccda61', '38f2a435-f866-11f0-ac5e-54ee75ccda61', '53ebff8b-f866-11f0-ac5e-54ee75ccda61', '2026-01-23 14:18:50', '2026-01-23 14:18:50');

-- --------------------------------------------------------

--
-- Structure de la table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_delta` decimal(12,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `name`, `price_delta`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
('44fe04d7-f866-11f0-ac5e-54ee75ccda61', '38f2a435-f866-11f0-ac5e-54ee75ccda61', 'Small', '0.00', 1, '2026-01-23 14:17:37', '2026-01-23 14:17:37', NULL),
('45072c47-f866-11f0-ac5e-54ee75ccda61', '38f2a435-f866-11f0-ac5e-54ee75ccda61', 'Medium', '1000.00', 1, '2026-01-23 14:17:37', '2026-01-23 14:17:37', NULL),
('45072eb2-f866-11f0-ac5e-54ee75ccda61', '38f2a435-f866-11f0-ac5e-54ee75ccda61', 'Large', '2000.00', 1, '2026-01-23 14:17:37', '2026-01-23 14:17:37', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `created_at`, `updated_at`) VALUES
('7b3b1dea-f865-11f0-ac5e-54ee75ccda61', 'Don Salvadore', '2026-01-23 14:11:59', '2026-01-23 14:11:59');

-- --------------------------------------------------------

--
-- Structure de la table `restaurant_tables`
--

CREATE TABLE `restaurant_tables` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dining_area_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(10) UNSIGNED NOT NULL DEFAULT 2,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FREE',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `restaurant_tables`
--

INSERT INTO `restaurant_tables` (`id`, `branch_id`, `dining_area_id`, `table_number`, `capacity`, `status`, `is_active`, `created_at`, `updated_at`) VALUES
('16ddf63f-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', '053029d4-f866-11f0-ac5e-54ee75ccda61', 'T1', 4, 'FREE', 1, '2026-01-23 14:16:20', '2026-01-23 14:16:20'),
('16e578df-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', '053029d4-f866-11f0-ac5e-54ee75ccda61', 'T2', 2, 'FREE', 1, '2026-01-23 14:16:20', '2026-01-23 14:16:20'),
('16e57b11-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', '053029d4-f866-11f0-ac5e-54ee75ccda61', 'T3', 6, 'FREE', 1, '2026-01-23 14:16:20', '2026-01-23 14:16:20'),
('16e57bff-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', '053029d4-f866-11f0-ac5e-54ee75ccda61', 'T4', 4, 'FREE', 1, '2026-01-23 14:16:20', '2026-01-23 14:16:20');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', '2026-01-27 14:16:22', '2026-01-27 14:16:22'),
(2, 'CAISSE', '2026-01-27 14:16:23', '2026-01-27 14:16:23'),
(3, 'CUISINE', '2026-01-27 14:16:23', '2026-01-27 14:16:23'),
(4, 'SERVEUR', '2026-01-27 14:16:23', '2026-01-27 14:16:23');

-- --------------------------------------------------------

--
-- Structure de la table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-01-27 14:16:23', '2026-01-27 14:16:23'),
(2, 4, '2026-01-27 14:37:39', '2026-01-27 14:37:39'),
(3, 3, '2026-01-27 14:37:38', '2026-01-27 14:37:38'),
(4, 2, '2026-01-27 14:37:38', '2026-01-27 14:37:38');

-- --------------------------------------------------------

--
-- Structure de la table `tax_rules`
--

CREATE TABLE `tax_rules` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_percent` decimal(6,3) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tax_rules`
--

INSERT INTO `tax_rules` (`id`, `branch_id`, `name`, `rate_percent`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
('22dff6f3-f866-11f0-ac5e-54ee75ccda61', 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'TVA 19.25%', '19.250', 1, '2026-01-23 14:16:40', '2026-01-23 14:16:40', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `branch_id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `is_active`, `remember_token`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'd0170196-f865-11f0-ac5e-54ee75ccda61', 'Admin1', 'admin@donsalvadore.local', NULL, NULL, '$2y$10$rt03Biz2Mb7VMpkFFRIV7O.7OM9vLrNtBAcY0LW9243OShvizH1Vm', 1, NULL, NULL, '2026-01-23 14:34:40', '2026-01-27 14:52:46'),
(2, NULL, 'Serveur 1', 'serveur@donsalvadore.local', NULL, NULL, '$2y$10$AQC5qNmjuabzLdhOG3Y3EOA5UTN.XMuBPvXirfwtJePMKlZrO79O.', 1, NULL, NULL, '2026-01-27 14:37:36', '2026-01-27 14:37:36'),
(3, NULL, 'Cuisine 1', 'cuisine@donsalvadore.local', NULL, NULL, '$2y$10$obQFwh6yynHUT.jla2BWkurBQF8yHJAm4WOpzziyDf4mA4RFZEp2i', 1, NULL, NULL, '2026-01-27 14:37:37', '2026-01-27 14:37:37'),
(4, NULL, 'Caisse 1', 'caisse@donsalvadore.local', NULL, NULL, '$2y$10$qLbCLgYx/koF81uRiFMka.sB7RmeGsgO7vw2dllVDm2T7nYkEH5vC', 1, NULL, NULL, '2026-01-27 14:37:37', '2026-01-27 14:37:37'),
(5, NULL, 'Weldon Renner', 'vincent49@example.com', NULL, '2026-01-28 12:37:32', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'DFJiYUK73a', NULL, '2026-01-28 12:37:32', '2026-01-28 12:37:32'),
(6, NULL, 'Ms. Gertrude Stamm', 'bianka.wisoky@example.com', NULL, '2026-01-28 12:37:32', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '2ezAfJxYdF', NULL, '2026-01-28 12:37:32', '2026-01-28 12:37:32'),
(7, NULL, 'Prof. Giuseppe Christiansen', 'jermain.klocko@example.com', NULL, '2026-01-28 12:37:32', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'jXBKOrnK2j', NULL, '2026-01-28 12:37:32', '2026-01-28 12:37:32'),
(8, NULL, 'Abdul Jaskolski', 'armando31@example.net', NULL, '2026-01-28 12:37:32', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'C9cDsgydSz', NULL, '2026-01-28 12:37:32', '2026-01-28 12:37:32'),
(9, NULL, 'Karelle Wolf Sr.', 'hleannon@example.com', NULL, '2026-01-28 12:37:32', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'Ru2dnrKULf', NULL, '2026-01-28 12:37:32', '2026-01-28 12:37:32');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_restaurant_id_name_unique` (`restaurant_id`,`name`),
  ADD KEY `branches_restaurant_id_index` (`restaurant_id`);

--
-- Index pour la table `dining_areas`
--
ALTER TABLE `dining_areas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dining_areas_branch_id_name_unique` (`branch_id`,`name`),
  ADD KEY `dining_areas_branch_id_index` (`branch_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_categories_branch_id_name_unique` (`branch_id`,`name`),
  ADD KEY `menu_categories_branch_id_index` (`branch_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `option_groups`
--
ALTER TABLE `option_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `option_groups_branch_id_name_unique` (`branch_id`,`name`),
  ADD KEY `option_groups_branch_id_index` (`branch_id`);

--
-- Index pour la table `option_items`
--
ALTER TABLE `option_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `option_items_option_group_id_name_unique` (`option_group_id`,`name`),
  ADD KEY `option_items_option_group_id_index` (`option_group_id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_branch_id_order_number_unique` (`branch_id`,`order_number`),
  ADD KEY `orders_opened_by_user_id_foreign` (`opened_by_user_id`),
  ADD KEY `orders_closed_by_user_id_foreign` (`closed_by_user_id`),
  ADD KEY `orders_branch_id_status_opened_at_index` (`branch_id`,`status`,`opened_at`),
  ADD KEY `orders_branch_id_channel_opened_at_index` (`branch_id`,`channel`,`opened_at`),
  ADD KEY `orders_restaurant_table_id_index` (`restaurant_table_id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_kitchen_status_index` (`order_id`,`kitchen_status`),
  ADD KEY `order_items_product_id_index` (`product_id`),
  ADD KEY `order_items_product_variant_id_index` (`product_variant_id`);

--
-- Index pour la table `order_item_options`
--
ALTER TABLE `order_item_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_options_order_item_id_index` (`order_item_id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_taken_by_user_id_foreign` (`taken_by_user_id`),
  ADD KEY `payments_order_id_status_index` (`order_id`,`status`),
  ADD KEY `payments_branch_id_paid_at_index` (`branch_id`,`paid_at`),
  ADD KEY `payments_payment_method_id_index` (`payment_method_id`),
  ADD KEY `payments_provider_reference_index` (`provider_reference`);

--
-- Index pour la table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_branch_id_name_unique` (`branch_id`,`name`),
  ADD KEY `payment_methods_branch_id_index` (`branch_id`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_branch_id_name_unique` (`branch_id`,`name`),
  ADD KEY `products_branch_id_menu_category_id_index` (`branch_id`,`menu_category_id`),
  ADD KEY `products_tax_rule_id_index` (`tax_rule_id`),
  ADD KEY `products_sku_index` (`sku`),
  ADD KEY `products_menu_category_id_foreign` (`menu_category_id`);

--
-- Index pour la table `product_option_groups`
--
ALTER TABLE `product_option_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_option_groups_product_id_option_group_id_unique` (`product_id`,`option_group_id`),
  ADD KEY `product_option_groups_product_id_index` (`product_id`),
  ADD KEY `product_option_groups_option_group_id_index` (`option_group_id`);

--
-- Index pour la table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_product_id_name_unique` (`product_id`,`name`),
  ADD KEY `product_variants_product_id_index` (`product_id`);

--
-- Index pour la table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `restaurants_name_unique` (`name`);

--
-- Index pour la table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `restaurant_tables_branch_id_table_number_unique` (`branch_id`,`table_number`),
  ADD KEY `restaurant_tables_branch_id_index` (`branch_id`),
  ADD KEY `restaurant_tables_dining_area_id_index` (`dining_area_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Index pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Index pour la table `tax_rules`
--
ALTER TABLE `tax_rules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tax_rules_branch_id_name_unique` (`branch_id`,`name`),
  ADD KEY `tax_rules_branch_id_index` (`branch_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_branch_id_index` (`branch_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`);

--
-- Contraintes pour la table `dining_areas`
--
ALTER TABLE `dining_areas`
  ADD CONSTRAINT `dining_areas_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD CONSTRAINT `menu_categories_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `option_groups`
--
ALTER TABLE `option_groups`
  ADD CONSTRAINT `option_groups_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `option_items`
--
ALTER TABLE `option_items`
  ADD CONSTRAINT `option_items_option_group_id_foreign` FOREIGN KEY (`option_group_id`) REFERENCES `option_groups` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_closed_by_user_id_foreign` FOREIGN KEY (`closed_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_opened_by_user_id_foreign` FOREIGN KEY (`opened_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_restaurant_table_id_foreign` FOREIGN KEY (`restaurant_table_id`) REFERENCES `restaurant_tables` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `order_item_options`
--
ALTER TABLE `order_item_options`
  ADD CONSTRAINT `order_item_options_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `payments_taken_by_user_id_foreign` FOREIGN KEY (`taken_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_menu_category_id_foreign` FOREIGN KEY (`menu_category_id`) REFERENCES `menu_categories` (`id`),
  ADD CONSTRAINT `products_tax_rule_id_foreign` FOREIGN KEY (`tax_rule_id`) REFERENCES `tax_rules` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `product_option_groups`
--
ALTER TABLE `product_option_groups`
  ADD CONSTRAINT `product_option_groups_option_group_id_foreign` FOREIGN KEY (`option_group_id`) REFERENCES `option_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_option_groups_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  ADD CONSTRAINT `restaurant_tables_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `restaurant_tables_dining_area_id_foreign` FOREIGN KEY (`dining_area_id`) REFERENCES `dining_areas` (`id`);

--
-- Contraintes pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tax_rules`
--
ALTER TABLE `tax_rules`
  ADD CONSTRAINT `tax_rules_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
