-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2026 at 03:19 PM
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
-- Database: `salon`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `preferred_date` date DEFAULT NULL,
  `preferred_time` time DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `responded_at` timestamp NULL DEFAULT NULL,
  `confirmation_email_sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `name`, `email`, `phone`, `service_type`, `preferred_date`, `preferred_time`, `event_location`, `message`, `status`, `responded_at`, `confirmation_email_sent_at`, `created_at`, `updated_at`) VALUES
(1, 'Frontend Test Client', 'frontend-test@example.com', '9999999999', 'Bridal Makeup', '2026-06-10', '14:30:00', NULL, 'Testing public appointment form', 'pending', NULL, NULL, '2026-05-29 05:25:37', '2026-05-29 05:25:37'),
(3, 'Deeshika Rastogi', 'deeshikarastogi.gms@gmail.com', '6787898896', 'Party Makeup', '2026-07-09', '16:00:00', NULL, 'Need a party Makeup for myself. It should be light', 'confirmed', '2026-05-29 07:09:04', NULL, '2026-05-29 07:08:43', '2026-05-29 07:09:04'),
(4, 'Shreya Rastogi', 'deeshikarastogi2810@gmail.com', '9634956096', 'Hair Styling', '2026-06-25', '17:00:00', NULL, 'Need a best open hairstyle for 3 person', 'confirmed', '2026-05-30 02:14:47', NULL, '2026-05-30 02:09:07', '2026-05-30 02:14:47'),
(5, 'Shreya Rastogi', 'deeshikarastogi2810@gmail.com', '9634956096', 'Party Makeup', '2026-06-26', '16:00:00', NULL, NULL, 'confirmed', '2026-05-30 02:23:05', NULL, '2026-05-30 02:22:18', '2026-05-30 02:23:05'),
(6, 'Deeshika Rastogi', 'deeshikarastogi.gms@gmail.com', '9634956096', 'Engagement Package', '2026-06-26', '18:40:00', NULL, NULL, 'confirmed', '2026-05-30 06:41:05', '2026-05-30 06:41:10', '2026-05-30 06:40:25', '2026-05-30 06:41:10'),
(7, 'Deeshika Rastogi', 'deeshikarastogi.gms@gmail.com', '9634956096', 'Party Makeup', '2026-05-27', '18:43:00', NULL, NULL, 'confirmed', '2026-05-30 07:44:37', '2026-05-30 07:44:42', '2026-05-30 07:44:00', '2026-05-30 07:44:42');

-- --------------------------------------------------------

--
-- Table structure for table `bridal_packages`
--

CREATE TABLE `bridal_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `full_description` longtext DEFAULT NULL,
  `includes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`includes`)),
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `suitable_for` text DEFAULT NULL,
  `important_notes` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `duration_hours` smallint(5) UNSIGNED DEFAULT NULL,
  `duration_text` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bridal_packages`
--

