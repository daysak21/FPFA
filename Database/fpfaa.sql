-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 20 avr. 2025 à 16:37
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fpfaa`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_image` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_name`, `admin_email`, `admin_image`, `admin_password`) VALUES
(1, 'Admin', 'admin@gmail.com', 'logo after 3d_2.png', '$2y$05$dpcCx9sXwojLoJ67NWNA3Oxftu1T3KryGsxrm6Ae/e1K13Z59pGuS');

-- --------------------------------------------------------

--
-- Structure de la table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(1, 'Apple'),
(2, 'Samsung'),
(3, 'Oppo'),
(4, 'Dell'),
(5, 'HP'),
(6, 'MSI'),
(7, 'Canon'),
(8, 'Nikon'),
(9, 'Sony'),
(10, 'Asus');

-- --------------------------------------------------------

--
-- Structure de la table `card_details`
--

CREATE TABLE `card_details` (
  `product_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `card_details`
--

INSERT INTO `card_details` (`product_id`, `ip_address`, `quantity`) VALUES
(10, '::1', 1);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`) VALUES
(1, 'Phones'),
(2, 'Laptops'),
(3, 'Smartwatches'),
(4, 'Camera'),
(5, 'HeadPhones');

-- --------------------------------------------------------

--
-- Structure de la table `orders_pending`
--

CREATE TABLE `orders_pending` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(255) NOT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(120) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_keywords` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_image_one` varchar(255) NOT NULL,
  `product_image_two` varchar(255) NOT NULL,
  `product_image_three` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_keywords`, `category_id`, `brand_id`, `product_image_one`, `product_image_two`, `product_image_three`, `product_price`, `date`, `status`) VALUES
