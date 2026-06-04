-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2026 at 11:54 AM
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
-- Database: `rasa_rekomendasi`
--

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `color`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Masakan Indonesia', 'masakan-indonesia', '🍛', '#FF6B35', NULL, 1, '2026-06-01 05:43:51', '2026-06-01 05:43:51', NULL),
(2, 'Masakan Asia', 'masakan-asia', '🍜', '#E63946', NULL, 1, '2026-06-01 05:43:51', '2026-06-01 05:43:51', NULL),
(3, 'Masakan Barat', 'masakan-barat', '🍝', '#457B9D', NULL, 1, '2026-06-01 05:43:51', '2026-06-01 05:43:51', NULL),
(4, 'Makanan Sehat', 'makanan-sehat', '🥗', '#2D6A4F', NULL, 1, '2026-06-01 05:43:51', '2026-06-01 05:43:51', NULL),
(5, 'Dessert & Kue', 'dessert-kue', '🍰', '#C77DFF', NULL, 1, '2026-06-01 05:43:51', '2026-06-01 05:43:51', NULL),
(6, 'Minuman', 'minuman', '🥤', '#48CAE4', NULL, 1, '2026-06-01 05:43:51', '2026-06-01 05:43:51', NULL),
(7, 'Sarapan', 'sarapan', '🍳', '#F4A261', NULL, 1, '2026-06-01 05:43:51', '2026-06-01 05:43:51', NULL),
(8, 'Makanan Bayi', 'makanan-bayi', '🍼', '#A8DADC', NULL, 1, '2026-06-01 05:43:51', '2026-06-01 05:43:51', NULL),
(9, 'Vegetarian & Vegan', 'vegetarian-vegan', '🥦', '#52B788', NULL, 1, '2026-06-01 05:43:51', '2026-06-01 05:43:51', NULL),
(10, 'Seafood', 'seafood', '🦐', '#0096C7', NULL, 1, '2026-06-01 05:43:51', '2026-06-01 05:43:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chef_schedules`
--

CREATE TABLE `chef_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chef_id` bigint(20) UNSIGNED NOT NULL,
  `available_date` date NOT NULL,
  `available_time_start` time NOT NULL,
  `available_time_end` time NOT NULL,
  `status` enum('available','booked','cancelled') NOT NULL DEFAULT 'available',
  `notes` text DEFAULT NULL,
  `max_bookings` int(11) NOT NULL DEFAULT 1,
  `current_bookings` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chef_schedules`
--

INSERT INTO `chef_schedules` (`id`, `chef_id`, `available_date`, `available_time_start`, `available_time_end`, `status`, `notes`, `max_bookings`, `current_bookings`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '2026-06-02', '09:00:00', '10:00:00', 'booked', NULL, 1, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(2, 2, '2026-06-02', '14:00:00', '15:00:00', 'available', NULL, 1, 0, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(3, 2, '2026-06-04', '10:00:00', '11:00:00', 'available', NULL, 1, 0, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(4, 2, '2026-06-06', '09:00:00', '10:00:00', 'available', NULL, 1, 0, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(5, 2, '2026-06-08', '15:00:00', '16:00:00', 'available', NULL, 1, 0, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(6, 3, '2026-06-03', '10:00:00', '11:00:00', 'available', NULL, 1, 0, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(7, 3, '2026-06-05', '13:00:00', '14:00:00', 'available', NULL, 1, 0, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(8, 3, '2026-06-07', '09:00:00', '10:00:00', 'available', NULL, 1, 0, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments_ratings`
--

CREATE TABLE `comments_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL COMMENT '1-5 stars',
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments_ratings`
--

INSERT INTO `comments_ratings` (`id`, `user_id`, `recipe_id`, `comment`, `rating`, `is_approved`, `approved_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 1, 'Rasanya autentik banget! Persis seperti rendang buatan nenek. Wajib coba!', 5, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(2, 6, 1, 'Langkah-langkahnya jelas dan hasilnya sempurna. Saya pakai daging sapi wagyu, makin juara!', 5, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(3, 7, 2, 'Simpel tapi enak. Cocok untuk makan malam cepat. Saya tambah sedikit terasi.', 4, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(4, 5, 2, 'Ini jadi menu andalan saya sekarang! Hemat waktu dan tetap lezat.', 5, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(5, 8, 4, 'Pedasnya pas, gurihnya mantap. Udangnya segar. Recommended!', 4, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(6, 9, 4, 'Saus padangnya kental dan kaya rasa. Lebih enak dari restoran!', 5, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(7, 7, 6, 'Super healthy dan instagrammable! Saya buat setiap pagi sekarang.', 5, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(8, 5, 6, 'Segar dan mengenyangkan. Warnanya cantik. Tapi butuh freezer untuk pisang bekunya.', 4, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(9, 11, 7, 'Mantap sih, Creammy banget', 5, 1, NULL, '2026-06-02 02:20:59', '2026-06-02 02:37:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `chef_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','confirmed','ongoing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `topic` text DEFAULT NULL,
  `chef_notes` text DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `ended_at` timestamp NULL DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `user_rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `user_feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `user_id`, `chef_id`, `schedule_id`, `status`, `topic`, `chef_notes`, `started_at`, `ended_at`, `duration_minutes`, `user_rating`, `user_feedback`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 6, 2, 1, 'completed', 'Cara membuat rendang agar empuk dan tidak pahit', NULL, '2026-05-30 02:00:00', '2026-05-30 02:45:00', 45, 5, 'Chef Rina sangat membantu dan sabar menjelaskan. Rendang saya jadi sukses!', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL);

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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consultation_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `sender_role` enum('user','chef') NOT NULL,
  `body` text NOT NULL,
  `type` enum('text','image','file','system') NOT NULL DEFAULT 'text',
  `attachment_url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `consultation_id`, `sender_id`, `sender_role`, `body`, `type`, `attachment_url`, `is_read`, `read_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 6, 'user', 'Halo Chef Rina! Saya mau tanya soal rendang yang tidak empuk.', 'text', NULL, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(2, 1, 2, 'chef', 'Halo Budi! Silakan, ceritakan prosesnya. Sudah berapa lama memasaknya?', 'text', NULL, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(3, 1, 6, 'user', 'Saya masak sekitar 2 jam tapi masih alot.', 'text', NULL, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(4, 1, 2, 'chef', 'Rendang butuh minimal 3-4 jam dengan api kecil. Kuncinya sabar! Gunakan daging bagian sengkel untuk hasil terbaik.', 'text', NULL, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(5, 1, 6, 'user', 'Oh begitu! Terima kasih Chef, saya coba lagi!', 'text', NULL, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(6, 1, 2, 'chef', 'Sama-sama! Semangat ya. Kalau ada pertanyaan lagi, jangan ragu untuk konsultasi lagi. 😊', 'text', NULL, 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(7, 1, 2, 'chef', 'tes', 'text', NULL, 0, NULL, '2026-06-02 02:08:18', '2026-06-02 02:08:18', NULL);

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
(1, '2024_01_01_000001_create_users_table', 1),
(2, '2024_01_01_000002_create_categories_table', 1),
(3, '2024_01_01_000003_create_recipes_table', 1),
(4, '2024_01_01_000004_create_preferences_table', 1),
(5, '2024_01_01_000005_create_comments_ratings_table', 1),
(6, '2024_01_01_000006_create_vip_packages_table', 1),
(7, '2024_01_01_000007_create_transactions_table', 1),
(8, '2024_01_01_000008_create_chef_schedules_table', 1),
(9, '2024_01_01_000009_create_consultations_table', 1),
(10, '2024_01_01_000010_create_messages_table', 1),
(11, '2024_01_01_000011_create_supporting_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `preferred_category_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`preferred_category_ids`)),
  `allergies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allergies`)),
  `available_ingredients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`available_ingredients`)),
  `cooking_time_limit` int(10) UNSIGNED NOT NULL DEFAULT 60,
  `preferred_difficulty` enum('easy','medium','hard','any') NOT NULL DEFAULT 'any',
  `calorie_limit` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`id`, `user_id`, `preferred_category_ids`, `allergies`, `available_ingredients`, `cooking_time_limit`, `preferred_difficulty`, `calorie_limit`, `created_at`, `updated_at`) VALUES
(1, 5, '[1,4]', '[\"seafood\",\"nuts\"]', '[\"ayam\",\"bawang\",\"tomat\",\"nasi\"]', 60, 'easy', 400, '2026-06-01 05:43:53', '2026-06-01 05:43:53'),
(2, 6, '[1,2,10]', '[]', '[\"daging\",\"bawang\",\"cabai\",\"santan\"]', 120, 'medium', NULL, '2026-06-01 05:43:53', '2026-06-01 05:43:53'),
(3, 7, '[4,5,9]', '[\"gluten\",\"dairy\"]', '[\"pisang\",\"mangga\",\"sayuran\",\"tahu\",\"tempe\"]', 45, 'any', 300, '2026-06-01 05:43:53', '2026-06-01 05:43:53');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chef_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ingredients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`ingredients`)),
  `cooking_steps` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`cooking_steps`)),
  `prep_time` int(10) UNSIGNED NOT NULL COMMENT 'Minutes',
  `cook_time` int(10) UNSIGNED NOT NULL COMMENT 'Minutes',
  `difficulty` enum('easy','medium','hard') NOT NULL DEFAULT 'medium',
  `calories` int(10) UNSIGNED DEFAULT NULL,
  `servings` int(10) UNSIGNED NOT NULL DEFAULT 2,
  `image` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL COMMENT 'VIP-only video tutorial URL',
  `is_vip_content` tinyint(1) NOT NULL DEFAULT 0,
  `allergens` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allergens`)),
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'published',
  `rating_avg` decimal(3,2) NOT NULL DEFAULT 0.00,
  `rating_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `view_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `chef_id`, `category_id`, `title`, `slug`, `description`, `ingredients`, `cooking_steps`, `prep_time`, `cook_time`, `difficulty`, `calories`, `servings`, `image`, `video_url`, `is_vip_content`, `allergens`, `status`, `rating_avg`, `rating_count`, `view_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 'Rendang Daging Sapi Padang', 'rendang-daging-sapi-padang', 'Rendang adalah masakan khas Minangkabau yang kaya rempah. Daging sapi dimasak perlahan dengan santan dan bumbu rempah hingga mengering dan berwarna cokelat kehitaman.', '[{\"name\":\"Daging sapi\",\"amount\":\"1\",\"unit\":\"kg\"},{\"name\":\"Santan kelapa\",\"amount\":\"800\",\"unit\":\"ml\"},{\"name\":\"Bawang merah\",\"amount\":\"15\",\"unit\":\"siung\"},{\"name\":\"Bawang putih\",\"amount\":\"8\",\"unit\":\"siung\"},{\"name\":\"Cabai merah keriting\",\"amount\":\"20\",\"unit\":\"buah\"},{\"name\":\"Lengkuas\",\"amount\":\"3\",\"unit\":\"cm\"},{\"name\":\"Serai\",\"amount\":\"3\",\"unit\":\"batang\"},{\"name\":\"Daun salam\",\"amount\":\"5\",\"unit\":\"lembar\"},{\"name\":\"Kunyit\",\"amount\":\"2\",\"unit\":\"cm\"},{\"name\":\"Garam\",\"amount\":\"2\",\"unit\":\"sdt\"}]', '[{\"step\":1,\"instruction\":\"Haluskan bawang merah, bawang putih, cabai, lengkuas, dan kunyit.\"},{\"step\":2,\"instruction\":\"Tumis bumbu halus bersama serai dan daun salam hingga harum.\"},{\"step\":3,\"instruction\":\"Masukkan daging sapi, aduk hingga berubah warna.\"},{\"step\":4,\"instruction\":\"Tuang santan, masak dengan api sedang sambil terus diaduk.\"},{\"step\":5,\"instruction\":\"Kecilkan api, masak selama 3-4 jam hingga santan mengering dan rendang berwarna cokelat.\"},{\"step\":6,\"instruction\":\"Koreksi rasa, sajikan dengan nasi putih hangat.\"}]', 30, 240, 'hard', 450, 6, NULL, 'https://www.youtube.com/embed/DMcFqtm1lfY', 0, '[]', 'published', 5.00, 2, 0, '2026-06-01 05:43:53', '2026-06-02 00:25:02', NULL),
(2, 2, 1, 'Nasi Goreng Kampung Spesial', 'nasi-goreng-kampung-spesial', 'Nasi goreng dengan bumbu kampung sederhana namun penuh cita rasa. Cocok untuk sarapan pagi yang cepat dan lezat.', '[{\"name\":\"Nasi putih\",\"amount\":\"3\",\"unit\":\"piring\"},{\"name\":\"Telur ayam\",\"amount\":\"2\",\"unit\":\"butir\"},{\"name\":\"Bawang merah\",\"amount\":\"5\",\"unit\":\"siung\"},{\"name\":\"Bawang putih\",\"amount\":\"3\",\"unit\":\"siung\"},{\"name\":\"Cabai rawit\",\"amount\":\"5\",\"unit\":\"buah\"},{\"name\":\"Kecap manis\",\"amount\":\"2\",\"unit\":\"sdm\"},{\"name\":\"Garam & merica\",\"amount\":\"secukupnya\",\"unit\":\"\"},{\"name\":\"Minyak goreng\",\"amount\":\"3\",\"unit\":\"sdm\"}]', '[{\"step\":1,\"instruction\":\"Haluskan bawang merah, bawang putih, and cabai rawit.\"},{\"step\":2,\"instruction\":\"Panaskan minyak, tumis bumbu halus hingga harum dan matang.\"},{\"step\":3,\"instruction\":\"Masukkan telur, orak-arik hingga setengah matang.\"},{\"step\":4,\"instruction\":\"Masukkan nasi, aduk rata dengan bumbu.\"},{\"step\":5,\"instruction\":\"Tambahkan kecap manis, garam, dan merica. Aduk rata.\"},{\"step\":6,\"instruction\":\"Sajikan dengan kerupuk, acar, dan irisan timun.\"}]', 0, 9, 'easy', 380, 2, NULL, 'https://www.youtube.com/watch?v=W1zb_ugYlu8', 0, '[\"eggs\"]', 'published', 4.50, 2, 0, '2026-06-01 05:43:53', '2026-06-02 02:03:56', NULL),
(3, 3, 2, 'Ramen Tonkotsu Homemade', 'ramen-tonkotsu-homemade', 'Ramen kuah tonkotsu dengan kaldu tulang babi yang dimasak selama 12 jam hingga creamy dan kaya umami. Versi premium dengan video tutorial eksklusif.', '[{\"name\":\"Mie ramen segar\",\"amount\":\"400\",\"unit\":\"gram\"},{\"name\":\"Tulang babi\",\"amount\":\"1\",\"unit\":\"kg\"},{\"name\":\"Telur rebus\",\"amount\":\"4\",\"unit\":\"butir\"},{\"name\":\"Chashu (daging babi gulung)\",\"amount\":\"200\",\"unit\":\"gram\"},{\"name\":\"Nori (rumput laut)\",\"amount\":\"4\",\"unit\":\"lembar\"},{\"name\":\"Bawang daun\",\"amount\":\"2\",\"unit\":\"batang\"},{\"name\":\"Tare (saus dasar)\",\"amount\":\"4\",\"unit\":\"sdm\"}]', '[{\"step\":1,\"instruction\":\"Rebus tulang babi selama 12 jam dengan api kecil hingga kaldu menjadi putih dan creamy.\"},{\"step\":2,\"instruction\":\"Buat tare dari kecap, mirin, dan sake.\"},{\"step\":3,\"instruction\":\"Rebus mie sesuai petunjuk, tiriskan.\"},{\"step\":4,\"instruction\":\"Siapkan mangkuk, tuang tare dan kaldu tonkotsu panas.\"},{\"step\":5,\"instruction\":\"Tata mie, telur, chashu, nori, dan bawang daun di atasnya.\"}]', 0, 18, 'hard', 650, 4, NULL, 'https://www.youtube.com/watch?v=uPqzY8rZLZM', 1, '[\"gluten\",\"eggs\"]', 'published', 0.00, 0, 0, '2026-06-01 05:43:53', '2026-06-02 02:03:56', NULL),
(4, 3, 10, 'Udang Saus Padang Pedas', 'udang-saus-padang-pedas', 'Udang segar dimasak dengan saus padang yang pedas dan gurih. Sajian seafood premium yang mudah dibuat di rumah.', '[{\"name\":\"Udang tiger\",\"amount\":\"500\",\"unit\":\"gram\"},{\"name\":\"Cabai merah\",\"amount\":\"8\",\"unit\":\"buah\"},{\"name\":\"Tomat merah\",\"amount\":\"2\",\"unit\":\"buah\"},{\"name\":\"Bawang bombay\",\"amount\":\"1\",\"unit\":\"buah\"},{\"name\":\"Saus tomat\",\"amount\":\"3\",\"unit\":\"sdm\"},{\"name\":\"Saus tiram\",\"amount\":\"2\",\"unit\":\"sdm\"}]', '[{\"step\":1,\"instruction\":\"Bersihkan udang, belah punggung, marinasi dengan garam dan merica.\"},{\"step\":2,\"instruction\":\"Tumis bawang bombay hingga harum, masukkan cabai yang sudah dihaluskan.\"},{\"step\":3,\"instruction\":\"Masukkan tomat, saus tomat, dan saus tiram. Aduk rata.\"},{\"step\":4,\"instruction\":\"Masukkan udang, masak hingga matang dan saus mengental.\"},{\"step\":5,\"instruction\":\"Sajikan dengan nasi putih hangat.\"}]', 0, 11, 'medium', 280, 3, NULL, 'https://www.youtube.com/watch?v=jYAo-UmbLGk&t=262s', 0, '[\"seafood\"]', 'published', 4.50, 2, 0, '2026-06-01 05:43:53', '2026-06-02 02:03:56', NULL),
(5, 4, 5, 'Lapis Legit Premium Saffron', 'lapis-legit-premium-saffron', 'Lapis legit dengan sentuhan saffron yang mewah. Resep rahasia dengan teknik memanggang berlapis yang membutuhkan kesabaran dan ketelitian tinggi. Tersedia video tutorial eksklusif.', '[{\"name\":\"Tepung terigu\",\"amount\":\"100\",\"unit\":\"gram\"},{\"name\":\"Margarin\",\"amount\":\"500\",\"unit\":\"gram\"},{\"name\":\"Telur kuning\",\"amount\":\"30\",\"unit\":\"butir\"},{\"name\":\"Gula pasir halus\",\"amount\":\"200\",\"unit\":\"gram\"},{\"name\":\"Saffron\",\"amount\":\"1\",\"unit\":\"gram\"},{\"name\":\"Susu kental manis\",\"amount\":\"2\",\"unit\":\"sdm\"},{\"name\":\"Bumbu spekuk\",\"amount\":\"1\",\"unit\":\"sdt\"}]', '[{\"step\":1,\"instruction\":\"Kocok margarin hingga putih dan fluffy, sisihkan.\"},{\"step\":2,\"instruction\":\"Kocok telur dan gula hingga mengembang dan berwarna pucat.\"},{\"step\":3,\"instruction\":\"Campurkan kedua adonan, masukkan tepung secara bertahap.\"},{\"step\":4,\"instruction\":\"Bagi adonan menjadi 2: satu polos, satu dengan saffron.\"},{\"step\":5,\"instruction\":\"Panggang berlapis satu per satu dalam oven 180\\u00b0C dengan posisi api atas.\"},{\"step\":6,\"instruction\":\"Ulangi proses hingga 18-20 lapisan. Panggang lapisan terakhir sampai matang.\"}]', 0, 21, 'hard', 520, 20, NULL, 'https://www.youtube.com/watch?v=A7XveUfM6Gk', 1, '[\"gluten\",\"eggs\",\"dairy\"]', 'published', 0.00, 0, 0, '2026-06-01 05:43:53', '2026-06-02 02:03:56', NULL),
(6, 4, 4, 'Smoothie Bowl Tropical', 'smoothie-bowl-tropical', 'Sarapan sehat berbasis buah tropis dengan topping granola dan biji chia. Rendah kalori, tinggi serat dan vitamin.', '[{\"name\":\"Pisang beku\",\"amount\":\"2\",\"unit\":\"buah\"},{\"name\":\"Mangga beku\",\"amount\":\"100\",\"unit\":\"gram\"},{\"name\":\"Yogurt plain\",\"amount\":\"100\",\"unit\":\"ml\"},{\"name\":\"Granola\",\"amount\":\"50\",\"unit\":\"gram\"},{\"name\":\"Biji chia\",\"amount\":\"1\",\"unit\":\"sdm\"},{\"name\":\"Buah naga\",\"amount\":\"50\",\"unit\":\"gram\"},{\"name\":\"Madu\",\"amount\":\"1\",\"unit\":\"sdt\"}]', '[{\"step\":1,\"instruction\":\"Blender pisang beku, mangga, dan yogurt hingga smooth dan creamy.\"},{\"step\":2,\"instruction\":\"Tuang ke mangkuk, ratakan permukaannya.\"},{\"step\":3,\"instruction\":\"Tata granola, buah naga, dan topping lain di atasnya.\"},{\"step\":4,\"instruction\":\"Taburkan biji chia dan drizzle madu. Sajikan segera.\"}]', 0, 9, 'easy', 180, 1, NULL, 'https://www.youtube.com/watch?v=fXLYqqxB2wc&t=45s', 0, '[\"dairy\"]', 'published', 4.50, 2, 0, '2026-06-01 05:43:53', '2026-06-02 02:03:56', NULL),
(7, 2, 1, 'Rendang Daging Sapi Panggang', 'rendang-daging-sapi-panggang', 'Rendang adalah masakan khas Minangkabau yang kaya rempah. Daging sapi dimasak perlahan dengan santan dan bumbu rempah hingga mengering dan berwarna cokelat kehitaman.', '[{\"name\":\"Daging sapi\",\"amount\":\"1\",\"unit\":\"kg\"},{\"name\":\"Santan kelapa\",\"amount\":\"800\",\"unit\":\"ml\"},{\"name\":\"Bawang merah\",\"amount\":\"15\",\"unit\":\"siung\"},{\"name\":\"Bawang putih\",\"amount\":\"8\",\"unit\":\"siung\"},{\"name\":\"Cabai merah keriting\",\"amount\":\"20\",\"unit\":\"buah\"},{\"name\":\"Lengkuas\",\"amount\":\"3\",\"unit\":\"cm\"},{\"name\":\"Serai\",\"amount\":\"3\",\"unit\":\"batang\"},{\"name\":\"Daun salam\",\"amount\":\"5\",\"unit\":\"lembar\"},{\"name\":\"Kunyit\",\"amount\":\"2\",\"unit\":\"cm\"},{\"name\":\"Garam\",\"amount\":\"2\",\"unit\":\"sdt\"}]', '[{\"instruction\":\"Haluskan bawang merah, bawang putih, cabai, lengkuas, dan kunyit.\"},{\"instruction\":\"Tumis bumbu halus bersama serai dan daun salam hingga harum.\"},{\"instruction\":\"Masukkan daging sapi, aduk hingga berubah warna.\"},{\"instruction\":\"Tuang santan, masak dengan api sedang sambil terus diaduk.\"},{\"instruction\":\"Kecilkan api, masak selama 3-4 jam hingga santan mengering dan rendang berwarna cokelat.\"}]', 0, 14, 'hard', 450, 6, NULL, 'https://www.youtube.com/watch?v=DMcFqtm1IfX', 0, '[]', 'published', 5.00, 1, 0, '2026-06-02 00:23:54', '2026-06-02 02:20:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_saves`
--

CREATE TABLE `recipe_saves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipe_tag`
--

CREATE TABLE `recipe_tag` (
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe_tag`
--

INSERT INTO `recipe_tag` (`recipe_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 13),
(2, 11),
(2, 12),
(2, 16),
(2, 17),
(3, 2),
(3, 18),
(4, 1),
(4, 2),
(5, 13),
(5, 18),
(6, 7),
(6, 11),
(6, 17),
(7, 1),
(7, 2),
(7, 13);

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
('dQTHaUWeHKwOoUnfnU0fD0ZHEJSQM8yc7u5Oa9K4', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ1ZWQjlWVWM4dFhpSWR2S3V4WElGUXk5c09BU21HaE5hM0ZBU1psTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWNpcGVzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1780394008),
('npsHs3ryBMYtWrquGQ0alWiVStk54SFxFfsrRcP9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieWR6Zm9OaXJjSHNiTkdOT3ZwOUhWMjlwb1hYUDcxU2hFbVc0YllZNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1780393271);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Pedas', 'pedas', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(2, 'Gurih', 'gurih', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(3, 'Manis', 'manis', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(4, 'Asam', 'asam', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(5, 'Asin', 'asin', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(6, 'Tanpa Gluten', 'tanpa-gluten', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(7, 'Rendah Kalori', 'rendah-kalori', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(8, 'Tinggi Protein', 'tinggi-protein', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(9, 'Keto', 'keto', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(10, 'Bebas Laktosa', 'bebas-laktosa', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(11, 'Cepat', 'cepat', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(12, 'Budget Friendly', 'budget-friendly', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(13, 'Tradisional', 'tradisional', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(14, 'Modern', 'modern', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(15, 'Fusion', 'fusion', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(16, 'Anti-Gagal', 'anti-gagal', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(17, 'Untuk Pemula', 'untuk-pemula', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(18, 'Restoran Style', 'restoran-style', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(19, 'Jajanan Pasar', 'jajanan-pasar', '2026-06-01 05:43:51', '2026-06-01 05:43:51'),
(20, 'Street Food', 'street-food', '2026-06-01 05:43:51', '2026-06-01 05:43:51');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vip_package_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_status` enum('pending','success','failed','expired','refunded') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_channel` varchar(255) DEFAULT NULL,
  `payment_gateway_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_gateway_log`)),
  `paid_at` timestamp NULL DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `vip_starts_at` timestamp NULL DEFAULT NULL,
  `vip_ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `invoice_number`, `user_id`, `vip_package_id`, `amount`, `payment_status`, `payment_method`, `payment_channel`, `payment_gateway_log`, `paid_at`, `expired_at`, `notes`, `vip_starts_at`, `vip_ends_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'RR-2024-00001', 6, 1, 49000.00, 'success', 'transfer_bank', 'BCA', '{\"transaction_id\":\"TRX-BCA-001\",\"status\":\"settlement\"}', '2026-05-27 05:43:53', NULL, NULL, '2026-05-27 05:43:53', '2026-06-26 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(2, 'RR-2024-00002', 7, 3, 399000.00, 'success', 'ewallet', 'GoPay', '{\"transaction_id\":\"TRX-GP-002\",\"status\":\"settlement\"}', '2026-05-02 05:43:53', NULL, NULL, '2026-05-02 05:43:53', '2027-05-02 05:43:53', '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(3, 'RR-2026-00001', 10, 2, 129000.00, 'success', 'e_wallet', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-01 07:24:05', '2026-06-01 07:24:05', NULL),
(4, 'RR-2026-00002', 11, 3, 399000.00, 'success', 'e_wallet', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-02 01:45:28', '2026-06-02 01:45:28', NULL);

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
  `role` enum('admin','chef','user') NOT NULL DEFAULT 'user',
  `avatar` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `is_vip` tinyint(1) NOT NULL DEFAULT 0,
  `vip_expires_at` timestamp NULL DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `rating_avg` decimal(3,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `avatar`, `phone`, `bio`, `is_vip`, `vip_expires_at`, `specialization`, `rating_avg`, `is_active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin RasaRekomendasi', 'admin@rasarekomendasi.id', '2026-06-01 05:43:51', '$2y$12$56Tmhxwtrk/sHGzGYyivSey4G1bw5qDV3cZTOCghc5XMcbCQvj0/S', 'admin', NULL, NULL, NULL, 0, NULL, NULL, 0.00, 1, NULL, '2026-06-01 05:43:51', '2026-06-01 05:43:51', NULL),
(2, 'Chef Rina Sari', 'chef.rina@rasarekomendasi.id', '2026-06-01 05:43:51', '$2y$12$ugoJwqGl0sp5CiPOWqi5wOYG7qaLQYwMq2f5bEsarr.qeoaTU9NBG', 'chef', NULL, NULL, 'Chef berpengalaman 15 tahun dengan keahlian masakan tradisional Jawa dan nusantara.', 0, NULL, 'Masakan Indonesia & Jawa', 4.80, 1, NULL, '2026-06-01 05:43:52', '2026-06-01 05:43:52', NULL),
(3, 'Chef Budi Santoso', 'chef.budi@rasarekomendasi.id', '2026-06-01 05:43:52', '$2y$12$ayiCnPRH1z/9OuFHyQLO9eCr8qXv4JJiYLtKHkN8p.5gUZCYay2m.', 'chef', NULL, NULL, 'Spesialis masakan Asia Tenggara dengan sentuhan modern.', 0, NULL, 'Masakan Asia & Fusion', 4.65, 1, NULL, '2026-06-01 05:43:52', '2026-06-01 05:43:52', NULL),
(4, 'Chef Dewi Kusuma', 'chef.dewi@rasarekomendasi.id', '2026-06-01 05:43:52', '$2y$12$4I.LKGUE2HXvtgY.UZu/IOnmxAtQATuqRYqn0jjruoJ0wiGCXlh42', 'chef', NULL, NULL, 'Lulusan Le Cordon Bleu Jakarta dengan passion di bidang kue dan dessert.', 0, NULL, 'Dessert & Pastry', 4.90, 1, NULL, '2026-06-01 05:43:52', '2026-06-01 05:43:52', NULL),
(5, 'Siti Rahayu', 'siti@example.com', '2026-06-01 05:43:52', '$2y$12$Dk376KSf6VMc.GxeUl/d6.iZRDrCE9m.c4hFFwQGSkTEp6uhWpbKG', 'user', NULL, NULL, NULL, 0, NULL, NULL, 0.00, 1, NULL, '2026-06-01 05:43:52', '2026-06-01 05:43:52', NULL),
(6, 'Budi Prakoso', 'budi@example.com', '2026-06-01 05:43:52', '$2y$12$gRaJRurVFXBOlaQZGvPQXeuAzVuRrsUsj/SG4y9z91JPiAyVvsklC', 'user', NULL, NULL, NULL, 1, '2026-07-01 05:43:52', NULL, 0.00, 1, NULL, '2026-06-01 05:43:52', '2026-06-01 05:43:52', NULL),
(7, 'Mega Wulandari', 'mega@example.com', '2026-06-01 05:43:53', '$2y$12$VPKTZQYAmBpVT7k0f3D99OsNqg9xe.fg0R8UTqVHImtMqIwxcewNC', 'user', NULL, NULL, NULL, 1, '2027-06-01 05:43:52', NULL, 0.00, 1, NULL, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(8, 'Rizki Pratama', 'rizki@example.com', '2026-06-01 05:43:53', '$2y$12$9HKqD1byKiO0WUNxkokyVeOIOApOCU5wQPzcB5snVyPjtcGLSbRH2', 'user', NULL, NULL, NULL, 0, NULL, NULL, 0.00, 1, NULL, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(9, 'Ayu Lestari', 'ayu@example.com', '2026-06-01 05:43:53', '$2y$12$ffJFl54IDU9UcuENiAV4jOD2AjSXkVV6vtC3ApODbSGBWvxRR4cqO', 'user', NULL, NULL, NULL, 0, NULL, NULL, 0.00, 1, NULL, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(10, 'rifqifauzi', 'rifqifauzi@gmail.com', NULL, '$2y$12$U/jhQdXjoDDFQiK.pRnbn.fz0ChWBWCQhGvzc1.XaeDXL6Mvxb7wq', 'user', NULL, NULL, NULL, 1, NULL, NULL, 0.00, 1, NULL, '2026-06-01 07:19:14', '2026-06-01 07:24:05', NULL),
(11, 'Budi Santoso', 'budi.santoso@gmail.com', NULL, '$2y$12$haaTNodvqcJTHoKSnVZzxuho.J.kAXg6MOcwrV/ulJ/CyDPlo9URa', 'user', NULL, NULL, NULL, 1, NULL, NULL, 0.00, 1, NULL, '2026-06-01 07:30:34', '2026-06-02 01:45:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vip_packages`
--

CREATE TABLE `vip_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `duration_days` int(10) UNSIGNED NOT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vip_packages`
--

INSERT INTO `vip_packages` (`id`, `name`, `description`, `price`, `duration_days`, `features`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Paket Bulanan', 'Akses penuh selama 30 hari. Cocok untuk pemula yang ingin mencoba layanan VIP.', 49000.00, 30, '[\"Akses semua resep eksklusif\",\"Video tutorial premium\",\"1x Konsultasi langsung dengan chef\",\"Download resep tanpa batas\",\"Bebas iklan\"]', 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(2, 'Paket Triwulan', 'Akses penuh selama 90 hari dengan harga lebih hemat.', 129000.00, 90, '[\"Semua fitur Paket Bulanan\",\"3x Konsultasi langsung dengan chef\",\"Akses materi kelas memasak online\",\"Sertifikat digital setelah konsultasi\",\"Prioritas dalam booking chef\"]', 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL),
(3, 'Paket Tahunan', 'Akses penuh selama 365 hari. Paket terbaik dengan harga paling terjangkau.', 399000.00, 365, '[\"Semua fitur Paket Triwulan\",\"Konsultasi tak terbatas\",\"Akses komunitas chef eksklusif\",\"Early access resep baru\",\"Badge VIP di profil\",\"Diskon 20% untuk merchandise RasaRekomendasi\"]', 1, '2026-06-01 05:43:53', '2026-06-01 05:43:53', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `chef_schedules`
--
ALTER TABLE `chef_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chef_schedules_chef_id_available_date_status_index` (`chef_id`,`available_date`,`status`),
  ADD KEY `chef_schedules_available_date_status_index` (`available_date`,`status`),
  ADD KEY `chef_schedules_status_index` (`status`);

--
-- Indexes for table `comments_ratings`
--
ALTER TABLE `comments_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `comments_ratings_user_id_recipe_id_unique` (`user_id`,`recipe_id`),
  ADD KEY `comments_ratings_recipe_id_is_approved_rating_index` (`recipe_id`,`is_approved`,`rating`),
  ADD KEY `comments_ratings_is_approved_index` (`is_approved`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultations_schedule_id_foreign` (`schedule_id`),
  ADD KEY `consultations_user_id_status_index` (`user_id`,`status`),
  ADD KEY `consultations_chef_id_status_index` (`chef_id`,`status`),
  ADD KEY `consultations_status_index` (`status`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_consultation_id_created_at_index` (`consultation_id`,`created_at`),
  ADD KEY `messages_sender_id_is_read_index` (`sender_id`,`is_read`),
  ADD KEY `messages_sender_role_index` (`sender_role`),
  ADD KEY `messages_is_read_index` (`is_read`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `preferences_user_id_unique` (`user_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recipes_slug_unique` (`slug`),
  ADD KEY `recipes_title_status_index` (`title`,`status`),
  ADD KEY `recipes_chef_id_status_index` (`chef_id`,`status`),
  ADD KEY `recipes_category_id_is_vip_content_index` (`category_id`,`is_vip_content`),
  ADD KEY `recipes_difficulty_prep_time_index` (`difficulty`,`prep_time`),
  ADD KEY `recipes_difficulty_index` (`difficulty`),
  ADD KEY `recipes_is_vip_content_index` (`is_vip_content`),
  ADD KEY `recipes_status_index` (`status`);

--
-- Indexes for table `recipe_saves`
--
ALTER TABLE `recipe_saves`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recipe_saves_user_id_recipe_id_unique` (`user_id`,`recipe_id`),
  ADD KEY `recipe_saves_recipe_id_foreign` (`recipe_id`);

--
-- Indexes for table `recipe_tag`
--
ALTER TABLE `recipe_tag`
  ADD PRIMARY KEY (`recipe_id`,`tag_id`),
  ADD KEY `recipe_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_invoice_number_unique` (`invoice_number`),
  ADD KEY `transactions_vip_package_id_foreign` (`vip_package_id`),
  ADD KEY `transactions_user_id_payment_status_index` (`user_id`,`payment_status`),
  ADD KEY `transactions_payment_status_created_at_index` (`payment_status`,`created_at`),
  ADD KEY `transactions_payment_status_index` (`payment_status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_is_active_index` (`role`,`is_active`),
  ADD KEY `users_is_vip_vip_expires_at_index` (`is_vip`,`vip_expires_at`),
  ADD KEY `users_role_index` (`role`),
  ADD KEY `users_is_vip_index` (`is_vip`),
  ADD KEY `users_is_active_index` (`is_active`);

--
-- Indexes for table `vip_packages`
--
ALTER TABLE `vip_packages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `chef_schedules`
--
ALTER TABLE `chef_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments_ratings`
--
ALTER TABLE `comments_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `recipe_saves`
--
ALTER TABLE `recipe_saves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vip_packages`
--
ALTER TABLE `vip_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chef_schedules`
--
ALTER TABLE `chef_schedules`
  ADD CONSTRAINT `chef_schedules_chef_id_foreign` FOREIGN KEY (`chef_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments_ratings`
--
ALTER TABLE `comments_ratings`
  ADD CONSTRAINT `comments_ratings_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_chef_id_foreign` FOREIGN KEY (`chef_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultations_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `chef_schedules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_consultation_id_foreign` FOREIGN KEY (`consultation_id`) REFERENCES `consultations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `preferences`
--
ALTER TABLE `preferences`
  ADD CONSTRAINT `preferences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `recipes_chef_id_foreign` FOREIGN KEY (`chef_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `recipe_saves`
--
ALTER TABLE `recipe_saves`
  ADD CONSTRAINT `recipe_saves_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_saves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_tag`
--
ALTER TABLE `recipe_tag`
  ADD CONSTRAINT `recipe_tag_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_vip_package_id_foreign` FOREIGN KEY (`vip_package_id`) REFERENCES `vip_packages` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
