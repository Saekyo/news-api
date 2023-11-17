/*
 Navicat Premium Data Transfer

 Source Server         : mysql docker
 Source Server Type    : MySQL
 Source Server Version : 80022
 Source Host           : localhost:3306
 Source Schema         : news-api

 Target Server Type    : MySQL
 Target Server Version : 80022
 File Encoding         : 65001

 Date: 17/11/2023 13:37:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of categories
-- ----------------------------
BEGIN;
INSERT INTO `categories` VALUES (1, 'Sports', '2023-11-17 10:54:15', '2023-11-17 10:54:19');
INSERT INTO `categories` VALUES (2, 'Automotive', NULL, NULL);
INSERT INTO `categories` VALUES (3, 'Finance', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2023_11_17_033011_create-categories-table', 1);
INSERT INTO `migrations` VALUES (6, '2023_11_17_033025_create-news-table', 1);
COMMIT;

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` timestamp NOT NULL,
  `author_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_author_id_foreign` (`author_id`),
  KEY `news_category_id_foreign` (`category_id`),
  CONSTRAINT `news_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  CONSTRAINT `news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of news
-- ----------------------------
BEGIN;
INSERT INTO `news` VALUES (1, 'a', 'b', 'c', 'f', 'd', '2023-11-17 10:54:45', 2, 1, NULL, '2023-11-17 06:00:00');
INSERT INTO `news` VALUES (2, 'a', 'b', 'c', 'f', 'd', '2023-11-17 05:52:25', 2, 1, '2023-11-17 05:52:25', '2023-11-17 05:52:25');
INSERT INTO `news` VALUES (3, 'Sports News 1', 'Exciting Sports Events', 'In-depth coverage of the latest sports events', 'https://example.com/sports1', 'https://example.com/sports_image1.jpg', '2023-11-17 10:54:45', 2, 1, NULL, NULL);
INSERT INTO `news` VALUES (4, 'Automotive News 1', 'Latest Automotive Innovations', 'Explore the newest trends in the automotive industry', 'https://example.com/automotive1', 'https://example.com/automotive_image1.jpg', '2023-11-17 10:54:45', 2, 2, NULL, NULL);
INSERT INTO `news` VALUES (5, 'Finance News 1', 'Financial Market Updates', 'Insights into the current state of the financial market', 'https://example.com/finance1', 'https://example.com/finance_image1.jpg', '2023-11-17 10:54:45', 2, 3, NULL, NULL);
INSERT INTO `news` VALUES (6, 'Sports News 2', 'Major Sports Highlights', 'Recap of the most significant moments in sports', 'https://example.com/sports2', 'https://example.com/sports_image2.jpg', '2023-11-17 10:54:45', 2, 1, NULL, NULL);
INSERT INTO `news` VALUES (7, 'Automotive News 2', 'Future of Automobiles', 'Exploring the future of automobiles and transportation', 'https://example.com/automotive2', 'https://example.com/automotive_image2.jpg', '2023-11-17 10:54:45', 2, 2, NULL, NULL);
INSERT INTO `news` VALUES (8, 'Finance News 2', 'Global Financial Trends', 'Analysis of global financial trends and developments', 'https://example.com/finance2', 'https://example.com/finance_image2.jpg', '2023-11-17 10:54:45', 2, 3, NULL, NULL);
INSERT INTO `news` VALUES (9, 'Sports News 3', 'Athlete Interviews and Profiles', 'Interviews and profiles of prominent athletes', 'https://example.com/sports3', 'https://example.com/sports_image3.jpg', '2023-11-17 10:54:45', 2, 1, NULL, NULL);
INSERT INTO `news` VALUES (10, 'Automotive News 3', 'Green Automotive Initiatives', 'Exploring eco-friendly initiatives in the automotive world', 'https://example.com/automotive3', 'https://example.com/automotive_image3.jpg', '2023-11-17 10:54:45', 2, 2, NULL, NULL);
INSERT INTO `news` VALUES (11, 'Finance News 3', 'Investment Strategies', 'Tips and strategies for successful investments', 'https://example.com/finance3', 'https://example.com/finance_image3.jpg', '2023-11-17 10:54:45', 2, 3, NULL, NULL);
INSERT INTO `news` VALUES (12, 'Sports News 4', 'Upcoming Sports Tournaments', 'Preview of upcoming sports tournaments worldwide', 'https://example.com/sports4', 'https://example.com/sports_image4.jpg', '2023-11-17 10:54:45', 2, 1, NULL, NULL);
INSERT INTO `news` VALUES (13, 'Automotive News 4', 'Luxury Car Reviews', 'Reviews and features of the latest luxury cars', 'https://example.com/automotive4', 'https://example.com/automotive_image4.jpg', '2023-11-17 10:54:45', 2, 2, NULL, NULL);
INSERT INTO `news` VALUES (14, 'Finance News 4', 'Economic Outlook', 'Assessment of the current economic outlook', 'https://example.com/finance4', 'https://example.com/finance_image4.jpg', '2023-11-17 10:54:45', 2, 3, NULL, NULL);
INSERT INTO `news` VALUES (15, 'Sports News 5', 'Sports Science Discoveries', 'Exploring the latest discoveries in sports science', 'https://example.com/sports5', 'https://example.com/sports_image5.jpg', '2023-11-17 10:54:45', 2, 1, NULL, NULL);
INSERT INTO `news` VALUES (16, 'Automotive News 5', 'Emerging Automotive Technologies', 'Discovering new technologies in the automotive sector', 'https://example.com/automotive5', 'https://example.com/automotive_image5.jpg', '2023-11-17 10:54:45', 2, 2, NULL, NULL);
INSERT INTO `news` VALUES (17, 'Finance News 5', 'Cryptocurrency Updates', 'Latest updates and trends in the cryptocurrency market', 'https://example.com/finance5', 'https://example.com/finance_image5.jpg', '2023-11-17 10:54:45', 2, 3, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------
BEGIN;
INSERT INTO `personal_access_tokens` VALUES (1, 'App\\Models\\User', 2, 'auth_token', 'a1cc57759e68d93dcba08fb1a0b586a8f9e7bcc5b81d17b0bb160a52bd98a61b', '[\"*\"]', '2023-11-17 06:00:06', NULL, '2023-11-17 05:37:59', '2023-11-17 06:00:06');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 'ahmad', 'ahma@gmail.com', '2023-11-17 10:55:32', 'ahmad', NULL, NULL, NULL);
INSERT INTO `users` VALUES (2, 'Reski', 'reski@gmail.com', NULL, '$2y$12$CYBO5tOQGBqa7K9KX9yNLu3ddocmVWtBCAjZYIRZYwePVsh.Vemcy', NULL, '2023-11-17 05:37:14', '2023-11-17 05:37:14');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