INSERT INTO `bridal_packages` (`id`, `name`, `slug`, `description`, `short_description`, `full_description`, `includes`, `features`, `suitable_for`, `important_notes`, `price`, `old_price`, `discount_price`, `duration_hours`, `duration_text`, `badge`, `image_path`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Classic Bridal Package', 'classic-bridal-package', 'A complete bridal look for the wedding day.', NULL, NULL, '[\"HD bridal makeup\",\"Hair styling\",\"Draping\",\"False lashes\"]', NULL, NULL, NULL, 22000.00, NULL, NULL, 4, NULL, NULL, NULL, 1, 1, 1, '2026-05-29 05:15:30', '2026-05-29 05:15:30'),
(2, 'Premium Bridal Package', 'premium-bridal-package', 'Premium bridal glam with extra detailing and extended finishing time.', NULL, NULL, '[\"Luxury bridal makeup\",\"Advanced hair styling\",\"Draping\",\"Jewellery setting\",\"Touch-up kit\"]', NULL, NULL, NULL, 32000.00, NULL, 29000.00, 5, NULL, NULL, NULL, 1, 1, 2, '2026-05-29 05:15:30', '2026-05-29 05:15:30'),
(3, 'Engagement Package', 'engagement-package', 'Soft glam makeup and hair for engagement or roka ceremonies.', NULL, NULL, '[\"HD makeup\",\"Hair styling\",\"Draping\"]', NULL, NULL, NULL, 12000.00, NULL, NULL, 3, NULL, NULL, NULL, 0, 1, 3, '2026-05-29 05:15:30', '2026-05-29 05:15:30');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_settings`
--

CREATE TABLE `contact_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `studio_name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `map_url` varchar(255) DEFAULT NULL,
  `map_embed_url` text DEFAULT NULL,
  `business_hours` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`business_hours`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_settings`
--

INSERT INTO `contact_settings` (`id`, `studio_name`, `phone`, `whatsapp`, `email`, `address`, `city`, `instagram_url`, `facebook_url`, `map_url`, `map_embed_url`, `business_hours`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Kharbanda Makeup Studio', '+91 98765 43210', '+91 98765 43210', 'hello@kharbandamakeupstudio.com', 'Kharbanda Makeup Studio, Main Market', 'Delhi', 'https://www.instagram.com/kharbandamakeupstudio', 'https://www.facebook.com/kharbandamakeupstudio', NULL, NULL, '{\"monday\":\"10:00 AM - 7:00 PM\",\"tuesday\":\"10:00 AM - 7:00 PM\",\"wednesday\":\"10:00 AM - 7:00 PM\",\"thursday\":\"10:00 AM - 7:00 PM\",\"friday\":\"10:00 AM - 7:00 PM\",\"saturday\":\"10:00 AM - 7:00 PM\",\"sunday\":\"By appointment\"}', 1, '2026-05-29 05:15:30', '2026-05-30 04:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `external_image_url` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `title`, `image_path`, `external_image_url`, `category`, `alt_text`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Royal Bridal Makeup Portfolio', 'gallery/IGzPxrCt4867GLkiGy2hVWdZ8a1oG8uEfHBl75RE.jpg', 'https://images.unsplash.com/photo-1595475884562-073c30d45670?auto=format&fit=crop&w=1000&q=85', 'bridal', 'Royal Bridal Makeup Portfolio', 1, 1, 1, '2026-05-29 05:15:30', '2026-05-29 06:23:23'),
(6, 'Gallery Image', 'gallery/N5c1jT2qScAm3ZOQjsIRFUeGI2bdivZRx58HBZFY.jpg', NULL, 'bridal', 'Kharbanda Makeup Studio bridal makeup portfolio', 0, 1, 5, '2026-05-29 06:51:29', '2026-05-29 06:51:29'),
(7, 'Gallery Image', 'gallery/xD72PjaSXMSFsqIAbEZatfHLniTffMYffPLYHl2U.jpg', NULL, 'bridal', 'Kharbanda Makeup Studio bridal makeup portfolio', 0, 1, 6, '2026-05-29 06:51:29', '2026-05-29 06:51:29'),
(8, 'Gallery Image', 'gallery/ciuelJIHdPl7TakTDjZBbD0Jb4CY9fQVyLous448.jpg', NULL, 'bridal', 'Kharbanda Makeup Studio bridal makeup portfolio', 0, 1, 7, '2026-05-29 06:51:29', '2026-05-29 06:51:29'),
(9, 'Gallery Image', NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTc_LM6KCF14iJS-I-ACVyRxWauzXMECizgew&s', 'bridal', 'Kharbanda Makeup Studio bridal makeup portfolio', 0, 1, 8, '2026-05-29 06:56:39', '2026-05-29 06:56:39'),
(13, 'Gallery Image', NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_btYSGbS0JPLtFyC-n1dakog4YGICoPsf5g&s', 'bridal', 'Kharbanda Makeup Studio bridal makeup portfolio', 0, 1, 9, '2026-05-30 05:00:49', '2026-05-30 05:00:49');

-- --------------------------------------------------------

--
-- Table structure for table `hero_slides`
--

CREATE TABLE `hero_slides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `badge_text` varchar(255) DEFAULT NULL,
  `main_heading` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `background_image_path` varchar(255) DEFAULT NULL,
  `primary_button_text` varchar(255) DEFAULT NULL,
  `primary_button_link` varchar(255) DEFAULT NULL,
  `secondary_button_text` varchar(255) DEFAULT NULL,
  `secondary_button_link` varchar(255) DEFAULT NULL,
  `stat_1_value` varchar(255) DEFAULT NULL,
  `stat_1_label` varchar(255) DEFAULT NULL,
  `stat_2_value` varchar(255) DEFAULT NULL,
  `stat_2_label` varchar(255) DEFAULT NULL,
  `stat_3_value` varchar(255) DEFAULT NULL,
  `stat_3_label` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hero_slides`
--

INSERT INTO `hero_slides` (`id`, `badge_text`, `main_heading`, `description`, `background_image_path`, `primary_button_text`, `primary_button_link`, `secondary_button_text`, `secondary_button_link`, `stat_1_value`, `stat_1_label`, `stat_2_value`, `stat_2_label`, `stat_3_value`, `stat_3_label`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'PREMIUM BEAUTY STUDIO', 'Where Beauty Meets Perfection', 'Kharbanda Makeup Studio creates luminous bridal looks, occasion glam and elevated beauty experiences with polished artistry and personal care.', 'hero-slides/CMrZTOkDa6HcVL5WiRWuBd7tDeeijWsKl6nCwW3N.jpg', 'Book Appointment', '#booking', 'Explore Services', '#services', '3+', 'Signature services', '5★', 'Client loved', '100%', 'Bridal focus', 1, 1, '2026-05-30 04:11:13', '2026-05-30 05:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_29_104255_create_bridal_packages_table', 2),
(5, '2026_05_29_104255_create_services_table', 2),
(6, '2026_05_29_104256_create_appointments_table', 2),
(7, '2026_05_29_104256_create_gallery_images_table', 2),
(8, '2026_05_29_104256_create_testimonials_table', 2),
(9, '2026_05_29_104257_create_contact_settings_table', 2),
(10, '2026_05_29_110519_add_cms_fields_to_existing_tables', 3),
(11, '2026_05_29_114425_add_external_image_url_to_gallery_images_table', 4),
(12, '2026_05_30_000000_create_hero_slides_table', 5),
(13, '2026_05_30_073000_add_confirmation_email_sent_at_to_appointments_table', 5),
(14, '2026_05_30_080000_add_is_admin_to_users_table', 6),
(15, '2026_05_30_100000_create_nav_menu_items_table', 7),
(16, '2026_05_30_163000_add_detail_fields_to_bridal_packages_table', 8),
(17, '2026_05_30_200000_add_detail_fields_to_services_table', 8),
(18, '2026_05_30_200100_create_service_content_tables', 8);

-- --------------------------------------------------------

--
-- Table structure for table `nav_menu_items`
--

CREATE TABLE `nav_menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `href` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `open_in_new_tab` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nav_menu_items`
--

INSERT INTO `nav_menu_items` (`id`, `label`, `href`, `sort_order`, `is_active`, `open_in_new_tab`, `created_at`, `updated_at`) VALUES
(1, 'Gallery', '/gallery', 1, 1, 0, '2026-05-30 05:15:51', '2026-05-30 05:15:51'),
(3, 'Contact', '#contact', 2, 1, 0, '2026-05-30 05:15:51', '2026-05-30 05:16:43');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `hero_image_path` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `full_description` text DEFAULT NULL,
  `starting_price` decimal(10,2) DEFAULT NULL,
  `duration_minutes` smallint(5) UNSIGNED DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `slug`, `hero_image_path`, `short_description`, `description`, `full_description`, `starting_price`, `duration_minutes`, `image_path`, `icon`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Bridal Makeup', 'bridal-makeup', NULL, NULL, 'Signature bridal makeup with skin prep, premium products, and a polished camera-ready finish.', NULL, 15000.00, 180, 'services/nbDmJcpnDkfttk2GT9AuayONz2myHmh8nwNuksis.jpg', NULL, 1, 1, 1, '2026-05-29 05:15:30', '2026-05-30 05:05:00'),
(2, 'Party Makeup', 'party-makeup', NULL, NULL, 'Elegant makeup for receptions, engagements, birthdays, and special occasions.', NULL, 4500.00, 90, 'services/KENSb4jpvEhLHrUvfZ7jU6WYw9hN55JyQ7jyLen5.jpg', NULL, 0, 1, 2, '2026-05-29 05:15:30', '2026-05-30 05:05:09'),
(3, 'Hair Styling', 'hair-styling', NULL, NULL, 'Classic and modern hair styling for bridal and event looks.', NULL, 2500.00, 60, 'services/Ze11sSCZ5tiiiNSSgWZav5sAqstloWOVWOGoKkNb.jpg', NULL, 0, 1, 3, '2026-05-29 05:15:30', '2026-05-30 05:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `service_faqs`
--

CREATE TABLE `service_faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_features`
--

CREATE TABLE `service_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `feature` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_gallery_images`
--

CREATE TABLE `service_gallery_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_products`
--

CREATE TABLE `service_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_steps`
--

CREATE TABLE `service_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('30V5gXmGaKk46KwLWSB9GcLdQLPyXwrJ8rqqsHVW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmx0cm1lc241bUk1RjRQVmxPQTdTdHVwMHRkbXpPT2NETGxpNlJMUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1780138285),
('AAqjQCPlnLpnzhedC6PezdxVs8F1Al8sBAtu3xEm', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic0lzWEc2M2tZYTFsYVFNU0syRkMxdXZlQ3ZoNUFsa2xPR1hQd3ozSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMDoiYXV0aC5sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1780146465),
('YpZT6gJVd7Ks9VlsKyza2hYiQWtzyCnnvYxpWVvd', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMkhnNHc5WTFkSlN6UTU4eFhqM3lnaTJtOFoxZjZqYlNmaDRvVWM4NyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hcHBvaW50bWVudHMvNyI7czo1OiJyb3V0ZSI7czoyMzoiYWRtaW4uYXBwb2ludG1lbnRzLnNob3ciO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1780146883);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_role` varchar(255) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `client_image_path` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `client_name`, `client_role`, `service_name`, `message`, `rating`, `client_image_path`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Aarushi Sharma', NULL, 'Bridal Makeup', 'The bridal look was exactly what I imagined. It stayed flawless through the entire ceremony.', 5, NULL, 1, 1, 1, '2026-05-29 05:15:30', '2026-05-29 05:15:30'),
(2, 'Neha Kapoor', NULL, 'Engagement Package', 'Beautiful soft glam and very professional service from start to finish.', 5, NULL, 0, 1, 2, '2026-05-29 05:15:30', '2026-05-29 05:15:30'),
(3, 'Simran Kaur', NULL, 'Party Makeup', 'Loved the final look. It felt natural, elegant, and photographed beautifully.', 5, NULL, 0, 1, 3, '2026-05-29 05:15:30', '2026-05-29 05:15:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Deeshika Rastogi', 'deeshikarastogi.gms+users@gmail.com', NULL, '$2y$12$NjERc8gkjEtUL1OXyG6/Bed/NUfwDwmmsSR1J2grb0j50pSGTsIZa', 0, NULL, '2026-05-30 01:15:58', '2026-05-30 01:15:58'),
(2, 'Shreya Rastogi', 'deeshikarastogi2810@gmail.com', NULL, '$2y$12$ONXp/34uiDE9lU.86A.hE.M6jTwKTu/LnC2Us26fPibE7nd8jVtDu', 0, NULL, '2026-05-30 02:04:50', '2026-05-30 02:04:50'),
(3, 'Deeshika Rastogi', 'deeshikarastogi.gms@gmail.com', NULL, '$2y$12$7kn9QCxU.fsjvUx9BTKfh.NOAjsMqLRndkoGoCTiwd4H0uyNoiLQq', 1, NULL, '2026-05-30 04:24:17', '2026-05-30 04:24:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bridal_packages`
--
ALTER TABLE `bridal_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bridal_packages_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `contact_settings`
--
ALTER TABLE `contact_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_slides`
--
ALTER TABLE `hero_slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nav_menu_items`
--
ALTER TABLE `nav_menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`);

--
-- Indexes for table `service_faqs`
--
ALTER TABLE `service_faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_faqs_service_id_foreign` (`service_id`);

--
-- Indexes for table `service_features`
--
ALTER TABLE `service_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_features_service_id_foreign` (`service_id`);

--
-- Indexes for table `service_gallery_images`
--
ALTER TABLE `service_gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_gallery_images_service_id_foreign` (`service_id`);

--
-- Indexes for table `service_products`
--
ALTER TABLE `service_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_products_service_id_foreign` (`service_id`);

--
-- Indexes for table `service_steps`
--
ALTER TABLE `service_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_steps_service_id_foreign` (`service_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bridal_packages`
--
ALTER TABLE `bridal_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_settings`
--
ALTER TABLE `contact_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `hero_slides`
--
ALTER TABLE `hero_slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `nav_menu_items`
--
ALTER TABLE `nav_menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_faqs`
--
ALTER TABLE `service_faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_features`
--
ALTER TABLE `service_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_gallery_images`
--
ALTER TABLE `service_gallery_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_products`
--
ALTER TABLE `service_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_steps`
--
ALTER TABLE `service_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `service_faqs`
--
ALTER TABLE `service_faqs`
  ADD CONSTRAINT `service_faqs_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_features`
--
ALTER TABLE `service_features`
  ADD CONSTRAINT `service_features_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_gallery_images`
--
ALTER TABLE `service_gallery_images`
  ADD CONSTRAINT `service_gallery_images_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_products`
--
ALTER TABLE `service_products`
  ADD CONSTRAINT `service_products_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_steps`
--
ALTER TABLE `service_steps`
  ADD CONSTRAINT `service_steps_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