(1, 'APPLE Watch Séries 10 GPS 46MM - Silver Aluminium', 'APPLE Watch Series 10 GPS - Always-On LTPO3 Retina Display - Ion-X Glass - Operating System: watchOS 11 - S10 SiP chip with 64-bit dual-core processor - Case Size: 46mm - Aluminum case with sport band - Capacity: 64GB - Wireless Connectivity: Bluetooth 5.', 'apple watch', 3, 1, 'apple-watch-series-10-gps-46mm-silver-aluminium.jpg', 'apple-watch-series-10-gps-46mm-silver-aluminium.jpg', 'apple-watch-series-10-gps-46mm-silver-aluminium.jpg', 2489, '2025-04-16 13:28:59', 'true'),
(2, 'APPLE Watch Séries 9 GPS 45MM - Midnight Aluminium', 'Always-On Retina Touchscreen - Ion-X Glass - Operating System: iOS - Sip S9 chip with 64-bit dual-core processor - Case Size: 45mm - Midnight Aluminum Case with Sport Band - Capacity: 64GB - Wireless Connectivity: Bluetooth 5.3, WiFi, GPS, LTE - Fall Dete', 'apple watch', 3, 1, 'apple-watch-series-9-gps-45mm-midnight-aluminium.jpg', 'apple-watch-series-9-gps-45mm-midnight-aluminium1.jpg', 'apple-watch-series-9-gps-45mm-midnight-aluminium2.jpg', 1899, '2025-04-16 13:30:27', 'true'),
(3, 'APPLE Watch Séries 9 GPS 41MM - Boitier Aluminium Rose S/M', 'Always-On Retina Touchscreen - Ion-X Glass - Operating System: iOS - Sip S9 chip with 64-bit dual-core processor - Size: S/M - Pink aluminum case with light pink sport band - Capacity: 64 GB - Wireless Connectivity: Bluetooth 5.3, WiFi, GPS, LTE - Fall de', 'apple watch', 3, 1, 'apple-watch-series-9-gps-41mm-boitier-aluminium-rose-s-m-1.jpg', 'apple-watch-series-9-gps-41mm-boitier-aluminium-rose-s-m.jpg', 'apple-watch-series-9-gps-41mm-boitier-aluminium-rose-s-m-2.jpg', 1999, '2025-04-16 13:31:43', 'true'),
(5, 'APPLE Watch SE GPS 44mm - Starlight Aluminum', 'Retina OLED LTPO Touchscreen - Operating System: iOS - S8 SiP chip with 64-bit dual-core processor - Aluminum case: 44mm - Wireless Connectivity: Bluetooth, WiFi, GPS - Siri - Apple Pay - GymKit - Built-in speaker and microphone - Battery life: up to 18 h', 'Smartwatches apple ', 3, 1, 'apple-watch-se-gps-44mm-starlight-aluminium.jpg', 'apple-watch-se-gps-44mm-starlight-aluminium1.jpg', 'apple-watch-se-gps-44mm-starlight-aluminium.jpg', 1379, '2025-04-16 13:26:24', 'true'),
(6, 'Smartphone Apple IPhone 12 / 4 GB / 64 GB / White', '6.1\" OLED Super Retina XDR screen (2532 x 1170 px) - Apple A14 Bionic Hexa Core processor - IP68 waterproof - 4 GB RAM - 64 GB memory - Apple iOS 14 system - Camera: 2x 12 MP (F/1.6 + F/2.4) (Rear), 12 MP (Front) - 4G - Wi-Fi 6 AX - Bluetooth 5.0 - 2815 m', 'Smartphone Apple IPhone', 1, 1, 'smartphone-apple-iphone-12-4-go-64-go-blanc-earpods-avec-connecteur-lightning-offert.jpg', 'smartphone-apple-iphone-12-4-go-64-go-blanc-earpods-avec-connecteur-lightning-offert (2).jpg', 'smartphone-apple-iphone-12-4-go-64-go-blanc-earpods-avec-connecteur-lightning-offert (1).jpg', 2499, '2025-04-18 16:30:03', 'true'),
(7, 'Smartphone Apple iPhone 13 / 5G / 4 GB / 128 GB / Midnight', 'Dual SIM - 6.1\" Super Retina XDR OLED Display - 1170 x 2532 px Resolution - Apple A15 Bionic Hexa-Core Processor - 4GB RAM - 128GB Storage - 2x 12MP Rear Cameras (Wide-angle and Ultra-Wide-angle Wide-angle: F/1.6 aperture Ultra-Wide-angle: F/2.4 aperture ', 'Smartphone Apple iPhone ', 1, 1, 'smartphone-apple-iphone-13-5g-4-go-128-go-midnight (2).jpg', 'smartphone-apple-iphone-13-5g-4-go-128-go-midnight (1).jpg', 'smartphone-apple-iphone-13-5g-4-go-128-go-midnight.jpg', 2699, '2025-04-18 16:31:38', 'true'),
(8, 'iPhone 16 256GB Pink - APPLE', '6.1\" OLED Super Retina XDR display  (2556 x 1179 pixels at 460 ppi) - Aluminum design -  Processor: Apple A18 (3 nm) Hexa-core - Apple 5-core graphics  GPU Operating system: iOS 18 - RAM: 8GB -  Storage: 256GB - Rear Fusion camera 48 MP f/ 1.6, 26 mm + 12', 'iPhone', 1, 1, 'iphone-16-256go-rose-apple.jpg', 'iphone-16-256go-rose-apple2.jpg', 'iphone-16-256go-rose-apple1.jpg', 4699, '2025-04-18 16:33:02', 'true'),
(9, 'Samsung Galaxy A06 / 4 GB / 64 GB / Gold', '6.7\" PLS LCD HD+ screen (720 x 1600px) - MediaTek Helio G85 processor (12 nm), Octa Core (2x2.0 GHz Cortex-A75 & 6x1.8 GHz Cortex-A55) - 4 GB RAM - 64 GB memory - Cameras: 50MP F1.8 + 2MP F2.4 with Auto Focus (Rear) | 8MP F2.0 (Front) - Android 14 - 4G - ', 'Samsung Galaxy ', 1, 2, 'samsung-galaxy-a06-4-go-64-go-gold.jpg', 'samsung-galaxy-a06-4-go-64-go-gold (2).jpg', 'samsung-galaxy-a06-4-go-64-go-gold (1).jpg', 379, '2025-04-18 16:42:09', 'true'),
(10, 'Samsung Galaxy A05S Smartphone / 4 GB / 128 GB / Purple', 'Dual SIM - 6.7\" Full HD+ 90 Hz Display - Resolution: 1080 x 2408 (FHD+) - Technology: PLS LCD - Snapdragon 680 6 nm Octa-Core Processor , (2.4GHz , 1.9GHz) - 4GB Memory - 128GB Storage - Support for MicroSD External Memory (Up to 1TB) - Multiple Rear Came', 'Samsung Galaxy', 1, 2, 'smartphone-samsung-galaxy-a05s-4-go-128-go-violet.jpg', 'smartphone-samsung-galaxy-a05s-4-go-128-go-violet (1).jpg', 'smartphone-samsung-galaxy-a05s-4-go-128-go-violet.jpg', 529, '2025-04-18 16:43:49', 'true'),
(11, 'Smartphone Samsung Galaxy A26 5G 6/128 GB / Pink', 'Reference : SM-A26_5G-6-128G-PK Dual Sim - 6.7\" Super AMOLED screen, Full HD+ 1080 x 2340 pixels - 120 Hz refresh rate - Octa-Core Exynos 1380  processor (5 nm)  - 6 GB RAM - 128 GB memory - 50 MP + 8 MP + 2MP camera (  wide angle +  ultra wide angle + Ma', 'Smartphone Samsung Galaxy', 1, 2, 'smartphone-samsung-galaxy-a26-5g-6128-go-pink.jpg', 'smartphone-samsung-galaxy-a26-5g-6128-go-pink (2).jpg', 'smartphone-samsung-galaxy-a26-5g-6128-go-pink (1).jpg', 1099, '2025-04-18 16:45:45', 'true'),
(12, 'Pc Portable Gamer MSI Katana 17 B13VGK-1226XFR / i7-13620H / RTX 4070 8G / 16 Go DDR5 / 1 To SSD / Noir', 'Écran 17.3\" Full HD (1920x1080), 144Hz, IPS - Processeur Intel Core i7-13620H 13e génération, (jusqu’à 4.9 GHz, 24 Mo de mémoire cache) - Mémoire 16 Go DDR5 - Disque SSD M.2 NVMe 1 To - Carte graphique NVIDIA GeForce RTX 4070, 8 Go de mémoire GDDR6 dédiée', 'MSI', 2, 6, 'pc-portable-gamer-msi-katana-17-b13vgk-i7-13620h-rtx-4070-8g-16-go-ddr5-1-to-ssd-noir.jpg', 'pc-portable-gamer-msi-katana-17-b13vgk-i7-13620h-rtx-4070-8g-16-go-ddr5-1-to-ssd-noir (2).jpg', 'pc-portable-gamer-msi-katana-17-b13vgk-i7-13620h-rtx-4070-8g-16-go-ddr5-1-to-ssd-noir (1).jpg', 4799, '2025-04-18 16:51:49', 'true'),
(13, 'Pc Portable Gamer MSI Katana 17 B13UDXK / i7-13620H / RTX 3050 6G / 24 Go DDR5 / 1 To SSD / Noir', 'Écran 17.3\" Full HD (1920 x 1080 px), 144 Hz, IPS - Processeur Intel Core i7-13620H 13e génération, (jusqu’à 4.9 GHz, 24 Mo de mémoire cache) - Mémoire 24 Go DDR5 - Disque SSD M.2 NVMe 512 Go - Carte graphique NVIDIA GeForce RTX 3050, 6 Go de mémoire GDDR', 'MSI', 2, 6, 'pc-portable-gamer-msi-katana-17-b13udxk-i7-13620h-rtx-3050-6g-24-go-ddr5-1-to-ssd-noir (2).jpg', 'pc-portable-gamer-msi-katana-17-b13udxk-i7-13620h-rtx-3050-6g-24-go-ddr5-1-to-ssd-noir.jpg', 'pc-portable-gamer-msi-katana-17-b13udxk-i7-13620h-rtx-3050-6g-24-go-ddr5-1-to-ssd-noir (1).jpg', 3539, '2025-04-18 16:53:52', 'true'),
(14, 'Pc Portable Gamer MSI Katana 17 B13VGK-1226XFR / i7-13620H / RTX 4070 8G / 24 Go DDR5 / 1 To SSD / Noir', 'Écran 17.3\" Full HD (1920x1080), 144Hz, IPS - Processeur Intel Core i7-13620H 13e génération, (jusqu’à 4.9 GHz, 24 Mo de mémoire cache) - Mémoire 24 Go DDR5 - Disque SSD M.2 NVMe 1 To - Carte graphique NVIDIA GeForce RTX 4070, 8 Go de mémoire GDDR6 dédiée', 'MSI', 2, 6, 'pc-portable-gamer-msi-katana-17-b13vgk-i7-13620h-rtx-4070-8g-24-go-ddr5-1-to-ssd-noir.jpg', 'pc-portable-gamer-msi-katana-17-b13vgk-i7-13620h-rtx-4070-8g-24-go-ddr5-1-to-ssd-noir (2).jpg', 'pc-portable-gamer-msi-katana-17-b13vgk-i7-13620h-rtx-4070-8g-24-go-ddr5-1-to-ssd-noir (1).jpg', 4889, '2025-04-18 16:57:33', 'true'),
(15, 'Dell Latitude 7340 Laptop / i7-1365U 13th Gen / 16 GB DDR5 / 512 GB SSD / Windows 11 Pro', '13.3\" FHD+ (1920 x 1200 px) Touchscreen - 13th Gen Intel Core i7-1365U Processor, up to 5.2 GHz, 12 MB Cache - 16 GB DDR5 Memory - 512 GB M.2 PCIe NVMe SSD - Intel Iris Xe Graphics Card - 1 USB 3.2 Gen 1 Type-A - 1x HDMI - 2x Thunderbolt - Fingerprint Rea', 'DELL', 2, 4, 'pc-portable-dell-latitude-7340-i7-1365u-de-13e-gen-16-go-ddr5-512-go-ssd.jpg', 'pc-portable-dell-latitude-7340-i7-1365u-de-13e-gen-16-go-ddr5-512-go-ssd (2).jpg', 'pc-portable-dell-latitude-7340-i7-1365u-de-13e-gen-16-go-ddr5-512-go-ssd (1).jpg', 6099, '2025-04-18 17:07:32', 'true'),
(16, 'DELL LATITUDE 7450 LAPTOP PC / ULTRA 7 165U / 16GB 512GB SSD / GRAY', '14\" Full HD+, IPS display - Processor: Intel Core Ultra 7 165U (Up to 4.9 GHz Turbo max, 12 MB cache, 12-Cores) - RAM: 16 GB LPDDR5x - Hard Drive: 512 GB SSD - Graphics: Intel Graphics with Wi-Fi, Bluetooth, 2x USB Type-C Thunderbolt™ 4.0 with Power Deliv', 'DELL', 2, 4, 'pc-portable-dell-latitude-7450-ultra-7-165u-16go-512go-ssd-gris.jpg', 'pc-portable-dell-latitude-7450-ultra-7-165u-16go-512go-ssd-gris (2).jpg', 'pc-portable-dell-latitude-7450-ultra-7-165u-16go-512go-ssd-gris (1).jpg', 5499, '2025-04-18 17:09:29', 'true'),
(17, 'Pc Portable Gamer Dell G15 5530 / i7-13650HX / RTX 4060 8G / 32 Go / 1 To SSD / Windows 11 Pro / Noir', '15.6\" Full HD 165 Hz screen  - 13th generation Intel Core i7-13650HX processor , (up to 4.9 GHz, 24 MB cache) - 32 GB memory - 1 TB NVMe M.2  SSD drive - Nvidia GeForce RTX 4060  graphics card, 8 GB dedicated GDDR6 memory - HD webcam - Backlit keyboard - ', 'DELL', 2, 4, 'pc-portable-gamer-dell-g15-5530-i7-13650hx-rtx-4060-8g-32-go-1-to-ssd-windows-11-pro-noir.jpg', 'pc-portable-gamer-dell-g15-5530-i7-13650hx-rtx-4060-8g-32-go-1-to-ssd-windows-11-pro-noir (2).jpg', 'pc-portable-gamer-dell-g15-5530-i7-13650hx-rtx-4060-8g-32-go-1-to-ssd-windows-11-pro-noir (1).jpg', 4304, '2025-04-18 17:11:50', 'true'),
(18, 'ASUS ROG Zephyrus G16 (2024) GU605MV Gaming Laptop / Ultra 9 185H / RTX 4060 8G / 32GB DDR5 / 1TB SSD / Windows 11 / Whi', 'ROG Nebula 16\" 2.5K Display (2560 x 1600, WQXGA), IPS Level, 240 Hz, G-Sync, HDR - Intel Core Ultra 9 185H Processor, (up to 5.1 GHz, 24 MB Cache) - 32 GB (2 x 16 GB) LPDDR5X Memory - 1 TB M.2 NVMe SSD - NVIDIA GeForce RTX 4060 Graphics Card, 8 GB Dedicat', 'ASUS', 2, 10, 'pc-portable-gamer-asus-rog-zephyrus-g16-2024-gu605mv-ultra-9-185h-rtx-4060-8g-32-go-ddr5-1-to-ssd-windows-11-blanc.jpg', 'pc-portable-gamer-asus-rog-zephyrus-g16-2024-gu605mv-ultra-9-185h-rtx-4060-8g-32-go-ddr5-1-to-ssd-windows-11-blanc (2).jpg', 'pc-portable-gamer-asus-rog-zephyrus-g16-2024-gu605mv-ultra-9-185h-rtx-4060-8g-32-go-ddr5-1-to-ssd-windows-11-blanc (1).jpg', 8679, '2025-04-18 17:16:15', 'true'),
(19, ' ASUS ROG Flow Z13 2025 GZ302EA Gaming Laptop / AMD Ryzen AI MAX+ 395 / 32 GB LPDDR5X / 1 TB SSD / Windows 11 / Black', 'ROG Nebula 13.4\" 2.5K WQXGA (2560 x 1600), IPS, 180 Hz, Adaptive-Sync, HDR Display - AMD Ryzen AI MAX+ 395 Processor , (up to 5.1 GHz, 80 MB cache) - 32 GB LPDDR5X Memory - 1 TB M.2 NVMe SSD- AMD XDNA Neural Processor NPU up to 50 TOPS - 1x 3.5 mm combo a', 'ASUS', 2, 10, 'pc-portable-gamer-asus-rog-flow-z13-2025-gz302ea-amd-ryzen-ai-max-395-32-go-lpddr5x-1-to-ssd-windows-11-noir.jpg', 'pc-portable-gamer-asus-rog-flow-z13-2025-gz302ea-amd-ryzen-ai-max-395-32-go-lpddr5x-1-to-ssd-windows-11-noir (2).jpg', 'pc-portable-gamer-asus-rog-flow-z13-2025-gz302ea-amd-ryzen-ai-max-395-32-go-lpddr5x-1-to-ssd-windows-11-noir (1).jpg', 8399, '2025-04-18 17:27:45', 'true'),
(20, 'ASUS ROG Strix G16 G614JIR Gaming Laptop / i9-14900HX / RTX 4070 8G / 64GB DDR5 / 1TB SSD / Windows 11 / Black With Free', 'ROG Nebula Display 16\" QHD+ (2560 x 1600, WQXGA), anti-glare, 240Hz, G-Sync, HDR - 14th Gen Intel Core i9-14900HX Processor, (up to 5.8 GHz, 36 MB cache) - 64 GB Memory - 1 TB M.2 NVMe SSD - NVIDIA GeForce RTX 4070 Graphics Card, 8 GB Dedicated GDDR6 Memo', 'ASUS', 2, 10, 'pc-portable-gamer-asus-rog-strix-g16-g614jir-i9-14900hx-rtx-4070-8g-64-go-ddr5-1-to-ssd-windows-11-noir.jpg', 'pc-portable-gamer-asus-rog-strix-g16-g614jir-i9-14900hx-rtx-4070-8g-64-go-ddr5-1-to-ssd-windows-11-noir (2).jpg', 'pc-portable-gamer-asus-rog-strix-g16-g614jir-i9-14900hx-rtx-4070-8g-64-go-ddr5-1-to-ssd-windows-11-noir (1).jpg', 8389, '2025-04-18 17:43:01', 'true'),
(21, 'CANON EOS 90D SLR Camera + 18-135mm IS U EU26 Lens - Black', 'CANON EOS 90D SLR Camera - Touchscreen: 3 \" TFT -  Image Sensor: 22.3mm × 14.8mm APS-C CMOS - Sensor Resolution: 32.5MP - Image Processor: DIGIC 8 - Video: 4K 3840 × 2160px  and Dual Pixel CMOS AF - Capture the action at up to 10fps - Sharp focus even on ', 'CANON', 4, 7, 'appareil-photo-reflex-canon-eos-90d-objectif-18-135mm-is-u-eu26-noir4.jpg', 'appareil-photo-reflex-canon-eos-90d-objectif-18-135mm-is-u-eu26-noir3.jpg', 'appareil-photo-reflex-canon-eos-90d-objectif-18-135mm-is-u-eu26-noir5.jpg', 6999, '2025-04-19 07:09:17', 'true'),
(22, 'CANON EOS 250D SLR Camera + 18-55mm IS Lens - Black', 'CANON EOS 250D Camera - 3\" Tiltable LCD Touchscreen -  Image Sensor: APS-C Size CMOS - Sensor Resolution: 24.1MP - Processor: DIGIC 8 - 1920 × 1080 Ultra HD Video - 4K Movies - Rechargeable Lithium-ion Batteries - Optical Viewfinder - Dual Pixel CMOS Auto', 'CANON', 4, 7, 'appareil-photo-reflex-canon-eos-250d-objectif-18-55-mm-noir5.jpg', 'appareil-photo-reflex-canon-eos-250d-objectif-18-55-mm-noir2.jpg', 'appareil-photo-reflex-canon-eos-250d-objectif-18-55-mm-noir3.jpg', 3299, '2025-04-19 07:11:20', 'true'),
(23, 'CANON EOS 2000D SLR Camera + EF-S 18-55mm IS II Lens - Black', 'CANON EOS 2000D SLR Camera - Screen:  3\" LCD Touchscreen -  Image Sensor: CMOS APS-C 22.3 mm × 14.9 mm  - Sensor Resolution: 24.1 megapixel  -  Full HD Video 1920 × 1080px - Image Processor: DIGIC 4+  - Lens:  18-55 mm  - Memory Card Support : SD, SDHC, S', 'CANON  CANON  CANON ', 4, 7, 'appareil-photo-reflex-canon-eos-2000d-ef-s-18-55mm-is-ii-noir-1.jpg', 'appareil-photo-reflex-canon-eos-2000d-ef-s-18-55mm-is-ii-noir-4.jpg', 'appareil-photo-reflex-canon-eos-2000d-ef-s-18-55mm-is-ii-noir-3.jpg', 2199, '2025-04-19 07:13:15', 'true'),
(24, 'HP Victus 16-r0001nk i5 13th Gen 16GB RTX 4050 Gaming Laptop PC', '16.1\' Full HD, IPS 144 Hz display - Processor: Intel Core i5-13500H  (Up to 4.7 GHz Turbo max , 18 MB cache, 12-Cores ) - Operating system: Windows 11 Home - RAM: 16 GB DDR5-5200 MHz - Hard drive: 512 GB SSD - Graphics card: NVIDIA GeForce RTX 4050 ( 6 GB', 'HP Victus ', 2, 5, 'pc-portable-gamer-hp-victus-16-r0001nk-i5-13e-gen-16go-rtx-4050-3_1.jpg', 'pc-portable-gamer-hp-victus-16-r0001nk-i5-13e-gen-16go-rtx-4050-5_1.jpg', 'pc-portable-gamer-hp-victus-16-r0001nk-i5-13e-gen-16go-rtx-4050-2_1.jpg', 3179, '2025-04-19 07:27:13', 'true');

