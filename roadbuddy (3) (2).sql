-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Nov 07, 2024 at 05:21 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roadbuddy`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(11) NOT NULL,
  `license_number` text NOT NULL,
  `vehicle` text NOT NULL,
  `profile_picture` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `rating` float NOT NULL,
  `comments` text NOT NULL,
  `date` date NOT NULL,
  `provider_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '0000_00_00_000000_create_websockets_statistics_entries_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 11, 'authToken', '1fef614f08d7fcb4eb0be4f70e4e95906909953044c9de1c1d21162dec0f6332', '[\"*\"]', '2024-10-31 07:18:36', NULL, '2024-10-02 21:30:55', '2024-10-31 07:18:36'),
(2, 'App\\Models\\User', 11, 'authToken', '1a18dadb66b7082aadc05fb487492997682bd10a764019bc3f8105d4f642d326', '[\"*\"]', NULL, NULL, '2024-10-09 10:50:44', '2024-10-09 10:50:44'),
(3, 'App\\Models\\User', 11, 'authToken', 'a78659f493930c1f3d8ee126e8ae5103e6f38749a652472f7479b747b08cd211', '[\"*\"]', NULL, NULL, '2024-10-09 11:15:46', '2024-10-09 11:15:46'),
(4, 'App\\Models\\User', 11, 'authToken', '32c739c239d4df1f38b7a7913226d898c91f1243a8afb4acf6a829b03f01fb58', '[\"*\"]', NULL, NULL, '2024-10-10 14:04:35', '2024-10-10 14:04:35'),
(5, 'App\\Models\\User', 11, 'authToken', '839202abc95dfe7f28a15520d83cd5e949c9b32a71b0cc6268766483fd14894a', '[\"*\"]', NULL, NULL, '2024-10-10 14:08:38', '2024-10-10 14:08:38'),
(6, 'App\\Models\\User', 11, 'authToken', '0d8e1219dd375f2518972832c1c823b015ed6e900a7296698a5d9a309001ba49', '[\"*\"]', NULL, NULL, '2024-10-10 14:08:45', '2024-10-10 14:08:45'),
(7, 'App\\Models\\User', 11, 'authToken', '548f5f2f67323f49480d0c8fe2d4ccfc30f47dda15785036f0e5c12bb9e97a41', '[\"*\"]', NULL, NULL, '2024-10-10 14:11:52', '2024-10-10 14:11:52'),
(8, 'App\\Models\\User', 11, 'authToken', '774c33dca790f6cd66b6c42f63a84fad3f16671145bbc224b24dbf64b9476175', '[\"*\"]', NULL, NULL, '2024-10-10 14:13:54', '2024-10-10 14:13:54'),
(9, 'App\\Models\\User', 11, 'authToken', '23d601d4abf6fd127f6ffd1ef4b4e1bbaa1bc6a7d6f544f934b24fa5b471b460', '[\"*\"]', NULL, NULL, '2024-10-10 14:29:45', '2024-10-10 14:29:45'),
(10, 'App\\Models\\User', 11, 'authToken', '14775dac4f909328ba92a455d22492c77f9a79081c2de62d80f366a89ce84bfa', '[\"*\"]', NULL, NULL, '2024-10-10 14:30:00', '2024-10-10 14:30:00'),
(11, 'App\\Models\\User', 11, 'authToken', '59da44af28a923437381f1435dca1dc0a7dbafb4fa03c244b931872153201f07', '[\"*\"]', NULL, NULL, '2024-10-10 14:30:56', '2024-10-10 14:30:56'),
(12, 'App\\Models\\User', 11, 'authToken', 'b08687f38492ff49de4d03f23d0c23e687497f1a76269ce6daa1f63aa6198c21', '[\"*\"]', NULL, NULL, '2024-10-10 14:31:30', '2024-10-10 14:31:30'),
(13, 'App\\Models\\User', 11, 'authToken', '7f94f4ee9e86d0ac136be4112615a290fa5662aa8cd5b3249166cf5dc2e9e70b', '[\"*\"]', NULL, NULL, '2024-10-10 14:32:51', '2024-10-10 14:32:51'),
(14, 'App\\Models\\User', 11, 'authToken', '27f25427be19f091dbef76c9cc90ef4d8b4e182e970fb8dfacc9e19e34846002', '[\"*\"]', NULL, NULL, '2024-10-10 14:58:17', '2024-10-10 14:58:17'),
(15, 'App\\Models\\User', 11, 'authToken', '7735035b697fab72513b04807ee413ea370966ed6c59f783e3b64a9f2e877451', '[\"*\"]', NULL, NULL, '2024-10-10 15:04:14', '2024-10-10 15:04:14'),
(16, 'App\\Models\\User', 11, 'authToken', '7ce9d5106e03dd90fdd527bdbe6e8f9307eee508a671e3207b0b992714503b95', '[\"*\"]', NULL, NULL, '2024-10-16 23:17:11', '2024-10-16 23:17:11'),
(17, 'App\\Models\\User', 11, 'authToken', 'da4ea645a385ef15ac4a05b4686fe59130d1400ce33294acf7ddfc9a151511d0', '[\"*\"]', NULL, NULL, '2024-10-16 23:18:08', '2024-10-16 23:18:08'),
(18, 'App\\Models\\User', 11, 'authToken', '13cb89893c423b7d917a811800f923261e24696883a0be9278c4f77304efcc42', '[\"*\"]', NULL, NULL, '2024-10-16 23:27:42', '2024-10-16 23:27:42'),
(19, 'App\\Models\\User', 11, 'authToken', 'dc14e6b54f8454592501afdf24b6ef3b2e8411ba04fe1068a42dd9d7b48fa8ae', '[\"*\"]', NULL, NULL, '2024-10-16 23:29:44', '2024-10-16 23:29:44'),
(20, 'App\\Models\\User', 11, 'authToken', 'c62fbabff8df81249bcf6dec40368e318a450ec1169697bdaee6b24d6f2cae71', '[\"*\"]', NULL, NULL, '2024-10-16 23:30:18', '2024-10-16 23:30:18'),
(21, 'App\\Models\\User', 11, 'authToken', 'f1e2936177d348b4b3cdf46841246d198865c383a1b45ce694bb145e19939452', '[\"*\"]', NULL, NULL, '2024-10-16 23:32:02', '2024-10-16 23:32:02'),
(22, 'App\\Models\\User', 11, 'authToken', '7001b660b987689c6736c235d89dc9fee5f70e95f40284797b7d71acfa8e73fe', '[\"*\"]', NULL, NULL, '2024-10-16 23:32:17', '2024-10-16 23:32:17'),
(23, 'App\\Models\\User', 11, 'authToken', '88fd12271365e464da5e6008d847223c9c2bd9c3b2d5ba78982756a0fe3d408a', '[\"*\"]', NULL, NULL, '2024-10-17 10:43:00', '2024-10-17 10:43:00'),
(24, 'App\\Models\\User', 11, 'authToken', 'a2e2cc909ff333df414d5b283ba50eb5041c6e1e60dc19823f5012329bb7bdf9', '[\"*\"]', NULL, NULL, '2024-10-17 10:44:40', '2024-10-17 10:44:40'),
(25, 'App\\Models\\User', 11, 'authToken', '223108060346b0446f6af363d0a6f4a1c20e3d947bf7ebbbbae1700b4efe3a2b', '[\"*\"]', NULL, NULL, '2024-10-17 20:46:23', '2024-10-17 20:46:23'),
(26, 'App\\Models\\User', 11, 'authToken', 'e619de401b55a7a529df75db16fdd21b8857da13acaf50a43dec35891d68bd96', '[\"*\"]', NULL, NULL, '2024-10-17 20:50:17', '2024-10-17 20:50:17'),
(27, 'App\\Models\\User', 11, 'authToken', '9280077a3a14e460beb34696f9b7fe10caa1f0803da25c638eaeee88aa207ba8', '[\"*\"]', NULL, NULL, '2024-10-17 20:50:40', '2024-10-17 20:50:40'),
(28, 'App\\Models\\User', 11, 'authToken', 'abe920df7f10fc0c93534adf396412bfbde0c36ab7304ceff35a6bda39410029', '[\"*\"]', NULL, NULL, '2024-10-17 20:51:26', '2024-10-17 20:51:26'),
(29, 'App\\Models\\User', 11, 'authToken', '61f14eb1da57c403d1488209ea0f57b70775104cbcfa3cd87ddadf006bed52cd', '[\"*\"]', NULL, NULL, '2024-10-17 20:54:24', '2024-10-17 20:54:24'),
(30, 'App\\Models\\User', 11, 'authToken', 'c9b93dc5eee526242e77540d3ade23ed1af6a0f8cec15873679326589f1bdfac', '[\"*\"]', NULL, NULL, '2024-10-17 20:58:59', '2024-10-17 20:58:59'),
(31, 'App\\Models\\User', 11, 'authToken', 'ca1ed0520c66f2a8d16faaf84749d0d2181916a33769ecf6fad5a14385a8b877', '[\"*\"]', NULL, NULL, '2024-10-17 21:00:03', '2024-10-17 21:00:03'),
(32, 'App\\Models\\User', 11, 'authToken', 'd8174b7790bc29c80cba73c9f1afb16b3e85ae32f98d1cb82ed4381f03f2c957', '[\"*\"]', NULL, NULL, '2024-10-17 21:01:25', '2024-10-17 21:01:25'),
(33, 'App\\Models\\User', 11, 'authToken', 'd1352700b851d5d6ab96f566ee301f48c36e4f4c9eb3aeb3def8b5b55d978998', '[\"*\"]', NULL, NULL, '2024-10-17 21:08:35', '2024-10-17 21:08:35'),
(34, 'App\\Models\\User', 11, 'authToken', '9b94e9c2954459d6389797b3b018744f7f4540b69bb9427e65f711cf630049d4', '[\"*\"]', NULL, NULL, '2024-10-17 21:10:14', '2024-10-17 21:10:14'),
(35, 'App\\Models\\User', 11, 'authToken', 'bec81e27beada4efd6a45c50980cd6d19add2f5b08050a26883d30b4695a2db1', '[\"*\"]', '2024-10-17 21:36:09', NULL, '2024-10-17 21:11:06', '2024-10-17 21:36:09'),
(36, 'App\\Models\\User', 11, 'authToken', '5711f84966ec43c03740406f1c0eae1d3b5cfeeac29eae238bed798ce328a5a6', '[\"*\"]', '2024-10-17 23:10:16', NULL, '2024-10-17 23:10:13', '2024-10-17 23:10:16'),
(37, 'App\\Models\\User', 11, 'authToken', '178e3292c6127aa40a5b81163a698a15c47529b63f3bdbdbaf234cc178e32579', '[\"*\"]', '2024-10-20 07:32:57', NULL, '2024-10-17 23:13:35', '2024-10-20 07:32:57'),
(38, 'App\\Models\\User', 11, 'authToken', '316f73f619793b9e13419905d88d1fbd90b6c15a18a05ddb7216f846b1d32d46', '[\"*\"]', '2024-10-21 20:17:06', NULL, '2024-10-21 18:14:33', '2024-10-21 20:17:06'),
(39, 'App\\Models\\User', 11, 'authToken', '63a2c15c9603609284cb1fd72e2b10a7f090a8b6f12c4815a93a4d724f8a641a', '[\"*\"]', '2024-10-22 04:48:50', NULL, '2024-10-21 23:22:33', '2024-10-22 04:48:50'),
(40, 'App\\Models\\User', 11, 'authToken', 'a9b5734baccc80a6fae57b755aedd930566c25b12f2cd38b022f2d7bc0118066', '[\"*\"]', '2024-10-22 06:04:35', NULL, '2024-10-22 05:40:51', '2024-10-22 06:04:35'),
(41, 'App\\Models\\User', 11, 'authToken', 'f737f2f6daca85fb1c35194c41c6b73018c6f5d66c505298fc4a40310f23aadd', '[\"*\"]', '2024-10-22 18:06:51', NULL, '2024-10-22 18:00:55', '2024-10-22 18:06:51'),
(42, 'App\\Models\\User', 11, 'authToken', '7fb1d64d4714d3c8f74a4b6c081f4e8a0bccbf056327c4e30dc6db9edb43f480', '[\"*\"]', NULL, NULL, '2024-10-25 06:35:37', '2024-10-25 06:35:37'),
(43, 'App\\Models\\User', 11, 'authToken', '4b9548d24980a6b39f2930facb015c4fdef8072cd5f838f04b92b9f443b61c19', '[\"*\"]', '2024-10-25 06:47:36', NULL, '2024-10-25 06:35:56', '2024-10-25 06:47:36'),
(44, 'App\\Models\\User', 27, 'authToken', '65de23c962d45458181414ac34ceb692636ce6fa2d08fad43108e3f1cea3f0eb', '[\"*\"]', '2024-10-25 07:02:34', NULL, '2024-10-25 06:48:21', '2024-10-25 07:02:34'),
(45, 'App\\Models\\User', 11, 'authToken', 'b43a3cd4f72b3c34494cac78338d686db859d613ee744c00d233900876b11e1a', '[\"*\"]', '2024-10-28 09:31:15', NULL, '2024-10-28 09:23:45', '2024-10-28 09:31:15'),
(46, 'App\\Models\\User', 18, 'authToken', 'bbb3a3de4c3f19b67dec15007797ad4b2f5607e59812525ffa1d990eda7dd6e7', '[\"*\"]', NULL, NULL, '2024-10-30 05:59:55', '2024-10-30 05:59:55'),
(47, 'App\\Models\\User', 18, 'authToken', 'f1557b67e70a40d7965187623342593057a97cea14b1de9b4574cc75c7f02b4f', '[\"*\"]', '2024-10-31 01:23:11', NULL, '2024-10-30 06:01:15', '2024-10-31 01:23:11'),
(48, 'App\\Models\\User', 11, 'authToken', '219d165a6b711bc1d37f0f7767516d2999a47f679381f6343af6003b2fb2b37e', '[\"*\"]', '2024-10-30 06:03:45', NULL, '2024-10-30 06:01:34', '2024-10-30 06:03:45'),
(49, 'App\\Models\\User', 18, 'authToken', '1acc2bf727c33e8e45df63aacce44374c5d49069e8d09c5c13a4280ec4793412', '[\"*\"]', '2024-10-31 08:08:52', NULL, '2024-10-31 06:18:04', '2024-10-31 08:08:52'),
(50, 'App\\Models\\User', 18, 'authToken', 'f5cbc4702f899e84ee3dcb4d7f7b6a4d75a326b111ea659aa037ec0f24954251', '[\"*\"]', '2024-11-01 08:04:31', NULL, '2024-11-01 07:20:46', '2024-11-01 08:04:31'),
(51, 'App\\Models\\User', 11, 'authToken', '8483fd4e09cef6053679ea4bd3d2d44f561c7c430e340f136232180c10ca307c', '[\"*\"]', '2024-11-01 14:56:47', NULL, '2024-11-01 11:25:15', '2024-11-01 14:56:47'),
(52, 'App\\Models\\User', 18, 'authToken', '460ed1c962b6b5414ab6c08108936fa548c7e8b0f3183269fd11c9711bc0eea6', '[\"*\"]', '2024-11-02 19:25:09', NULL, '2024-11-02 00:36:39', '2024-11-02 19:25:09'),
(53, 'App\\Models\\User', 11, 'authToken', 'de8b6d0434fee17cd1c310d0576b228a572fb5504d3de8b2e69ffe43d41b826f', '[\"*\"]', '2024-11-03 02:57:46', NULL, '2024-11-03 01:59:30', '2024-11-03 02:57:46'),
(54, 'App\\Models\\User', 11, 'authToken', '35bb22a79e413ddf53d32edde01935c29cda86ad61478313adbe4df85663e1e1', '[\"*\"]', '2024-11-03 06:20:18', NULL, '2024-11-03 02:56:02', '2024-11-03 06:20:18'),
(55, 'App\\Models\\User', 11, 'authToken', '3b052d1f89b2bdb8dcd2a166464e4047f77c0840d334d4f6fd419442c06578a3', '[\"*\"]', '2024-11-03 02:59:01', NULL, '2024-11-03 02:58:59', '2024-11-03 02:59:01'),
(56, 'App\\Models\\User', 11, 'authToken', '5cca63dd774d5437bd0475e6c2be82b288472093d04df98d1c67901b79ca25a1', '[\"*\"]', '2024-11-03 06:20:24', NULL, '2024-11-03 02:59:12', '2024-11-03 06:20:24'),
(57, 'App\\Models\\User', 11, 'authToken', '3aaddf06f5fa208e2d9aaf6195ec4da5703a5ec31dbf1670403200824ae2c0ea', '[\"*\"]', '2024-11-04 00:15:02', NULL, '2024-11-03 06:27:08', '2024-11-04 00:15:02'),
(58, 'App\\Models\\User', 11, 'authToken', '47de101828bb674d873d58cb896b0d88b246aeb0b81f01b4de3a706c4e6e00f2', '[\"*\"]', NULL, NULL, '2024-11-04 00:14:22', '2024-11-04 00:14:22'),
(59, 'App\\Models\\User', 11, 'authToken', '7951e27a8cacddace963c685ebe4441311931e94d4fc491c7f8d9a73ed64d5d9', '[\"*\"]', '2024-11-05 05:48:50', NULL, '2024-11-04 00:16:11', '2024-11-05 05:48:50'),
(60, 'App\\Models\\User', 18, 'authToken', '041e4f8c088fefc008c54d8e6e250c3e55c0ce04400abf1012eb63e761308162', '[\"*\"]', '2024-11-05 15:25:29', NULL, '2024-11-05 09:38:30', '2024-11-05 15:25:29'),
(61, 'App\\Models\\User', 18, 'authToken', '1183e0eff45b1f59815586141f535ec2fa83e632f496d4bd4dbd67a42af9303b', '[\"*\"]', '2024-11-06 17:01:21', NULL, '2024-11-06 14:20:44', '2024-11-06 17:01:21'),
(62, 'App\\Models\\User', 11, 'authToken', '696424443930c483d193c61272331c782e99acf407a9cde4d9df2b0caa0672e7', '[\"*\"]', '2024-11-06 17:50:02', NULL, '2024-11-06 17:49:59', '2024-11-06 17:50:02'),
(63, 'App\\Models\\User', 11, 'authToken', '0089572ee6fd5e2e738a9ba2dd1c7a783c7772e26a56f5a41bc858fde83c8793', '[\"*\"]', '2024-11-06 20:04:02', NULL, '2024-11-06 17:50:20', '2024-11-06 20:04:02');

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `contact_info` text NOT NULL,
  `location_lat` double(8,2) NOT NULL,
  `location_lng` double(8,2) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `status` text NOT NULL DEFAULT 'pending',
  `request_time` datetime NOT NULL DEFAULT current_timestamp(),
  `completion_time` datetime DEFAULT NULL,
  `location_lat` float NOT NULL,
  `location_lng` float NOT NULL,
  `service_id` int(11) NOT NULL,
  `rating` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `user_id`, `provider_id`, `status`, `request_time`, `completion_time`, `location_lat`, `location_lng`, `service_id`, `rating`) VALUES
