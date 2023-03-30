-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 26, 2023 at 07:49 AM
-- Server version: 5.7.36
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mwfcameroonsql2`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) DEFAULT '1',
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `blog_category_content`
--

DROP TABLE IF EXISTS `blog_category_content`;
CREATE TABLE IF NOT EXISTS `blog_category_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_id` int(10) UNSIGNED DEFAULT '1',
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `description` mediumtext,
  `image_caption` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_blog_category_content_to_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `author` int(1) DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `fk_blog_to_blog_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_content`
--

DROP TABLE IF EXISTS `blog_post_content`;
CREATE TABLE IF NOT EXISTS `blog_post_content` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `blog_id` int(10) UNSIGNED NOT NULL,
  `last_update` datetime DEFAULT CURRENT_TIMESTAMP,
  `lang_id` int(10) UNSIGNED DEFAULT '1',
  `title` varchar(150) NOT NULL,
  `description` mediumtext,
  `content` text,
  `image_caption` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_blog_postid0_idx` (`blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

DROP TABLE IF EXISTS `carousel`;
CREATE TABLE IF NOT EXISTS `carousel` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `fk_carousel_to_carousel_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id`, `category_id`, `is_active`, `link`, `image`) VALUES
(1, 1, 1, 'building-synergies-between-u-s--government-sponsor', 'carousel-building-synergi1679308512.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `carousel_categories`
--

DROP TABLE IF EXISTS `carousel_categories`;
CREATE TABLE IF NOT EXISTS `carousel_categories` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carousel_categories`
--

INSERT INTO `carousel_categories` (`id`, `link`, `image`, `is_active`) VALUES
(1, 'homepage-carousel', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `carousel_category_content`
--

DROP TABLE IF EXISTS `carousel_category_content`;
CREATE TABLE IF NOT EXISTS `carousel_category_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) UNSIGNED DEFAULT NULL,
  `lang_id` int(11) DEFAULT '1',
  `title` varchar(200) DEFAULT NULL,
  `description` longtext,
  `image_caption` varchar(500) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `fk_caroursel_category_content_to_carousel_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carousel_category_content`
--

INSERT INTO `carousel_category_content` (`id`, `category_id`, `lang_id`, `title`, `description`, `image_caption`) VALUES
(1, 1, 1, 'Homepage Carousel', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carousel_content`
--

DROP TABLE IF EXISTS `carousel_content`;
CREATE TABLE IF NOT EXISTS `carousel_content` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang_id` int(10) UNSIGNED DEFAULT '1',
  `carousel_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `content` mediumtext,
  `image_caption` text,
  PRIMARY KEY (`id`),
  KEY `fk_bannerid0_idx` (`carousel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carousel_content`
--

INSERT INTO `carousel_content` (`id`, `lang_id`, `carousel_id`, `title`, `content`, `image_caption`) VALUES
(1, 1, 1, 'Building synergies between U.S. Government-Sponsored Exchange Programs Alumni and leveraging youth potential through U.S. - Cameroon Cultural Exchange', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_form_messages`
--

DROP TABLE IF EXISTS `contact_form_messages`;
CREATE TABLE IF NOT EXISTS `contact_form_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(300) DEFAULT NULL,
  `email` varchar(300) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` longtext,
  `file` varchar(300) DEFAULT NULL,
  `subject` varchar(300) DEFAULT NULL,
  `message` text NOT NULL,
  `contact_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `email_subscriptions`
--

DROP TABLE IF EXISTS `email_subscriptions`;
CREATE TABLE IF NOT EXISTS `email_subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(300) DEFAULT NULL,
  `last_name` varchar(300) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `from_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `to_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `link` varchar(150) DEFAULT NULL,
  `venue` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `fk_event_to_event_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `category_id`, `is_active`, `from_date`, `to_date`, `link`, `venue`, `image`) VALUES
(1, NULL, 1, '2022-04-26 00:00:00', '2022-04-28 12:55:01', 'the-cameroon-alumni-national-symposium', 'Palais de Congres, Yaounde', 'project-the-cameroon-alum1679506845.jpg'),
(2, NULL, 1, '2023-04-26 12:55:26', '2023-04-28 12:55:26', 'the-cameroon-alumni-national-symposium--2nd-editio', 'ENAM, Yaounde', 'project-the-cameroon-alum1679507435.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `event_categories`
--

DROP TABLE IF EXISTS `event_categories`;
CREATE TABLE IF NOT EXISTS `event_categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `link` varchar(150) NOT NULL,
  `image` varchar(150) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event_category_content`
--

DROP TABLE IF EXISTS `event_category_content`;
CREATE TABLE IF NOT EXISTS `event_category_content` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang_id` int(10) UNSIGNED DEFAULT '1',
  `category_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(300) DEFAULT NULL,
  `description` text,
  `image_caption` mediumtext,
  PRIMARY KEY (`id`),
  KEY `fk_category_content_to_category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event_content`
--

DROP TABLE IF EXISTS `event_content`;
CREATE TABLE IF NOT EXISTS `event_content` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang_id` int(10) UNSIGNED DEFAULT '1',
  `event_id` int(10) UNSIGNED NOT NULL,
  `last_update` varchar(150) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `description` mediumtext,
  `content` text,
  `image_caption` mediumtext,
  PRIMARY KEY (`id`),
  KEY `fk_event_content_to_event` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event_content`
--

INSERT INTO `event_content` (`id`, `lang_id`, `event_id`, `last_update`, `title`, `description`, `content`, `image_caption`) VALUES
(1, 1, 1, NULL, 'The Cameroon Alumni National Symposium', NULL, '<p>The 1st Edition of the Cameroon Alumni National symposium organized from the in April 2021 under the theme &ldquo;Building Synergies Between U.S Exchange Programs Alumni and Leveraging Youth Potential Through U.S -Cameroon Cultural Exchange&rdquo; sought to build synergy and enhance collaboration among Alumni of U.S. Government-sponsored Exchange Programs, contributing to their personal and professional development in a bit to forge better partnerships for nation-building.&nbsp;</p>\r\n<p>The symposium brought together over 300 participants from U.S. Government-sponsored Exchange Programs, government officials, youth leaders, and civic leaders from across the national territory.&nbsp; For the first time, alumni from 14 U.S. Government-sponsored Exchange Programs were brought together, wherein, 161 alumni registered present at the symposium.&nbsp;&nbsp;</p>\r\n<p>Through this symposium, the US Embassy in Cameroon sought to give more visibility to it exchange programs and the impact they have had in Cameroon. It equally seeks to reorganize all its Alumni associations within the National Territory and bring them under one umbrella organization to better manage its intervention in the development of Cameroon&rsquo;s youths through these Alumni Associations. This symposium will include Panel Discussions, Networking Sessions, Cultural exposition, exhibitions, creation of a Cameroon U.S Funded Exchange Program Alumni Professional Digital Platform, and finally the Creation of a Canopy Alumni Association.</p>\r\n<p>GOAL: The main goal of this project is to build synergy and enhance collaboration among alumni of US government-funded exchange programs, contributing to their personal and professional development in a bit to forge better partnerships for national building.&nbsp;&nbsp;</p>\r\n<h3>OBJECTIVES</h3>\r\n<ol>\r\n<li>To organize a three (3) day Cameroon National Alumni symposium that will bring together 150 alumni from all US government-funded exchange programs by April 2022.</li>\r\n<li>To enhance PAS Cameroon alumni engagement by March 2022</li>\r\n<li>To Create an umbrella association or Platform for collaboration that will bring together alumni from all exchange programs sponsored by the U.S. Government by April 2022</li>\r\n</ol>\r\n<h3>ACTIVITIES&nbsp;&nbsp;</h3>\r\n<ol>\r\n<li>Organize plenary and parallel thematic discussion sessions.</li>\r\n<li>Organize social/cultural activities to showcase American and US culture.</li>\r\n<li>Carry out site events to brainstorm on collaborative projects for implementation among Alumni that address youth issues to enhance engagement and collaboration among alumni.&nbsp;&nbsp;</li>\r\n<li>Organize panel discussions for the evaluation of past alumni projects and sharing of experiences vis a vis post-fellowship expectations.</li>\r\n<li>Create an Umbrella Association or Platform for collaboration</li>\r\n<li>Create a Digital Platform for engagement</li>\r\n</ol>', NULL),
(2, 1, 2, NULL, 'The Cameroon Alumni National Symposium (2nd Edition)', NULL, '<h3>Theme: Driving Youth Actions for Cameroon&rsquo;s Economic Development.</h3>\r\n<p>The Cameroon Alumni National symposium is a U.S. Embassy-funded project, which seeks to build synergy and enhance collaboration among alumni of U.S. government-sponsored exchange programs, contributing to their personal and professional development in a bit to forge better partnerships for nation-building.&nbsp; &nbsp;The first edition which held last year was a great success which gathered more than 300 alumni and non-alumni from all over the nation.&nbsp; The recommendations and outcomes of last year therefore form the basis of implementation of the second edition. This year&rsquo;s symposium is a three-day event organized under the theme &ldquo;Driving Youth Actions for Cameroon&rsquo;s Economic Development&rdquo;.&nbsp;</p>\r\n<p>This event will bring together over 300 participants. These include representatives from the U.S. Embassy, Government officials, U.S. Government Exchange Program Alumni, Youth leaders, and CSO leaders from across the national territory.</p>\r\n<h3>Benefits</h3>\r\n<ul>\r\n<li>Networking opportunities with peers and change makers in all sectors of life;</li>\r\n<li>Learning opportunities through presentations and panel discussions with world class speakers on thematic cutting across civic, entrepreneurship, and public management.</li>\r\n<li>Fully funded for USG selected alumni.</li>\r\n<li>Opportunities to promote alumni associations and enhance alumni engagement.</li>\r\n<li>Participation in a cultural gala that showcases American and Cameroonian cultures.</li>\r\n</ul>\r\n<h3>Selection Criteria&nbsp;</h3>\r\n<p><strong>a) For Alumni&nbsp;</strong></p>\r\n<ul>\r\n<li>Open to all USG alumni.&nbsp;</li>\r\n<li>Priority given to new applicants (alumni who did not have the opportunity to attend the previous symposium);&nbsp;</li>\r\n<li>Ensure diversity, equity, and inclusion (This includes consideration of gender balance, alumni associations&rsquo; representation, and encouraging people with disabilities to ensure diverse representation on all symposium);&nbsp;&nbsp;</li>\r\n<li>Commitment to attend the entire 3-days program.&nbsp;</li>\r\n<li>Demonstration that the symposium will have maximum positive contribution by/impact the alumni in attendance.&nbsp;</li>\r\n</ul>\r\n<p><strong>b) For Non-Alumni&nbsp;</strong></p>\r\n<ul>\r\n<li>Youth leaders and Students between the ages of 15-35 years.&nbsp;</li>\r\n<li>Priority to applicants living in Yaounde (Note that no transportation nor accommodation will be provided).&nbsp;</li>\r\n<li>Priority given to new applicants (who did not have the opportunity to attend the previous symposium).&nbsp;</li>\r\n<li>Consideration given to former participants who capitalized on the skills gained and the resources obtained from the previous symposium.&nbsp;</li>\r\n<li>Ensure diversity and inclusion.</li>\r\n</ul>\r\n<p>Are you an alumnus of the United States Exchange Programs or not, apply now and connect with other young impactful leaders of the country on an exchange platform that promotes community and nation development.</p>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `album_id` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `image_tags` mediumtext,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_to_gallery_category` (`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_albums`
--

DROP TABLE IF EXISTS `gallery_albums`;
CREATE TABLE IF NOT EXISTS `gallery_albums` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` int(10) UNSIGNED DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_album_content`
--

DROP TABLE IF EXISTS `gallery_album_content`;
CREATE TABLE IF NOT EXISTS `gallery_album_content` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `album_id` int(10) UNSIGNED NOT NULL,
  `lang_id` int(10) UNSIGNED DEFAULT '1',
  `title` varchar(300) DEFAULT NULL,
  `description` text,
  `image_caption` mediumtext,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_album_content_to_gallery_album` (`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_content`
--

DROP TABLE IF EXISTS `gallery_content`;
CREATE TABLE IF NOT EXISTS `gallery_content` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gallery_id` int(10) UNSIGNED DEFAULT NULL,
  `lang_id` int(11) DEFAULT '1',
  `title` varchar(300) DEFAULT NULL,
  `image_caption` text,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_content_to_gallery` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(150) NOT NULL,
  `locale` varchar(7) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `locale` (`locale`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `locale`) VALUES
(1, 'English (US)', 'en_us'),
(2, 'French', 'fre');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `title` varchar(300) DEFAULT NULL,
  `description` text,
  `image` varchar(150) DEFAULT NULL,
  `image_caption` mediumtext,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `navs`
--

DROP TABLE IF EXISTS `navs`;
CREATE TABLE IF NOT EXISTS `navs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(150) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `navs`
--

INSERT INTO `navs` (`id`, `link`, `title`, `description`) VALUES
(1, NULL, 'Main Menu', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nav_links`
--

DROP TABLE IF EXISTS `nav_links`;
CREATE TABLE IF NOT EXISTS `nav_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `link_type` int(11) DEFAULT '1',
  `link` varchar(300) DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `icon` varchar(300) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_nav_link_to_nav_link_parent` (`parent`),
  KEY `fk_nav_link_to_nav` (`nav_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nav_links`
--

INSERT INTO `nav_links` (`id`, `nav_id`, `position`, `parent`, `link_type`, `link`, `image`, `icon`, `is_active`) VALUES
(1, 1, NULL, NULL, 1, 'welcome', NULL, NULL, 0),
(2, 1, NULL, NULL, 1, 'about', NULL, NULL, 1),
(3, 1, NULL, NULL, 1, 'programs', NULL, NULL, 1),
(4, 1, NULL, NULL, 1, 'activities', NULL, NULL, 1),
(5, 1, NULL, NULL, 1, 'news', NULL, NULL, 1),
(6, 1, NULL, NULL, 1, 'contact', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nav_link_content`
--

DROP TABLE IF EXISTS `nav_link_content`;
CREATE TABLE IF NOT EXISTS `nav_link_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_link_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT '1',
  `title` varchar(300) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_nav_link_content_to_nav_link` (`nav_link_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nav_link_content`
--

INSERT INTO `nav_link_content` (`id`, `nav_link_id`, `lang_id`, `title`, `description`) VALUES
(1, 1, 1, 'Welcome', NULL),
(2, 2, 1, 'About Us', NULL),
(3, 3, 1, 'Exchange Programs', NULL),
(4, 4, 1, 'Activities', NULL),
(5, 5, 1, 'News Center', NULL),
(6, 6, 1, 'Contact Us', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `author` int(11) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `fk_news_to_category` (`category_id`),
  KEY `fk_news_author_to_users` (`author`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `category_id`, `author`, `is_active`, `date`, `link`, `image`) VALUES
(1, NULL, NULL, 1, '2023-03-20 11:49:31', 'another-news-title', 'news-applications-for-the1679309371.jpg'),
(2, NULL, NULL, 1, '2023-03-26 17:58:02', 'sample-news-title', 'news-applications-for-the1679309371.jpg'),
(3, NULL, NULL, 1, '2023-03-24 17:58:12', 'applications-for-the-2nd-edition-of-the-symposium', 'news-applications-for-the1679309371.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `news_categories`
--

DROP TABLE IF EXISTS `news_categories`;
CREATE TABLE IF NOT EXISTS `news_categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) DEFAULT '1',
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `news_category_content`
--

DROP TABLE IF EXISTS `news_category_content`;
CREATE TABLE IF NOT EXISTS `news_category_content` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang_id` int(10) UNSIGNED DEFAULT '1',
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `description` text,
  `image_caption` mediumtext,
  PRIMARY KEY (`id`),
  KEY `fk_news_category_content_to_category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `news_content`
--

DROP TABLE IF EXISTS `news_content`;
CREATE TABLE IF NOT EXISTS `news_content` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `news_id` int(10) UNSIGNED NOT NULL,
  `last_update` datetime DEFAULT NULL,
  `lang_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(300) NOT NULL,
  `description` mediumtext,
  `content` text,
  `image_caption` mediumtext,
  PRIMARY KEY (`id`),
  KEY `fk_news_content_to_news` (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news_content`
--

INSERT INTO `news_content` (`id`, `news_id`, `last_update`, `lang_id`, `title`, `description`, `content`, `image_caption`) VALUES
(1, 1, '2023-03-23 00:00:00', 1, 'Another News Title', NULL, NULL, NULL),
(2, 2, NULL, 1, 'Sample News title', NULL, NULL, NULL),
(3, 3, NULL, 1, 'Applications for the 2nd Edition of the Symposium are now open', NULL, '<p>The 2nd Edition of the Symposium of The Cameroon Alumni National symposium will be held from the <strong>26th â€“ 28th April 2023 at ENAM, Yaounde</strong></p>\n<p>The Cameroon Alumni National symposium is a U.S. Embassy-funded project, which seeks to build synergy and enhance collaboration among alumni of U.S. government-sponsored exchange programs, contributing to their personal and professional development in a bit to forge better partnerships for nation-building.</p>\n<p>Read more about the event and apply by following the link below</p>\n<a href=\"https://questionpro.com/t/AWcJ6Zwnta\" target=\"_blank\" class=\"btn btn-lg btn-custom-accent-green px-5 text-uppercase fw-bold\">Apply Now</a>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `parent` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `layout` int(11) DEFAULT '1',
  `template` int(11) DEFAULT NULL,
  `controller` varchar(50) DEFAULT 'standard',
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `fk_page_to_category` (`category_id`),
  KEY `fk_page_to_template` (`template`),
  KEY `fk_page_to_layout` (`layout`),
  KEY `fk_page_to_parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `category_id`, `parent`, `is_active`, `layout`, `template`, `controller`, `link`, `image`) VALUES
(1, NULL, NULL, 1, 5, NULL, 'standard', '', NULL),
(2, NULL, NULL, 1, 1, NULL, 'standard', 'about', 'page-about-image-1679305057.jpg'),
(3, NULL, NULL, 1, 1, 2, 'standard', 'contact', NULL),
(4, NULL, NULL, 1, 4, NULL, 'variable_data', 'programs', NULL),
(5, NULL, NULL, 1, 4, NULL, 'variable_data', 'activities', NULL),
(6, NULL, NULL, 1, 4, NULL, 'variable_data', 'news', NULL),
(7, NULL, NULL, 1, 1, NULL, 'standard', 'apply', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `page_categories`
--

DROP TABLE IF EXISTS `page_categories`;
CREATE TABLE IF NOT EXISTS `page_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `page_category_content`
--

DROP TABLE IF EXISTS `page_category_content`;
CREATE TABLE IF NOT EXISTS `page_category_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `title` varchar(300) NOT NULL,
  `description` text,
  `content` text,
  `image_caption` text,
  PRIMARY KEY (`id`),
  KEY `fk_page_category_content_to_category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `page_content`
--

DROP TABLE IF EXISTS `page_content`;
CREATE TABLE IF NOT EXISTS `page_content` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang_id` int(10) UNSIGNED DEFAULT '1',
  `page_id` int(10) UNSIGNED DEFAULT NULL,
  `nav_title` varchar(300) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `description` mediumtext,
  `content` mediumtext,
  `image_caption` text,
  `last_update` varchar(150) DEFAULT NULL,
  `last_update_by` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_page_content_to_page` (`page_id`),
  KEY `fk_page_content_author_to_users` (`last_update_by`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `page_content`
--

INSERT INTO `page_content` (`id`, `lang_id`, `page_id`, `nav_title`, `title`, `description`, `content`, `image_caption`, `last_update`, `last_update_by`) VALUES
(1, 1, 1, NULL, 'Welcome', NULL, NULL, NULL, NULL, NULL),
(2, 1, 2, NULL, 'About the USG Alumni Association', 'The USG Cameroon is the association of alumni of US Exchange Programs across the country in a bid to create greater impact through USG programs.', '<p>The USG Cameroon is the association of alumni of US Exchange Programs across the country in a bid to create greater impact through USG programs.</p>', NULL, '2023-03-23', NULL),
(3, 1, 3, NULL, 'Contact', NULL, NULL, NULL, NULL, NULL),
(4, 1, 4, NULL, 'Programs', NULL, '{{{feature =>Program}}}', NULL, NULL, NULL),
(5, 1, 5, NULL, 'Activities', NULL, '{{{feature =>Event}}}', NULL, NULL, NULL),
(6, 1, 6, NULL, 'News', NULL, '{{{feature =>News}}}', NULL, '2023-03-20', NULL),
(7, 1, 7, NULL, 'Apply to attend The Cameroon Alumni National symposium', NULL, NULL, NULL, '2023-03-23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
CREATE TABLE IF NOT EXISTS `partners` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) DEFAULT '1',
  `priority` int(10) UNSIGNED DEFAULT NULL,
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `url` mediumtext,
  `title` varchar(150) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `is_active`, `priority`, `link`, `image`, `url`, `title`, `description`) VALUES
(1, 1, NULL, 'mwf-cameroon', 'partner-mwf-cameroon-imag1679484415.png', 'http://mwfcameroon.org', 'MWF Cameroon', NULL),
(2, 1, NULL, 'cameroon-fulbright-tea-alumni--association', 'partner-cameroon-fulbrigh1679484532.png', 'https://caftal.cm', 'Cameroon Fulbright TEA Alumni  Association', NULL),
(3, 1, NULL, 'cci', 'partner-cci-image-1679484987.png', NULL, 'CCI', NULL),
(4, 1, NULL, 'fullbright', 'partner-fullbright-image-1679484998.png', NULL, 'Fullbright', NULL),
(5, 1, NULL, 'hubert-h-humphery-fellowship', 'partner-hubert-h-humphery1679485019.png', NULL, 'Hubert H Humphery Fellowship', NULL),
(6, 1, NULL, 'yali-wa-alumni-association--cameroon', 'partner-yali-wa-alumni-as1679485040.png', NULL, 'YALI WA Alumni Association, Cameroon', NULL),
(7, 1, NULL, 'awep-cameroon', 'partner-awep-cameroon-ima1679485054.png', NULL, 'AWEP Cameroon', NULL),
(8, 1, NULL, 'study-of-the-us-institutes', 'partner-study-of-the-us-i1679485076.png', NULL, 'Study of the US Institutes', NULL),
(9, 1, NULL, 'techwomen', 'partner-techwomen-image-1679485084.png', NULL, 'Techwomen', NULL),
(10, 1, NULL, 'youth-exchange-and-study', 'partner-youth-exchange-an1679485096.png', NULL, 'Youth Exchange and Study', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `poems`
--

DROP TABLE IF EXISTS `poems`;
CREATE TABLE IF NOT EXISTS `poems` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `author` int(11) UNSIGNED DEFAULT '1',
  `is_active` tinyint(1) DEFAULT '1',
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `image_share` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `fk_poems_to_category` (`category_id`),
  KEY `fk_poem_author_to_users` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `poem_categories`
--

DROP TABLE IF EXISTS `poem_categories`;
CREATE TABLE IF NOT EXISTS `poem_categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) DEFAULT '1',
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `poem_category_content`
--

DROP TABLE IF EXISTS `poem_category_content`;
CREATE TABLE IF NOT EXISTS `poem_category_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_id` int(10) UNSIGNED DEFAULT '1',
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `description` text,
  `image_caption` mediumtext,
  PRIMARY KEY (`id`),
  KEY `fk_poem_category_content_to_category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `poem_content`
--

DROP TABLE IF EXISTS `poem_content`;
CREATE TABLE IF NOT EXISTS `poem_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poem_id` int(10) UNSIGNED DEFAULT NULL,
  `lang_id` int(11) DEFAULT '1',
  `last_update` varchar(150) DEFAULT NULL,
  `last_update_by` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `description` mediumtext,
  `content` text,
  `image_caption` mediumtext,
  PRIMARY KEY (`id`),
  KEY `fk_poem_content_to_poem` (`poem_id`),
  KEY `fk_poem_content_update_to_author` (`last_update_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
CREATE TABLE IF NOT EXISTS `programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `icon` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `link`, `image`, `icon`) VALUES
(1, 'mandela-washington-fellowship', 'partner-mwf-cameroon-imag1679484415.png', NULL),
(2, 'the-fulbright-teaching-excellence-achievement-prog', 'partner-cameroon-fulbrigh1679484532.png', NULL),
(3, 'cci', 'partner-cci-image-1679484987.png', NULL),
(4, 'fullbright', 'partner-fullbright-image-1679484998.png', NULL),
(5, 'hubert-h-humphery-fellowship', 'partner-hubert-h-humphery1679485019.png', NULL),
(6, 'yali-wa-alumni-association--cameroon', 'partner-yali-wa-alumni-as1679485040.png', NULL),
(7, 'awep-cameroon', 'partner-awep-cameroon-ima1679485054.png', NULL),
(8, 'study-of-the-us-institutes', 'partner-study-of-the-us-i1679485076.png', NULL),
(9, 'techwomen', 'partner-techwomen-image-1679485084.png', NULL),
(10, 'youth-exchange-and-study', 'partner-youth-exchange-an1679485096.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `program_content`
--

DROP TABLE IF EXISTS `program_content`;
CREATE TABLE IF NOT EXISTS `program_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `program_id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `title` varchar(300) NOT NULL,
  `description` mediumtext,
  `content` text,
  `image_caption` text,
  PRIMARY KEY (`id`),
  KEY `fk_program_content_to_program` (`program_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program_content`
--

INSERT INTO `program_content` (`id`, `program_id`, `lang_id`, `title`, `description`, `content`, `image_caption`) VALUES
(1, 1, 1, 'Mandela Washington Fellowship', NULL, 'The Mandela Washington Fellowship for Young African Leaders, begun in 2014, is the flagship program of the Young African Leaders Initiative (YALI) that empowers young people through academic coursework, leadership training, and networking. In 2019, the Fellowship will provide 700 outstanding young leaders from Sub-Saharan Africa with the opportunity to hone their skills at a U.S. college or university with support for professional development after they return home.', NULL),
(2, 2, 1, 'The Fulbright Teaching Excellence Achievement Program', NULL, '<p>It is a program sponsored by the U.S. Department of State with funding provided by the U.S. Government and administered by the International Research and Exchanges (IREX) Board. The program brings outstanding international secondary school teachers to the United States to further develop their expertise in their subject areas and enhance their teaching skills. The program consists of a six-to-seven-week customized academic program including seminars on teaching methodologies, curriculum development, instructional technology, inclusive education, and educational leadership.</p>\r\n<p>During the Fulbright TEA fellowship program, participants work closely with U.S. teachers in a secondary or high school and classroom. Upon completion of the program, the participants return to their countries and are expected to share the experience and knowledge gained from the program with their students, colleagues, and other community members.</p>', NULL),
(3, 3, 1, 'CCI', NULL, NULL, NULL),
(4, 4, 1, 'Fullbright', NULL, NULL, NULL),
(5, 5, 1, 'Hubert H Humphery Fellowship', NULL, NULL, NULL),
(6, 6, 1, 'YALI WA Alumni Association, Cameroon', NULL, NULL, NULL),
(7, 7, 1, 'AWEP Cameroon', NULL, NULL, NULL),
(8, 8, 1, 'Study of the US Institutes', NULL, NULL, NULL),
(9, 9, 1, 'Techwomen', NULL, NULL, NULL),
(10, 10, 1, 'Youth Exchange and Study', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) DEFAULT '1',
  `cycle` varchar(50) DEFAULT NULL,
  `link` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `video` text,
  `location` varchar(300) DEFAULT NULL,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `impact` int(11) DEFAULT NULL,
  `funding` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project_content`
--

DROP TABLE IF EXISTS `project_content`;
CREATE TABLE IF NOT EXISTS `project_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `title` varchar(300) NOT NULL,
  `description` mediumtext,
  `content` text,
  `image_caption` text,
  PRIMARY KEY (`id`),
  KEY `fk_project_content_to_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_options`
--

DROP TABLE IF EXISTS `site_options`;
CREATE TABLE IF NOT EXISTS `site_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_options`
--

INSERT INTO `site_options` (`id`, `name`, `image`) VALUES
(1, 'ORG_ACRONYM', NULL),
(2, 'ORG_TITLE', NULL),
(3, 'ORG_DESCRIPTION', NULL),
(4, 'ORG_TAG', NULL),
(5, 'ORG_LOGO', 'option--image-1679303950.png'),
(6, 'ORG_ADDRESS', NULL),
(7, 'ORG_EMAIL', NULL),
(8, 'ORG_NUMBER', NULL),
(9, 'DOMAIN', NULL),
(10, 'THEME', NULL),
(11, 'ORG_VISION', NULL),
(12, 'ORG_ICON', 'favicon.png'),
(13, 'ORG_DEFAULT_IMAGE', 'option--image-1679483821.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `site_options_content`
--

DROP TABLE IF EXISTS `site_options_content`;
CREATE TABLE IF NOT EXISTS `site_options_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT '1',
  `title` varchar(300) DEFAULT NULL,
  `description` mediumtext,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `fk_options_content_to_options` (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_options_content`
--

INSERT INTO `site_options_content` (`id`, `option_id`, `lang_id`, `title`, `description`, `content`) VALUES
(1, 1, 1, 'Acronym', 'define the acronym for the organisation', 'USGEx'),
(2, 2, 1, 'Name of Organisation', 'Defines the name to be used for the organisation throughout the Website', 'USG Exchange Programs Alumni Cameroon'),
(3, 3, 1, 'Description', 'Defines a brief introduction (Pitch) for your organisation used for Meta Information.', 'The USG Cameroon is the association of alumni of US Exchange Programs across the country in a bid to create greater impact through USG programs.'),
(4, 4, 1, 'Tagline', 'Defines the tag line for the organisation', NULL),
(5, 5, 1, 'Organisation\'s Logo', 'Defines the logo for the organisation.', NULL),
(6, 6, 1, 'Organisation\'s Address', 'Defines the Organisation\'s main Physical Address', NULL),
(7, 7, 1, 'Email', 'Defines Organisation\'s main Email address', 'info@usgexchangeprogramscmr.org'),
(8, 8, 1, 'Organisation\'s Phone Number', 'Defines Organisation\'s Primary Phone Number', NULL),
(9, 9, 1, 'Organisation\'s DOMAIN', 'defines Organisation\'s Domain name without http(s)://', 'usgexchangeprogramscmr.org'),
(10, 10, 1, 'Site Theme', 'Defines the Design theme which the site uses', 'bootstrap_child'),
(11, 11, 1, 'Our Vision', NULL, NULL),
(12, 12, 1, 'Favicon', 'Icon displayed on the address bar of browser', NULL),
(13, 13, 1, 'Default Image', 'The default image to display where there\'s none', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `social_networks`
--

DROP TABLE IF EXISTS `social_networks`;
CREATE TABLE IF NOT EXISTS `social_networks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) DEFAULT '1',
  `link` varchar(100) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `icon` varchar(150) DEFAULT 'far fa-share-square',
  `image` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `social_networks`
--

INSERT INTO `social_networks` (`id`, `is_active`, `link`, `title`, `url`, `icon`, `image`) VALUES
(1, 1, 'facebook', 'Facebook', 'https://facebook.com', 'fab fa-facebook', NULL),
(2, 1, 'twitter', 'Twitter', 'https://twitter.com', 'fab fa-twitter', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `spotlight`
--

DROP TABLE IF EXISTS `spotlight`;
CREATE TABLE IF NOT EXISTS `spotlight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(150) NOT NULL,
  `image` varchar(100) NOT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `spotlight_content`
--

DROP TABLE IF EXISTS `spotlight_content`;
CREATE TABLE IF NOT EXISTS `spotlight_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spotlight_id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT '1',
  `title` varchar(150) NOT NULL,
  `description` mediumtext,
  `image_caption` varchar(300) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `fk_spotlight_content_to_spotlight` (`spotlight_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

DROP TABLE IF EXISTS `stories`;
CREATE TABLE IF NOT EXISTS `stories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) DEFAULT '1',
  `link` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `story_content`
--

DROP TABLE IF EXISTS `story_content`;
CREATE TABLE IF NOT EXISTS `story_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `story_id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `title` varchar(300) NOT NULL,
  `description` mediumtext,
  `content` text,
  `image_caption` text,
  PRIMARY KEY (`id`),
  KEY `fk_story_content_to_story` (`story_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(11) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `location_id` int(11) DEFAULT NULL,
  `link` varchar(150) DEFAULT NULL,
  `first_name` varchar(300) DEFAULT NULL,
  `last_name` varchar(300) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `facebook` longtext,
  `twitter` longtext,
  `youtube` longtext,
  `linkedin` longtext,
  `email` longtext,
  `website` longtext,
  PRIMARY KEY (`id`),
  KEY `fk_team_to_location` (`location_id`),
  KEY `fk_team_to_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `category_id`, `is_active`, `location_id`, `link`, `first_name`, `last_name`, `image`, `from_date`, `to_date`, `facebook`, `twitter`, `youtube`, `linkedin`, `email`, `website`) VALUES
(1, 2, 1, NULL, NULL, 'Desmond', 'Ngala', 'team--image-1679569487.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 1, NULL, NULL, 'Prof. Marceline', 'Djuidje Ngounoue, Ph.D', 'team--image-1679644021.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 2, 1, NULL, NULL, 'Prof. Tonjock Rosemary', 'Kinge', 'team--image-1679644076.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 2, 1, NULL, NULL, 'Ferdinant M.', 'Sonyuy', 'team--image-1679644410.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2, 1, NULL, NULL, 'Ngenang Cheyip', 'Kulu', 'team--image-1679644461.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 2, 1, NULL, NULL, 'Ines', 'Tchakounte Yimga', 'team--image-1679644506.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 2, 1, NULL, NULL, 'Nelly-Shella', 'T. Yonga', 'team--image-1679648450.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 2, 1, NULL, NULL, 'Joseph', 'Bainamndi Daliwa', 'team--image-1679648489.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 2, 1, NULL, NULL, 'Joseph', 'Lambe Yonkam', 'team--image-1679648518.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_categories`
--

DROP TABLE IF EXISTS `team_categories`;
CREATE TABLE IF NOT EXISTS `team_categories` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) DEFAULT '1',
  `link` varchar(150) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_categories`
--

INSERT INTO `team_categories` (`id`, `is_active`, `link`, `image`) VALUES
(1, 1, 'first-edition', NULL),
(2, 1, 'second-edition', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_category_content`
--

DROP TABLE IF EXISTS `team_category_content`;
CREATE TABLE IF NOT EXISTS `team_category_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) UNSIGNED DEFAULT NULL,
  `lang_id` int(11) DEFAULT '1',
  `title` varchar(300) DEFAULT NULL,
  `description` text,
  `image_caption` mediumtext,
  PRIMARY KEY (`id`),
  KEY `fk_team_category_content_to_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_category_content`
--

INSERT INTO `team_category_content` (`id`, `category_id`, `lang_id`, `title`, `description`, `image_caption`) VALUES
(1, 1, 1, 'First Edition', NULL, NULL),
(2, 2, 1, 'Second Edition', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_content`
--

DROP TABLE IF EXISTS `team_content`;
CREATE TABLE IF NOT EXISTS `team_content` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` int(11) UNSIGNED NOT NULL,
  `lang_id` int(10) UNSIGNED NOT NULL,
  `position` mediumtext,
  `profile` text,
  `image_caption` text,
  PRIMARY KEY (`id`),
  KEY `fk_team_content_to_team` (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_content`
--

INSERT INTO `team_content` (`id`, `team_id`, `lang_id`, `position`, `profile`, `image_caption`) VALUES
(1, 1, 1, NULL, '- Profession: Project Manager \r\n- Exchange Program and Year of Participation: IVLP-GMIT 2021\r\n- Project Committee/Subcommittee: Scientific Committee', NULL),
(2, 2, 1, NULL, '<p>Prof. Marceline Djuidje Ngounoue, Ph.D. is an Associate Professor of Biochemistry, Molecular Biology and Immunology & Coordinator of Research Ethics Committee at the University of YaoundÃ© 1, Cameroon. Fulbright Scholar Alumna/Former Visiting Professor at Yale University School of Medicine, New Haven, CT, USA. Fellow of the Cameroon Academy of Young Scientists (CAYS). Member of the African Consortium of Bioethicists. Holistic mentor for women and girls in science. Deputy Chair of the USG Umbrella Alumni Board. Chair of the Scientific Committee</p>', NULL),
(3, 3, 1, NULL, '<p>Associate Professor of Mycology and Phytopathology, University of Bamenda. Technical and Logistic Secretary of the Cameroon Academy of Young Scientists. Fulbright Scholar Alumni 2018. Alexander on Humboldt Experienced Researcher Alumni 2022. Subcommittee: Scientific Committee</p>', NULL),
(4, 4, 1, NULL, NULL, NULL),
(5, 5, 1, NULL, '- Profession: Paralegal/MARCOM/Human Right\r\n- Exchange Program and Year of Participation: YALI RLC Accra-Ghana cohort 11\r\n- Project Committee: Assist Project Lead/Subcommittee: Communication.', NULL),
(6, 6, 1, NULL, 'Profession: Project Manager\r\nProgam and year: MWF 2022\r\nCommittee: Project supervision/Logistics', NULL),
(7, 7, 1, NULL, '- Profession: Humanitarian Worker \r\n- Exchange Program and Year of Participation: Mandela Washington Fellowship - 2015\r\n- Project Committee/Subcommittee:  Technical Adviser', NULL),
(8, 8, 1, NULL, '- Profession: Researcher/Executive Director\r\n- Exchange Program and Year of Participation: MWF /2017 and Fulbright /2020\r\n- Project Committee/Subcommittee:  General Supervision /Scientific Committee', NULL),
(9, 9, 1, NULL, 'Profession: Project Officer\r\nExchange Program and Year: K-L YES 2012-2013\r\nCommittee: Secretariat', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test_features`
--

DROP TABLE IF EXISTS `test_features`;
CREATE TABLE IF NOT EXISTS `test_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `fk_test_feature_to_category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `test_feature_categories`
--

DROP TABLE IF EXISTS `test_feature_categories`;
CREATE TABLE IF NOT EXISTS `test_feature_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `test_feature_category_content`
--

DROP TABLE IF EXISTS `test_feature_category_content`;
CREATE TABLE IF NOT EXISTS `test_feature_category_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `title` varchar(300) NOT NULL,
  `description` text,
  `content` text,
  `image_caption` text,
  PRIMARY KEY (`id`),
  KEY `fk_test_feature_category_content_to_category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `test_feature_content`
--

DROP TABLE IF EXISTS `test_feature_content`;
CREATE TABLE IF NOT EXISTS `test_feature_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_feature_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `title` varchar(300) NOT NULL,
  `description` mediumtext,
  `content` text,
  `image_caption` text,
  PRIMARY KEY (`id`),
  KEY `fk_test_feature_content_to_test_feature` (`test_feature_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

DROP TABLE IF EXISTS `themes`;
CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(32) DEFAULT NULL,
  `image` varchar(32) DEFAULT NULL,
  `title` varchar(300) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `link`, `image`, `title`, `description`) VALUES
(1, NULL, NULL, 'Default', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `theme_layouts`
--

DROP TABLE IF EXISTS `theme_layouts`;
CREATE TABLE IF NOT EXISTS `theme_layouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_id` int(11) DEFAULT NULL,
  `link` varchar(32) DEFAULT NULL,
  `image` varchar(32) DEFAULT NULL,
  `title` varchar(300) NOT NULL,
  `description` text,
  `filename` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_theme_layouts_to_them` (`theme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `theme_layouts`
--

INSERT INTO `theme_layouts` (`id`, `theme_id`, `link`, `image`, `title`, `description`, `filename`) VALUES
(1, 1, NULL, NULL, 'Default', NULL, 'default.php'),
(2, 1, NULL, NULL, 'Full Page', NULL, 'full-page.php'),
(3, 1, NULL, NULL, 'Blank Page', NULL, 'blank-page.php'),
(4, NULL, NULL, NULL, 'Variable Data', NULL, 'variable-data.php'),
(5, 1, 'home', NULL, 'Homepage', NULL, 'home.php');

-- --------------------------------------------------------

--
-- Table structure for table `theme_templates`
--

DROP TABLE IF EXISTS `theme_templates`;
CREATE TABLE IF NOT EXISTS `theme_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_id` int(11) DEFAULT NULL,
  `link` varchar(32) DEFAULT NULL,
  `image` varchar(32) DEFAULT NULL,
  `title` varchar(300) NOT NULL,
  `description` text,
  `filename` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_theme_templates_to_thems` (`theme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `theme_templates`
--

INSERT INTO `theme_templates` (`id`, `theme_id`, `link`, `image`, `title`, `description`, `filename`) VALUES
(1, 1, NULL, NULL, 'Default', NULL, 'default.html'),
(2, 1, NULL, NULL, 'Contact', NULL, 'contact.html');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` int(11) DEFAULT '2',
  `is_active` tinyint(1) DEFAULT '1',
  `username` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `profile` text,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `is_active`, `username`, `email`, `hashed_password`, `first_name`, `last_name`, `profile`, `image`) VALUES
(1, 2, NULL, 'trevor@yems.group', 'trevor@yems.group', 'efacc4001e857f7eba4ae781c2932dedf843865e', 'Trevor @ Y\'G', NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_category_content`
--
ALTER TABLE `blog_category_content`
  ADD CONSTRAINT `fk_blog_category_content_to_category_id` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `fk_blog_to_blog_category_id` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `blog_post_content`
--
ALTER TABLE `blog_post_content`
  ADD CONSTRAINT `fk_blog_content_to_blog_id` FOREIGN KEY (`blog_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carousel`
--
ALTER TABLE `carousel`
  ADD CONSTRAINT `fk_carousel_to_carousel_category` FOREIGN KEY (`category_id`) REFERENCES `carousel_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `carousel_category_content`
--
ALTER TABLE `carousel_category_content`
  ADD CONSTRAINT `fk_caroursel_category_content_to_carousel_category` FOREIGN KEY (`category_id`) REFERENCES `carousel_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carousel_content`
--
ALTER TABLE `carousel_content`
  ADD CONSTRAINT `fk_carousel_content_to_carousel` FOREIGN KEY (`carousel_id`) REFERENCES `carousel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_event_to_event_category` FOREIGN KEY (`category_id`) REFERENCES `event_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `event_category_content`
--
ALTER TABLE `event_category_content`
  ADD CONSTRAINT `fk_category_content_to_category` FOREIGN KEY (`category_id`) REFERENCES `event_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_content`
--
ALTER TABLE `event_content`
  ADD CONSTRAINT `fk_event_content_to_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `fk_gallery_to_gallery_category` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `gallery_album_content`
--
ALTER TABLE `gallery_album_content`
  ADD CONSTRAINT `fk_gallery_album_content_to_gallery_album` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gallery_content`
--
ALTER TABLE `gallery_content`
  ADD CONSTRAINT `fk_gallery_content_to_gallery` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nav_links`
--
ALTER TABLE `nav_links`
  ADD CONSTRAINT `fk_nav_link_to_nav` FOREIGN KEY (`nav_id`) REFERENCES `navs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nav_link_to_nav_link_parent` FOREIGN KEY (`parent`) REFERENCES `nav_links` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `nav_link_content`
--
ALTER TABLE `nav_link_content`
  ADD CONSTRAINT `fk_nav_link_content_to_nav_link` FOREIGN KEY (`nav_link_id`) REFERENCES `nav_links` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_author_to_users` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_news_to_category` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `news_category_content`
--
ALTER TABLE `news_category_content`
  ADD CONSTRAINT `fk_news_category_content_to_category` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news_content`
--
ALTER TABLE `news_content`
  ADD CONSTRAINT `fk_news_content_to_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `fk_page_to_category` FOREIGN KEY (`category_id`) REFERENCES `page_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_page_to_layout` FOREIGN KEY (`layout`) REFERENCES `theme_layouts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_page_to_parent` FOREIGN KEY (`parent`) REFERENCES `pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_page_to_template` FOREIGN KEY (`template`) REFERENCES `theme_templates` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `page_category_content`
--
ALTER TABLE `page_category_content`
  ADD CONSTRAINT `fk_page_category_content_to_category` FOREIGN KEY (`category_id`) REFERENCES `page_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `page_content`
--
ALTER TABLE `page_content`
  ADD CONSTRAINT `fk_page_content_author_to_users` FOREIGN KEY (`last_update_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_page_content_to_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `poems`
--
ALTER TABLE `poems`
  ADD CONSTRAINT `fk_poem_author_to_users` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_poems_to_category` FOREIGN KEY (`category_id`) REFERENCES `poem_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `poem_category_content`
--
ALTER TABLE `poem_category_content`
  ADD CONSTRAINT `fk_poem_category_content_to_category` FOREIGN KEY (`category_id`) REFERENCES `poem_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `poem_content`
--
ALTER TABLE `poem_content`
  ADD CONSTRAINT `fk_poem_content_to_poem` FOREIGN KEY (`poem_id`) REFERENCES `poems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_poem_content_update_to_author` FOREIGN KEY (`last_update_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `program_content`
--
ALTER TABLE `program_content`
  ADD CONSTRAINT `fk_program_content_to_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_content`
--
ALTER TABLE `project_content`
  ADD CONSTRAINT `fk_project_content_to_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `site_options_content`
--
ALTER TABLE `site_options_content`
  ADD CONSTRAINT `fk_options_content_to_options` FOREIGN KEY (`option_id`) REFERENCES `site_options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `spotlight_content`
--
ALTER TABLE `spotlight_content`
  ADD CONSTRAINT `fk_spotlight_content_to_spotlight` FOREIGN KEY (`spotlight_id`) REFERENCES `spotlight` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `story_content`
--
ALTER TABLE `story_content`
  ADD CONSTRAINT `fk_story_content_to_story` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `fk_team_to_category` FOREIGN KEY (`category_id`) REFERENCES `team_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_team_to_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `team_category_content`
--
ALTER TABLE `team_category_content`
  ADD CONSTRAINT `fk_team_category_content_to_category` FOREIGN KEY (`category_id`) REFERENCES `team_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team_content`
--
ALTER TABLE `team_content`
  ADD CONSTRAINT `fk_team_content_to_team` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test_features`
--
ALTER TABLE `test_features`
  ADD CONSTRAINT `fk_test_feature_to_category` FOREIGN KEY (`category_id`) REFERENCES `test_feature_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `test_feature_category_content`
--
ALTER TABLE `test_feature_category_content`
  ADD CONSTRAINT `fk_test_feature_category_content_to_category` FOREIGN KEY (`category_id`) REFERENCES `test_feature_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test_feature_content`
--
ALTER TABLE `test_feature_content`
  ADD CONSTRAINT `fk_test_feature_content_to_test_feature` FOREIGN KEY (`test_feature_id`) REFERENCES `test_features` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `theme_layouts`
--
ALTER TABLE `theme_layouts`
  ADD CONSTRAINT `fk_theme_layouts_to_them` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `theme_templates`
--
ALTER TABLE `theme_templates`
  ADD CONSTRAINT `fk_theme_templates_to_thems` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