-- --------------------------------------------------------

--
-- Structure de la table `product_recommendations`
--

CREATE TABLE `product_recommendations` (
  `product_id` int(11) NOT NULL,
  `recommended_products` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `product_recommendations`
--

INSERT INTO `product_recommendations` (`product_id`, `recommended_products`, `updated_at`) VALUES
(1, '[3, 2, 5, 8, 7]', '2025-04-19 12:47:08'),
(2, '[3, 5, 1, 7, 6]', '2025-04-19 12:47:08'),
(3, '[2, 1, 5, 7, 8]', '2025-04-19 12:47:08'),
(5, '[2, 3, 1, 6, 7]', '2025-04-19 12:47:08'),
(6, '[7, 8, 1, 3, 2]', '2025-04-19 12:47:08'),
(7, '[6, 8, 1, 3, 2]', '2025-04-19 12:47:08'),
(8, '[7, 6, 1, 3, 2]', '2025-04-19 12:47:08'),
(9, '[10, 11, 6, 7, 8]', '2025-04-19 12:47:08'),
(10, '[9, 11, 6, 7, 8]', '2025-04-19 12:47:08'),
(11, '[10, 9, 6, 7, 8]', '2025-04-19 12:47:08'),
(12, '[14, 13, 18, 19, 20]', '2025-04-19 12:47:08'),
(13, '[12, 14, 15, 16, 20]', '2025-04-19 12:47:08'),
(14, '[12, 13, 18, 19, 20]', '2025-04-19 12:47:08'),
(15, '[16, 17, 18, 19, 20]', '2025-04-19 12:47:08'),
(16, '[15, 17, 18, 19, 20]', '2025-04-19 12:47:08'),
(17, '[16, 15, 20, 19, 18]', '2025-04-19 12:47:08'),
(18, '[19, 20, 15, 16, 14]', '2025-04-19 12:47:08'),
(19, '[20, 18, 15, 16, 14]', '2025-04-19 12:47:08'),
(20, '[19, 18, 15, 16, 14]', '2025-04-19 12:47:08'),
(21, '[22, 23, 18, 19, 20]', '2025-04-19 12:47:08'),
(22, '[23, 21, 18, 19, 20]', '2025-04-19 12:47:08'),
(23, '[22, 21, 18, 19, 20]', '2025-04-19 12:47:08'),
(24, '[15, 16, 14, 12, 17]', '2025-04-19 12:47:08');

-- --------------------------------------------------------

--
-- Structure de la table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount_due` int(255) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `total_products` int(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_status` varchar(255) NOT NULL,
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_orders`
--

INSERT INTO `user_orders` (`order_id`, `user_id`, `amount_due`, `invoice_number`, `total_products`, `order_date`, `order_status`, `payment_method`) VALUES
(1, 4, 120, 0, 1, '2025-04-19 06:56:03', 'paid', ''),
(2, 4, 120, 0, 1, '2025-04-19 06:56:19', 'paid', ''),
(3, 4, 380, 0, 1, '2025-04-19 06:56:12', 'paid', '');

-- --------------------------------------------------------

--
-- Structure de la table `user_payments`
--

CREATE TABLE `user_payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_payments`
--

INSERT INTO `user_payments` (`payment_id`, `order_id`, `invoice_number`, `amount`, `payment_method`, `payment_date`) VALUES
(6, 17, 673073, 380, 'd17', '2025-04-16 13:02:09'),
(7, 18, 688227, 1899, 'd17', '2025-04-16 15:51:56');

-- --------------------------------------------------------

--
-- Structure de la table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_ip` varchar(100) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_mobile` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_table`
--

INSERT INTO `user_table` (`user_id`, `username`, `user_email`, `user_password`, `user_image`, `user_ip`, `user_address`, `user_mobile`) VALUES
(8, 'daysak essid', 'essiddaysak@gmail.com', '$2y$10$wNO.nObGnXDBty9FyEKBJeNq8weLpB/gEIVDC5b7r/IdG5ZiPW4te', '', '::1', 'sousse', '29587071'),
(9, 'DIDI', 'DIDI@gmail.com', '$2y$10$c6iubu8MdA0hQuICicJAsOdKWH4suIw945PpTgk8cga4k7nGssQ/e', '', '::1', 'sousse sahloul ', '26585767'),
(10, 'DAY', 'anaskacem12@gmail.com', '$2y$10$8U7PR7e8pAfOOMHDi8MNbeQVwVykZi9Y5P9zN7WI6W4uE4ONX2b46', '', '::1', 'sousse', '29587071'),
(11, 'NAS', 'NAS@GMAIL.com', '$2y$10$V5XdfNAFxdjD6DL2aEuY5ep/Zqr7KI3YVVhSmvjRKyAle5tmD4fMe', '', '::1', 'sousse', '29587071'),
(12, 'daissem', 'daissem@gmail.com', '$2y$10$VT2d/V3xx.WkzDtZe8wg5uRDaIPZBxGv2MYq7LjpMPqYJKmyHzicy', '', '::1', 'sousse', '29587071');

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Index pour la table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Index pour la table `card_details`
--
ALTER TABLE `card_details`
  ADD PRIMARY KEY (`product_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Index pour la table `orders_pending`
--
ALTER TABLE `orders_pending`
  ADD PRIMARY KEY (`order_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Index pour la table `product_recommendations`
--
ALTER TABLE `product_recommendations`
  ADD PRIMARY KEY (`product_id`);

--
-- Index pour la table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Index pour la table `user_payments`
--
ALTER TABLE `user_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Index pour la table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `orders_pending`
--
ALTER TABLE `orders_pending`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `user_payments`
--
ALTER TABLE `user_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`user_id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
