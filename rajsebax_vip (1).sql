-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 01, 2026 at 02:08 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rajsebax_vip`
--

-- --------------------------------------------------------

--
-- Table structure for table `automated_emails`
--

CREATE TABLE `automated_emails` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trigger` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delay_hours` int NOT NULL DEFAULT '0',
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sent_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `automated_email_logs`
--

CREATE TABLE `automated_email_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `automated_email_id` bigint UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('sent','failed','opened','clicked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sent',
  `opened_at` timestamp NULL DEFAULT NULL,
  `clicked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `availability_slots`
--

CREATE TABLE `availability_slots` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `instructor_id` bigint UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `max_bookings` int NOT NULL DEFAULT '1',
  `current_bookings` int NOT NULL DEFAULT '0',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `is_blocked` tinyint(1) NOT NULL DEFAULT '0',
  `is_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `recurring_frequency` enum('daily','weekly') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recurring_duration_months` int DEFAULT NULL,
  `recurring_end_date` date DEFAULT NULL,
  `recurring_parent_id` bigint UNSIGNED DEFAULT NULL,
  `recurring_group_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `pattern_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'manual, onetime, daily, weekly',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `availability_slots`
--

INSERT INTO `availability_slots` (`id`, `service_id`, `location_id`, `instructor_id`, `date`, `start_time`, `end_time`, `max_bookings`, `current_bookings`, `is_available`, `is_blocked`, `is_recurring`, `recurring_frequency`, `recurring_duration_months`, `recurring_end_date`, `recurring_parent_id`, `recurring_group_id`, `notes`, `pattern_type`, `created_at`, `updated_at`) VALUES
(301, 5, 4, 3, '2026-03-20', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(300, 5, 4, 3, '2026-03-19', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(299, 5, 4, 3, '2026-03-18', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(298, 5, 4, 3, '2026-03-17', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(297, 5, 4, 3, '2026-03-16', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(296, 5, 4, 3, '2026-03-13', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(295, 5, 4, 3, '2026-03-12', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(294, 5, 4, 3, '2026-03-11', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(293, 5, 4, 3, '2026-03-10', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(292, 5, 4, 3, '2026-03-09', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(291, 5, 4, 3, '2026-03-06', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(290, 5, 4, 3, '2026-03-05', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(289, 5, 4, 3, '2026-03-04', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(288, 5, 4, 3, '2026-03-03', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(287, 5, 4, 3, '2026-03-02', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(286, 5, 4, 3, '2026-02-27', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(285, 5, 4, 3, '2026-02-26', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(284, 5, 4, 3, '2026-02-25', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(283, 5, 4, 3, '2026-02-24', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(282, 5, 4, 3, '2026-02-23', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(281, 5, 4, 3, '2026-02-20', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(280, 5, 4, 3, '2026-02-19', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(279, 5, 4, 3, '2026-02-18', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(278, 5, 4, 3, '2026-02-17', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(277, 5, 4, 3, '2026-02-16', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-15 11:11:59', '2026-02-15 11:11:59'),
(302, 6, 1, 3, '2026-03-02', '09:00:00', '11:00:00', 1, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 19:23:44'),
(303, 6, 1, 3, '2026-03-03', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(304, 6, 1, 3, '2026-03-04', '09:00:00', '11:00:00', 1, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 19:44:27'),
(305, 6, 1, 3, '2026-03-05', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(306, 6, 1, 3, '2026-03-06', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(307, 6, 1, 3, '2026-03-09', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(308, 6, 1, 3, '2026-03-10', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(309, 6, 1, 3, '2026-03-11', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(310, 6, 1, 3, '2026-03-12', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(311, 6, 1, 3, '2026-03-13', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(312, 6, 1, 3, '2026-03-16', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(313, 6, 1, 3, '2026-03-17', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(314, 6, 1, 3, '2026-03-18', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(315, 6, 1, 3, '2026-03-19', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(316, 6, 1, 3, '2026-03-20', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(317, 6, 1, 3, '2026-03-23', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:37', '2026-02-28 02:53:37'),
(318, 6, 1, 3, '2026-03-24', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:38', '2026-02-28 02:53:38'),
(319, 6, 1, 3, '2026-03-25', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:38', '2026-02-28 02:53:38'),
(320, 6, 1, 3, '2026-03-26', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:38', '2026-02-28 02:53:38'),
(321, 6, 1, 3, '2026-03-27', '09:00:00', '11:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 02:53:38', '2026-02-28 02:53:38'),
(322, NULL, NULL, 2, '2026-03-01', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 11:02:45', '2026-02-28 11:02:45'),
(323, NULL, NULL, 2, '2026-03-02', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 11:03:24', '2026-02-28 11:03:24'),
(324, NULL, NULL, 3, '2026-03-01', '09:00:00', '10:00:00', 1, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'onetime', '2026-02-28 11:04:26', '2026-02-28 11:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `image`, `meta_title`, `meta_description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Driving Tips', 'driving-tips', 'Practical tips for learner drivers', NULL, NULL, NULL, 1, 1, '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(2, 'Road Rules', 'road-rules', 'Updates and explanations of Tasmanian road rules', NULL, NULL, NULL, 1, 2, '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(3, 'Test Preparation', 'test-preparation', 'Getting ready for your driving test', NULL, NULL, NULL, 1, 3, '2026-02-11 21:07:02', '2026-02-11 21:07:02');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `blog_post_id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `author_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','spam','trash') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `moderated_by` bigint UNSIGNED DEFAULT NULL,
  `moderated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint UNSIGNED NOT NULL,
  `blog_category_id` bigint UNSIGNED DEFAULT NULL,
  `author_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_image_alt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `canonical_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','scheduled','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `views_count` int NOT NULL DEFAULT '0',
  `comments_count` int NOT NULL DEFAULT '0',
  `reading_time` int NOT NULL DEFAULT '5',
  `allow_comments` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `blog_category_id`, `author_id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `featured_image_alt`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `status`, `published_at`, `scheduled_at`, `views_count`, `comments_count`, `reading_time`, `allow_comments`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '5 Essential Tips for Your First Driving Lesson', '5-essential-tips-for-your-first-driving-lesson', 'Your first driving lesson can feel overwhelming. Here are five tips to help you get the most out of it and build confidence from day one.', '<p>Your first driving lesson is a big milestone. Here are five tips to make it a success:</p>\n<ol>\n<li><strong>Get a good sleep</strong> – Being well-rested helps you focus and react quickly.</li>\n<li><strong>Wear comfortable shoes</strong> – Avoid thick soles or heels so you can feel the pedals properly.</li>\n<li><strong>Ask questions</strong> – Your instructor is there to help. No question is too small.</li>\n<li><strong>Stay calm</strong> – Everyone was a beginner once. Your instructor will guide you through each step.</li>\n<li><strong>Review the basics</strong> – A quick look at the road rules the night before can help.</li>\n</ol>\n<p>At VIP Driving School we specialise in making first lessons relaxed and positive. Book your first lesson with us today!</p>', NULL, NULL, NULL, NULL, NULL, NULL, 'published', '2026-02-09 21:07:02', NULL, 0, 0, 3, 1, 1, '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(2, 2, 1, 'Understanding Give Way Rules in Tasmania', 'understanding-give-way-rules-in-tasmania', 'Give way rules can be confusing. We break down the key rules you need to know for the Hobart area.', '<p>Give way rules are essential for safe driving. In Tasmania:</p>\n<ul>\n<li>You must give way to vehicles on your right at roundabouts.</li>\n<li>When turning right, give way to oncoming vehicles going straight or turning left.</li>\n<li>At a T-junction, vehicles on the continuing road have right of way.</li>\n<li>Always give way to pedestrians at marked crossings.</li>\n</ul>\n<p>During your lessons we practice these situations in real traffic so they become second nature.</p>', NULL, NULL, NULL, NULL, NULL, NULL, 'published', '2026-01-14 21:07:02', NULL, 0, 0, 3, 1, 1, '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(3, 3, 1, 'How to Prepare for Your P1 Practical Test', 'how-to-prepare-for-your-p1-practical-test', 'A step-by-step guide to preparing for your P1 driving test in Hobart.', '<p>Preparing for your P1 test? Follow these steps:</p>\n<ol>\n<li><strong>Book enough lessons</strong> – Most learners need 20–30 hours of professional instruction.</li>\n<li><strong>Practice in test areas</strong> – Familiarise yourself with common test routes in Hobart.</li>\n<li><strong>Know the test criteria</strong> – Your instructor can run through what the examiner looks for.</li>\n<li><strong>Rest the night before</strong> – Avoid last-minute cramming.</li>\n<li><strong>Arrive early</strong> – Give yourself time to relax before the test.</li>\n</ol>\n<p>We offer dedicated test preparation lessons and mock tests. Ask us when you book.</p>', NULL, NULL, NULL, NULL, NULL, NULL, 'published', '2026-02-08 21:07:02', NULL, 0, 0, 3, 1, 1, '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(4, 1, 1, 'Manual vs Automatic: Which Should You Learn In?', 'manual-vs-automatic-which-should-you-learn-in', 'The pros and cons of learning in a manual or automatic car, and what it means for your licence.', '<p>Choosing between manual and automatic is a common question.</p>\n<p><strong>Automatic</strong> – Easier to learn, less to coordinate, and most new cars are automatic. Your licence will allow you to drive automatic only.</p>\n<p><strong>Manual</strong> – More work to learn, but your licence will allow you to drive both manual and automatic. Useful if you might drive older or work vehicles.</p>\n<p>We offer lessons in both. Talk to your instructor about your goals and we can recommend the best option for you.</p>', NULL, NULL, NULL, NULL, NULL, NULL, 'published', '2026-02-10 21:07:02', NULL, 0, 0, 3, 1, 0, '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(5, 1, 1, 'What to Bring to Your Driving Lesson', 'what-to-bring-to-your-driving-lesson', 'A simple checklist so you never forget anything important for your lesson.', '<p>Bring these to every lesson:</p>\n<ul>\n<li><strong>Learner licence</strong> – You must have it with you whenever you drive.</li>\n<li><strong>Glasses or contacts</strong> – If your licence says you need to wear them.</li>\n<li><strong>Comfortable shoes</strong> – Safe for operating the pedals.</li>\n<li><strong>Water</strong> – Especially in summer.</li>\n<li><strong>Any questions</strong> – Write them down so you remember to ask!</li>\n</ul>\n<p>Your instructor will have everything else – including the car and dual controls. Just bring yourself and your licence.</p>', NULL, NULL, NULL, NULL, NULL, NULL, 'published', '2026-02-01 21:07:02', NULL, 0, 0, 3, 1, 0, '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(6, 2, 1, 'Hazard Perception: How to Spot Risks Early', 'hazard-perception-how-to-spot-risks-early', 'Improving your hazard perception makes you a safer driver and helps you pass the test.', '<p>Good hazard perception is one of the most important skills for safe driving.</p>\n<p>Scan ahead, check mirrors regularly, and look for clues: brake lights, pedestrians near the kerb, cars in side streets, and changing road conditions.</p>\n<p>During lessons we point out hazards in real time and practise the “commentary drive” technique to build your awareness. This is also part of the P1 assessment.</p>', NULL, NULL, NULL, NULL, NULL, NULL, 'published', '2026-01-27 21:07:02', NULL, 0, 0, 3, 1, 0, '2026-02-11 21:07:02', '2026-02-11 21:07:02');

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_tag`
--

CREATE TABLE `blog_post_tag` (
  `blog_post_id` bigint UNSIGNED NOT NULL,
  `blog_tag_id` bigint UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_post_tag`
--

INSERT INTO `blog_post_tag` (`blog_post_id`, `blog_tag_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(2, 6),
(3, 7),
(3, 8),
(3, 9),
(4, 10),
(4, 11),
(4, 12),
(5, 13),
(5, 14),
(5, 15),
(6, 7),
(6, 16),
(6, 17);

-- --------------------------------------------------------

--
-- Table structure for table `blog_tags`
--

CREATE TABLE `blog_tags` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_tags`
--

INSERT INTO `blog_tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'first lesson', 'first-lesson', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(2, 'tips', 'tips', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(3, 'beginners', 'beginners', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(4, 'road rules', 'road-rules', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(5, 'give way', 'give-way', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(6, 'roundabouts', 'roundabouts', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(7, 'P1', 'p1', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(8, 'test', 'test', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(9, 'preparation', 'preparation', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(10, 'manual', 'manual', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(11, 'automatic', 'automatic', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(12, 'learner', 'learner', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(13, 'checklist', 'checklist', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(14, 'lesson', 'lesson', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(15, 'what to bring', 'what-to-bring', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(16, 'hazard perception', 'hazard-perception', '2026-02-11 21:07:02', '2026-02-11 21:07:02'),
(17, 'safety', 'safety', '2026-02-11 21:07:02', '2026-02-11 21:07:02');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `instructor_id` bigint UNSIGNED DEFAULT NULL,
  `booking_reference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `package_id` bigint UNSIGNED DEFAULT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `availability_slot_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_license` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci,
  `pickup_address` text COLLATE utf8mb4_unicode_ci,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `transmission_type` enum('auto','manual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'auto',
  `status` enum('pending','confirmed','completed','cancelled','no_show') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `coupon_id` bigint UNSIGNED DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gift_voucher_id` bigint UNSIGNED DEFAULT NULL,
  `parent_booking_id` bigint UNSIGNED DEFAULT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `recurring_frequency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recurring_count` int DEFAULT NULL,
  `voucher_amount_used` decimal(10,2) NOT NULL DEFAULT '0.00',
  `original_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('pending','paid','refunded','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `stripe_payment_intent_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_charge_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `review_requested` tinyint(1) NOT NULL DEFAULT '0',
  `review_requested_at` timestamp NULL DEFAULT NULL,
  `booking_source` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'website',
  `utm_source` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utm_medium` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utm_campaign` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_id`, `instructor_id`, `booking_reference`, `service_id`, `package_id`, `location_id`, `availability_slot_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_license`, `customer_address`, `pickup_address`, `booking_date`, `booking_time`, `transmission_type`, `status`, `amount`, `coupon_id`, `discount_amount`, `gift_voucher_id`, `parent_booking_id`, `is_recurring`, `recurring_frequency`, `recurring_count`, `voucher_amount_used`, `original_amount`, `payment_status`, `stripe_payment_intent_id`, `stripe_charge_id`, `paid_at`, `notes`, `admin_notes`, `review_requested`, `review_requested_at`, `booking_source`, `utm_source`, `utm_medium`, `utm_campaign`, `cancellation_reason`, `cancelled_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'VDS-MUHLK7CQ', NULL, 2, NULL, NULL, 'John Smith', 'john@demo.com', '0412 345 678', NULL, NULL, NULL, '2026-03-01', '00:07:22', 'auto', 'confirmed', 550.00, NULL, 0.00, NULL, NULL, 0, NULL, NULL, 0.00, NULL, 'paid', 'pi_3T5xXZHEk37jwym90yOkXksS', NULL, '2026-02-28 18:07:22', NULL, NULL, 0, NULL, 'website', NULL, NULL, NULL, NULL, NULL, '2026-02-28 18:07:22', '2026-02-28 18:07:22'),
(2, NULL, NULL, 'VDS-AHV8UNTI', 6, NULL, 1, 302, 'মাফরূহা বীথি', 'mafruhabithi1996@gmail.com', '01640034355', NULL, NULL, 'village# notunbosti(Rajnagar dokkhin), House# 484', '2026-03-02', '09:00:00', 'auto', 'confirmed', 75.00, NULL, 0.00, NULL, NULL, 0, NULL, NULL, 0.00, NULL, 'paid', 'pi_3T5yjRHEk37jwym91MW9GtK7', NULL, '2026-02-28 19:23:43', NULL, NULL, 0, NULL, 'website', NULL, NULL, NULL, NULL, NULL, '2026-02-28 19:23:43', '2026-02-28 19:23:43'),
(3, 7, NULL, 'VDS-AYW24BYG', 6, NULL, 1, 304, 'Black Navy', 'blacknavybd@gmail.com', '01401493935', '333333333333333333', NULL, '265/266,road -5,bock-cha,section-2,mirpur,dhaka-1216', '2026-03-04', '09:00:00', 'auto', 'confirmed', 75.00, NULL, 0.00, NULL, NULL, 0, NULL, NULL, 0.00, NULL, 'paid', 'pi_3T5z3UHEk37jwym90kwebG9F', NULL, '2026-02-28 19:44:27', 'de', NULL, 0, NULL, 'website', NULL, NULL, NULL, NULL, NULL, '2026-02-28 19:44:27', '2026-02-28 19:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cancellation_requests`
--

CREATE TABLE `cancellation_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `refund_type` enum('full','partial','none','credit') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','approved','rejected','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `stripe_refund_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `processed_by` bigint UNSIGNED DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('percentage','fixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) DEFAULT NULL,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `applicable_services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `applicable_packages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `applicable_locations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `first_booking_only` tinyint(1) NOT NULL DEFAULT '0',
  `usage_limit` int DEFAULT NULL,
  `usage_limit_per_customer` int NOT NULL DEFAULT '1',
  `times_used` int NOT NULL DEFAULT '0',
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint UNSIGNED NOT NULL,
  `coupon_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `suburb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `profile_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferred_transmission` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'auto',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `email_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `sms_notifications` tinyint(1) NOT NULL DEFAULT '0',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `license_number`, `address`, `suburb`, `postcode`, `date_of_birth`, `profile_photo`, `preferred_transmission`, `is_active`, `email_notifications`, `sms_notifications`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John Smith', 'john@demo.com', NULL, '$2y$12$wmsvx3xEiS20ICN9/Vvsz.7x1PyFXZsYMBSLwB2Kr3msO96O10S3.', '0412 345 678', 'L1234567', '123 Collins Street', 'Hobart', '7000', NULL, NULL, 'auto', 1, 1, 0, '2026-02-28 18:06:46', 'fdVEuGYxya12lN9K4HhSU9AFEZ40JKDLzfcNySGUslK51BykCtBuTzgcuKBL', '2026-02-11 21:06:53', '2026-02-28 18:06:46'),
(2, 'Sarah Wilson', 'sarah@demo.com', NULL, '$2y$12$03MELbf7epriFrqnk85GU.z6p6XHofY.KN18LuU9BSHumXcWclOVW', '0423 456 789', NULL, '45 Main Road', 'Glenorchy', '7010', NULL, NULL, 'manual', 1, 1, 0, NULL, NULL, '2026-02-11 21:06:53', '2026-02-11 21:15:04'),
(3, 'Mike Johnson', 'mike@demo.com', NULL, '$2y$12$NnVJ.Nju8MsfBC9gd/KawOJLrkCk07Lwz3MzJlDhWvFBeZ0H3spW2', '0434 567 890', 'L7654321', '78 Channel Highway', 'Kingston', '7050', NULL, NULL, 'auto', 1, 1, 0, NULL, NULL, '2026-02-11 21:06:53', '2026-02-11 21:15:04'),
(4, 'Test Customer', 'test@example.com', NULL, '$2y$12$sralUJwOKK89QoxepulxvOkhWXL3xrWlSk0GTme.U1tZnDLGfMj4.', '0400000000', NULL, NULL, NULL, NULL, NULL, NULL, 'auto', 1, 1, 0, '2026-02-28 01:14:30', 'qLHvz7PrHzIAdMYM45idcAU2NGEsuyB0Rz7d9erZJ0WcEshjc0b6hfabx4ei', '2026-02-28 00:57:41', '2026-02-28 01:14:30'),
(5, 'Iyas Kayes', 'i.k.shuvo@gmail.com', NULL, '$2y$12$coIgNyDIQeMiu4hu820J/O/eOoF4KUjSd6BmP7tTAl0elHpWsH0ce', '01710534320', NULL, NULL, NULL, NULL, NULL, NULL, 'auto', 1, 1, 0, '2026-02-28 07:33:01', NULL, '2026-02-28 05:08:58', '2026-02-28 07:33:01'),
(6, 'zahid Ahmed', 'zahiislink@gmail.com', NULL, '$2y$12$tK9bRVP19lKBvkKl7Vp/1eVLN/MVR2TN2Qa55B8aAEiQEWBjWreVm', '0000000003', NULL, NULL, NULL, NULL, NULL, NULL, 'auto', 1, 1, 0, '2026-02-28 11:10:38', NULL, '2026-02-28 11:10:38', '2026-02-28 11:10:38'),
(7, 'Black Navy', 'blacknavybd@gmail.com', NULL, '$2y$12$vLFnZ505s5gIKVkvqDXjVerV0F0heZ5SFgQF6.fAGUqsWoTUWyAwO', '01401493935', '333333333333333333', '265/266,road -5,bock-cha,section-2,mirpur,dhaka-1216', NULL, NULL, NULL, NULL, 'auto', 1, 1, 0, '2026-02-28 19:44:31', NULL, '2026-02-28 19:44:27', '2026-02-28 19:44:31');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pdf',
  `file_size` int DEFAULT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `download_count` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_campaigns`
--

CREATE TABLE `email_campaigns` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preview_text` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','scheduled','sending','sent','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `recipients_count` int NOT NULL DEFAULT '0',
  `opens_count` int NOT NULL DEFAULT '0',
  `clicks_count` int NOT NULL DEFAULT '0',
  `bounces_count` int NOT NULL DEFAULT '0',
  `unsubscribes_count` int NOT NULL DEFAULT '0',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `question` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `category`, `page`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'What do I need to bring to my driving lesson?', 'You must bring your valid learner\'s licence to every lesson. We also recommend wearing comfortable clothing and flat shoes. If you wear glasses or contact lenses for driving, please bring them.', 'general', NULL, 1, 1, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(2, 'Do you offer pick-up and drop-off?', 'Yes! We offer free pick-up and drop-off within our service areas including Hobart CBD, Glenorchy, Kingston, Moonah, and Sandy Bay. Just let us know your preferred location when booking.', 'general', NULL, 1, 2, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(3, 'How do I book a lesson?', 'You can book online through our website 24/7, or call us during business hours. Online booking is the quickest way to secure your preferred time slot.', 'general', NULL, 1, 3, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(4, 'What happens if I don\'t use all my package lessons?', 'Package lessons are valid for the period specified at purchase (typically 3-12 months depending on the package). Unused lessons after this period will expire. We recommend booking lessons regularly to make the most of your package.', 'packages', NULL, 1, 1, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(5, 'Can I share my package with someone else?', 'No, lesson packages are non-transferable and can only be used by the person who purchased them.', 'packages', NULL, 1, 2, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(6, 'What is the difference between your packages?', 'Our packages differ in the number of lessons included and the savings offered. Larger packages provide better value per lesson and are ideal for learners who need more practice. The 10-lesson package is our most popular choice for most learners.', 'packages', NULL, 1, 3, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(7, 'What is your cancellation policy?', 'We require at least 24 hours notice for cancellations or reschedules. Cancellations made less than 24 hours before the lesson may incur a 50% fee. No-shows will be charged the full lesson amount.', 'booking', NULL, 1, 1, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(8, 'Can I reschedule my booking?', 'Yes, you can reschedule with at least 24 hours notice at no extra charge. Please contact us or use our online booking system to make changes.', 'booking', NULL, 1, 2, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(9, 'What payment methods do you accept?', 'We accept all major credit and debit cards (Visa, Mastercard, American Express) for online payments. Payment is required at the time of booking.', 'payment', NULL, 1, 1, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(10, 'Are your prices inclusive of GST?', 'Yes, all prices displayed on our website are inclusive of GST.', 'payment', NULL, 1, 2, '2026-02-11 12:22:47', '2026-02-11 12:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `gift_vouchers`
--

CREATE TABLE `gift_vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('fixed','package') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `amount` decimal(10,2) DEFAULT NULL,
  `package_id` bigint UNSIGNED DEFAULT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaser_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchaser_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchaser_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `stripe_payment_intent_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_charge_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('pending','paid','failed','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','partially_used','fully_used','expired','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `expires_at` date NOT NULL,
  `redeemed_at` timestamp NULL DEFAULT NULL,
  `redeemed_by` bigint UNSIGNED DEFAULT NULL,
  `redeemed_booking_id` bigint UNSIGNED DEFAULT NULL,
  `email_sent` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `info_cards`
--

CREATE TABLE `info_cards` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fontawesome',
  `page` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home',
  `section` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info_cards`
--

INSERT INTO `info_cards` (`id`, `title`, `content`, `icon`, `icon_type`, `page`, `section`, `link_url`, `link_text`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Auto & Manual', 'Choose between automatic or manual transmission vehicles for your lessons.', 'fas fa-car', 'fontawesome', 'home', NULL, NULL, NULL, 1, 1, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(2, 'Valid Licence Required', 'You must hold a valid learner\'s licence to book lessons with us.', 'fas fa-id-card', 'fontawesome', 'home', NULL, NULL, NULL, 1, 2, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(3, 'Experienced Instructors', 'All our instructors are fully qualified, accredited, and patient.', 'fas fa-user-graduate', 'fontawesome', 'home', NULL, NULL, NULL, 1, 3, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(4, 'Dual Control Vehicles', 'Learn in safe, modern dual-control vehicles for your peace of mind.', 'fas fa-shield-alt', 'fontawesome', 'home', NULL, NULL, NULL, 1, 4, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(5, 'Flexible Scheduling', 'Book lessons at times that suit you. We offer weekday and weekend appointments.', 'fas fa-calendar-check', 'fontawesome', 'lesson-packages', NULL, NULL, NULL, 1, 1, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(6, 'Pick-up & Drop-off', 'We pick you up from home, work, or school within our service areas.', 'fas fa-map-marker-alt', 'fontawesome', 'lesson-packages', NULL, NULL, NULL, 1, 2, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(7, 'Easy Online Booking', 'Book your lesson in minutes with our simple online booking system.', 'fas fa-laptop', 'fontawesome', 'book-online', NULL, NULL, NULL, 1, 1, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(8, 'Secure Payments', 'Pay securely online with credit card. All payments are encrypted.', 'fas fa-lock', 'fontawesome', 'book-online', NULL, NULL, NULL, 1, 2, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(9, '24-Hour Notice', 'Please provide at least 24 hours notice for cancellations or changes.', 'fas fa-clock', 'fontawesome', 'book-online', NULL, NULL, NULL, 1, 3, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(10, 'Minimum Driving Experience', 'You must have held your learner licence for at least 12 months.', 'fas fa-calendar', 'fontawesome', 'p1-assessments', 'things-to-know', NULL, NULL, 1, 1, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(11, 'Log Book Hours', 'Complete minimum 50 hours of supervised driving including 10 night hours.', 'fas fa-book', 'fontawesome', 'p1-assessments', 'things-to-know', NULL, NULL, 1, 2, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(12, 'Learner Licence', 'Bring your current valid learner licence.', 'fas fa-id-card', 'fontawesome', 'p1-assessments', 'things-to-bring', NULL, NULL, 1, 1, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(13, 'Log Book', 'Bring your completed log book if required.', 'fas fa-clipboard-list', 'fontawesome', 'p1-assessments', 'things-to-bring', NULL, NULL, 1, 2, '2026-02-11 12:22:47', '2026-02-11 12:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `qualifications` text COLLATE utf8mb4_unicode_ci,
  `years_experience` int NOT NULL DEFAULT '0',
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_expiry` date DEFAULT NULL,
  `specializations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `available_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `available_from` time NOT NULL DEFAULT '08:00:00',
  `available_to` time NOT NULL DEFAULT '18:00:00',
  `service_areas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `rating` decimal(3,2) NOT NULL DEFAULT '5.00',
  `total_reviews` int NOT NULL DEFAULT '0',
  `total_lessons` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `name`, `slug`, `email`, `phone`, `bio`, `qualifications`, `years_experience`, `photo`, `license_number`, `license_expiry`, `specializations`, `available_days`, `available_from`, `available_to`, `service_areas`, `rating`, `total_reviews`, `total_lessons`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'David Brown', 'david-brown', 'david.brown@vipdrivingschool.com.au', '0401 111 222', 'David has been teaching driving for over 12 years. He specialises in helping nervous learners build confidence and pass their test first time.', 'Accredited Driving Instructor, Defensive Driving Certified', 12, NULL, NULL, NULL, '[\"automatic\", \"manual\", \"test_preparation\"]', '[\"monday\", \"tuesday\", \"wednesday\", \"thursday\", \"friday\"]', '08:00:00', '17:00:00', NULL, 4.90, 127, 2100, 1, 1, 1, '2026-02-11 21:07:01', '2026-02-11 21:07:01'),
(2, 'Emma Roberts', 'emma-roberts', 'emma.roberts@vipdrivingschool.com.au', '0402 222 333', 'Emma is passionate about road safety and making every lesson count. She has a calm, patient approach that students love.', 'Accredited Driving Instructor, First Aid Certified', 8, NULL, NULL, NULL, '[\"automatic\", \"defensive\"]', '[\"tuesday\", \"wednesday\", \"thursday\", \"friday\", \"saturday\"]', '09:00:00', '18:00:00', NULL, 4.95, 89, 1450, 1, 1, 2, '2026-02-11 21:07:01', '2026-02-11 21:07:01'),
(3, 'James Taylor', 'james-taylor', 'james.taylor@vipdrivingschool.com.au', '0403 333 444', 'James teaches both automatic and manual vehicles. He is known for his clear instructions and focus on hazard perception.', 'Accredited Driving Instructor, Manual & Automatic', 6, NULL, NULL, NULL, '[\"automatic\", \"manual\", \"test_preparation\"]', '[\"monday\", \"wednesday\", \"friday\", \"saturday\"]', '08:30:00', '16:30:00', NULL, 4.85, 64, 980, 0, 1, 3, '2026-02-11 21:07:01', '2026-02-11 21:07:01');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_suburb`
--

CREATE TABLE `instructor_suburb` (
  `instructor_id` bigint UNSIGNED NOT NULL,
  `suburb_id` bigint UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructor_suburb`
--

INSERT INTO `instructor_suburb` (`instructor_id`, `suburb_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `instructor_unavailabilities`
--

CREATE TABLE `instructor_unavailabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `instructor_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `departure_info` text COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `available_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `available_days_text` text COLLATE utf8mb4_unicode_ci,
  `map_embed_code` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `slug`, `address`, `departure_info`, `latitude`, `longitude`, `available_days`, `available_days_text`, `map_embed_code`, `image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Hobart CBD', 'hobart-cbd', 'Hobart CBD, TAS 7000', 'Central Hobart area including city streets, residential areas, and main roads.', NULL, NULL, '[\"Monday\", \"Tuesday\", \"Wednesday\", \"Thursday\", \"Friday\", \"Saturday\"]', 'Monday - Saturday', NULL, 'locations/arawTojKvgJdPJzJSR5qadDWXlCTzvlGPhs4FGis.jpg', 1, 1, '2026-02-11 12:21:34', '2026-02-28 02:19:47'),
(2, 'Glenorchy', 'glenorchy', 'Glenorchy, TAS 7010', 'Glenorchy area including Main Road, shopping centre vicinity, and surrounding suburbs.', NULL, NULL, '[\"Monday\", \"Tuesday\", \"Wednesday\", \"Thursday\", \"Friday\"]', 'Monday - Friday', NULL, 'locations/xM3hJj898mar2a0HiQRHBABSEDyVxH2QBPIEkaMc.jpg', 1, 2, '2026-02-11 12:21:34', '2026-02-28 02:20:34'),
(3, 'Kingston', 'kingston', 'Kingston, TAS 7050', 'Kingston and surrounding southern suburbs.', NULL, NULL, '[\"Tuesday\", \"Thursday\", \"Saturday\"]', 'Tuesday, Thursday & Saturday', NULL, 'locations/bhzAiCix9s2TvP8uibaCFGj4iqcgMxDXu33LUMr4.jpg', 1, 3, '2026-02-11 12:21:34', '2026-02-28 02:20:48'),
(4, 'Moonah', 'moonah', 'Moonah, TAS 7009', 'Moonah area including Main Road and surrounding streets.', NULL, NULL, '[\"Monday\", \"Wednesday\", \"Friday\"]', 'Monday, Wednesday & Friday', NULL, 'locations/jnNIqroAf1VuER2pEuScq3SsYW5DVar86KpsT3O2.jpg', 1, 4, '2026-02-11 12:21:34', '2026-02-28 02:21:11'),
(5, 'Sandy Bay', 'sandy-bay', 'Sandy Bay, TAS 7005', 'Sandy Bay area including university precinct and surrounding residential areas.', NULL, NULL, '[\"Monday\", \"Tuesday\", \"Wednesday\", \"Thursday\", \"Friday\"]', 'Monday - Friday', NULL, 'locations/3DyAFa0GXBECjbppKhkEmf30C2CJ1q0lVDcHoKmG.jpg', 1, 5, '2026-02-11 12:21:34', '2026-02-28 02:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_settings_table', 1),
(5, '2024_01_01_000002_create_pages_table', 1),
(6, '2024_01_01_000003_create_service_categories_table', 1),
(7, '2024_01_01_000004_create_locations_table', 1),
(8, '2024_01_01_000005_create_services_table', 1),
(9, '2024_01_01_000006_create_packages_table', 1),
(10, '2024_01_01_000007_create_availability_slots_table', 1),
(11, '2024_01_01_000008_create_bookings_table', 1),
(12, '2024_01_01_000009_create_testimonials_table', 1),
(13, '2024_01_01_000010_create_info_cards_table', 1),
(14, '2024_01_01_000011_create_faqs_table', 1),
(15, '2024_01_01_000012_create_documents_table', 1),
(16, '2024_01_01_000013_create_contact_submissions_table', 1),
(17, '2024_01_01_000014_add_role_to_users_table', 1),
(18, '2024_01_01_000020_add_pickup_address_to_bookings_table', 2),
(19, '2026_02_12_014723_add_menu_options_to_pages_table', 3),
(20, '2026_02_12_015458_create_customers_table', 4),
(21, '2026_02_12_015459_create_gift_vouchers_table', 4),
(22, '2026_02_12_015501_create_instructors_table', 4),
(23, '2026_02_12_015503_create_coupons_table', 4),
(24, '2026_02_12_015504_create_waitlists_table', 4),
(25, '2026_02_12_015506_create_reviews_table', 4),
(26, '2026_02_12_015508_create_newsletter_subscribers_table', 4),
(27, '2026_02_12_015510_create_blog_categories_table', 4),
(28, '2026_02_12_015511_create_blog_posts_table', 4),
(29, '2026_02_12_015513_create_blog_comments_table', 4),
(30, '2026_02_12_015514_create_suburbs_table', 4),
(31, '2026_02_12_015516_create_theory_categories_table', 4),
(32, '2026_02_12_015517_create_theory_questions_table', 4),
(33, '2026_02_12_015518_create_theory_attempts_table', 4),
(34, '2026_02_12_015520_add_customer_and_instructor_to_bookings_table', 4),
(35, '2026_02_12_145725_add_instructor_id_to_availability_slots_table', 5),
(36, '2026_02_15_150410_add_is_recurring_to_availability_slots_table', 6),
(37, '2026_02_15_162651_add_recurring_fields_to_availability_slots_table_v2', 7),
(38, '2026_02_15_165656_add_pattern_type_to_availability_slots_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','subscribed','unsubscribed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `confirmation_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `unsubscribe_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `source` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'website',
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lesson_count` int NOT NULL,
  `lesson_duration` int NOT NULL DEFAULT '50',
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `tagline` text COLLATE utf8mb4_unicode_ci,
  `validity_days` int NOT NULL DEFAULT '365',
  `validity_text` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Valid for one year',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `slug`, `lesson_count`, `lesson_duration`, `price`, `original_price`, `description`, `tagline`, `validity_days`, `validity_text`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, '5 Lesson Package', '5-lesson-package', 5, 60, 300.00, 350.00, 'Save $50! Great for beginners starting their driving journey. 5 hours of professional instruction.', 'An Affordable and Practical Start', 90, 'Valid for 3 months', 0, 1, 1, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(2, '10 Lesson Package', '10-lesson-package', 10, 60, 550.00, 700.00, 'Save $150! Our most popular package. Perfect for learners who want to build solid driving skills.', 'Most Popular Choice', 180, 'Valid for 6 months', 1, 1, 2, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(3, '15 Lesson Package', '15-lesson-package', 15, 60, 750.00, 1050.00, 'Save $300! Comprehensive package for thorough preparation. Ideal for nervous drivers.', 'Best Value for Money', 240, 'Valid for 8 months', 0, 1, 3, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(4, '20 Lesson Package', '20-lesson-package', 20, 60, 900.00, 1400.00, 'Save $500! The ultimate preparation package. From complete beginner to test-ready.', 'Complete Learner Package', 365, 'Valid for one year', 0, 1, 4, '2026-02-11 12:22:47', '2026-02-11 12:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `featured_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `show_in_navbar` tinyint(1) NOT NULL DEFAULT '0',
  `show_in_footer` tinyint(1) NOT NULL DEFAULT '1',
  `navbar_order` int NOT NULL DEFAULT '0',
  `footer_order` int NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `meta_description`, `meta_keywords`, `content`, `featured_image`, `is_active`, `show_in_navbar`, `show_in_footer`, `navbar_order`, `footer_order`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'About Us', 'about-us', 'Learn about VIP Driving School Hobart - your trusted partner for professional driving lessons and P1 assessments in Tasmania.', NULL, '<h2>Welcome to VIP Driving School Hobart</h2>\r\n<p>VIP Driving School has been providing professional driving instruction in Hobart and surrounding areas for over 10 years. Our mission is to help learner drivers develop the skills and confidence they need to become safe, responsible drivers.</p>\r\n\r\n<h3>Our Commitment</h3>\r\n<p>We believe that learning to drive should be a positive experience. Our patient, friendly instructors create a supportive learning environment where students can develop their skills at their own pace.</p>\r\n\r\n<h3>Why Choose Us?</h3>\r\n<ul>\r\n    <li>Fully qualified and accredited instructors</li>\r\n    <li>Modern, dual-control vehicles</li>\r\n    <li>Flexible lesson times including weekends</li>\r\n    <li>Pick-up and drop-off service</li>\r\n    <li>Competitive pricing with package discounts</li>\r\n</ul>\r\n\r\n<h3>Our Team</h3>\r\n<p>Our team of experienced instructors are passionate about road safety and dedicated to helping you achieve your driving goals. All instructors hold current accreditation and undergo regular professional development.</p>', NULL, 1, 0, 1, 0, 0, 1, '2026-02-11 12:47:20', '2026-02-11 19:44:56'),
(2, 'Terms and Conditions', 'terms-and-conditions', 'Terms and conditions for VIP Driving School Hobart services.', NULL, '<h2>Terms and Conditions</h2>\n\n<h3>1. Booking and Cancellation Policy</h3>\n<p>All lessons must be booked in advance. Cancellations must be made at least 24 hours before the scheduled lesson time. Late cancellations or no-shows may incur a cancellation fee.</p>\n\n<h3>2. Payment Terms</h3>\n<p>Payment is required at the time of booking unless otherwise arranged. We accept all major credit cards, debit cards, and bank transfers.</p>\n\n<h3>3. Lesson Requirements</h3>\n<p>Students must hold a valid learner\'s licence and present it at the start of each lesson. Students under the influence of alcohol or drugs will not be permitted to take their lesson.</p>\n\n<h3>4. Package Validity</h3>\n<p>Lesson packages are valid for 12 months from the date of purchase unless otherwise stated. Packages are non-transferable and non-refundable.</p>\n\n<h3>5. Instructor Assignment</h3>\n<p>While we endeavor to maintain consistency with instructor assignments, we reserve the right to assign alternative instructors when necessary.</p>\n\n<h3>6. Liability</h3>\n<p>VIP Driving School maintains comprehensive insurance coverage. However, students are responsible for any damage caused by deliberate misconduct or failure to follow instructor directions.</p>', NULL, 1, 0, 1, 0, 0, 2, '2026-02-11 12:47:20', '2026-02-11 12:47:20'),
(3, 'Privacy Policy', 'privacy-policy', 'Privacy policy for VIP Driving School Hobart - how we collect, use, and protect your personal information.', NULL, '<h2>Privacy Policy</h2>\n\n<h3>Information We Collect</h3>\n<p>We collect personal information necessary to provide our driving instruction services, including:</p>\n<ul>\n    <li>Name and contact details</li>\n    <li>Learner\'s licence information</li>\n    <li>Payment information</li>\n    <li>Booking and lesson history</li>\n</ul>\n\n<h3>How We Use Your Information</h3>\n<p>Your information is used to:</p>\n<ul>\n    <li>Process bookings and payments</li>\n    <li>Communicate with you about lessons</li>\n    <li>Improve our services</li>\n    <li>Comply with legal requirements</li>\n</ul>\n\n<h3>Information Security</h3>\n<p>We take reasonable steps to protect your personal information from unauthorized access, modification, or disclosure.</p>\n\n<h3>Third Party Disclosure</h3>\n<p>We do not sell or share your personal information with third parties except as necessary to provide our services or as required by law.</p>\n\n<h3>Contact Us</h3>\n<p>If you have questions about our privacy practices, please contact us.</p>', NULL, 1, 0, 1, 0, 0, 3, '2026-02-11 12:47:20', '2026-02-11 12:47:20'),
(4, 'Refund Policy', 'refund-policy', 'Refund policy for VIP Driving School Hobart lessons and packages.', NULL, '<h2>Refund Policy</h2>\n\n<h3>Individual Lessons</h3>\n<p>Individual lessons cancelled with more than 24 hours notice will receive a full refund or credit. Late cancellations (less than 24 hours notice) may forfeit up to 50% of the lesson fee.</p>\n\n<h3>Lesson Packages</h3>\n<p>Lesson packages may be refunded within 14 days of purchase if no lessons have been used. After lessons have commenced, packages are non-refundable but may be transferred to another person with management approval.</p>\n\n<h3>How to Request a Refund</h3>\n<p>To request a refund, please contact us with your booking details. Refunds are typically processed within 5-7 business days.</p>\n\n<h3>Exceptional Circumstances</h3>\n<p>We understand that unexpected circumstances can arise. Please contact us to discuss your situation and we will do our best to accommodate your needs.</p>', NULL, 1, 0, 1, 0, 0, 4, '2026-02-11 12:47:20', '2026-02-11 12:47:20');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reschedule_requests`
--

CREATE TABLE `reschedule_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `original_date` date NOT NULL,
  `original_time` time NOT NULL,
  `requested_date` date NOT NULL,
  `requested_time` time DEFAULT NULL,
  `new_slot_id` bigint UNSIGNED DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `processed_by` bigint UNSIGNED DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `package_id` bigint UNSIGNED DEFAULT NULL,
  `instructor_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `overall_rating` tinyint NOT NULL,
  `instructor_rating` tinyint DEFAULT NULL,
  `vehicle_rating` tinyint DEFAULT NULL,
  `value_rating` tinyint DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_response` text COLLATE utf8mb4_unicode_ci,
  `admin_responded_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `moderated_by` bigint UNSIGNED DEFAULT NULL,
  `moderated_at` timestamp NULL DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `show_on_homepage` tinyint(1) NOT NULL DEFAULT '0',
  `helpful_count` int NOT NULL DEFAULT '0',
  `review_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_requested_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_helpful`
--

CREATE TABLE `review_helpful` (
  `id` bigint UNSIGNED NOT NULL,
  `review_id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `duration` int NOT NULL DEFAULT '50',
  `transmission_type` enum('auto','manual','both') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'auto',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `location_id`, `name`, `slug`, `short_description`, `description`, `price`, `duration`, `transmission_type`, `image`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '1 Hour Driving Lesson (Auto)', '1-hour-driving-lesson-auto', NULL, 'Standard 1-hour driving lesson in an automatic vehicle. Perfect for building confidence and skills.', 70.00, 60, 'auto', NULL, 1, 1, 1, '2026-02-11 12:22:10', '2026-02-11 12:22:10'),
(2, 1, NULL, '1 Hour Driving Lesson (Manual)', '1-hour-driving-lesson-manual', NULL, 'Standard 1-hour driving lesson in a manual vehicle. Master clutch control and gear changes.', 80.00, 60, 'manual', NULL, 0, 1, 2, '2026-02-11 12:22:10', '2026-02-11 12:22:10'),
(3, 1, NULL, '2 Hour Driving Lesson (Auto)', '2-hour-driving-lesson-auto', NULL, 'Extended 2-hour driving lesson in an automatic vehicle. More time to practice and improve.', 130.00, 120, 'auto', NULL, 1, 1, 3, '2026-02-11 12:22:10', '2026-02-11 12:22:10'),
(4, 2, NULL, 'P1 Driving Assessment', 'p1-driving-assessment', NULL, 'Official P1 driver assessment. Includes pre-assessment vehicle familiarisation.', 230.00, 60, 'auto', NULL, 1, 1, 1, '2026-02-11 12:22:10', '2026-02-11 12:22:10'),
(5, 2, NULL, 'P1 Assessment + 1 Hour Lesson', 'p1-assessment-with-lesson', NULL, 'P1 assessment with a 1-hour pre-assessment driving lesson to ensure you\'re prepared.', 290.00, 120, 'auto', NULL, 0, 1, 2, '2026-02-11 12:22:10', '2026-02-11 12:22:10'),
(6, 2, 1, 'Refresher Driving Lesson', 'refresher-driving-lesson', NULL, 'Ideal for licensed drivers who need to refresh their skills and confidence.', 75.00, 60, 'both', 'services/ObIVr1Pd7CTbLi8Neen7f56YZtQ8sP94wMLnwIe1.jpg', 0, 1, 1, '2026-02-11 12:22:10', '2026-02-28 02:01:06'),
(7, 2, 3, '50 Min Lesson - Manual (Kingston)', '50-min-lesson-manual-kingston', 'Departing from Kingborough Community Hub, Goshawk Way, Kingston', 'Departing from Kingborough Community Hub, Goshawk Way, Kingston', 80.00, 50, 'auto', NULL, 1, 1, 0, '2026-02-28 07:28:57', '2026-02-28 07:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `icon`, `image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Driving Lessons', 'driving-lessons', 'Professional driving lessons for learners at all skill levels.', 'fas fa-car', NULL, 1, 1, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(2, 'P1 Assessments', 'p1-assessments', 'Practical driving assessment to obtain your P1 licence.', 'fas fa-clipboard-check', NULL, 1, 2, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(4, 'Single Leassons', 'single-leassons', 'Professional driving lessons for learners at all skill levels.', NULL, NULL, 1, 0, '2026-02-28 19:49:04', '2026-02-28 19:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('q3JJ3oRdX9pCZGVzrRfydWGS99j6JBPJqCYAlg0L', NULL, '103.177.221.62', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMmNZdXo4UDdMelhLVUZ2R1ByU1VvUkhRR1gxenhCTjF5bURSRXcwNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vcmFqc2ViYS54eXovYWNjb3VudC9wcm9maWxlIjtzOjU6InJvdXRlIjtzOjE2OiJjdXN0b21lci5wcm9maWxlIjt9czo1NToibG9naW5fY3VzdG9tZXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1772324082),
('Q8BVrPWEOVUCxGco1tXVBr2qJDi9RM8fhLz74mEu', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoic2Y2OHZYUzlYQVZUTkdXNHRnQVhYZU1WRDVGaXVOYmVhNm9hcFN0eSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMzoiZnJvbnRlbmQuaG9tZSI7fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc3MjMyOTc4Nzt9fQ==', 1772330791),
('c57DXpTtEJG7FZDYn8KVpnrqOdAmUZ2XICyMj4iV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7705', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmRxQWEwNU04ZlozaTA1amM3bkNxUW1WWGxPZ0l5ZGZRRU9Idk9udyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ib29rLW9ubGluZT9zZXJ2aWNlPTYiO3M6NToicm91dGUiO3M6MTE6ImJvb2stb25saW5lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772328079),
('M5M7AcS4dMnRxFT5WdBzhfCiHN7hXnNX7sgLwzum', NULL, '127.0.0.1', 'curl/8.16.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXVlbUhsVlF2MndRMWVmd212SGliS1FzQm5Rd0hqdm83cGc3VkNCSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ib29rLW9ubGluZT9zZXJ2aWNlPTYiO3M6NToicm91dGUiO3M6MTE6ImJvb2stb25saW5lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772328102),
('eaDMYKQzWKdo4SusN4BXE0pQU1NRIUbFxE8Wy7PJ', NULL, '127.0.0.1', 'curl/8.16.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWdvdVd6WWw2Wmd1RFNqMzA4VGdzaXdWanJ0TEdiYnNBcm53SFB0aiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ib29rLW9ubGluZT9zZXJ2aWNlPTYiO3M6NToicm91dGUiO3M6MTE6ImJvb2stb25saW5lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772328372),
('boICjkRkoGeLLSrgtLmfiA69AI0EoSS3sr3rhV1t', NULL, '127.0.0.1', 'curl/8.16.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZUZoQ1lyMk55emlyUkprUklMS1I2OWtEMWRTVUJScVhGQXg1d1ZjTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ib29rLW9ubGluZT9zZXJ2aWNlPTYiO3M6NToicm91dGUiO3M6MTE6ImJvb2stb25saW5lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6Mjp7aTowO3M6MTA6Il9vbGRfaW5wdXQiO2k6MTtzOjY6ImVycm9ycyI7fXM6MzoibmV3IjthOjA6e319czoxMDoiX29sZF9pbnB1dCI7YToxOntzOjY6Il90b2tlbiI7czo0MDoiZUZoQ1lyMk55emlyUkprUklMS1I2OWtEMWRTVUJScVhGQXg1d1ZjTyI7fXM6NjoiZXJyb3JzIjtPOjMxOiJJbGx1bWluYXRlXFN1cHBvcnRcVmlld0Vycm9yQmFnIjoxOntzOjc6IgAqAGJhZ3MiO2E6MTp7czo3OiJkZWZhdWx0IjtPOjI5OiJJbGx1bWluYXRlXFN1cHBvcnRcTWVzc2FnZUJhZyI6Mjp7czoxMToiACoAbWVzc2FnZXMiO2E6ODp7czoxMjoiYm9va2luZ19kYXRlIjthOjE6e2k6MDtzOjM1OiJUaGUgYm9va2luZyBkYXRlIGZpZWxkIGlzIHJlcXVpcmVkLiI7fXM6MTI6ImJvb2tpbmdfdGltZSI7YToxOntpOjA7czozNToiVGhlIGJvb2tpbmcgdGltZSBmaWVsZCBpcyByZXF1aXJlZC4iO31zOjEwOiJmaXJzdF9uYW1lIjthOjE6e2k6MDtzOjMzOiJUaGUgZmlyc3QgbmFtZSBmaWVsZCBpcyByZXF1aXJlZC4iO31zOjk6Imxhc3RfbmFtZSI7YToxOntpOjA7czozMjoiVGhlIGxhc3QgbmFtZSBmaWVsZCBpcyByZXF1aXJlZC4iO31zOjU6ImVtYWlsIjthOjE6e2k6MDtzOjI4OiJUaGUgZW1haWwgZmllbGQgaXMgcmVxdWlyZWQuIjt9czo1OiJwaG9uZSI7YToxOntpOjA7czoyODoiVGhlIHBob25lIGZpZWxkIGlzIHJlcXVpcmVkLiI7fXM6MTI6InRyYW5zbWlzc2lvbiI7YToxOntpOjA7czozNToiVGhlIHRyYW5zbWlzc2lvbiBmaWVsZCBpcyByZXF1aXJlZC4iO31zOjE0OiJwYXltZW50X21ldGhvZCI7YToxOntpOjA7czozNzoiVGhlIHBheW1lbnQgbWV0aG9kIGZpZWxkIGlzIHJlcXVpcmVkLiI7fX1zOjk6IgAqAGZvcm1hdCI7czo4OiI6bWVzc2FnZSI7fX19fQ==', 1772328384);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `label`, `description`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'VIP Driving School Hobart', 'text', 'general', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(2, 'site_tagline', 'Learn to Drive with Confidence', 'text', 'general', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(3, 'contact_email', 'info@vipdrivingschool.com.au', 'text', 'contact', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(4, 'contact_phone', '0400 000 000', 'text', 'contact', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(5, 'admin_email', 'admin@vipdrivingschool.com.au', 'text', 'contact', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(6, 'business_address', '123 Main Street, Hobart TAS 7000', 'text', 'contact', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(7, 'facebook_url', 'https://facebook.com/vipdrivingschoolhobart', 'text', 'social', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(8, 'instagram_url', 'https://instagram.com/vipdrivingschoolhobart', 'text', 'social', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(9, 'google_url', '', 'text', 'social', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(10, 'business_hours_weekday', '8:00 AM - 6:00 PM', 'text', 'hours', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(11, 'business_hours_saturday', '8:00 AM - 4:00 PM', 'text', 'hours', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(12, 'business_hours_sunday', 'Closed', 'text', 'hours', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(13, 'booking_advance_days', '30', 'text', 'booking', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(14, 'cancellation_notice_hours', '24', 'text', 'booking', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(15, 'currency', 'AUD', 'text', 'payment', NULL, NULL, '2026-02-11 12:21:00', '2026-02-11 12:21:00'),
(16, 'stripe_key', 'pk_test_sGyH01XZwQrnTl6j6pOKgz9k', 'text', 'stripe', NULL, NULL, '2026-02-28 18:05:53', '2026-02-28 18:05:53'),
(17, 'stripe_secret', 'sk_test_IwW9d0mRJf5my01dRWnADnEc', 'text', 'stripe', NULL, NULL, '2026-02-28 18:05:53', '2026-02-28 18:05:53'),
(18, 'stripe_webhook_secret', 'whsec_your_webhook_secret', 'text', 'stripe', NULL, NULL, '2026-02-28 18:05:53', '2026-02-28 18:05:53');

-- --------------------------------------------------------

--
-- Table structure for table `suburbs`
--

CREATE TABLE `suburbs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'TAS',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `hero_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_description` text COLLATE utf8mb4_unicode_ci,
  `hero_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `local_routes_info` text COLLATE utf8mb4_unicode_ci,
  `test_center_info` text COLLATE utf8mb4_unicode_ci,
  `is_serviced` tinyint(1) NOT NULL DEFAULT '1',
  `travel_fee` decimal(8,2) DEFAULT NULL,
  `min_booking_hours` int DEFAULT NULL,
  `show_on_map` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `suburbs`
--

INSERT INTO `suburbs` (`id`, `name`, `slug`, `postcode`, `state`, `latitude`, `longitude`, `meta_title`, `meta_description`, `hero_title`, `hero_description`, `hero_image`, `content`, `features`, `local_routes_info`, `test_center_info`, `is_serviced`, `travel_fee`, `min_booking_hours`, `show_on_map`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Hobart', 'hobart', '7000', 'TAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, 1, 1, '2026-02-11 21:07:01', '2026-02-11 21:07:01'),
(2, 'Glenorchy', 'glenorchy', '7010', 'TAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, 1, 2, '2026-02-11 21:07:01', '2026-02-11 21:07:01'),
(3, 'Kingston', 'kingston', '7050', 'TAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, 1, 3, '2026-02-11 21:07:01', '2026-02-11 21:07:01');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `service_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `customer_name`, `customer_location`, `customer_image`, `content`, `rating`, `service_type`, `date`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Sarah M.', 'Hobart', NULL, 'Absolutely fantastic experience! My instructor was patient and explained everything clearly. Passed my P1 test on the first try!', 5, NULL, NULL, 1, 1, 1, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(2, 'James W.', 'Glenorchy', NULL, 'After failing my test twice with another school, VIP helped me understand my mistakes and build confidence. Highly recommend!', 5, NULL, NULL, 1, 1, 2, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(3, 'Emily T.', 'Kingston', NULL, 'Great value for money with the 10-lesson package. The flexible scheduling made it easy to fit lessons around my work.', 5, NULL, NULL, 1, 1, 3, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(4, 'Michael K.', 'Sandy Bay', NULL, 'As a nervous driver, I needed someone patient. My instructor was incredible and never made me feel rushed or stressed.', 5, NULL, NULL, 1, 1, 4, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(5, 'Jessica L.', 'Moonah', NULL, 'The pick-up and drop-off service was so convenient. Professional instructors and modern cars. 10/10!', 5, NULL, NULL, 0, 1, 5, '2026-02-11 12:22:47', '2026-02-11 12:22:47'),
(6, 'David R.', 'Hobart', NULL, 'Booked a refresher course after not driving for 5 years. My instructor helped me regain my confidence quickly.', 4, NULL, NULL, 0, 1, 6, '2026-02-11 12:22:47', '2026-02-11 12:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `theory_attempts`
--

CREATE TABLE `theory_attempts` (
  `id` bigint UNSIGNED NOT NULL,
  `theory_category_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `session_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_questions` int NOT NULL,
  `correct_answers` int NOT NULL DEFAULT '0',
  `wrong_answers` int NOT NULL DEFAULT '0',
  `skipped_questions` int NOT NULL DEFAULT '0',
  `score_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `passed` tinyint(1) NOT NULL DEFAULT '0',
  `time_taken_seconds` int DEFAULT NULL,
  `answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `started_at` timestamp NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `theory_categories`
--

CREATE TABLE `theory_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `questions_count` int NOT NULL DEFAULT '0',
  `pass_percentage` int NOT NULL DEFAULT '80',
  `time_limit_minutes` int NOT NULL DEFAULT '30',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theory_questions`
--

CREATE TABLE `theory_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `theory_category_id` bigint UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_type` enum('single','multiple','true_false') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'single',
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `correct_answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `explanation` text COLLATE utf8mb4_unicode_ci,
  `explanation_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `difficulty` enum('easy','medium','hard') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `points` int NOT NULL DEFAULT '1',
  `times_answered` int NOT NULL DEFAULT '0',
  `times_correct` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `theory_resources`
--

CREATE TABLE `theory_resources` (
  `id` bigint UNSIGNED NOT NULL,
  `theory_category_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('article','video','pdf','link') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'article',
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `video_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL,
  `views_count` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin','staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `is_active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@vipdrivingschool.com.au', 'super_admin', NULL, 1, '2026-02-11 12:22:46', '$2y$12$ip21vUlYPkx8wcgNF7blHezRPEgmg.FeXSaxC3Sf.K9CirXDofVIe', 'aK8lI1MOQ7odyyePHpe03XAhzVdnSYtIVqJMnKQ2Q5aNjAClbTSqdAVV34rf', '2026-02-11 12:20:30', '2026-02-11 12:22:46'),
(2, 'Staff Member', 'staff@vipdrivingschool.com.au', 'staff', '0400 111 111', 1, '2026-02-11 12:22:47', '$2y$12$Km6KktTFS4ArvjnyfCDcrevYTTMlEIp5JJvjyVLQcjVpZNOVRZz/2', NULL, '2026-02-11 12:21:00', '2026-02-11 12:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `waitlists`
--

CREATE TABLE `waitlists` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `package_id` bigint UNSIGNED DEFAULT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `availability_slot_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferred_date` date NOT NULL,
  `preferred_time` time DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('waiting','notified','booked','expired','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `notified_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `automated_emails`
--
ALTER TABLE `automated_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `automated_email_logs`
--
ALTER TABLE `automated_email_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `automated_email_logs_automated_email_id_foreign` (`automated_email_id`),
  ADD KEY `automated_email_logs_customer_id_foreign` (`customer_id`),
  ADD KEY `automated_email_logs_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `availability_slots`
--
ALTER TABLE `availability_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `availability_slots_date_is_available_index` (`date`,`is_available`),
  ADD KEY `availability_slots_service_id_date_index` (`service_id`,`date`),
  ADD KEY `availability_slots_location_id_date_index` (`location_id`,`date`),
  ADD KEY `availability_slots_instructor_id_foreign` (`instructor_id`),
  ADD KEY `availability_slots_is_recurring_index` (`is_recurring`),
  ADD KEY `availability_slots_recurring_group_id_index` (`recurring_group_id`),
  ADD KEY `availability_slots_recurring_parent_id_index` (`recurring_parent_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_categories_slug_unique` (`slug`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_comments_parent_id_foreign` (`parent_id`),
  ADD KEY `blog_comments_customer_id_foreign` (`customer_id`),
  ADD KEY `blog_comments_moderated_by_foreign` (`moderated_by`),
  ADD KEY `blog_comments_blog_post_id_status_index` (`blog_post_id`,`status`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  ADD KEY `blog_posts_blog_category_id_foreign` (`blog_category_id`),
  ADD KEY `blog_posts_author_id_foreign` (`author_id`),
  ADD KEY `blog_posts_status_published_at_index` (`status`,`published_at`);

--
-- Indexes for table `blog_post_tag`
--
ALTER TABLE `blog_post_tag`
  ADD PRIMARY KEY (`blog_post_id`,`blog_tag_id`),
  ADD KEY `blog_post_tag_blog_tag_id_foreign` (`blog_tag_id`);

--
-- Indexes for table `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_tags_slug_unique` (`slug`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_booking_reference_unique` (`booking_reference`),
  ADD KEY `bookings_service_id_foreign` (`service_id`),
  ADD KEY `bookings_package_id_foreign` (`package_id`),
  ADD KEY `bookings_location_id_foreign` (`location_id`),
  ADD KEY `bookings_availability_slot_id_foreign` (`availability_slot_id`),
  ADD KEY `bookings_status_booking_date_index` (`status`,`booking_date`),
  ADD KEY `bookings_customer_email_index` (`customer_email`),
  ADD KEY `bookings_payment_status_index` (`payment_status`),
  ADD KEY `bookings_customer_id_foreign` (`customer_id`),
  ADD KEY `bookings_instructor_id_foreign` (`instructor_id`),
  ADD KEY `bookings_coupon_id_foreign` (`coupon_id`),
  ADD KEY `bookings_gift_voucher_id_foreign` (`gift_voucher_id`),
  ADD KEY `bookings_parent_booking_id_foreign` (`parent_booking_id`);

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
-- Indexes for table `cancellation_requests`
--
ALTER TABLE `cancellation_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cancellation_requests_booking_id_foreign` (`booking_id`),
  ADD KEY `cancellation_requests_customer_id_foreign` (`customer_id`),
  ADD KEY `cancellation_requests_processed_by_foreign` (`processed_by`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_usages_customer_id_foreign` (`customer_id`),
  ADD KEY `coupon_usages_booking_id_foreign` (`booking_id`),
  ADD KEY `coupon_usages_coupon_id_customer_id_index` (`coupon_id`,`customer_id`),
  ADD KEY `coupon_usages_coupon_id_customer_email_index` (`coupon_id`,`customer_email`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documents_slug_unique` (`slug`);

--
-- Indexes for table `email_campaigns`
--
ALTER TABLE `email_campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_campaigns_created_by_foreign` (`created_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_vouchers`
--
ALTER TABLE `gift_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gift_vouchers_code_unique` (`code`),
  ADD KEY `gift_vouchers_package_id_foreign` (`package_id`),
  ADD KEY `gift_vouchers_redeemed_by_foreign` (`redeemed_by`),
  ADD KEY `gift_vouchers_redeemed_booking_id_foreign` (`redeemed_booking_id`);

--
-- Indexes for table `info_cards`
--
ALTER TABLE `info_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `instructors_slug_unique` (`slug`),
  ADD UNIQUE KEY `instructors_email_unique` (`email`);

--
-- Indexes for table `instructor_suburb`
--
ALTER TABLE `instructor_suburb`
  ADD PRIMARY KEY (`instructor_id`,`suburb_id`),
  ADD KEY `instructor_suburb_suburb_id_foreign` (`suburb_id`);

--
-- Indexes for table `instructor_unavailabilities`
--
ALTER TABLE `instructor_unavailabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_unavailabilities_instructor_id_date_index` (`instructor_id`,`date`);

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
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_slug_unique` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newsletter_subscribers_email_unique` (`email`),
  ADD KEY `newsletter_subscribers_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `packages_slug_unique` (`slug`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reschedule_requests_booking_id_foreign` (`booking_id`),
  ADD KEY `reschedule_requests_customer_id_foreign` (`customer_id`),
  ADD KEY `reschedule_requests_new_slot_id_foreign` (`new_slot_id`),
  ADD KEY `reschedule_requests_processed_by_foreign` (`processed_by`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_review_token_unique` (`review_token`),
  ADD KEY `reviews_booking_id_foreign` (`booking_id`),
  ADD KEY `reviews_customer_id_foreign` (`customer_id`),
  ADD KEY `reviews_service_id_foreign` (`service_id`),
  ADD KEY `reviews_package_id_foreign` (`package_id`),
  ADD KEY `reviews_moderated_by_foreign` (`moderated_by`),
  ADD KEY `reviews_status_overall_rating_index` (`status`,`overall_rating`),
  ADD KEY `reviews_instructor_id_index` (`instructor_id`);

--
-- Indexes for table `review_helpful`
--
ALTER TABLE `review_helpful`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `review_helpful_review_id_ip_address_unique` (`review_id`,`ip_address`),
  ADD KEY `review_helpful_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`),
  ADD KEY `services_category_id_foreign` (`category_id`),
  ADD KEY `services_location_id_foreign` (`location_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_categories_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `suburbs`
--
ALTER TABLE `suburbs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suburbs_slug_unique` (`slug`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theory_attempts`
--
ALTER TABLE `theory_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theory_attempts_theory_category_id_foreign` (`theory_category_id`),
  ADD KEY `theory_attempts_customer_id_theory_category_id_index` (`customer_id`,`theory_category_id`);

--
-- Indexes for table `theory_categories`
--
ALTER TABLE `theory_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `theory_categories_slug_unique` (`slug`);

--
-- Indexes for table `theory_questions`
--
ALTER TABLE `theory_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theory_questions_theory_category_id_is_active_index` (`theory_category_id`,`is_active`);

--
-- Indexes for table `theory_resources`
--
ALTER TABLE `theory_resources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `theory_resources_slug_unique` (`slug`),
  ADD KEY `theory_resources_theory_category_id_foreign` (`theory_category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `waitlists`
--
ALTER TABLE `waitlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waitlists_customer_id_foreign` (`customer_id`),
  ADD KEY `waitlists_service_id_foreign` (`service_id`),
  ADD KEY `waitlists_package_id_foreign` (`package_id`),
  ADD KEY `waitlists_location_id_foreign` (`location_id`),
  ADD KEY `waitlists_availability_slot_id_foreign` (`availability_slot_id`),
  ADD KEY `waitlists_status_preferred_date_index` (`status`,`preferred_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `automated_emails`
--
ALTER TABLE `automated_emails`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `automated_email_logs`
--
ALTER TABLE `automated_email_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `availability_slots`
--
ALTER TABLE `availability_slots`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog_tags`
--
ALTER TABLE `blog_tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cancellation_requests`
--
ALTER TABLE `cancellation_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_campaigns`
--
ALTER TABLE `email_campaigns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gift_vouchers`
--
ALTER TABLE `gift_vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `info_cards`
--
ALTER TABLE `info_cards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instructor_unavailabilities`
--
ALTER TABLE `instructor_unavailabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_helpful`
--
ALTER TABLE `review_helpful`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `suburbs`
--
ALTER TABLE `suburbs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `theory_attempts`
--
ALTER TABLE `theory_attempts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theory_categories`
--
ALTER TABLE `theory_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theory_questions`
--
ALTER TABLE `theory_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theory_resources`
--
ALTER TABLE `theory_resources`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `waitlists`
--
ALTER TABLE `waitlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
