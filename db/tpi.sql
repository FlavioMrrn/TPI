-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 02 mai 2021 à 15:02
-- Version du serveur :  5.7.24
-- Version de PHP : 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Création du compte tpiecommerce pour accéder à la base ecommerce
--

CREATE USER IF NOT EXISTS 'tpiecommerce'@'localhost' IDENTIFIED BY 'tipi1234';
GRANT USAGE ON *.* TO 'tpiecommerce'@'localhost' REQUIRE NONE 
WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT SELECT, INSERT, UPDATE, DELETE ON `ecommerce`.* TO 'tpiecommerce'@'localhost';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce`
--
CREATE DATABASE IF NOT EXISTS `ecommerce` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ecommerce`;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `idCategory` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text,
  `idParentCategory` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`idCategory`, `title`, `description`, `idParentCategory`) VALUES
(1, 'Ordinateurs', 'Appareils complets, prêts à l\'usage', NULL),
(2, 'Composants', 'Construisez vous-même votre ordinateur', NULL),
(3, 'Ordinateurs de bureau', 'All in One, PC, Client Thin, etc', 1),
(4, 'Ordinateurs portables', NULL, 1),
(5, 'Tablettes', NULL, 1),
(6, 'Processeurs', NULL, 2),
(7, 'Cartes mères', NULL, 2),
(8, 'Mémoire RAM', NULL, 2),
(9, 'Cartes graphiques', NULL, 2),
(10, 'Boîtiers', NULL, 2),
(11, 'Alimentations', NULL, 2),
(12, 'Refroidissement', NULL, 2),
(13, 'Stockage', NULL, 2),
(14, 'SSD', NULL, 13),
(15, 'Disques internes HDD', NULL, 13),
(16, 'Clés USB', NULL, 13),
(17, 'NAS', NULL, 13),
(18, 'Lecteurs optiques DVD/BD', NULL, 13);

-- --------------------------------------------------------

--
-- Structure de la table `commands`
--