(60, 18, 10, 'pending', '2024-11-06 01:53:08', NULL, 40.7128, -74.006, 1, NULL),
(61, 18, 18, 'pending', '2024-11-06 01:53:54', NULL, 40.7128, -74.006, 1, NULL),
(62, 18, 18, 'pending', '2024-11-07 06:37:52', NULL, 40.7128, -74.006, 1, NULL),
(63, 18, 18, 'pending', '2024-11-07 06:38:27', NULL, 40.7128, -74.006, 1, NULL),
(64, 18, 18, 'pending', '2024-11-07 06:51:24', NULL, 40.7128, -74.006, 1, NULL),
(65, 18, 18, 'pending', '2024-11-07 07:02:06', NULL, 40.7128, -74.006, 1, NULL),
(66, 18, 18, 'pending', '2024-11-07 07:37:27', NULL, 40.7128, -74.006, 1, NULL),
(67, 18, 18, 'pending', '2024-11-07 07:37:44', NULL, 40.7128, -74.006, 1, NULL),
(68, 18, 18, 'pending', '2024-11-07 07:44:17', NULL, 40.7128, -74.006, 1, NULL),
(69, 18, 18, 'pending', '2024-11-07 07:45:12', NULL, 40.7128, -74.006, 1, NULL),
(70, 18, 18, 'pending', '2024-11-07 07:47:48', NULL, 40.7128, -74.006, 1, NULL),
(71, 18, 18, 'pending', '2024-11-07 07:54:39', NULL, 40.7128, -74.006, 1, NULL),
(72, 18, 18, 'pending', '2024-11-07 08:10:01', NULL, 40.7128, -74.006, 1, NULL),
(73, 18, 18, 'pending', '2024-11-07 08:10:31', NULL, 40.7128, -74.006, 1, NULL),
(74, 18, 18, 'pending', '2024-11-07 08:21:47', NULL, 40.7128, -74.006, 1, NULL),
(75, 18, 18, 'pending', '2024-11-07 08:24:58', NULL, 40.7128, -74.006, 1, NULL),
(76, 18, 18, 'pending', '2024-11-07 08:26:30', NULL, 40.7128, -74.006, 1, NULL),
(77, 18, 18, 'pending', '2024-11-07 08:28:27', NULL, 40.7128, -74.006, 1, NULL),
(78, 18, 18, 'pending', '2024-11-07 08:33:21', NULL, 40.7128, -74.006, 1, NULL),
(79, 18, 18, 'pending', '2024-11-07 08:36:55', NULL, 40.7128, -74.006, 1, NULL),
(80, 18, 18, 'pending', '2024-11-07 08:44:01', NULL, 40.7128, -74.006, 1, NULL),
(81, 18, 18, 'pending', '2024-11-07 08:45:26', NULL, 40.7128, -74.006, 1, NULL),
(82, 18, 18, 'pending', '2024-11-07 08:52:11', NULL, 40.7128, -74.006, 1, NULL),
(83, 11, 18, 'accepted', '2024-11-07 09:55:38', '2024-10-10 10:00:00', 37.7749, -122.419, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` text NOT NULL,
  `service_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_providers`
--

CREATE TABLE `service_providers` (
  `provider_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `contact_info` text NOT NULL,
  `location_lat` float NOT NULL,
  `location_lng` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_providers`
--

INSERT INTO `service_providers` (`provider_id`, `name`, `contact_info`, `location_lat`, `location_lng`) VALUES
(18, 'Road Buddy', 'updated_contact@example.com', 37.7749, -122.419);

-- --------------------------------------------------------

--
-- Table structure for table `service_provider_ratings`
--

CREATE TABLE `service_provider_ratings` (
  `rating_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `service_provider_id` int(11) NOT NULL,
  `rating` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_provider_ratings`
--

INSERT INTO `service_provider_ratings` (`rating_id`, `driver_id`, `service_provider_id`, `rating`) VALUES
(1, 1, 10, 5),
(2, 5, 18, 5);

-- --------------------------------------------------------

--
-- Table structure for table `service_provider_services`
--

CREATE TABLE `service_provider_services` (
  `provider_service_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `service_name` text NOT NULL,
  `price` float NOT NULL,
  `description` text DEFAULT NULL,
  `ratings` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_provider_services`
--

INSERT INTO `service_provider_services` (`provider_service_id`, `provider_id`, `service_name`, `price`, `description`, `ratings`) VALUES
(1, 18, 'Car Repair', 150, 'Car repair with wash service included', NULL),
(2, 18, 'Gas Delivery', 200, 'Full car repair service', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dark_mode` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `payment_method` text NOT NULL,
  `transaction_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `password` text NOT NULL,
  `type` enum('admin','driver','service_provider') NOT NULL,
  `username` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `phone`, `password`, `type`, `username`) VALUES
(10, 'Store Name', 'newuser@example.com', '1234567890', 'BC41E6F1C544616AF6B051C0943B5E45', 'service_provider', 'newUsername'),
(11, 'John Doe Updated', 'johndoe@example.com', '0987654321', '$2y$10$rJg4aYVV/.HY/kBhj3iGx.IwPYoVJi6ZV7tG0rCEKrxwPwraJ8hO.', 'driver', 'johndoe'),
(12, 'John Doe', 'johndoe123@example.com', '1234567890', '$2y$10$GfGaCUQR1C4dkhfSzZl0HeajMLoNZ7FtlELAwB9XQtI1FzOWV3S0a', 'service_provider', 'johndoe123'),
(13, 'Jane Service', 'jane.service@example.com', '0987654321', '$2y$10$WxVoTQBi89FaO2EJ35z3zuYXaSZNjAnRivRoOTSMBLOccM8Q1vds2', 'service_provider', 'janeservice'),
(14, 'Jane Service', 'jane12.service@example.com', '0987654321', '$2y$10$Yq1OmOIqI7OMuhHlHw.L/ehui/8FjTjsTfEJA4bVyY5Hc6TGDHcLq', 'service_provider', 'janeservice2'),
(15, 'Jane Service', 'jane123.service@example.com', '0987654321', '$2y$10$.fm4qrbNkviVN4S.sQKn1erJG2tKBxfAuoN3FS26Cf1g81L7nzMaa', 'service_provider', 'janeservice23'),
(16, 'Jane Service', 'jane123w.service@example.com', '0987654321', '$2y$10$sMx3i0ciE6uvNZK5teK2k.Tez2Ia5KkvGqbIwW9U.XVWbjYRey1CK', 'service_provider', 'janeservice2w3'),
(17, 'Jane Service', 'jane123w.3service@example.com', '0987654321', '$2y$10$VVaH4Et6H4MVIcnfdvnijeQIUbY3jyJjrI0SS29HinFJnR5E.Ause', 'service_provider', 'janeservice222'),
(18, 'Jane edited Service', 'test@example.com', '0912345678', '$2y$10$6lvA1f.OHrWWHpwgpmbb/eVDko5BLb.ec9tNdMeu/jzYQYK6PgA/i', 'service_provider', 'test123'),
(19, 'Jane Driver', 'janedriver@example.com', '0987654321', '$2y$10$wgNw6UJM5ovjnet5OxAPeO4iUDQyFzO2W46YtamF9fXAc0pxtIZyK', 'driver', 'janedriver'),
(20, 'Jane Driver', 'janedriver123@example.com', '0987654321', '$2y$10$koU/ymYiYDArMTeOoHZpCOk2ClRPWL/FYcOkcjbiQR.8FofYjbeBu', 'driver', 'janedriver123'),
(21, 'Jane Driver', 'janedriver12342@example.com', '0987654321', '$2y$10$5TNzgDmCwSkve8M3ZSq3Vu39kTHUZAzPd8bTLYcyAp7/JxF1Ed0Xu', 'driver', 'janedriver1234'),
(22, 'Jane Driver', 'driver@example.com', '0987654321', '$2y$10$Jz4bZv6Uv4uFSku044VnyudvGrsgTFf2OpOtapJAoiTwkNYw4o3Xu', 'driver', 'driver'),
(23, 'Jane Driver', 'driver1@example.com', '0987654321', '$2y$10$wx5eH2z3Oj52Q85t68ErROpQzu2UmwmoYUQLD6isXoue06ZHldnZu', 'driver', 'driver1');

-- --------------------------------------------------------

--
-- Table structure for table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user feedback` (`user_id`),
  ADD KEY `provider feedback` (`provider_id`),
  ADD KEY `request feedback` (`request_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user notif` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`provider_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `provider request` (`provider_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_providers`
--
ALTER TABLE `service_providers`
  ADD PRIMARY KEY (`provider_id`);

--
-- Indexes for table `service_provider_ratings`
--
ALTER TABLE `service_provider_ratings`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `service_provider_services`
--
ALTER TABLE `service_provider_services`
  ADD PRIMARY KEY (`provider_service_id`),
  ADD KEY `provider service` (`provider_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `user settings` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `request transaction` (`request_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `provider_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `service_provider_ratings`
--
ALTER TABLE `service_provider_ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_provider_services`
--
ALTER TABLE `service_provider_services`
  MODIFY `provider_service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `driver_user` FOREIGN KEY (`driver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `request feedback` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service_provider_services` (`provider_service_id`);

--
-- Constraints for table `service_providers`
--
ALTER TABLE `service_providers`
  ADD CONSTRAINT `service_provider_user` FOREIGN KEY (`provider_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_provider_services`
--
ALTER TABLE `service_provider_services`
  ADD CONSTRAINT `provider service` FOREIGN KEY (`provider_id`) REFERENCES `service_providers` (`provider_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `request transaction` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
