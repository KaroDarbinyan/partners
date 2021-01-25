-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 10 2020 г., 09:33
-- Версия сервера: 10.4.8-MariaDB
-- Версия PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `involve`
--

-- --------------------------------------------------------

--
-- Структура таблицы `all_post_number`
--

CREATE TABLE IF NOT EXISTS `all_post_number` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `post_number` smallint(5) UNSIGNED DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lon` double DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `municipal_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `municipal_g_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `neighbourhood` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `archive_form`
--

CREATE TABLE IF NOT EXISTS `archive_form` (
  `id` int(11) NOT NULL,
  `name` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` char(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `target_id` int(10) DEFAULT NULL,
  `broker_id` int(10) DEFAULT NULL,
  `department_id` int(10) DEFAULT NULL,
  `source_id` int(10) DEFAULT NULL,
  `address` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_number` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `boligvarsling`
--

CREATE TABLE IF NOT EXISTS `boligvarsling` (
  `id` int(11) NOT NULL,
  `cost_from` int(11) DEFAULT NULL,
  `cost_to` int(11) DEFAULT NULL,
  `area_from` int(11) DEFAULT NULL,
  `area_to` int(11) DEFAULT NULL,
  `property_type` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `rooms` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subscribe` tinyint(1) DEFAULT 0,
  `notify_at` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `budsjett`
--

CREATE TABLE IF NOT EXISTS `budsjett` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `inntekt` int(10) UNSIGNED DEFAULT NULL,
  `snittprovisjon` int(10) UNSIGNED DEFAULT NULL,
  `hitrate` smallint(5) UNSIGNED DEFAULT NULL,
  `befaringer` smallint(5) UNSIGNED DEFAULT NULL,
  `salg` smallint(5) UNSIGNED DEFAULT NULL,
  `year` smallint(5) UNSIGNED DEFAULT NULL,
  `created_at` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` int(10) UNSIGNED DEFAULT NULL,
  `avdeling_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `calendar_events`
--

CREATE TABLE IF NOT EXISTS `calendar_events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `classes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL,
  `name` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_number` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_contact` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `blocked` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_firma` int(10) UNSIGNED DEFAULT NULL,
  `navn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `organisasjonsnummer` int(10) UNSIGNED DEFAULT NULL,
  `besoksadresse` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `postnummer` smallint(5) UNSIGNED DEFAULT NULL,
  `poststed` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefon` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefax` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inaktiv` tinyint(4) DEFAULT NULL,
  `dagligleder` int(10) UNSIGNED DEFAULT NULL,
  `avdelingsleder` int(10) UNSIGNED DEFAULT NULL,
  `fagansvarlig` int(10) UNSIGNED DEFAULT NULL,
  `web_id` int(10) UNSIGNED DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `part_of_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acting` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `digital_marketing`
--

CREATE TABLE IF NOT EXISTS `digital_marketing` (
  `id` int(11) UNSIGNED NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `start` bigint(20) UNSIGNED DEFAULT NULL,
  `stop` bigint(20) UNSIGNED DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `source_object_id` int(11) UNSIGNED DEFAULT NULL,
  `live` tinyint(1) UNSIGNED DEFAULT NULL,
  `completed` tinyint(1) UNSIGNED DEFAULT NULL,
  `creative_a_stats` varchar(255) DEFAULT NULL,
  `creative_b_stats` varchar(255) DEFAULT NULL,
  `stats` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `docs`
--

CREATE TABLE IF NOT EXISTS `docs` (
  `id` int(10) UNSIGNED NOT NULL,
  `urldokument` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `filtype` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `navn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `property_web_id` int(10) UNSIGNED DEFAULT NULL,
  `web_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `broker_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source_id` int(10) UNSIGNED DEFAULT NULL,
  `source` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `delegated` int(10) UNSIGNED DEFAULT NULL,
  `post_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `subscribe_email` tinyint(1) NOT NULL DEFAULT 0,
  `contact_me` tinyint(1) NOT NULL DEFAULT 0,
  `target_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  `updated_at` int(10) UNSIGNED NOT NULL,
  `send_sms` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referer_source` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `status` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `handle_type` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `request_phone_user_id` int(11) DEFAULT NULL,
  `request_phone_at` int(11) DEFAULT NULL,
  `favorite` tinyint(1) DEFAULT 0,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `free_text`
--

CREATE TABLE IF NOT EXISTS `free_text` (
  `id` int(10) UNSIGNED NOT NULL,
  `propertyDetailId` int(10) UNSIGNED DEFAULT NULL,
  `nr` tinyint(3) UNSIGNED DEFAULT NULL,
  `visinettportaler` int(2) DEFAULT NULL,
  `gruppenavn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `overskrift` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `htmltekst` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `compositeTextId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `nr` tinyint(3) UNSIGNED DEFAULT NULL,
  `propertyDetailId` int(10) UNSIGNED DEFAULT NULL,
  `id` int(10) UNSIGNED NOT NULL,
  `urlstorthumbnail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `urloriginalbilde` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `overskrift` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_navn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `width` int(5) DEFAULT NULL,
  `height` int(5) DEFAULT NULL,
  `web_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `lead_log`
--

CREATE TABLE IF NOT EXISTS `lead_log` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `notify_at` int(11) DEFAULT NULL,
  `inform_in_advance` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ledige_stillinger`
--

CREATE TABLE IF NOT EXISTS `ledige_stillinger` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `kontor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  `updated_at` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'nyheter',
  `show_img` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `percent_text`
--

CREATE TABLE IF NOT EXISTS `percent_text` (
  `id` int(11) NOT NULL,
  `number` int(3) DEFAULT NULL,
  `name` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` int(3) DEFAULT NULL,
  `property_web_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `post_number`
--

CREATE TABLE IF NOT EXISTS `post_number` (
  `id` int(10) UNSIGNED NOT NULL,
  `index` mediumint(8) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `properties_events`
--

CREATE TABLE IF NOT EXISTS `properties_events` (
  `id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `event_id` int(3) DEFAULT NULL,
  `start_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `property`
--

CREATE TABLE IF NOT EXISTS `property` (
  `id` int(11) NOT NULL,
  `web_id` int(10) UNSIGNED DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` float DEFAULT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `s_meters` smallint(5) UNSIGNED DEFAULT NULL,
  `employee_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `property_ads`
--

CREATE TABLE IF NOT EXISTS `property_ads` (
  `id` int(11) NOT NULL,
  `finn_adid` varchar(255) DEFAULT NULL,
  `finn_viewings` varchar(255) DEFAULT NULL,
  `finn_emails` varchar(255) DEFAULT NULL,
  `finn_general_emails` varchar(255) DEFAULT NULL,
  `eiendom_viewings` int(11) DEFAULT 0,
  `adv_in_fb` tinyint(1) DEFAULT 0,
  `adv_in_insta` tinyint(1) DEFAULT 0,
  `adv_in_video` tinyint(1) DEFAULT 0,
  `adv_in_solgt` tinyint(1) DEFAULT 0,
  `property_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `property_details`
--

CREATE TABLE IF NOT EXISTS `property_details` (
  `id` int(11) NOT NULL,
  `endretdato` int(10) UNSIGNED DEFAULT NULL,
  `markedsforingsdato` int(10) UNSIGNED DEFAULT NULL,
  `oppdragsnummer` bigint(10) UNSIGNED DEFAULT NULL,
  `arkivert` int(1) DEFAULT NULL,
  `trukket` int(1) DEFAULT NULL,
  `type_eiendomstyper` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_eierformbygninger` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_eierformtomt` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `finn_orderno` bigint(20) DEFAULT NULL,
  `energimerke_bokstav` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `energimerke_farge` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `befaringsdato` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `prisvurderingsdato` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `solgt` tinyint(4) DEFAULT NULL,
  `oppdragsdato` int(10) UNSIGNED DEFAULT NULL,
  `utlopsdato` int(10) UNSIGNED DEFAULT NULL,
  `markedsforingsklart` tinyint(4) DEFAULT NULL,
  `vispaafinn` tinyint(4) DEFAULT NULL,
  `avdeling_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `ansatte1_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `ansatte2_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `gaardsnummer` mediumint(8) UNSIGNED DEFAULT NULL,
  `bruksnummer` mediumint(8) UNSIGNED DEFAULT NULL,
  `fylkesnummer` mediumint(8) UNSIGNED DEFAULT NULL,
  `fylkesnavn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kommuneomraade` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kommunenummer` mediumint(8) UNSIGNED DEFAULT NULL,
  `kommunenavn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `overskrift` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `postnummer` mediumint(8) UNSIGNED DEFAULT NULL,
  `poststed` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `byggeaar` smallint(5) UNSIGNED DEFAULT NULL,
  `fastpris` int(10) DEFAULT NULL,
  `prisantydning` int(10) UNSIGNED DEFAULT NULL,
  `prissamletsum` int(10) UNSIGNED DEFAULT NULL,
  `tomteareal` mediumint(8) UNSIGNED DEFAULT NULL,
  `prom` smallint(5) UNSIGNED DEFAULT NULL,
  `bruksareal` mediumint(8) UNSIGNED DEFAULT NULL,
  `bruttoareal` mediumint(8) UNSIGNED DEFAULT NULL,
  `oppholdsrom` tinyint(3) UNSIGNED DEFAULT NULL,
  `soverom` tinyint(3) UNSIGNED DEFAULT NULL,
  `antallrom` tinyint(3) UNSIGNED DEFAULT NULL,
  `totalkostnadsomtekst` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `totalkostnadsomtall` int(10) UNSIGNED DEFAULT NULL,
  `totalomkostningsomtall` int(10) UNSIGNED DEFAULT NULL,
  `finnmatchekriterier` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `bad` tinyint(3) UNSIGNED DEFAULT NULL,
  `akseptdato` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `salgssum` int(10) UNSIGNED DEFAULT NULL,
  `etasje` tinyint(3) DEFAULT NULL,
  `borettslag` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `borettslag_organisasjonsnummer` bigint(20) UNSIGNED DEFAULT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bokfortprovisjon` mediumint(8) UNSIGNED DEFAULT NULL,
  `ligningsverdi` int(11) DEFAULT NULL,
  `kommentarleie` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `urlelektroniskbudgivning` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `modernisert` smallint(6) DEFAULT NULL,
  `tinde_oppdragstype` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fellesutgifter` int(11) DEFAULT NULL,
  `andelfellesgjeld` int(11) DEFAULT NULL,
  `finn_eiendomstype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `finn_importstatisticsurl` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `overtagelse` int(10) DEFAULT NULL,
  `kontraktsmoteinklklokkeslett` int(10) DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sold_date` int(11) DEFAULT NULL,
  `sp_boost` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `property_links`
--

CREATE TABLE IF NOT EXISTS `property_links` (
  `id` int(10) UNSIGNED NOT NULL,
  `navn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `property_web_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `property_neighbourhood`
--

CREATE TABLE IF NOT EXISTS `property_neighbourhood` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `distance` float DEFAULT NULL,
  `property_web_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `property_visits`
--

CREATE TABLE IF NOT EXISTS `property_visits` (
  `id` int(10) UNSIGNED NOT NULL,
  `nr` tinyint(11) UNSIGNED DEFAULT NULL,
  `visit_id` int(10) UNSIGNED DEFAULT NULL,
  `fra` int(11) DEFAULT NULL,
  `til` int(11) DEFAULT NULL,
  `property_web_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `salgssnitt`
--

CREATE TABLE IF NOT EXISTS `salgssnitt` (
  `id` int(11) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `value` double DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` char(40) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_department_post_number`
--

CREATE TABLE IF NOT EXISTS `tbl_department_post_number` (
  `id` int(11) NOT NULL,
  `post_number` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `web_id` int(10) UNSIGNED DEFAULT NULL,
  `navn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  `updated_at` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED DEFAULT NULL,
  `id_avdelinger` int(10) UNSIGNED DEFAULT NULL,
  `tittel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inaktiv` tinyint(4) DEFAULT NULL,
  `mobiltelefon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `urlstandardbilde` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `inaktiv_status` tinyint(4) DEFAULT 0,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `recruitdate` int(11) DEFAULT NULL,
  `dismissaldate` int(11) DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expire_at` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `all_post_number`
--
ALTER TABLE `all_post_number`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index` (`post_number`),
  ADD KEY `area` (`area`);

--
-- Индексы таблицы `archive_form`
--
ALTER TABLE `archive_form`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `boligvarsling`
--
ALTER TABLE `boligvarsling`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `budsjett`
--
ALTER TABLE `budsjett`
  ADD PRIMARY KEY (`id`),
  ADD KEY `year` (`year`);

--
-- Индексы таблицы `calendar_events`
--
ALTER TABLE `calendar_events`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_firma` (`id_firma`),
  ADD KEY `web_id` (`web_id`);

--
-- Индексы таблицы `digital_marketing`
--
ALTER TABLE `digital_marketing`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `docs`
--
ALTER TABLE `docs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_index_from_source` (`property_web_id`,`web_id`),
  ADD KEY `property_web_id` (`property_web_id`),
  ADD KEY `navn` (`navn`);

--
-- Индексы таблицы `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `source_id` (`source_id`),
  ADD KEY `source` (`source`(255)),
  ADD KEY `delegated` (`delegated`),
  ADD KEY `post_number` (`post_number`),
  ADD KEY `phone` (`phone`),
  ADD KEY `email` (`email`),
  ADD KEY `target_id` (`target_id`),
  ADD KEY `broker_id` (`broker_id`);

--
-- Индексы таблицы `free_text`
--
ALTER TABLE `free_text`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_index_from_source` (`propertyDetailId`,`compositeTextId`),
  ADD KEY `propertyDetailId` (`propertyDetailId`),
  ADD KEY `visinettportaler` (`visinettportaler`),
  ADD KEY `nr` (`nr`);

--
-- Индексы таблицы `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_index_from_source` (`propertyDetailId`,`web_id`),
  ADD KEY `propertyDetailId` (`propertyDetailId`);

--
-- Индексы таблицы `lead_log`
--
ALTER TABLE `lead_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_form` (`lead_id`);

--
-- Индексы таблицы `ledige_stillinger`
--
ALTER TABLE `ledige_stillinger`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `percent_text`
--
ALTER TABLE `percent_text`
  ADD PRIMARY KEY (`id`);


--
-- Индексы таблицы `post_number`
--
ALTER TABLE `post_number`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index` (`index`),
  ADD KEY `department_id` (`department_id`);

--
-- Индексы таблицы `properties_events`
--
ALTER TABLE `properties_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `properties_events` (`property_id`),
  ADD KEY `_events` (`event_id`);

--
-- Индексы таблицы `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `web_id` (`web_id`),
  ADD KEY `price` (`price`),
  ADD KEY `type` (`type`),
  ADD KEY `s_meters` (`s_meters`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Индексы таблицы `property_ads`
--
ALTER TABLE `property_ads`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `property_details`
--
ALTER TABLE `property_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oppdragsnummer` (`oppdragsnummer`),
  ADD KEY `solgt` (`solgt`),
  ADD KEY `oppdragsdato` (`oppdragsdato`),
  ADD KEY `utlopsdato` (`utlopsdato`),
  ADD KEY `markedsforingsklart` (`markedsforingsklart`),
  ADD KEY `vispaafinn` (`vispaafinn`),
  ADD KEY `ansatte1_id` (`ansatte1_id`),
  ADD KEY `ansatte2_id` (`ansatte2_id`),
  ADD KEY `postnummer` (`postnummer`),
  ADD KEY `tomteareal` (`tomteareal`),
  ADD KEY `prom` (`prom`),
  ADD KEY `soverom` (`soverom`),
  ADD KEY `salgssum` (`salgssum`),
  ADD KEY `avdeling_id` (`avdeling_id`);

--
-- Индексы таблицы `property_links`
--
ALTER TABLE `property_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_web_id` (`property_web_id`),
  ADD KEY `navn` (`navn`);

--
-- Индексы таблицы `property_neighbourhood`
--
ALTER TABLE `property_neighbourhood`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_web_id` (`property_web_id`),
  ADD KEY `distance` (`distance`);

--
-- Индексы таблицы `property_visits`
--
ALTER TABLE `property_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_web_id` (`property_web_id`),
  ADD KEY `fra` (`fra`);

--
-- Индексы таблицы `salgssnitt`
--
ALTER TABLE `salgssnitt`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_department_post_number`
--
ALTER TABLE `tbl_department_post_number`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_combination` (`post_number`,`department_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD UNIQUE KEY `webmegler_id` (`web_id`),
  ADD KEY `inaktiv_status` (`inaktiv_status`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `all_post_number`
--
ALTER TABLE `all_post_number`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `archive_form`
--
ALTER TABLE `archive_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `boligvarsling`
--
ALTER TABLE `boligvarsling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `budsjett`
--
ALTER TABLE `budsjett`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `calendar_events`
--
ALTER TABLE `calendar_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `department`
--
ALTER TABLE `department`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `digital_marketing`
--
ALTER TABLE `digital_marketing`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `docs`
--
ALTER TABLE `docs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `free_text`
--
ALTER TABLE `free_text`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `image`
--
ALTER TABLE `image`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `lead_log`
--
ALTER TABLE `lead_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ledige_stillinger`
--
ALTER TABLE `ledige_stillinger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `percent_text`
--
ALTER TABLE `percent_text`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `post_number`
--
ALTER TABLE `post_number`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `properties_events`
--
ALTER TABLE `properties_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `property`
--
ALTER TABLE `property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `property_ads`
--
ALTER TABLE `property_ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `property_details`
--
ALTER TABLE `property_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `property_links`
--
ALTER TABLE `property_links`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `property_neighbourhood`
--
ALTER TABLE `property_neighbourhood`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `property_visits`
--
ALTER TABLE `property_visits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `salgssnitt`
--
ALTER TABLE `salgssnitt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_department_post_number`
--
ALTER TABLE `tbl_department_post_number`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа таблицы `properties_events`
--
ALTER TABLE `properties_events`
  ADD CONSTRAINT `_events` FOREIGN KEY (`event_id`) REFERENCES `calendar_events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `properties_events` FOREIGN KEY (`property_id`) REFERENCES `property_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
