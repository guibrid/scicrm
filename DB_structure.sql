-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 11 Juillet 2018 à 16:18
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cake_crmsci`
--

-- --------------------------------------------------------

--
-- Structure de la table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1AL "1": Sec alimentaire; 1NAL "2": Sec non alimentaire; 2AL "3": Surgeler; 3AL "4": Frais (Voir colonne AG) ',
  `store_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `origins`
--

CREATE TABLE `origins` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `remplacement_product` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `pcb` int(11) DEFAULT NULL,
  `prix` double DEFAULT NULL,
  `uv` varchar(255) DEFAULT NULL,
  `poids` double DEFAULT NULL,
  `volume` double DEFAULT NULL,
  `dlv` date DEFAULT NULL,
  `duree_vie` int(11) DEFAULT NULL,
  `gencod` bigint(20) DEFAULT NULL,
  `douanier` bigint(20) DEFAULT NULL,
  `dangereux` varchar(255) DEFAULT NULL,
  `origin_id` varchar(255) DEFAULT NULL,
  `tva` double DEFAULT NULL,
  `cdref` varchar(255) DEFAULT NULL,
  `category_code` int(11) DEFAULT NULL,
  `subcategory_code` int(11) DEFAULT NULL,
  `entrepot` varchar(255) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `couche_palette` varchar(11) DEFAULT NULL,
  `colis_palette` varchar(255) DEFAULT NULL,
  `pieceartk` varchar(255) DEFAULT NULL,
  `ifls_remplacement` varchar(255) DEFAULT NULL,
  `assortiment` varchar(255) DEFAULT NULL,
  `brand_id` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `shortbrands`
--

CREATE TABLE `shortbrands` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `shortbrands_products`
--

CREATE TABLE `shortbrands_products` (
  `id` int(11) NOT NULL,
  `shortbrand_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `shortorigins`
--

CREATE TABLE `shortorigins` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `origin_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `shortorigins_products`
--

CREATE TABLE `shortorigins_products` (
  `id` int(11) NOT NULL,
  `shortorigin_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_code` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `warnings`
--

CREATE TABLE `warnings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `urgence` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkey_store_id` (`store_id`);

--
-- Index pour la table `origins`
--
ALTER TABLE `origins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkey_origin_id` (`origin_id`),
  ADD KEY `fkey_brand_id` (`brand_id`),
  ADD KEY `fkey_category_code` (`category_code`),
  ADD KEY `fkey_subcategory_code` (`subcategory_code`);

--
-- Index pour la table `shortbrands`
--
ALTER TABLE `shortbrands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkey_brand_id` (`brand_id`);

--
-- Index pour la table `shortbrands_products`
--
ALTER TABLE `shortbrands_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkey_shortbrand_id` (`shortbrand_id`),
  ADD KEY `fkey_product_id` (`product_id`);

--
-- Index pour la table `shortorigins`
--
ALTER TABLE `shortorigins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkey_origin_id` (`origin_id`);

--
-- Index pour la table `shortorigins_products`
--
ALTER TABLE `shortorigins_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkey_shortorigin_id` (`shortorigin_id`),
  ADD KEY `fkey_product_id` (`product_id`);

--
-- Index pour la table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `warnings`
--
ALTER TABLE `warnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkey_product_code` (`product_code`);