CREATE TABLE `commands` (
  `idCommand` int(10) UNSIGNED NOT NULL,
  `commandStatus` enum('Basket','Sent','PartiallyDelivered','Finalised') NOT NULL,
  `commandDate` datetime NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `pdfPath` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commands`
--

INSERT INTO `commands` (`idCommand`, `commandStatus`, `commandDate`, `idUser`, `pdfPath`) VALUES
(1, 'Finalised', '2021-03-01 12:51:37', 8, NULL),
(2, 'Finalised', '2021-03-05 12:51:37', 4, NULL),
(3, 'Finalised', '2021-03-05 12:51:37', 10, NULL),
(4, 'PartiallyDelivered', '2021-03-10 12:51:37', 14, NULL),
(5, 'PartiallyDelivered', '2021-03-12 12:51:37', 8, NULL),
(6, 'Sent', '2021-04-02 12:51:37', 14, NULL),
(7, 'Sent', '2021-04-11 12:51:37', 13, NULL),
(8, 'Sent', '2021-04-21 12:51:37', 12, NULL),
(9, 'Basket', '2021-05-01 12:51:37', 8, NULL),
(10, 'Basket', '2021-05-01 12:51:37', 9, NULL),
(15, 'Sent', '2021-05-02 14:41:36', 11, NULL),
(16, 'Sent', '2021-05-02 14:45:12', 4, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commands_has_items`
--

CREATE TABLE `commands_has_items` (
  `idCommand` int(10) UNSIGNED NOT NULL,
  `idItem` int(10) UNSIGNED NOT NULL,
  `salePrice` decimal(10,2) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commands_has_items`
--

INSERT INTO `commands_has_items` (`idCommand`, `idItem`, `salePrice`, `quantity`) VALUES
(1, 4, '1439.00', 1),
(1, 5, '1315.00', 1),
(1, 84, '79.00', 2),
(1, 92, '32.00', 5),
(2, 9, '2300.00', 1),
(2, 16, '169.85', 1),
(2, 52, '375.00', 1),
(2, 86, '121.00', 1),
(3, 23, '489.00', 1),
(3, 36, '45.00', 1),
(3, 53, '254.00', 1),
(3, 55, '1901.00', 1),
(3, 66, '234.00', 1),
(3, 75, '95.00', 1),
(3, 87, '113.00', 1),
(4, 7, '498.00', 1),
(4, 14, '748.90', 1),
(4, 92, '29.00', 1),
(5, 11, '472.00', 5),
(5, 16, '169.85', 5),
(5, 91, '12.00', 20),
(6, 62, '81.00', 1),
(6, 66, '234.00', 1),
(6, 79, '181.00', 1),
(7, 24, '780.00', 1),
(7, 83, '56.00', 1),
(8, 15, '986.00', 1),
(9, 62, '81.00', 1),
(9, 88, '215.00', 4),
(9, 92, '32.00', 5),
(9, 95, '228.00', 1),
(10, 2, '983.00', 1),
(10, 15, '986.00', 1),
(10, 91, '17.00', 1),
(15, 13, '209.00', 1),
(15, 51, '180.00', 2),
(16, 3, '1088.00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `deliveries`
--

CREATE TABLE `deliveries` (
  `idDelivery` int(10) UNSIGNED NOT NULL,
  `deliveryStatus` enum('Starting','Sent','Delivered') NOT NULL,
  `deliveryDate` datetime NOT NULL,
  `idCommand` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `deliveries`
--

INSERT INTO `deliveries` (`idDelivery`, `deliveryStatus`, `deliveryDate`, `idCommand`) VALUES
(8, 'Sent', '2021-03-17 08:37:00', 1),
(9, 'Sent', '2021-04-21 10:20:00', 1),
(10, 'Sent', '2021-03-08 08:16:00', 2),
(11, 'Sent', '2021-03-10 09:20:00', 3),
(12, 'Sent', '2021-03-15 09:20:00', 4),
(13, 'Sent', '2021-03-17 17:00:00', 5);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `idImage` int(10) UNSIGNED NOT NULL,
  `imageName` varchar(45) NOT NULL,
  `idItem` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

CREATE TABLE `items` (
  `idItem` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `manufacturer` varchar(50) NOT NULL,
  `partNumber` varchar(100) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `idCategory` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`idItem`, `name`, `description`, `price`, `manufacturer`, `partNumber`, `published`, `idCategory`) VALUES
(1, 'AiO ENVY 32-a1700nz - 199Y6EA', 'Intel Core i7-10700 (2.9 Ghz/4.7 GHz Turbo) 8-Core - 16GB DDR4 - 1TB SSD - 31.5\" LED IPS (3840x2160) - Nvidia GeForce RTX 2070 (8GB) - Gigabit LAN / Wi-Fi 802.11ax / Bluetooth 5.0 - Windows 10 Home 64-bit - EAN : 195122190736', '3165.00', 'HP', '199Y6EA#UUZ', 1, 3),
(2, 'ProOne 440 G6 AiO - 1C7A0EA', 'Intel Core i5-10500T (2.3 Ghz/3.8 GHz Turbo) 6-Core - 8GB DDR4 - 256GB SSD - 23.8\" LED IPS (1920x1080) - Intel UHD Graphics 630 - Gigabit LAN / Wi-Fi 802.11ax / Bluetooth 5.0 - DVD - Windows 10 Pro 64-bit - EAN : 195122931520', '961.00', 'HP', '1C7A0EA#UUZ', 1, 3),
(3, 'All-in-One OptiPlex Touch 3280-4XGC3', '21.5\" LED (1920x1080) Touch - Intel Core i5-10500T (2.3 Ghz/3.8 GHz Turbo) 6-Core - 8GB DDR4 - 256GB SSD - Intel UHD Graphics 630 - Gigabit LAN / Wi-Fi 802.11ac / Bluetooth 4.2 - Windows 10 Pro 64-bit - EAN : 5397184415740', '1088.00', 'Dell', '4XGC3', 1, 3),
(4, 'Veriton AiO Z6870G i7', '23.8\" (1920x1080) - Intel Core i7-10700 (2.9 GHz / 4.8 GHz) 8-core - 16GB DDR4 - 1TB SSD - Intel UHD Graphics - Gigabit LAN / Wi-Fi 802.11ax / Bluetooth 5.0 - DVD - Windows 10 Pro - EAN : 4710886065623', '1444.00', 'Acer', 'DQ.VTEEZ.001', 1, 3),
(5, 'Aspire TC-895 (DG.BEZEZ.001)', 'Intel Core i7-10700 (2.9 GHz / 4.8 GHz Turbo) 8-core - 16GB DDR4 - 1TB HDD + 1TB SSD - NVIDIA GeForce GTX 1650 (4GB GDDR5) - Gigabit LAN / WiFi 80.11ac / Bluetooth 4.0 - DVD - Windows 10 Home - EAN : 4710886056140', '1317.00', 'Acer', 'DG.BEZEZ.001', 1, 3),
(6, 'EliteDesk 800 G6 Desktop Mini - 1D2M5EA', 'Intel Core i7-10700 (2.9 GHz/4.8 GHz Turbo) 8-Core - 16GB DDR4 - 512GB SSD - Intel UHD Graphics 630 - Gigabit LAN / WiFi 802.11ax / Bluetooth 5.0 - Windows 10 Pro 64-bit - EAN : 195161164163', '1260.00', 'HP', '1D2M5EA#UUZ', 1, 3),
(7, 'OptiPlex 3080-XHK61 MFF', 'Intel Core i3-10100T (3.0 GHz/3.8 GHz Turbo) 6-Core - 8GB DDR4 - 256GB SSD - Intel UHD Graphics - Gigabit LAN / Wi-Fi 802.11ac / Bluetooth 4.2 - Windows 10 Pro - EAN : 5397184434444', '498.00', 'Dell', 'XHK61', 1, 3),
(8, '470 G7 - 15S36ES', 'Intel Core i5-10210U (1.6 GHz/4.2 GHz Turbo) Quad Core - 16GB DDR4 - 512GB SSD - 17.3\" LED FHD (1920x1080) - AMD Radeon 530 (2GB DDR5) - Windows 10 Home 64-bit - EAN : 195122162733', '1070.00', 'HP', '15S36ES#UUZ', 1, 4),
(9, 'Precision 5750-0YY3V', 'Intel Core i7-10750H (2.7 GHz/5.1 GHz Turbo) 6-Core - 16GB DDR4 - 512GB SSD - 17.3\" IGZO (1920x1200) - NVIDIA Quadro T2000 (4GB GDDR5) - Wi-Fi 802.11ax / Bluetooth 5.0 - Thunderbolt 3 - Windows 10 Pro 64-bit - EAN : 5397184469026', '2323.00', 'Dell', '0YY3V', 1, 4),
(10, 'XPS 17 (9700-0VN0J)', 'Dell XPS 17 (9700-0VN0J)Dell XPS 17 (9700-0VN0J)\r\nIntel Core i7-10750H (2.6 GHz/5.0 GHz Turbo) 6-Core - 16GB DDR4 - 1TB SSD - 17\" LED IPS (1920x1200) - Intel UHD Graphics - Wi-Fi 802.11ax / Bluetooth 5.0 - Thunderbolt 3 - Windows 10 Pro 64-bit - EAN : 5397184463666', '2550.00', 'Dell', '0VN0J', 1, 4),
(11, 'Chromebook 11 LTE (NX.GUNEZ.001)', 'Intel Celeron N3450 (1.1 GHz/2.2GHz Turbo) Quad-Core - 8GB DDR4 - 32GB eMMC - 11.6\" LED IPS (1366x768) Touch - Intel HD Graphics 500 - WLAN 802.11ac / Bluetooth 4.2 / 4G/LTE - HDMI - USB 3.0 / USB Type-C - HD Webcam - Chrome OS - EAN : 4710180664065', '472.00', 'Acer', 'NX.GUNEZ.001', 1, 4),
(12, 'ThinkPad X12 Detachable - 20UW0020MZ', 'Intel Core i7-1160G7 (2.1 GHz/4.4 GHz) Quad Core - 16GB DDR4 - 512GB SSD - 12.3\" LED IPS (1920x1080) Touch - Intel Iris Xe Graphics - Wi-Fi 802.11ax / Bluetooth 5.1 - Thunderbolt 4 - Windows 10 Pro - EAN : 195713107051', '1864.00', 'Lenovo', '20UW0020MZ', 1, 4),
(13, 'Galaxy Tab A7 10.4 WiFi (2020), 32GB, Dark Grey (SM-T500)', '2GHz, 3GB RAM, 32GB Flash • 10.4\" (26.4cm), IPS, 2000x1200 px, 224 ppi • Bluetooth 5.0, WLAN (802.11a/b/g/n/ac), GPS, USB 2.0 (Type C)', '209.00', 'Samsung', 'SM-T500NZAAEUC', 1, 5),
(14, 'Galaxy Tab S7+ Wi-Fi, 128GB, Mystic Black (SM-T970)', '3.09GHz, 6GB RAM, 128GB Flash • 12.4\" (31.5cm), Super AMOLED, 2800x1752 px, 266 ppi • Bluetooth 5.0, WLAN (802.11a/b/g/n/ac/ax), GPS, USB 3.2 (type C)', '748.90', 'Samsung', 'SM-T970NZKAEUC', 1, 5),
(15, 'iPad Pro 11\" (2020) Wi-Fi + Cellular (4G), 256GB, Space Gray (MXE42TY/A)', '2.5GHz, 6GB RAM, 256GB Flash • 11.0\" (27.9cm), Liquid Retina (LED/IPS), 2388x1668 px, 264 ppi • LTE Advanced (LTE+) • Bluetooth 5.0, WLAN (802.11a/b/g/n/ac/ax), GPS, USB 3.1 (Type C) • Face ID/barometer/Apple SIM/eSIM/pencil support (2nd generation)', '986.00', 'Apple', 'MXE42TY/A', 1, 5),
(16, 'Tab M10 FHD Plus, 32GB, Iron Grey (TB-X606F)', '2.3GHz, 2GB RAM, 32GB Flash • 10.3\" (26.2cm), IPS, 1920x1200 px, 220 ppi • Bluetooth 5.0, WLAN (802.11a/b/g/n/ac), USB 2.0 (Type C)', '169.85', 'Lenovo', 'ZA5T0197SE', 1, 5),
(17, 'Surface Pro 7, Core i5-1035G4 (4x 1.1/3.7GHz), 16GB RAM, 256GB, Platinum (PUW-00003)', '1.1GHz, 16GB RAM, 256GB Flash • 12.3\" (31.2cm), PixelSense, 2736x1824 px, 267 ppi • Bluetooth 5.0, WLAN (802.11a/b/g/n/ac/ax), USB 3.1 (Type C), USB 3.0', '1235.20', 'Microsoft', 'PUW-00003', 1, 5),
(20, 'MatePad Pro LTE, 128GB, Midnight Grey', '2.86GHz, 6GB RAM, 128GB Flash • 10.8\" (27.4cm), IPS, 2560x1600 px, 280 ppi • LTE Advanced (LTE+) • Bluetooth 5.1, WLAN (802.11a/b/g/n/ac), GPS, USB 3.1 (Type C)', '517.90', 'Huawei', '53010WLY', 1, 5),
(21, 'SurfTab Theatre L15 15.6 quad, ARM Cortex A53 (4x 1.5GHz), 32GB (38581)', '1.5GHz, 2GB RAM, 32GB Flash • 15.6\" (39.6cm), IPS, 1920x1080 px • Bluetooth 4.0, WLAN (802.11b/g/n), USB 2.0, mini-HDMI', '301.05', 'Trekstor', '38581', 1, 5),
(22, 'Pi 4 Model B 8.0GB', 'Broadcom BCM2711 (4x 1.5GHz), 8GB • 1x PoE-header, 2x USB-A 2.0, 2x USB-A 3.0, 1x microSDXC, 40 pin GPIO • LAN (10/100/1000 Mbps), WLAN (802.11a/b/g/n/ac), Bluetooth 5.0', '85.00', 'Raspberry', '198-3476', 1, 7),
(23, 'Ryzen 7 5800X', 'Socket AM4 - 8-Core / 16 Threads - 3.8 GHz (4.7 GHz boost) - L2/L3 4+32 MB Cache - 7 nm - 105W TDP - Sans refroidissement - BOX - EAN : 730143312714', '489.00', 'AMD', '100-100000063WOF', 1, 6),
(24, 'Ryzen 9 3950X', 'Socket AM4 - 16-Core / 32 Threads - 3.5 GHz (4.7 GHz boost) - L2/L3 8+64 MB Cache - 7 nm - 105W TDP - Sans refroidissement inclus - BOX - EAN : 730143311809', '780.00', 'AMD', '100-100000051WOF', 1, 6),
(25, 'EPYC 7351', 'Socket SP3 - 16-Core - 2.4 GHz (2.9 GHz boost) - 64 MB L3 Cache - 14 nm - 155/170W TDP - Without Fan and Cooler - BOX - EAN : 730143308878', '576.00', 'AMD', 'PS7351BEAFWOF', 1, 6),
(26, 'EPYC 7502', 'Socket SP3 - 32 Cores - 2.5 GHz (3.35 GHz boost) - 128 MB L3 Cache - 7 nm - 180W TDP - Without Fan and Cooler - BOX - EAN : 730143310048', '2779.00', 'AMD', '100-100000054WOF', 1, 6),
(27, 'Ryzen 3 3100', 'Socket AM4 - 4-Core / 8 Threads - 3.6 GHz (3.9GHz boost) - L2/L3 2+16 MB Cache - 7 nm - 65W TDP - AMD Wraith Stealth Cooler - BOX - EAN : 730143312202', '115.00', 'AMD', 'YD3200C5FHBOX', 1, 6),
(28, 'Celeron G5900', 'Socket Intel LGA 1200 - Dual-Core - 3.4 GHz - 2 MB Cache - Intel UHD Graphics 610 - 58W TDP - boxed processor with fan and heatsink - EAN : 5032037186995', '83.00', 'Intel', 'BX80701G5900', 1, 6),
(29, 'Core i3-10320', 'Socket Intel LGA 1200 - 4 Core / 8 Threads - 3.7 GHz / 4.4 GHz Turbo - 8 MB Cache - Intel UHD Graphics 630 - 65W TDP - boxed processor - EAN : 5032037186933', '178.00', 'Intel', 'BX8070110300', 1, 6),
(30, 'Core i5-11500', 'Socket Intel LGA 1200 - 6 Core / 12 Threads - 2.7 GHz / 4.6 GHz Turbo - 12 MB Cache - Intel UHD Graphics 750 - 65W TDP - boxed processor - EAN : 675901933667', '236.00', 'Intel', 'BX8070811500', 1, 6),
(31, 'Core i7-10700KF', 'Socket Intel LGA 1200 - 8 Core / 16 Threads - 3.8 GHz / 5.1 GHz Turbo - 16 MB Cache - 125W TDP - boxed processor - EAN : 5032037188685', '323.00', 'Intel', 'BX8070110700KF', 1, 6),
(32, 'Core i9-10900', 'Socket Intel LGA 1200 - 10 Core / 20 Threads - 2.8 GHz / 5.2 GHz Turbo - 20 MB Cache - Intel UHD Graphics 630 - 65W TDP - boxed processor - EAN : 5032037189163', '423.00', 'Intel', 'BX8070110900', 1, 6),
(33, 'Xeon Gold 6142', 'Socket LGA3647-0 - 16 Cores - 2.6 GHz (3.7 GHz Turbo) - 14nm - 22 MB L3 Cache - TDP 150W - BOX - EAN : 675901473491', '3214.00', 'Intel', 'BX806736142', 1, 6),
(34, 'X570M Pro4', 'mATX - AM4 - AMD X570 - 4 x DDR4 - 2 x PCIe 16X - 1 x PCIe 1X - 2 x M.2 Socket 3 - 8 x SATA 6.0 Gb/s - Gigabit LAN - USB 3.2 / Type-C - PS/2 - HDMI / DisplayPort - EAN : 4717677338812', '188.00', 'ASRock', '90-MXBAS0-A0UAYZ', 1, 7),
(35, 'B450 I AORUS PRO WIFI', 'Mini-ITX - AM4 - AMD B450 - 2x DDR4 - 1x PCIe 16X - 1x M.2 Socket 3 - 4 x SATA 6.0 Gb/s - Gigabit LAN - Wi-Fi 802.11 a/b/g/n/ac and Bluetooth v5 - USB 3.1 / USB 3.0 - 2x HDMI / DisplayPort - EAN : 4719331803988', '128.00', 'Gygabyte', 'B450 I AORUS PRO WIFI', 1, 7),
(36, 'A320M-HDV R4.0', 'mATX - AM4 - AMD A320 - 2 x DDR4 - 1 x PCIe 3.0 16X - 1 x PCIe 2.0 1X - 1 xUltra M.2 Socket - 4 x SATA 6.0 Gb/s - Gigabit LAN - USB 3.0 - VGA / DVI / HDMI - EAN : 4717677337648', '58.00', 'ASRock', '90-MXB9L0-A0UAYZ', 1, 7),
(37, 'ROG Zenith II Extreme Alpha', 'E-ATX - Socket sTRX4 - AMD TRX40 - 8x DDR4 - 4x PCIe 16X - 3x M.2 Socket 3 PCIe 4.0 - 8x SATA 6.0 Gb/s - 10 Gbps LAN / WiFi 802.11ax / Bluetooth 5.0 - USB 3.2 Gen 2x2 / USB Type-C - EAN : 4718017619684', '970.00', 'Asus', '90MB14K0-M0EAY0', 1, 7),
(38, 'ROG Zenith Extreme Alpha', 'E-ATX - Socket TR4 - AMD X399 - 8x DDR4 - 4x PCIe 16X - 1x PCIe 4X - 1x PCIe 1X - 3x M.2 Socket 3 - 1x U.2 port - 8x SATA 6.0 Gb/s - Gigabit LAN - Aquantia AQC-107 10G LAN port - Wi-Fi 802.11 a/b/g/n/ac - USB 3.1 / USB 3.0 - EAN : 4718017233163', '574.00', 'Asus', '90MB10G0-M0EAY0', 1, 7),
(39, 'P10S-E/4L', 'ATX - Socket Intel LGA 1151 - support Xeon E3-1200 v5 - Chipset Intel C236 - 4 x DDR4 - 1x PCIe x16 - 2x PCIe x8 - 1x PCI 32bit - 8x SATA - 2x M.2 - 4x Gigabit LAN - USB 3.0 - VGA - EAN : 4712900092943', '289.00', 'Asus', '90SB0520-M0UAY0', 1, 7),
(40, 'PRIME B360M-C', 'mATX - Socket Intel LGA 1151 - Chipset Intel B360 - 4x DDR4 - 1x PCIe x16 - 2x PCIe x1 - 1x PCI - 6x SATA - 2x M.2 - Gigabit LAN - USB 3.1 / USB 3.0 / USB 2.0 - VGA / HDMI / DisplayPort - EAN : 4712900984880', '105.00', 'Asus', '90MB0W80-M0EAYM', 1, 7),
(41, 'B460M Steel Legend', 'mATX - Socket Intel LGA 1200 - Chipset Intel B460 - 4x DDR4 - 2x PCIe x16 - 1x PCIe x1 - 2x M.2 Socket 3 - 6x SATA - 2.5 Gigabit LAN - USB 3.2 Gen 1 / USB Type-C / PS/2 - HDMI / DisplayPort - EAN : 4710483931291', '114.00', 'ASRock', '90-MXBDQ0-A0UAYZ', 1, 7),
(42, 'MBD-X10DRi-O', 'E-ATX - Intel Socket LGA2011v3 - Chipset Intel C612 - 16x DDR4 ECC - 3x PCIe x16 (x8) - 3x PCIe x8 (8/8/4/4) - 2x Gigabit LAN - 1x RJ45 Dedicated IPMI LAN port - 10x SATA3 - 2x COM - 5x USB 3.0 - 6x USB 2.0 - VGA - EAN : 672042137572', '482.00', 'Supermicro', 'MBD-X10DRi-O', 1, 7),
(43, 'ROG RAMPAGE VI EXTREME Encore', 'E-ATX - Socket Intel LGA2066 - Chipset Intel X299 - 8x DDR4 Quad Channel - 3x PCIe x16 - 1x PCIe x4 - 2x M.2 - 8x SATA - USB3.2 Gen 2 / USB3.0 / USB 2.0 / USB Type-C - 1x Gigabit LAN port - 1x Aquantia AQC-107 10G LAN port - Wi-Fi 802.11ax / Bluetooth v5.0 - EAN : 4718017478144', '732.00', 'Asus', '90MB11K0-M0EAY0', 1, 7),
(44, 'WS C621E SAGE', 'EEB - Socket Intel LGA3647 - Chipset Intel C621 - 12x DDR4 Quad Channel - 7x PCIe x16 - 1x M.2 - 4x U.2 - 10x SATA - USB3.1 / USB3.0 / USB 2.0 / USB Type-C - Dual Gigabit LAN - EAN : 4712900611236\r\n', '562.00', 'Asus', '90SW0020-M0EAY0', 1, 7),
(45, 'Trident Z Neo DDR4-3600 - 32GB kit (F4-3600C16D-32GTZNC)', '2 x 16GB - DDR4 - 3600 MHz - CL 16-19-19-39 - 1.35v - EAN : 4713294223463', '289.00', 'G.Skill', 'F4-3600C16D-32GTZNC', 1, 8),
(46, 'MAC Memory DDR3-1333 - 8GB', '1x 8GB SO-DIMM PC3-10600 1.5V - EAN : 843591014762', '50.00', 'Corsair', 'CMSA8GX3M1A1333C9', 1, 8),
(47, 'KTD-PE424E/8G', '8GB - DDR4 2400 MHz - ECC - DELL - EAN : 740617270617', '58.00', 'Kingston', 'KTD-PE424E/8G', 1, 8),
(48, '32GB DDR4 2400MHz ECC', '1 x 32GB DDR4 2400MHz ECC RDIMM - CL 17-17-17 at 1.2V - EAN : 740617308211', '215.00', 'Kingston', 'KSM24RD4/32HDI', 1, 8),
(49, 'SODIMM DDR3 KCP316SD8/8 - 8 GB', '8 GB - DDR3 SODIMM - 1600 MHz - EAN : 740617253719', '75.00', 'Kingston', 'KCP316SD8/8', 1, 8),
(50, 'DDR4-2666 -16 GB', '16 Go de mémoire UDIMM DDR4 2 666 MHz Entièrement compatible avec les produits ThinkCentre et ThinkStation spécifiés, notamment ThinkCentre M715, M720, M920 et ThinkStation P310/320 TWR&SFF, etc. - EAN : 192651262774', '153.00', 'Lenovo', '4X70R38788', 1, 8),
(51, 'Dominator Platinum RGB DDR4-3200 - 16 GB Kit (2x8GB)', '2 x 8 GB - DDR4 3200 MHz - CL 16-18-18-36 - 1.35 V - EAN : 840006609452', '180.00', 'Corsair', 'CMT16GX4M2Z3200C16', 1, 8),
(52, 'Dominator Platinum RGB DDR4-3600 - 32 GB Kit (4x8GB)', '4 x 8 GB - DDR4 3600Mhz - CL18-19-19-39 - 1.35v - EAN : 840006607403', '375.00', 'Corsair', 'CMT32GX4M4C3600C18', 1, 8),
(53, 'Vengeance RGB Pro SL DDR4-3200 - 32 GB kit (White) - (4x8GB)', '4 x 8 GB - DDR4 3200Mhz - CL 16-20-20-38 - 1.35v - EAN : 840006632160', '254.00', 'Corsair', 'CMH32GX4M4E3200C16W', 1, 8),
(54, 'Trident Z RGB DDR4-3600 - 32GB kit (F4-3600C17D-32GTZR)', '2 x 16GB - DDR4 - 3600 MHz - CL 17-19-19-39 - 1.35v - EAN : 4719692015280', '279.00', 'G.Skill', 'F4-3600C17D-32GTZR', 1, 8),
(55, 'Radeon Pro WX 9100', 'Radeon Pro WX 9100 - 16GB HBC with ECC - OpenGL 4.5+DX12.1 - 6 x DisplayPorts 1.4 - EAN : 727419416399', '1901.00', 'AMD', '100-505957', 1, 9),
(56, 'Radeon RX 580 PULSE 8GD5', 'GPU 1366 Mhz - 8 GB GDDR5 8000 Mhz (256-bit) - 1x DVI / 2x HDMI / 2x DisplayPort 1.4 - EAN : 4895106281905', '816.00', 'Sapphire', '11265-05-20G', 1, 9),
(57, 'M9140 LP (PCIe 16X)', 'PCIe 16X - 512 MB - Low Profile - KX-20 (KX-20 > 4 x DVI-I) - max. 1920x1200 - PowerDesk Software - OpenGL 2.0 - EAN : 790750235899', '563.00', 'Matrox', 'M9140-E512LAF', 1, 9),
(58, 'GeForce GTX 1660 Super Phoenix OC 6GB', 'PH-GTX1660S-O6G - GPU 1530 / 1830 Mhz - 6GB GDDR6 @ 7000 MHz (192-bit) - 1x DVI-D / 1x HDMI 2.0b / 1x DisplayPort 1.4 - EAN : 4718017505291', '499.00', 'Asus', '90YV0DT0-M0NA00', 1, 9),
(59, 'Quadro P1000 V2 DVI', '4GB GDDR5 (128-bit) - 4x mini Display Port 1.4 - 4x mini DisplayPort -> DVI Adapters - Attached Low-Profile (SFF) Bracket - Unattached Full-Height (ATX) Bracket - EAN : 3536403375706', '407.00', 'PNY', 'VCQP1000DVIV2-PB', 1, 9),
(60, 'Quadro RTX A6000', 'Quadro RTX A6000 - 10,752 CUDA Cores - 48GB GDDR6 (384-bit) - 4x DisplayPort 1.4 - EAN : 3536403379193', '5848.00', 'PNY', 'VCNRTXA6000-PB', 1, 9),
(61, 'GeForce GT 730 ZONE Edition', '902MHz GPU - 2GB DDR3 @ 1600MHz (64-bit) - HDMI x1 / DVI x1 / VGA x1 - EAN : 4895173605109', '110.00', 'Zotac', 'ZT-71113-20L', 1, 9),
(62, 'BC-12D2HT (Retail)', 'BD-R (12X) - BD-RE (8x) - BD-ROM (12x) - DVD±RW/DL/RAM (16x/8x/8x/5x) - SATA - EAN : 4716659524359', '81.00', 'Asus', '90DD0230-B20010', 1, 18),
(63, 'BW-16D1H-U Pro', 'Graveur Blu-Ray externe - USB 3.0 - 16x BD-R / 16x DVD-R / 48x CD-R - Windows/MacOS - EAN : 4716659921622', '154.00', 'Asus', '90DD01L0-M69000', 1, 18),
(64, 'BDR-212DBK', 'BD-R (16X) - BD-RE (2x) - DVD±RW/DL/RAM (16x/8x/8x/6x) - SATA - Bulk (Black) - EAN : 8849384282174', '72.00', 'Pioneer', 'BDR-212DBK', 1, 18),
(65, 'TUF GT501 (Black)', 'Boitier Mini-ITX / M-ATX / ATX / E-ATX - 4 x 3.5\" int. - 3 x 2.5\" - USB 3.1/Audio - RGB - Sans Alimentation - EAN : 4718017105002', '160.00', 'Asus', '90DC0012-B49000', 1, 10),
(66, 'Dark Base 900 (Black)', 'E-ATX / XL-ATX / ATX / M-ATX / Mini-ITX - 2x USB 2.0 - 2x USB 3.0 - 2x 5.25\" ext. - 7x 3.5\" int. - 15x 2.5\" int. - 2x USB 2.0 - 2x USB 3.0 - Audio - No PSU - EAN : 4260052184929', '234.00', 'be quiet!', 'BG011', 1, 10),
(67, 'Pure Base 500 Window (Metallic Gray)', 'ATX / m-ATX / M-ITX - 2 x 3.5\" int. - 5 x 2.5\" int. - USB 3.0 / Audio - Pas d\'alimentation - EAN : 4260052187814', '94.00', 'be quiet!', 'BGW36', 1, 10),
(68, 'Nova Mesh (White)', 'E-ATX / ATX / Micro-ATX / Mini-ITX - 2x 3.5\" - 3x 2.5\" - USB 3.0 / Audio - EAN : 4712883217203', '63.00', 'BitFenix', 'BFC-NVM-300-WWXKW-RP', 1, 10),
(69, 'Scorpion III', 'ATX, mATX, mini-ITX - 2 x 3.5\" int. - 2 x 2.5\" int. - USB 3.0 / Audio - Pas d\'alimentation - EAN : 753263076342', '103.00', 'Chieftec', 'GL-03B-OP', 1, 10),
(70, 'Cosmos C700P Black Edition', 'Mini-ITX, Micro-ATX, ATX, E-ATX - 1 x 5.25\" - 4 x 3.5\"/2.5\" - 4 x 2.5\" - 4x USB 3.0 / USB 3.1 Type-C / Audio - Sans Alimentation - EAN : 4719512085028', '363.00', 'CoolerMaster', 'MCC-C700P-KG5N-S00', 1, 10),
(71, 'H710i (Red/Black)', 'Mini ITX / mATX / ATX / E-ATX - 4 x 3.5\" int. - 7 x 2.5\" int. - 7 positions ventilateur (4 incl.) - RGB - USB 3.0 / Type-C - Sans alimentation - EAN : 5060301694952', '195.00', 'NZXT', 'CA-H710i-BR', 1, 10),
(72, 'NIGHT SHARK RGB', 'Mini ITX/ mATX/ ATX / E-ATX - 1 x 5.25\" - 3 x 3.5\" - 5 x 2.5\" - RGB Hub Incl. - Sans alimentation - EAN : 4044951026258', '127.00', 'Sharkoon', '4044951026258', 1, 10),
(73, 'Raven RVZ02', 'mini-ITX - 1 x Slim Slot-in ODD ext. - 1 x 3.5\" int. - 2 x 2.5\" int. - USB 3.0/Audio - Sans alimentation - EAN : 4710007222539', '85.00', 'SilverStone', 'SST-RVZ02B', 1, 10),
(74, 'AH T200 (White)', 'm-ATX / Mini-ITX - 2 x 3.5\" / 3 x 2.5\" - USB 3.0 / Type-C / HD Audio - Sans Alimentation - EAN : 4713227525749', '179.00', 'Thermaltake', 'CA-1R4-00S6WN-00', 1, 10),
(75, 'Photon RGB - 750 W', '750W - ATX V2.3 - 120 mm RGB fan - EAN : 753263075925', '95.00', 'Chieftec', 'CTG-750C-RGB', 1, 11),
(76, 'ROG STRIX Gold 750W', 'ATX 12V V2.4 / EPS 12V V2.92 - 80 PLUS Gold - 100% Modular - EAN : 4718017375924', '180.00', 'Asus', '90YE00A0-B0WA00', 1, 11),
(77, 'SF Series SF600 GoldCorsair SF Series SF600 Gold', '600W - SFX 12V - 80PLUS Gold - fully modular cabling design - EAN : 843591069014', '130.00', 'Corsair', 'CP-9020105-EU', 1, 11),
(78, 'TFX Power 2 300W Gold', 'TFX 12V Version 2.4 - 300 Watts - Certified 80 PLUS Gold - EAN : 4260052183748', '76.00', 'be quiet!', 'BN229', 1, 11),
(79, 'ROG STRIX Gold 650W', 'ATX 12V V2.4 / EPS 12V V2.92 - 80 PLUS Gold - 100% Modular - EAN : 4718017375795', '181.00', 'Asus', '90YE00A1-B0WA00', 1, 11),
(80, 'Pure Power 11 400W', 'ATX 12V V2.4 / EPS 12V V2.92 - 80 PLUS Gold - 120mm silent fan - EAN : 4260052186336', '68.00', 'be quiet!', 'BN292', 1, 11),
(81, 'ROG Ryujin 360', 'Refroidissement liquide pour processeur - 3x 120mm - Intel Sockets: LGA 115x,1366, 2011, 2011-3, 2066 - AMD: AM4, TR4 - Ecran OLED 1.77” - EAN : 4718017058193', '274.00', 'Asus', '90RC0020-M0UAY0', 1, 12),
(82, 'Watercooling PF240-ARGB', 'Système de refroidissement watercooling - 2 x 120mm PWM ARGB fans - 94 CFM - 7.4-35.6 dB - EAN : 4710007228692', '87.00', 'SilverStone', 'SST-PF240-ARGB', 1, 12),
(83, 'MasterLiquid Lite 120', 'Système Watercooling fermé & autonome - Waterblock CPU AMD FM2+ / FM2 / FM1 / AM4 / AM3+ / AM3 / AM2+ / AM2, Intel LGA 2011-v3 / 2011 / 1366 / 1151 / 1150 / 1156 / 1155 / 775 - 1 x Ventilateur 120mm (650/2000 RPM) - Radiateur Aluminium - EAN : 4719512055847', '56.00', 'CoolerMaster', 'MLW-D12M-A20PW-R1', 1, 12),
(84, 'SSD 870 EVO - 500GB', '- 2.5\"\r\n- 6.8mm\r\n- SATA 6Gb/s\r\n- V-NAND 3bit MLC\r\n- Samsung MKX Controller\r\n- read 560 MB/s\r\n- write 530 MB/s\r\n- AES 256-bit Encryption\r\nRef: 122818 - MZ-77E500B/EU', '79.00', 'Samsung', 'MZ-77E500B/EU', 1, 14),
(85, 'SSD 660p Series M.2 (NVMe) - 2TB', 'M.2 2280 - 3D QLC - PCI Express Gen3.1 x4 lanes - read 1800 MB/s - write 1800 MB/s - EAN : 735858381093', '223.00', 'Intel', 'SSDPEKNW020T8X1', 1, 14),
(86, 'SSD 860 EVO M.2 - 1TB', 'M.2 2280 - SATA - Samsung MJX - Up to 550MB/s read, 520MB/s write - EAN : 8801643068714', '121.00', 'Samsung', 'MZ-N6E1T0BW', 1, 14),
(87, 'IronWolf NAS HDD SATA 6 Gb/s - 4.0 TB', '3.5\" - 64 MB - 5900 RPM - SATA 6 Gb/s - 180 MB/s - Optimized for 1 to 8-bay NAS - EAN : 8719706003278', '113.00', 'Seagate', 'ST4000VN008', 1, 15),
(88, 'Purple HDD SATA 6 Gb/s - 8.0 TB', '3.5\" - SATA 6 Gb/s - 256 MB - 7200 RPM - 245 MB/s - Technologie AllFrame 4K - Optimisé pour la vidéosurveillance 24/7', '218.00', 'WD', 'WD82PURZ', 1, 15),
(89, 'BarraCuda HDD SATA 6 Gb/s - 1.0 TB', '3.5\" - 64 MB - 7200 RPM - SATA 6 Gb/s - 210 MB/s - EAN : 3660619402182\r\nRef: 101381 - ST1000DM010\r\n', '39.00', 'Seagate', 'ST1000DM010', 1, 15),
(90, 'BarraCuda Pro 2.5 HDD SATA 6 Gb/s - 500 GB', '2.5\" - 128 MB - 7200 RPM - SATA 6 Gb/s - 160 MB/s - 7 mm - EAN : 763649115763\r\nRef: 112713 - ST500LM034', '54.00', 'Seagate', 'ST500LM034', 1, 15),
(91, 'Kingston DataTraveler 100 G3 - 128 GB', 'USB 3.0 - 128 GB - 100MB/s read, 10MB/s write - Retractable connector - EAN : 740617249231', '17.00', 'Kingston', 'DT100G3/128GB', 1, 16),
(92, 'USB 3.1 FIT Plus Flash Drive - 128 GB', 'USB 3.1 (Gen 1) - 300 MB/s - EAN : 8801643233556', '32.00', 'Samsung', 'MUF-128AB/APC', 1, 16),
(93, 'DiskStation DS420j', 'Serveur NAS - CPU Realtek RTD1296 Quadruple cœur 1.4 GHz - 1 GB DDR4 - 4 x 3.5\"/2.5\" SATA HDD - 2 x USB 3.0 - 1 x Lan Gigabit - EAN : 4711174723720', '322.00', 'Synology', 'DS420j', 1, 17),
(94, 'Deep Learning NVR DVA3219', 'Deep Learning Network Video Recorder - Intel Atom C3538 quad-core 2.1GHz - 4GB DDR4 - NVIDIA GeForce GTX 1050 Ti - 4 x 3.5\" SATA HDD - 3x USB 3.0 / 2x eSATA / 1x COM port - 4x Gigabit LAN - supports up to 32 cameras in total and comes with 8 camera licenses pre-installed - EAN : 4711174723393', '1769.00', 'Synology', 'DVA3219', 1, 17),
(95, 'NAS TS-231K', 'NAS - Alpine AL214 (1.7 GHz) - 1GB DDR3 - 2 x SATA (3.5\"/2.5\") - 2x Gigabit LAN - EAN : 4713213516805', '228.00', 'QNAP', 'TS-231K', 1, 17),
(96, 'External Slimline Blu-ray Writer, USB-C 3.0 (43889)', '6x/6x/6x/6x/4x BD-RE/-ROM/-R/-R(DL)/-R XL TL • 8x/8x/8x/6x/6x/6x/8x DVD+R/-R/+RW/-RW/DL+R/DL-R/-ROM • 24x/24x/24x CD-R/-RW/-ROM • USB-C 3.0 (3.1 Gen1), 4MB cache, tray • M-DISC', '99.70', 'VERBATIM', '43889', 1, 18),
(97, 'GH24NS, DVD±RW/RAM, Black, Bulk', '24x/8x/6x/8x/12x DVD+R/+RW/-RW/DL+R/-RAM • Serial ATA, tray', '17.50', 'LG ELECTRONICS', 'GH24NS', 1, 18);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `idProduct` int(10) UNSIGNED NOT NULL,
  `serialNumber` varchar(100) NOT NULL,
  `arrivalDate` datetime NOT NULL,
  `departureDate` datetime DEFAULT NULL,
  `idItem` int(10) UNSIGNED NOT NULL,
  `idDelivery` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`idProduct`, `serialNumber`, `arrivalDate`, `departureDate`, `idItem`, `idDelivery`) VALUES
(1, '23D4D0714A7907D67279EDD81F5E175B', '2021-03-01 08:00:00', '2021-03-08 08:16:00', 9, 10),
(2, 'D65C4557116333F1DDA8ADF04682FB70', '2021-03-01 08:00:00', '2021-03-08 08:16:00', 16, 10),
(3, 'C0D2DF97E918C981DDA54B24236718C3', '2021-03-01 08:00:00', '2021-03-17 17:00:00', 16, 13),
(4, 'D4924B451D58A0FBD14F2EF50F167E7E', '2021-03-01 08:00:00', '2021-03-17 17:00:00', 16, 13),
(5, 'C3A63F232B8A3C6F8213F807E98675F3', '2021-03-01 08:00:00', '2021-03-10 09:20:00', 23, 11),
(6, '5353E2E965D59500EC1338F515D62DAF', '2021-03-01 08:00:00', NULL, 23, NULL),
(7, 'A4D69DB5B11E13E828962BC8E8CE77B1', '2021-03-01 08:00:00', '2021-03-10 09:20:00', 36, 11),
(8, '4063E343AB59FCA9E70D7AE72DC1D1A5', '2021-03-01 08:00:00', NULL, 51, NULL),
(9, 'F62B0AF795C1B30280590474C4B01FDB', '2021-03-01 08:00:00', '2021-03-08 08:16:00', 52, 10),
(10, '3CC8FB398F8D271C7E71947D66CF0B22', '2021-03-01 08:00:00', '2021-03-10 09:20:00', 66, 11),
(11, '30D852F51387869EA53005A1802E5291', '2021-03-01 08:00:00', '2021-03-10 09:20:00', 75, 11),
(12, '0694ED7BCE6FE4D9C52D2C1B4D72BE0F', '2021-03-01 08:00:00', '2021-03-17 08:37:00', 84, 8),
(13, 'D782D56B0DF0ABEFF1D75E801A127E72', '2021-03-01 08:00:00', '2021-03-17 08:37:00', 84, 8),
(14, '6BC058945CF6C194396C9E571093E072', '2021-03-01 08:00:00', NULL, 84, NULL),
(15, '5D7E0E36540DDE4CBD0E363BA8979490', '2021-03-01 08:00:00', NULL, 84, NULL),
(16, 'D1089FA6F62FF74E3ECEA52A0F054D74', '2021-03-01 08:00:00', NULL, 84, NULL),
(17, '5A8B3F636F1D01454362AFEE9D2B2FFE', '2021-03-01 08:00:00', '2021-03-08 08:16:00', 86, 10),
(18, 'D0EFE56147A136A50BBA765A3F839309', '2021-03-01 08:00:00', NULL, 86, NULL),
(19, '0F2722BF8EF425C2E8CD10B8F9800C4A', '2021-03-01 08:00:00', '2021-03-10 09:20:00', 87, 11),
(20, '6DCFD2DC3756614664A2DF0858E35346', '2021-03-01 08:00:00', '2021-03-17 08:37:00', 92, 8),
(21, '628BCAFCDC077D3A13378F087EAFD965', '2021-03-01 08:00:00', '2021-03-17 08:37:00', 92, 8),
(22, '25BE48E8C394831E39E92DF52B135ECC', '2021-03-01 08:00:00', '2021-03-17 08:37:00', 92, 8),
(23, '49705DFF4FF854F6CA93FC319DD4B642', '2021-03-01 08:00:00', '2021-03-17 08:37:00', 92, 8),
(24, '081527AB458D43D67B04813E3DEE1F53', '2021-03-01 08:00:00', '2021-03-17 08:37:00', 92, 8),
(25, 'D787D3E08E5797502E66A0B694AF6F3F', '2021-03-01 08:00:00', '2021-03-15 09:20:00', 92, 12),
(26, 'B300883318E455477C61E7027279AEB8', '2021-03-01 08:00:00', NULL, 92, NULL),
(27, 'D918AE00424108A3ABF8EECA7966D64C', '2021-03-01 08:00:00', NULL, 92, NULL),
(28, '7D4BDD385625EC9A2338DB7CB8B0E03C', '2021-03-01 08:00:00', NULL, 92, NULL),
(29, '856FC55A2BA3F18AF4171152804E7652', '2021-03-01 08:00:00', NULL, 92, NULL),
(30, 'DCE36DC30916A0A717F5F611D5CD7066', '2021-03-03 10:15:00', '2021-04-21 10:20:00', 4, 9),
(31, '1E29870F97D132069EFB532D438CF0BE', '2021-03-03 10:15:00', '2021-04-21 10:20:00', 5, 9),
(32, 'D54181E10F944E245D7675A0380809DD', '2021-03-09 09:20:00', '2021-03-10 09:20:00', 53, 11),
(33, '005390A67D3A69A7C1EB8947A456F47A', '2021-03-09 09:20:00', NULL, 53, NULL),
(34, '28BE7FD083CFB9B767EDE246C09BF75B', '2021-03-09 09:20:00', '2021-03-10 09:20:00', 55, 11),
(35, '9B1ED0AE58B273819FB2B62525D34B8D', '2021-03-16 09:14:00', '2021-03-17 17:00:00', 16, 13),
(36, 'B6CE3D69F0A050B4E37425AB3DD84816', '2021-03-16 09:14:00', '2021-03-17 17:00:00', 16, 13),
(37, 'FC2805B602CAB1759F14CA67E2B54C26', '2021-03-16 09:14:00', '2021-03-17 17:00:00', 16, 13),
(38, '0858627D8D5BB13A4D07B97A1F8EBB1F', '2021-03-16 09:14:00', NULL, 16, NULL),
(39, 'CD83AFCB27A16565FAC42A744FFEC879', '2021-03-16 09:14:00', NULL, 16, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUser` int(10) UNSIGNED NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `pwdHash` varchar(100) NOT NULL,
  `status` set('Anonymous','NotVerified','Customer','SaleManager','ProductManager','WebManager','Banned') NOT NULL,
  `pwdRecoveryDate` datetime DEFAULT NULL,
  `lastConnection` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`idUser`, `firstName`, `lastName`, `address`, `email`, `pwdHash`, `status`, `pwdRecoveryDate`, `lastConnection`) VALUES
(1, 'William', 'Weber', '', 'webadmin@gmail.com', 'n\'importe quoi', 'WebManager', NULL, NULL),
(2, 'Patrick', 'Produit', '', 'productadmin@gmail.com', 'n\'importe quoi', 'ProductManager', NULL, NULL),
(3, 'Vincent', 'Ventout', '', 'salemadmin@gmail.com', 'n\'importe quoi', 'SaleManager', NULL, NULL),
(4, 'Chris', 'Client', 'Ch. des Coudres 23\r\n1227 Carouge', 'client1@gmail.com', 'n\'importe quoi', 'Customer', NULL, NULL),
(5, 'Nathalie', 'Nouvelle', 'Rue Neuve 1\r\n1260 Nyon', 'new@gmail.com', 'n\'importe quoi', 'NotVerified', NULL, NULL),
(6, 'Bernard', 'Banning', 'Ch. des Buissons\r\n1257 Bardonnex\r\n', 'banned@gmail.com', 'n\'importe quoi', 'Customer,Banned', NULL, NULL),
(7, 'Super', 'Admin', 'Ch. Gérard-de-Ternier 10\r\n1213 Petit-Lancy 1', 'superadmin@gmail.com', 'n\'importe quoi', 'Customer,SaleManager,ProductManager,WebManager', NULL, NULL),
(8, 'Marie', 'Bambelle', 'Ch. des Ecoliers 29\r\n1217 Meyrin', 'client2@gmail.com', 'n\'importe quoi', 'Customer', NULL, NULL),
(9, 'Elie', 'Coptaire', 'Ch. de l\'Aéroport\r\n1217 Meyrin', 'client3@gmail.com', 'n\'importe quoi', 'Customer', NULL, NULL),
(10, 'Alain', 'Térieur', 'Rue Close 8\r\n1201 Genève 3', 'client4@gmail.com', 'n\'importe quoi', 'Customer', NULL, NULL),
(11, 'Camille', 'Honnête', 'Avenue de l\'Espoir \r\n1004 Lausanne', 'client5@gmail.com', 'n\'importe quoi', 'Customer', NULL, NULL),
(12, 'Eléonore', 'Labanquise', 'Ch. des Glaçons -20\r\n2406 La Brévine', 'client6@gmail.com', 'n\'importe quoi', 'Customer', NULL, NULL),
(13, 'Marie', 'Navoile', 'Ch. du Lac\r\n1260 Nyon', 'client7@gmail.com', 'n\'importe quoi', 'Customer', NULL, NULL),
(14, 'Sam', 'Suffit', 'Impasse du Terminus 99\r\n1212 Grand-Lancy', 'client8@gmail.com', 'n\'importe quoi', 'Customer', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`idCategory`),
  ADD KEY `fk_categories_categories1_idx` (`idParentCategory`);

--
-- Index pour la table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`idCommand`),
  ADD KEY `fk_commands_users_idx` (`idUser`);

--
-- Index pour la table `commands_has_items`
--
ALTER TABLE `commands_has_items`
  ADD PRIMARY KEY (`idCommand`,`idItem`),
  ADD KEY `fk_commands_has_items_items1_idx` (`idItem`);

--
-- Index pour la table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`idDelivery`),
  ADD KEY `fk_deliveries_commands1_idx` (`idCommand`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`idImage`),
  ADD KEY `fk_images_items1_idx` (`idItem`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`idItem`),
  ADD UNIQUE KEY `manufacturer_partnumber_unique` (`manufacturer`,`partNumber`) USING BTREE,
  ADD KEY `fk_items_categories1_idx` (`idCategory`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`idProduct`),
  ADD KEY `fk_products_items1_idx` (`idItem`),
  ADD KEY `idDelivery` (`idDelivery`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `idCategory` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `commands`
--
ALTER TABLE `commands`
  MODIFY `idCommand` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `idDelivery` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `idImage` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `idItem` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `idProduct` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_categories1` FOREIGN KEY (`idParentCategory`) REFERENCES `categories` (`idCategory`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `commands`
--
ALTER TABLE `commands`
  ADD CONSTRAINT `commands_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `commands_has_items`
--
ALTER TABLE `commands_has_items`
  ADD CONSTRAINT `fk_commands_has_items_commands1` FOREIGN KEY (`idCommand`) REFERENCES `commands` (`idCommand`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_commands_has_items_items1` FOREIGN KEY (`idItem`) REFERENCES `items` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `fk_deliveries_commands1` FOREIGN KEY (`idCommand`) REFERENCES `commands` (`idCommand`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_items1` FOREIGN KEY (`idItem`) REFERENCES `items` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_items_categories1` FOREIGN KEY (`idCategory`) REFERENCES `categories` (`idCategory`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_items1` FOREIGN KEY (`idItem`) REFERENCES `items` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`idDelivery`) REFERENCES `deliveries` (`idDelivery`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
