-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 09, 2022 at 12:14 AM
-- Server version: 5.7.32
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbs4260248`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `user_type_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `user_type_id`, `status`, `is_deleted`, `created_at`, `last_login`) VALUES
(12, 'Shivam', 'Panday', 'shivampanday.sp@gmail.com', '$2y$10$d2W0wdwlE1v8UTAsmsx0cOFRqecqD6iAUZ6aKfRupm9eWwixYG7p6', '07397996479', 1, 1, 0, '2021-08-04 18:25:07', '2022-09-29 22:07:57'),
(18, 'Raj', 'Sodha', 'rajsodha97@gmail.com', '$2y$10$8drsKa7Mmn2JRZ.DvyOwA.xPE0aaFJfiGhSRVef96M/8LaYB39P8.', '07548606680', 1, 1, 0, '2021-09-23 23:01:38', '2021-11-27 12:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `delivery_cost` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`id`, `delivery_cost`, `description`, `created_at`, `status`) VALUES
(2, 4.99, 'Delivery within 3-5 days', '2021-09-26 23:35:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_addresses`
--

CREATE TABLE `delivery_addresses` (
  `id` int(11) NOT NULL,
  `address_id` varchar(255) DEFAULT NULL,
  `hamper_id` varchar(255) DEFAULT NULL,
  `hamper_total` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `delivery_addresses`
--

INSERT INTO `delivery_addresses` (`id`, `address_id`, `hamper_id`, `hamper_total`) VALUES
(1, '16', '33db73ef19a4248ddadce97ed2a9de30', 29.99),
(2, '17', '6798a694ae72da061706468c925d1f83', 29.99),
(3, '17', '5fbab38370a02d22e0e3f745e8278df2', 15.46);

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `discount_group` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `discount_value` varchar(255) DEFAULT '0',
  `discount_type` varchar(255) NOT NULL,
  `minimum_total` float NOT NULL DEFAULT '0',
  `expiry` datetime DEFAULT NULL,
  `used` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`id`, `discount_group`, `description`, `discount_value`, `discount_type`, `minimum_total`, `expiry`, `used`, `status`, `created_at`, `is_deleted`) VALUES
(10, 'COMPETITION', 'BBXXCOMP10', '10', '%TAGE', 20, '2021-11-26 22:00:00', 1, 0, '2021-11-26 17:21:52', 0),
(11, 'COMPETITION', 'BBXXCOMP20', '20', '%TAGE', 50, '2021-11-28 17:00:00', 0, 1, '2021-11-26 17:25:58', 0),
(12, 'PROMO', 'BBXXWEL20', '20', '%TAGE', 20, '2021-12-30 23:59:00', 0, 1, '2021-11-26 19:55:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gift_messages`
--

CREATE TABLE `gift_messages` (
  `id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `hamper_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gift_messages`
--

INSERT INTO `gift_messages` (`id`, `message`, `hamper_id`) VALUES
(1, 'Happy Birthday', '5fbab38370a02d22e0e3f745e8278df2');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_id` text NOT NULL,
  `total` float DEFAULT NULL,
  `discount_applied` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `dispatched_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_no`, `user_id`, `payment_id`, `total`, `discount_applied`, `created_at`, `dispatched_at`, `cancelled_at`, `status`) VALUES
(1, 'BBXX260293', 26, 'pi_3K2jhdJc0HLWismg0e3Lya7T', 34.98, NULL, '2021-12-03 21:54:13', NULL, NULL, 0),
(2, 'BBXX679380', 27, 'pi_3K2jq2Jc0HLWismg0LVvA7yp', 34.98, NULL, '2021-12-03 22:02:51', '2021-12-03 22:12:28', '2021-12-03 22:13:29', 2),
(3, 'BBXX985398', 27, 'pi_3K2kQrJc0HLWismg12ha0jsG', 21.94, NULL, '2021-12-03 22:40:55', '2021-12-03 22:48:49', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `hamper_id` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `hamper_id`, `product_id`, `type`, `quantity`, `created_at`, `order_id`) VALUES
(1, '33db73ef19a4248ddadce97ed2a9de30', 266, 'hotm', 1, '2021-12-03 21:54:13', 1),
(2, '6798a694ae72da061706468c925d1f83', 266, 'hotm', 1, '2021-12-03 22:02:51', 2),
(3, '5fbab38370a02d22e0e3f745e8278df2', 84, 'colour', 1, '2021-12-03 22:40:55', 3),
(4, '5fbab38370a02d22e0e3f745e8278df2', 104, 'size', 1, '2021-12-03 22:40:55', 3),
(5, '5fbab38370a02d22e0e3f745e8278df2', 113, 'filling', 1, '2021-12-03 22:40:55', 3),
(6, '5fbab38370a02d22e0e3f745e8278df2', 110, 'filling', 1, '2021-12-03 22:40:55', 3),
(7, '5fbab38370a02d22e0e3f745e8278df2', 155, 'product', 1, '2021-12-03 22:40:55', 3),
(8, '5fbab38370a02d22e0e3f745e8278df2', 156, 'product', 1, '2021-12-03 22:40:55', 3),
(9, '5fbab38370a02d22e0e3f745e8278df2', 157, 'product', 1, '2021-12-03 22:40:55', 3);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(500) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `cost` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `SKU` varchar(255) DEFAULT NULL,
  `visibility_order` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(500) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `url`, `description`, `cost`, `price`, `SKU`, `visibility_order`, `is_deleted`, `created_at`, `image`, `quantity`, `status`) VALUES
(84, 'White', NULL, 'White Boxx', '0.00', '0.00', '8697', 0, 0, '2021-10-09 15:59:57', '5BF9899B-FF7A-D123-B13D-1E5908362D0E.jpeg', '4', 1),
(85, 'Black', NULL, 'Black Hamper', '0.00', '0.00', '4351', 0, 0, '2021-10-09 16:01:19', '6693FFB6-5EF2-0CBA-A339-A7A1E836E7F8.jpeg', '5', 1),
(87, 'Grey', NULL, 'Grey Boxx', '0.00', '0.00', '6270', 0, 0, '2021-10-09 16:02:42', 'B088F757-9F90-7CEA-A3AF-5CB3AB4C968B.jpeg', '2', 1),
(91, 'Small', 'Ebay', 'Small White Boxx\r\nSize - W28 x D21 x H12 cm', '4.99', '5.99', '1030', 1, 0, '2021-10-09 17:46:55', '42F7F79A-72C8-6DB5-105E-2C95E6784C4B.jpeg', '13', 1),
(104, 'Medium', 'Ebay', 'Medium White Boxx\r\nSize - W33 x D25 x H15 cm', '6.00', '7.99', '9581', 5, 0, '2021-10-10 00:03:51', '67F993CE-62E1-A480-5D21-51BA5324B6AA.jpeg', '9', 1),
(106, 'Large', 'Ebay', 'Large White Boxx\r\nSize - W36 x D29 x H18 cm', '5.99', '9.99', '3132', 9, 0, '2021-10-15 19:34:45', 'B398428C-5955-CDCB-2199-66685E8CFED5.jpeg', '14', 1),
(109, 'Yellow', NULL, 'Yellow Filling', '0.00', '0.00', '8301', 1, 0, '2021-10-28 18:21:21', 'BBD9715A-4A39-2652-B403-C668DC45D088.jpeg', '5', 1),
(110, 'Teal', NULL, 'Teal filling', '0.00', '0.00', '8262', 2, 0, '2021-10-28 18:25:17', '77FF0009-6A4F-D1F3-5003-8BC7C1EFF4DB.jpeg', '8', 1),
(111, 'Blue', NULL, 'Blue Filling', '0.00', '0.00', '7125', 0, 0, '2021-10-28 18:25:49', '2B20323C-D6F0-9121-CBD7-135DF688C927.jpeg', '2', 1),
(112, 'Natural', NULL, 'Natural Filling', '0.00', '0.00', '8759', 0, 0, '2021-10-28 18:26:21', '78AD05FC-0513-28AF-B62B-000992FCE864.jpeg', '1', 1),
(113, 'Pink', 'https://shredded-paper.co.uk/shop/ols/products/pink-zig-zag-shredded-kraft-paper/v/PNK-ZIG4-10-KG-4MM-ZIG', '150g/Boxx \r\n£76.99 Total', '0', '0', '3157', 0, 0, '2021-10-28 18:26:54', '67DBEE0D-0D49-F90A-3EE6-0F599A9CF9D1.jpeg', '6', 1),
(115, 'White Teddy Bear', 'https://www.risuswholesale.co.uk/product/plush-silver-teddy-bears-wholesale', 'Super soft plush teddy bear, each measures approx 20cm tall when sitting. Suitable from birth. \r\n\r\nSize - 20cm', '2.28', '5.99', '8800', 0, 0, '2021-11-02 23:03:54', '8C1051D4-2E6B-1FA7-B442-12D0B4D31D1D.jpeg', '4', 1),
(116, 'Grey Teddy Bear', 'https://www.risuswholesale.co.uk/product/plush-silver-teddy-bears-wholesale', 'Super soft plush teddy bear, each measures approx 20cm tall when sitting. Suitable from birth. Size - 20cm', '2.28', '5.99', '9788', 0, 0, '2021-11-02 23:11:21', 'B70AB310-F109-91A1-431D-456099264611.jpeg', '6', 1),
(117, 'Baby Boy Teddy Bear', 'https://www.risuswholesale.co.uk/product/plush-blue-baby-boy-teddy-bears-wholesale', 'Super soft plush toy - the perfect gift for a new baby boy. Suitable from birth. \r\n\r\nSize - 20cm', '3.78', '6.99', '473', 0, 0, '2021-11-02 23:19:35', '6A5C6031-7AF7-2CBC-583C-A6A56BECB931.jpeg', '6', 1),
(118, 'Baby Girl Teddy Bear', 'https://www.risuswholesale.co.uk/product/luxury-plush-pink-teddy-bears-wholesale', 'Super soft plush toy - the perfect gift for a baby girl. Suitable from birth. Size - 20cm', '3.78', '6.99', '7383', 0, 0, '2021-11-02 23:22:08', 'B5175898-E1F5-6F46-A53C-20C1653CEBA9.jpeg', '6', 1),
(119, 'Brown', '', 'Brown Boxx', '0.00', '0.00', '6172', 0, 0, '2021-11-03 00:58:12', '3221AD91-7AE2-FA60-B2C8-71F332389DC9.jpeg', '3', 1),
(120, 'Blue Unicorn', 'https://www.risuswholesale.co.uk/product/sitting-plush-unicorns-6-inch', 'Super soft plush unicorn. Suitable from birth.\r\n\r\nSize - 15cm', '2.47', '5.99', '7972', 0, 0, '2021-11-03 02:07:04', '265ED097-A40F-E3CB-7A74-661DF3D4F7F6.jpeg', '3', 1),
(121, 'Pink Unicorn', 'https://www.risuswholesale.co.uk/product/sitting-plush-unicorns-6-inch', 'Pink Unicorn\r\n\r\nSize - 15cm', '2.47', '5.99', '4295', 0, 0, '2021-11-03 02:14:50', '1DD214F8-3E49-414D-9FC4-942703FB9AFF.jpeg', '3', 1),
(122, 'Purple Unicorn', 'Risus', 'Super Soft plush toy.\r\n\r\nSize - 15cm', '2.47', '5.99', '3128', 0, 0, '2021-11-03 02:23:34', '7A0B6F9A-BA76-858B-5F27-16B05D8E2498.jpeg', '2', 1),
(123, 'White Unicorn', 'Risus', 'Super soft plush toy.', '2.47', '5.99', '7396', 0, 0, '2021-11-03 02:27:48', 'DDB49231-E0F8-97DA-4A2C-AE4EDF10F119.jpeg', '3', 1),
(124, 'Baby White Hand Mitts', 'Kids wholesale', 'Super soft woollen hand mitts. \r\n\r\nSize - 0-12 Months', '1.26', '3.99', '6040', 1, 0, '2021-11-03 02:47:29', '4922DA92-57A7-41DE-309E-DA8419510550.jpeg', '2', 1),
(125, 'Baby Pink Hand Mitts', 'Kids wholesale ', 'Super soft woollen hand mitts\r\n\r\nSize - 0-12 Months', '1.26', '3.99', '6949', 1, 0, '2021-11-03 02:50:00', '2D31880A-99EA-75F3-E3BF-155BEA316EAD.jpeg', '4', 1),
(128, 'Strawberry Overnight Lip Mask', 'https://www.eapollowholesale.co.uk/strawberry-overnight-lip-mask-12g.html', 'Sweet dreams with Vitamin C, Aloe Vera & Grape Seed Oil', '1.38', '4.99', '3170', 5, 0, '2021-11-10 03:12:03', 'E108B424-86E1-F74A-A83E-77FE4389F255.jpeg', '23', 1),
(129, 'Hydro Glow Moisturiser', 'https://www.eapollowholesale.co.uk/w7-watermelon-wave-with-hyaluronic-acid-vitamin-e-hydro-glow-moisturiser.html', 'Watermelon wave with Hydrochloric acid, Watermelon extract & Vitamin C', '2.34', '4.99', '8652', 5, 0, '2021-11-10 03:16:46', 'B9FF7EB4-010E-C404-496F-9DAF98E28063.jpeg', '11', 1),
(130, 'White Hat & Mitt Set', 'Kids Wholesale', 'Super soft set for your little ones. Suitable from birth.', '3.24', '6.99', '6701', 0, 0, '2021-11-10 04:40:09', '8885BFBE-6D88-9BBF-FC02-A190548F99B7.jpeg', '2', 1),
(131, 'Grey Hat & Mitt Set', 'Kids Wholesale ', 'Super soft set for your little ones. Suitable from birth.', '3.24', '6.99', '2819', 0, 0, '2021-11-10 04:42:12', '2ADD0111-0EEA-28DD-2B7E-1168EF922A8D.jpeg', '3', 1),
(132, 'Argan Oil Lip balm', 'https://www.eapollowholesale.co.uk/w7-argan-oil-lip-balm-24-pcs.html?___SID=S', 'Argan oil lip balm', '0.95', '2.49', '2151', 5, 0, '2021-11-10 04:44:27', '8F4BE137-3FE1-D4C6-D039-B30B28E77232.jpeg', '23', 1),
(133, 'Banana Blast Face Mask', 'https://www.eapollowholesale.co.uk/w7-super-skin-superfood-banana-face-mask.html', 'Packed with Banana extract, Linseed, and Vitamin E', '0.70', '2.99', '59', 3, 0, '2021-11-10 04:47:17', '5DCE93F5-2B42-4810-540D-704275EB8271.jpeg', '24', 1),
(134, 'Awesome Avocado Face Mask', 'https://www.eapollowholesale.co.uk/w7-super-skin-superfood-avocado-face-mask.html', 'Packed with Avocado extract, Marine collagen, Aloe & Vitamin E.', '0.70', '2.99', '7131', 3, 0, '2021-11-10 04:49:13', '2E5C1EC8-8BD1-8F4D-4912-CB865B4138E8.jpeg', '24', 1),
(135, 'Pomegranate Power Face Mask', 'https://www.eapollowholesale.co.uk/w7-super-skin-superfood-pomegranate-face-mask.html', 'Packed with Pomegranate extract, Collagen, Star Anise, Green Tea & Witch Hazel extract.', '0.70', '2.99', '8105', 3, 0, '2021-11-10 04:51:46', '0DC710A7-156A-18A6-05EC-BE30D59B4E6B.jpeg', '24', 1),
(136, 'Moisturising Hand Mask', 'https://www.eapollowholesale.co.uk/w7-wearable-glove-moisturizing-hand-mask-1-pair.html', 'Intensive Moisturising Treatment- Enriched with peach extract, shea butter, honey & seed oil.', '1.56', '3.49', '7016', 3, 0, '2021-11-10 05:12:47', 'CFF7E816-6988-DC42-ED7B-4ACEAC7441C8.jpeg', '20', 1),
(137, 'Moisturising Foot Mask', 'https://www.eapollowholesale.co.uk/w7-moisturizing-wearable-sock-foot-mask-1-pair.html', 'Formulated with peppermint, Shea butter,  macadamia seed oil, witch hazel, oat & apple extract.', '1.56', '3.49', '1079', 3, 0, '2021-11-10 05:16:21', 'CAA390D6-E5B8-31AB-DFEF-DFEE89D10FE9.jpeg', '20', 1),
(138, 'MAN\'STUFF Shaving Gift Set', 'https://www.eapollowholesale.co.uk/technic-man-s-stuff-shaving-gift-set.html', 'Contains: x1 shaving cream, x1 post shave balm, x1 shaving brush\r\nAchieve a closer shave with this great gift set, containing a soft shaving brush to whip up a creamy lather, together with a shave cream and post shave balm.', '3.59', '7.99', '7184', 4, 0, '2021-11-10 09:38:52', 'DECF925C-9B1C-03EE-14D6-489D3DBE2821.jpeg', '9', 1),
(140, 'MAN\' STUFF Stubble Face Cleansing Foam 150ml & Face Moisturiser 150ml Gift Set', 'https://www.eapollowholesale.co.uk/technic-man-s-stuff-2-piece-gift-set.html?___SID=S', 'Contains: 1x Stubble & Face Cleansing Foam (150ml), 1x Stubble & Face Moisturiser (150ml).', '3.00', '5.99', '6781', 4, 0, '2021-11-10 09:42:26', 'E6DD30CD-475C-FB67-B16A-78DED1855A26.jpeg', '8', 1),
(141, 'MAN\'STUFF Shampoo Bar 150g & Cleansing Bar 150g Box', 'https://www.eapollowholesale.co.uk/technic-man-s-stuff-shampoo-cleansing-bar.html', 'MAN\'STUFF Shampoo Bar 150g & Cleansing Bar 150g Box', '2.50', '4.99', '7036', 4, 0, '2021-11-10 09:43:54', '0CB1997E-2AE5-706A-4AE9-F904B6A99DD4.jpeg', '8', 1),
(142, 'Johnson\'s Baby Cotton Buds', 'Costco', 'Johnson\'s Baby Cotton Buds', '0.50', '1.49', '6571', 5, 0, '2021-11-10 09:46:27', 'C71E93D4-55B4-B87A-F2B1-42AE72287AD4.jpeg', '17', 1),
(143, 'Princess Hat & Bootee set', 'Kids wholesale', 'Princess Hat & Bootee set\r\n\r\nSize - Newborn  - 2 Months', '1.86', '4.99', '9647', 0, 0, '2021-11-10 09:51:16', 'D26F6CA7-DF7F-9E71-DF45-2857669ECA93.jpeg', '6', 1),
(144, 'Prince Hat & Bootee set', 'Kids Wholesale', 'Prince Hat & Bootee set\r\n\r\nSize - Newborn  - 2 Months', '1.86', '4.99', '8231', 0, 0, '2021-11-10 09:52:44', '4EC9F741-27E1-E5DD-BA7F-EA658603BE87.jpeg', '6', 1),
(145, 'Baby Blue Hand Mitts', 'Kids wholesale ', 'Super soft woollen hand mitts\r\n\r\nSize - 0-12 Months', '1.26', '3.99', '5260', 1, 0, '2021-11-10 09:57:45', '131DB616-2127-AE09-4C2F-E4324CDB346C.jpeg', '4', 1),
(146, 'Blue Waffle Wrap', 'Kids wholesale ', 'Blue Waffle Wrap', '3.06', '6.99', '4605', 1, 0, '2021-11-10 10:05:10', '6745DB64-3615-AC8A-15A9-C0D140B588CF.jpeg', '4', 1),
(147, 'Pink Waffle Wrap', 'Kids wholesale ', 'Pink Waffle Wrap', '3.06', '6.99', '7083', 1, 0, '2021-11-10 10:08:30', 'F080C80C-75F8-77DE-6695-C64C6498911E.jpeg', '4', 1),
(148, 'White Waffle Wrap', 'Kids Wholesale', 'White Waffle Wrap', '3.06', '6.99', '4346', 1, 0, '2021-11-10 10:13:32', '0691C054-9C93-6D95-9C46-9C8EB9A0EA16.jpeg', '3', 1),
(149, 'Trio of Ducks', 'https://www.risuswholesale.co.uk/product/rubber-bath-ducks', 'Trio of Ducks', '1.26', '2.49', '3340', 2, 0, '2021-11-10 10:14:42', '52A68727-15CD-3860-67E8-A19105318FD5.jpeg', '7', 1),
(150, 'White Bunny Comforter W/RIBBONS', 'Kids wholesale ', 'White Bunny Comforter W/RIBBONS', '2.52', '6.99', '1575', 1, 0, '2021-11-10 10:31:39', 'AB6AEDBC-1056-D851-D580-FE9EB87CDB46.jpeg', '6', 1),
(151, 'Pina Colada Bath Salts', 'https://www.cutpricewholesaler.com/seasonal/novelties-gifts/ely1077-elysium-spa-bath-crystals-mixed-case', 'Pina Colada Bath Salts \r\n\r\nSize - 500g', '0.88', '3.49', '2525', 2, 0, '2021-11-10 10:33:22', '81DEFBA6-5866-34E2-4078-2A71AB5FC258.jpeg', '6', 1),
(152, 'Mojito Bath Salts', 'https://www.cutpricewholesaler.com/seasonal/novelties-gifts/ely1077-elysium-spa-bath-crystals-mixed-case', 'Mojito Bath Salts \r\nSize - 500g', '0.88', '3.49', '6790', 2, 0, '2021-11-10 10:34:26', '2356F468-9761-37AB-EC2A-8C823E17FE7B.jpeg', '8', 1),
(153, 'Strawberry Daiquiri Bath Salts', 'https://www.cutpricewholesaler.com/seasonal/novelties-gifts/ely1077-elysium-spa-bath-crystals-mixed-case', 'Strawberry Daiquiri Bath Salts\r\nSize -  500g', '0.88', '3.49', '532', 2, 0, '2021-11-10 10:35:17', '66889404-1C4A-325B-50C6-E3FB406D5690.jpeg', '7', 1),
(154, 'Sex on the Beach Bath Salts', 'https://www.cutpricewholesaler.com/seasonal/novelties-gifts/ely1077-elysium-spa-bath-crystals-mixed-case', 'Sex on the Beach Bath Salts \r\n\r\nSize - 500g', '0.88', '3.49', '4811', 2, 0, '2021-11-10 10:35:53', 'C97E6717-363A-403F-2544-E88042D2909A.jpeg', '8', 1),
(155, 'Eucalyptus & Peppermint Bath Bomb', 'https://www.cutpricewholesaler.com/seasonal/novelties-gifts/ely1097-elysium-bath-bombs-eucalyptus-and-peppermint', '3 pack Eucalyptus & Peppermint Bath Bomb - fragrant bath fizzer', '0.94', '2.49', '3756', 1, 0, '2021-11-10 10:37:31', '7B25DBE1-67D1-017B-202D-671DB77FC215.jpeg', '9', 1),
(156, 'Green Tea & Chamomile Bath Bomb', 'https://www.cutpricewholesaler.com/seasonal/novelties-gifts/ely1099-elysium-bath-bombs-green-tea-and-cammomile', '3 pack Green Tea & Chamomile Bath Bomb - fragrant bath fizzer', '0.94', '2.49', '244', 1, 0, '2021-11-10 10:39:44', '50D75D6B-CB4A-B31C-F1ED-6F75E49189BB.jpeg', '8', 1),
(157, 'Lavender Bath Bomb', 'https://www.cutpricewholesaler.com/seasonal/novelties-gifts/ely1098-elysium-bath-bombs-lavender', '3 pack Lavender Bath Bomb - fragrant bath fizzer', '0.94', '2.49', '6513', 1, 0, '2021-11-10 10:42:31', 'D0084C87-431A-D3DD-7F54-0C8C4E70588A.jpeg', '10', 1),
(158, 'Blue Massaging Loofah Ball', 'https://www.cutpricewholesaler.com/seasonal/fathers-day/729061-mr-massaging-loofah-ball-on-loop-rope', 'Blue Massaging Loofah Ball', '1.07', '2.49', '4399', 4, 0, '2021-11-10 10:53:07', 'A66058ED-E1AE-CF3C-DEAC-A82D5470DE58.jpeg', '6', 1),
(160, 'Grey Massaging Loofah Ball', 'https://www.cutpricewholesaler.com/seasonal/fathers-day/729061-mr-massaging-loofah-ball-on-loop-rope', 'Grey Massaging Loofah Ball', '1.07', '2.49', '3314', 4, 0, '2021-11-10 10:54:12', '2F3E81F2-F98A-13A6-30FE-EBE5673CD593.jpeg', '6', 1),
(161, '4PC Eyelash Pedicure Set', 'https://www.cutpricewholesaler.com/seasonal/novelties-gifts/ey0102-4pc-eyelash-pedicure-set', '4PC Eyelash Pedicure Set', '2.64', '5.99', '3101', 4, 0, '2021-11-10 11:08:05', '07AC0701-E51F-477D-676A-82EA9FDB0A65.jpeg', '6', 1),
(162, 'Luxe 7 piece Manicure set', 'https://www.eapollowholesale.co.uk/royal-cosmetics-boutique-luxe-7-piece-manicure-set.html', 'Manicure set perfect for maintaining finger and toenails\r\n\r\nManicure set contains: Cuticle Pusher, Cuticle Trimmer, Slanted Tweezers, Nail File, Large Nail Clipper, Small Nail Clipper, Nail Scissors', '3.00', '6.99', '6722', 4, 0, '2021-11-10 11:12:28', '5B47CDC7-67BF-2BEC-EB84-181CE50BD230.jpeg', '11', 1),
(163, 'Girls with class don’t need a glass hip flask', 'Something Different', 'Girls with class don’t need a glass hip flask\r\n\r\nSize - 6oz', '4.20', '6.99', '1433', 8, 0, '2021-11-10 11:14:09', '503C6A82-3D07-CD25-17DB-8E126E93F8EE.jpeg', '4', 1),
(164, 'There is a chance this is gin hip flask', 'Something Different', 'There is a chance this is gin hip flask\r\n\r\nSize - 6oz', '4.20', '6.99', '3797', 8, 0, '2021-11-10 11:15:17', 'A32E6680-4F96-9099-BAC9-F013621752C8.jpeg', '3', 1),
(165, 'Good Vibes Only hip flask', 'Something Different', 'Good vibes only hip flask\r\n\r\nSize - 6oz', '4.20', '6.99', '2805', 8, 0, '2021-11-10 11:16:24', '9004E225-A42D-9D01-428F-B730C0FAB6BC.jpeg', '4', 1),
(166, 'GAME OVER JOYSTICK SHAPED MUG WITH ARCADE DETAIL', 'https://www.cutpricewholesaler.com/seasonal/novelties-gifts/smug189-game-over-joystick-shaped-mug-with-arcade-detail', 'GAME OVER JOYSTICK SHAPED MUG WITH ARCADE DETAIL', '3.07', '5.99', '9477', 8, 0, '2021-11-10 11:18:19', '49D5C8C9-6D44-C527-B9B9-B8BD6E4CB7F1.jpeg', '6', 1),
(167, 'DO NOT DISTURB I’M DISTURBED ENOUGH AS IT IS metal wall sign.', 'https://www.somethingdifferentwholesale.co.uk/home-and-garden/home-decor/decorative-signs/Do-Not-Disturb-Sign/?searchterm=do%20not', 'DO NOT DISTURB I’M DISTURBED ENOUGH AS IT IS metal wall sign.', '2.10', '4.99', '2299', 3, 0, '2021-11-10 11:22:06', '826CA2D7-63C1-CA8F-86C1-AFF0AB441B95.jpeg', '3', 1),
(168, '4pc MR LOGO PRINTED COASTER SET', 'https://www.cutpricewholesaler.com/seasonal/fathers-day/834095-4pc-mr-logo-printed-coaster-set', '4pc MR LOGO PRINTED COASTER SET', '1.16', '3.99', '7859', 4, 0, '2021-11-10 11:22:58', '217EB1F4-FA30-ACFB-B338-717BA970A07F.jpeg', '6', 1),
(169, 'GENTS HIP FLASK', 'https://www.cutpricewholesaler.com/seasonal/novelties-gifts/gr0009-170ml-gents-hip-flask', '170ml GENTS HIP FLASK\r\n\r\nSize - 170 ml', '2.58', '6.99', '2088', 8, 0, '2021-11-10 11:24:07', '7FA375D5-4894-9ACD-1620-95768F5A1FFA.jpeg', '6', 1),
(170, 'Yellow Notepad', 'https://www.risuswholesale.co.uk/product/a5-quotes-hardback-notebooks', 'Yellow Notepad', '0.78', '2.99', '2490', 5, 0, '2021-11-10 11:25:33', '031B34FE-35F4-F965-A73B-2BAAE18202F3.jpeg', '4', 1),
(171, 'Black Notepad', 'https://www.risuswholesale.co.uk/product/a5-quotes-hardback-notebooks', 'Black Notepad', '0.78', '2.99', '8825', 5, 0, '2021-11-10 11:26:53', '151AC404-84E1-7A93-7E67-0FF2750608CD.jpeg', '4', 1),
(172, 'Green Notepad', 'https://www.risuswholesale.co.uk/product/a5-quotes-hardback-notebooks', 'Green Notepad', '0.78', '2.99', '3181', 5, 0, '2021-11-10 11:27:51', '8ECD5ECB-2C87-C49D-73C5-A0B81D8461C9.jpeg', '4', 1),
(175, 'Retro Record Coasters', 'Rosefields', 'Retro Record Coasters', '2.99', '5.99', '5756', 4, 0, '2021-11-10 11:33:44', '940CA4DA-3773-1778-9367-B421EF0434F8.jpeg', '4', 1),
(176, 'Rubik’s cube key chain', 'https://www.risuswholesale.co.uk/product/magic-puzzle-cube-keyrings', 'Rubik’s cube key chain', '0.98', '3.99', '4427', 7, 0, '2021-11-10 11:35:29', 'AA783B0B-530A-7C94-6181-743E96ADCFC6.jpeg', '24', 1),
(177, 'Retro Puzzle Cube', 'https://www.risuswholesale.co.uk/product/retro-puzzle-cubes', 'Retro Puzzle Cube', '0.62', '2.99', '2601', 7, 0, '2021-11-10 11:37:03', 'C6E3BDEC-2005-BE26-0F92-A8E6583C05E9.jpeg', '12', 1),
(178, 'Green Leaf Printed Bamboo Travel Mug (Large Leaf Print)', 'https://www.rosefields.co.uk/green-leaf-printed-bamboo-travel-mugs-14cm-/_1140/__51878', 'Green Leaf Printed Bamboo Travel Mug (Large Leaf Print)', '3.46', '6.99', '2404', 8, 0, '2021-11-10 11:38:53', '15573416-B839-E06F-45C6-A0B80BD82A3D.jpeg', '3', 1),
(179, 'Bamboo Leaves Travel mug', NULL, 'Bamboo Leaves Travel mug', '2.49', '4.99', '7272', 0, 1, '2021-11-10 11:40:01', 'FF6C960F-3FFF-E254-4510-8480512769A5.jpeg', '100', 1),
(180, 'Green Leaf Printed Bamboo Travel Mug (Small Leaf Print)', 'Rosefields', 'Green Leaf Printed Bamboo Travel Mug (Small Leaf Print)', '3.46', '6.99', '7568', 8, 0, '2021-11-10 11:40:01', 'EB015808-200C-AA1C-0ED4-995887EB356D.jpeg', '3', 1),
(181, 'Too Glam to give a damn travel mug', 'Cut Price Wholesalers', 'Too Glam to give a damn travel mug', '2.57', '6.99', '3174', 8, 0, '2021-11-10 11:41:28', 'D3162235-C858-D6EF-9619-1F1A1281F24A.jpeg', '3', 1),
(182, 'I woke up like this travel mug', 'Cut Price Wholesalers', 'I woke up like this travel mug', '2.57', '6.99', '7889', 8, 0, '2021-11-10 11:42:32', '269F6CA2-EA01-5E8F-F847-2D342CF29093.jpeg', '3', 1),
(183, 'NOT A MORNING PERSON BAMBOO ECO TRAVEL MUG', 'https://www.somethingdifferentwholesale.co.uk/home-and-garden/kitchen-dining/travel-mugs/Not-a-Morning-Person-Bamboo-Eco-Travel-Mug/', 'Eco-friendly, reusable travel mug is made out of durable bamboo fibre and comes with a matching silicone sleeve and lid for keeping hydrated (and caffeinated) on the go', '5.00', '7.99', '387', 8, 0, '2021-11-10 11:44:02', '56FFD86E-2371-2504-49B7-CA53587F8EDC.jpeg', '6', 1),
(184, 'Llama money box', 'Risus', 'Llama money box', '2.16', '7.99', '5636', 3, 0, '2021-11-10 11:44:57', '4198E5BD-1FA6-4E2B-F56D-FD19316D899F.jpeg', '11', 1),
(185, 'Cupcake money box', 'Risus', 'Cupcake money box', '1.71', '6.99', '658', 3, 0, '2021-11-10 11:45:53', '6A8471DE-1F78-F8A0-75A0-CCF246EBBCA2.jpeg', '11', 1),
(186, 'Doughnut money box', 'Risus', 'Doughnut money box', '1.71', '6.99', '6603', 3, 0, '2021-11-10 11:46:52', '3BF7E604-52F2-E351-944B-7E3BEBAA89DE.jpeg', '11', 1),
(187, 'Poker chip key chain', 'EApollo', 'Poker chip key chain', '0.20', '1.99', '4706', 2, 0, '2021-11-10 11:48:31', 'DEC7F79F-54FA-F018-FE72-BF7594B409A5.jpeg', '24', 1),
(188, 'Love heart trolley coin', 'EApollo', 'Trolley coin', '0.36', '1.99', '6546', 2, 0, '2021-11-10 11:49:17', '43DA2347-C111-99A6-D6C4-4E78E874707D.jpeg', '24', 1),
(189, 'Home Sweet Home hanging heart sign', 'https://www.somethingdifferentwholesale.co.uk/home-and-garden/home-decor/decorative-signs/Home-Sweet-Home-Hanging-Heart-Sign/', 'Home Sweet Home hanging heart sign', '1.05', '2.99', '1561', 2, 0, '2021-11-10 11:53:19', 'FB1C5314-6EEC-EFDF-A6CA-C4AE073A14F9.jpeg', '9', 1),
(190, 'Love My Man Cave Hanging Heart Sign', 'https://www.somethingdifferentwholesale.co.uk/home-and-garden/home-decor/decorative-signs/Love-My-Man-Cave-Hanging-Heart-Sign/', 'Love My Man Cave Hanging Heart Sign', '1.05', '2.99', '1748', 2, 0, '2021-11-10 11:54:27', 'B8ABD9E0-9CF2-3FB4-F863-15D4B52F462F.jpeg', '12', 1),
(191, 'Love Hanging Heart Sign', 'https://www.somethingdifferentwholesale.co.uk/home-and-garden/home-decor/decorative-signs/Love-Hanging-Heart-Sign/?searchterm=Love%20sign', 'Love Hanging Heart Sign', '1.05', '2.99', '6793', 2, 0, '2021-11-10 11:55:45', 'CC186857-225E-6338-11A4-3BD34B65B9B5.jpeg', '23', 1),
(192, 'Baby Girl Hanging Heart Sign', 'https://www.somethingdifferentwholesale.co.uk/home-and-garden/home-decor/decorative-signs/Baby-Girl-Hanging-Heart-Sign/?searchterm=baby%20girl', 'Baby Girl Hanging Heart Sign', '1.04', '2.99', '561', 1, 0, '2021-11-10 11:57:01', '6D7C6743-391C-0D3E-2125-7CD3A8E76879.jpeg', '10', 1),
(193, 'Baby Boy Hanging Heart Sign', 'https://www.somethingdifferentwholesale.co.uk/home-and-garden/home-decor/decorative-signs/Baby-Boy-Hanging-Heart-Sign/', 'Baby Boy Hanging Heart Sign', '1.04', '2.99', '9781', 1, 0, '2021-11-10 11:57:58', 'DD8EA7C0-B510-FDF0-0AEC-D204F6B7E22F.jpeg', '9', 1),
(194, 'Mr Hanging Sign', 'Rosefields', 'Mr Hanging Sign', '1.02', '3.99', '7155', 2, 0, '2021-11-10 11:59:11', 'A646BC73-13DC-FE4E-15E2-C6EE1152FF76.jpeg', '6', 1),
(195, 'Mrs Hanging Sign', 'Rosefields', 'Mrs Hanging Sign', '1.02', '3.99', '4107', 2, 0, '2021-11-10 11:59:54', '136E8C1C-0FF3-A403-5E79-D3DCAD35BBEC.jpeg', '6', 1),
(196, 'Fresh Rose scented candle', 'Risus', 'Fresh Rose scented candle', '1.77', '4.99', '2632', 1, 0, '2021-11-10 12:01:02', 'A3FDA6C1-9A4E-17C2-216E-96D8707FC24D.jpeg', '10', 1),
(197, 'Grey Love Heart Candle Holder', 'Rosefields', 'Grey Love Heart Candle Holder', '2.52', '5.99', '9224', 3, 0, '2021-11-10 12:15:38', '1AFC3BDD-66A0-183C-620F-DB0A3CC1F0BF.jpeg', '6', 1),
(198, 'White Love Heart Candle Holder', 'Rosefields', 'White Love Heart Candle Holder', '2.52', '5.99', '9846', 3, 0, '2021-11-10 12:16:53', 'F9FE8AEF-67A6-1C6F-BBC6-9C90D2884495.jpeg', '6', 1),
(199, 'Natural Dreamcatcher with Turquoise Beads', 'https://www.somethingdifferentwholesale.co.uk/home-and-garden/home-decor/dreamcatchers/Small-Natural-Dreamcatcher-with-Turquoise-Beads/', 'Native American inspired, rope-wrapped dreamcatcher that features four white string webs accented with beautiful turquoise stones and fabric tassels finished with wooden beads and white feathers.', '4.20', '8.99', '8786', 0, 0, '2021-11-10 12:18:16', '3567B86B-0D25-4E22-7750-B30E289020ED.jpeg', '5', 1),
(200, 'Silver Tree Scented Wax Jar', 'Rosefields', 'Silver Tree Scented Wax Jar. Size - 12cm', '2.52', '6.99', '1213', 1, 0, '2021-11-10 12:19:36', '68C8FDA9-9F5E-E622-719A-45CF60102E60.jpeg', '5', 1),
(201, '100ml Lime Basil & Mandarin Desire Diffuser', 'Rosefields', '100ml Lime Basil & Mandarin Desire Diffuser', '3.24', '8.99', '1831', 3, 0, '2021-11-10 12:21:07', 'E8E8AD96-8CEE-10EA-89F7-479B6AEAFDB0.jpeg', '5', 1),
(202, '100ml Velvet Rose & Oud Desire Diffuser', 'Rosefields', '100ml Velvet Rose & Oud Desire Diffuser', '3.24', '8.99', '4558', 3, 0, '2021-11-10 12:22:43', '23144F9E-F2B2-0C56-D0AA-FF5127141FD9.jpeg', '5', 1),
(203, 'Madagascar Vanilla Pure Aroma Oil', 'https://www.eapollowholesale.co.uk/goloka-pure-aroma-oil-madagascar-vanilla.html', 'Madagascar Vanilla Pure Aroma Oil', '1.08', '3.99', '5340', 3, 0, '2021-11-10 12:26:34', '9321AC11-BDD1-AFFF-E7C7-D29E5E15B61B.jpeg', '8', 1),
(204, 'California White Sage Pure Aroma Oil', 'EApollo', 'California White Sage pure aroma oil', '1.08', '3.99', '8530', 3, 0, '2021-11-10 12:28:24', '5D656CA7-670F-5448-CD11-E78010CF1CCC.jpeg', '4', 1),
(205, 'Mystic Rose pure aroma oil', 'EApollo', 'Mystic Rose pure aroma oil', '1.08', '3.99', '6885', 3, 0, '2021-11-10 12:29:27', 'A6E6CF43-8DDB-8790-E653-7A9D360C80C1.jpeg', '6', 1),
(206, 'Hand & Lotus Flower Backflow Incense Burner', 'https://www.somethingdifferentwholesale.co.uk/home-fragrance/backflow-burners-cones/Hand-Lotus-Flower-Backflow-Incense-Burner/', 'A stunningly simple backflow incense burner in a black ceramic hand and lotus flower design. When the cone is lit the smoke from the cone cascades downwards in a mesmerising waterfall effect to pool at the bottom. Beautiful to watch.', '2.70', '6.99', '1878', 0, 0, '2021-11-10 12:31:14', 'E04A973B-6071-218A-8D1C-74A8B9064AFB.jpeg', '5', 1),
(207, 'Back flow Dhoop Cones-White Sage', 'EApollo', 'Back flow Dhoop Cones-White Sage', '1.93', '3.99', '5219', 3, 0, '2021-11-10 12:33:09', 'BB994408-FA63-DBE5-CE66-873E71EFADE6.jpeg', '6', 1),
(208, 'Back flow Dhoop Cones-Lavender Sage', 'EApollo', 'Back flow Dhoop Cones-Lavender Sage', '1.93', '3.99', '3933', 3, 0, '2021-11-10 12:34:13', 'C8FB0D46-7C17-69B3-1B6F-A4E859FC780C.jpeg', '6', 1),
(209, 'Back flow Dhoop Cones-Rose Sage', 'EApollo', 'Back flow Dhoop Cones-Rose Sage', '1.93', '3.99', '6928', 3, 0, '2021-11-10 12:34:55', 'D6875F5E-4948-BE78-A7DB-00A806CC3903.jpeg', '6', 1),
(210, 'Say It With Words Candle - Dad', 'https://boxer.gifts/words-candle-dad', 'Brighten up someone’s day with this beautiful and unique word candle. Stylish and modern, this ivory coloured candle with black print text allows you to celebrate all different occasions. Size -  4 cm x 4cm x 1.8 cm', '0.50', '1.99', '4113', 1, 0, '2021-11-10 12:36:48', '456E8E82-3F63-7E3B-070A-4FC36793FFDB.jpeg', '12', 1),
(211, 'HAPPY BIRTHDAY symbol candle', 'Light up someone\'s special day and home with this glamorous ivory word candle. This bright, modern candle with black text that reads ', 'HAPPY BIRTHDAY candles', '0.50', '1.99', '8934', 1, 0, '2021-11-10 12:38:49', 'EF4C18EE-0C91-5BC5-B0B6-8753942E06C0.jpeg', '12', 1),
(212, 'WORLD’S BEST symbol candle', 'https://boxer.gifts/world-best-symbol-candle', 'Light up a special someone\'s day and home with this glamorous ivory word candle. This bright, modern candle with black text that reads WORLD’S BEST. Size - 4cm x 4cm x 1.8cm', '0.50', '1.99', '4361', 1, 0, '2021-11-10 21:19:07', '1DB22BAB-7EEB-D2C3-5917-191A364F00FF.jpeg', '12', 1),
(213, 'WORLD’S BEST candle', NULL, 'WORLD’S BEST candle', '0.40', '1.99', '1799', 0, 1, '2021-11-10 21:19:07', '515DAAB0-8B88-021F-DA5B-889DBD7EA46D.jpeg', '100', 1),
(214, 'WORLD’S BEST candle', NULL, 'WORLD’S BEST candle', '0.40', '1.99', '962', 0, 1, '2021-11-10 21:19:07', '9A847C18-C52C-875D-3EC2-779120CF2E1C.jpeg', '100', 1),
(215, 'Say It With Words Candle - Wife', 'https://boxer.gifts/words-candle-wife', 'Brighten up someone’s day with this beautiful and unique word candle. Stylish and modern, this ivory coloured candle with black print text allows you to celebrate all different occasions.', '0.50', '1.99', '9006', 1, 0, '2021-11-10 22:28:08', '2E4040AB-CA69-E017-13B0-16D8D6F24AE5.jpeg', '12', 1),
(216, 'WIFE Candle', NULL, '', '', '2.99', '9199', 0, 1, '2021-11-10 22:28:08', 'D2C42138-2218-E457-6DD6-03AAD281F15C.jpg', '100', 1),
(217, 'Say It With Words Candle - Husband', 'https://boxer.gifts/words-candle-husband', 'Brighten up someone’s day with this beautiful and unique word candle. Stylish and modern, this ivory coloured candle with black print text allows you to celebrate all different occasions. Size - 9cm x 4cm x 1.8cm', '1.00', '2.99', '3735', 1, 0, '2021-11-10 23:11:10', 'DBFD12A0-28AC-93E9-A760-F168CEBE8125.jpeg', '12', 1),
(218, 'Say It With Words Candle - Thank You', 'https://boxer.gifts/words-candle-thank-you', 'Brighten up someone’s day with this beautiful and unique word candle. Stylish and modern, this ivory coloured candle with black print text allows you to celebrate all different occasions. Size - 9cm x 4cm x 1.8cm', '1.00', '2.99', '2443', 1, 0, '2021-11-10 23:12:42', '2105DCAF-5844-2021-48E3-2F095F30F4CC.jpeg', '12', 1),
(219, 'Say It With Words Candle - Congrats', 'https://boxer.gifts/words-candle-congrats', 'Brighten up someone’s day with this beautiful and unique word candle. Stylish and modern, this ivory coloured candle with black print text allows you to celebrate all different occasions.', '1.00', '2.99', '8521', 1, 0, '2021-11-10 23:13:29', 'F5E6AF94-17CF-87C1-E275-5426D20378FA.jpeg', '12', 1),
(220, 'HEART symbol candle', 'https://boxer.gifts/heart-symbol-candle', 'This unique candle is great for adding a personal touch to any room. Simply pick and choose the letters or symbols you require and put them together to make a candle display that actually means something to you! Size - 2cm x 2cm x 2cm', '0.50', '1.99', '708', 1, 0, '2021-11-10 23:14:20', '8D3FF910-0218-4758-8E09-C60D07E46DF8.jpeg', '12', 1),
(221, 'Magnetic Beer Bottle Shaped Bottle Opener - Anytime Is Beer Time', 'https://boxer.gifts/beer-bottle-opener-anytime-beer-time', 'You can never find a bottle opener when you need oneﾅ Well, now you can! Stick this magnetic beer bottle shaped bottle opener to the fridge door and it\'ll be on hand whenever the thirst takes you.', '1.92', '6.99', '1452', 0, 0, '2021-11-10 23:15:35', '3A0AA1E8-852E-A861-84F4-3CF9C996CDB5.jpeg', '8', 1),
(222, 'Himalayan Salt candle holder', 'https://www.somethingdifferentwholesale.co.uk/home-fragrance/candle-holders/Single-Salt-Candle-Holder/', '100% natural Himalayan Salt tea light holder. Holds a single tea light in the centre. The size and shape of this product may vary.', '2.03', '6.99', '2465', 0, 0, '2021-11-10 23:16:27', 'C67C89B9-E5AF-0B7B-95DC-388CB04FF2C5.jpeg', '10', 1),
(223, 'WHITE OWL OIL BURNER', 'https://www.somethingdifferentwholesale.co.uk/home-fragrance/oil-burners/White-Owl-Oil-Burner/', 'Charming white owl oil burner which looks beautiful when a lit tea light is placed inside. This burner has a deep bowl making it perfect for using with oils to fragrance the home. This item can also be used as a wax melt burner however it is advisable to consider the size and depth of the bowl when adding wax to ensure it will not overrun the edges when melted.', '4.20', '7.99', '7874', 0, 0, '2021-11-10 23:17:23', 'DCDBEF69-389E-7980-3EE0-CB60A59F7C33.jpeg', '5', 1),
(224, 'WHITE BUDDHA HEAD OIL BURNER', 'https://www.somethingdifferentwholesale.co.uk/home-fragrance/oil-burners/White-Buddha-Head-Oil-Burner/', 'A matte white Buddha head oil burner. This item can also be used as a wax melt burner however it is advisable to consider the size and depth of the bowl when adding wax to ensure it will not overrun the edges when melted.', '4.20', '9.99', '5454', 0, 0, '2021-11-10 23:18:17', '92B54FEE-298B-BE53-90A0-053E46174F16.jpeg', '5', 1),
(225, 'BUTTERCUP COTTAGE INCENSE CONE HOLDER', 'https://www.somethingdifferentwholesale.co.uk/home-fragrance/incense-holders/Buttercup-Cottage-Incense-Cone-Holder-by-Lisa-Parker/', 'This \'Buttercup Cottage\' is an adorable incense cone burner shaped like a little house. Place an incense cone inside and watch as smoke rises from a tiny fairy chimney.', '4.50', '9.99', '7903', 0, 0, '2021-11-10 23:19:13', 'B2BB9D8F-B44B-E8C2-01AC-9D82433FF229.jpeg', '5', 1),
(228, 'Tropical Rainforest and Exotic Papaya', NULL, 'Tropical Rainforest and Exotic Papaya', '1.20', '2.99', '5718', 0, 1, '2021-11-17 12:34:49', '94799589-8EB9-B9C6-D7A4-975CF7C4047F.jpeg', '100', 1),
(229, 'Tropical Rainforest and Exotic Papaya Shower Gel', 'Asda', 'Tropical Rainforest and Exotic Papaya Shower Gel', '0.61', '1.99', '6918', 1, 0, '2021-11-17 12:38:29', 'FAD68C90-1833-3711-F9C1-74912D7EE223.jpeg', '4', 1),
(230, 'Tropical Rainforest and Exotic Papaya Shower Gel', NULL, 'Tropical Rainforest and Exotic Papaya Shower Gel', '1.20', '2.99', '6191', 0, 1, '2021-11-17 12:38:29', '6BEAF4EF-3301-6D97-50A5-FF3BC1868DAD.jpeg', '100', 1),
(231, 'Arctic Ocean and Icelandic Moss Shower Gel', 'Asda', 'Arctic Ocean and Icelandic Moss Shower Gel', '0.61', '1.99', '7200', 1, 0, '2021-11-17 12:40:22', 'C185FCD4-A998-AAFC-9201-FAF5E881D8C9.jpeg', '4', 1),
(232, 'Fijian Waterfall & Zesty Bergamot Shower Gel', 'Asda', 'Fijian Waterfall & Zesty Bergamot Shower Gel', '0.61', '1.99', '1800', 1, 0, '2021-11-17 12:42:22', 'A922F996-BDAE-B922-CD20-A56BF20D9BAF.jpeg', '4', 1),
(233, 'Cotton Clouds & White Cashmere Shower Gel', 'Asda', 'Cotton Clouds & White Cashmere Shower Gel', '0.61', '1.99', '1353', 1, 0, '2021-11-17 12:43:31', '811C0A1E-C308-3E77-5B3E-2E54A44377CF.jpeg', '4', 1),
(234, 'Dove Beauty Cream Soap Bar', 'Asda', 'For soft & smooth skin.\r\n\r\nSize - 100g', '0.41', '0.99', '270', 1, 0, '2021-11-17 12:45:45', 'F2CBBC7D-4732-E856-BEFB-81BE7668C1F1.jpeg', '7', 1),
(235, 'Johnson\'s Baby Honey Soap', 'Asda', 'Johnson\'s Baby Honey Soap with honey extract - Gently cleanses delicate skin leaving it feeling soft.\r\n\r\nSize - 100g', '0.26', '0.99', '1012', 5, 0, '2021-11-17 12:47:20', '36597AAB-6192-985A-1714-7EC557E3C17D.jpeg', '12', 1),
(236, 'Johnson\'s Baby Powder', 'Asda', 'Absorbs moisture to keep skin comfortable, dry & feeling healthy all day.\r\n\r\nSize - 200g', '0.53', '1.99', '3900', 5, 0, '2021-11-17 12:48:58', '3E07F5F6-2303-19A3-20E9-E104512023B4.jpeg', '5', 1),
(237, 'Johnson\'s Baby Oil', 'Asda', 'Locks in more than double the moisture’ to keep delicate skin soft & feeling soft. \r\n\r\nSize - 500ml', '1.22', '2.99', '7924', 5, 0, '2021-11-17 12:50:29', '10E0ADF2-4283-A49D-5E51-2BC8D9343926.jpeg', '5', 1),
(238, 'Johnson\'s Baby bath', 'Asda', 'Gently cleanses and leaves skin feeling healthy. \r\n\r\nSize - 500ml', '1.22', '2.99', '4518', 5, 0, '2021-11-17 12:51:50', '9C533B80-F77C-60BB-F9AA-2481FE6899B3.jpeg', '5', 1),
(239, 'Johnson\'s Baby lotion', 'Asda', 'With coconut oil, leaves skin soft & smooth after just 1 use.\r\n\r\nSize - 500ml', '1.22', '2.99', '2604', 5, 0, '2021-11-17 12:53:10', '66BECA6E-BC2F-74BC-956A-EF132A825236.jpeg', '4', 1),
(240, 'Johnson\'s Baby Shampoo', 'Asda', 'As gentle to eyes as pure water. Size - 500ml', '1.22', '2.99', '3302', 5, 0, '2021-11-17 12:54:01', 'C6A60A96-48B0-BC9A-D6E2-CEF5B54CC57C.jpeg', '5', 1),
(241, 'Jelly Babies Jar', 'Asda', 'Jelly Babies Jar. \r\nSize - 495g', '2.84', '5.99', '4786', 7, 0, '2021-11-17 12:56:06', '8E52BE1C-F5E2-BBBB-0E62-DA201E861503.jpeg', '5', 1),
(242, 'Liquorice Allsorts', 'Asda', 'Liquorice Allsorts\r\nSize - 495g', '2.84', '5.99', '8281', 7, 0, '2021-11-17 12:56:54', '2BF1217C-8BD7-2E7C-97BC-C0AFC3035F98.jpeg', '5', 1),
(243, 'Haribo Starmix Box', 'Asda', 'Haribo Starmix Box\r\nSize - 380g', '1.62', '3.99', '1188', 5, 0, '2021-11-17 12:57:53', 'B58F6808-0DE0-1911-14FC-016FEE6A06D7.jpeg', '6', 1),
(244, 'Sweet shop favourites', 'Asda', 'Sweet shop favourites\r\nSize - 324g', '1.62', '3.99', '1323', 5, 0, '2021-11-17 12:59:44', 'B53A7BA7-BA26-752B-7140-EECBE1C6F3AA.jpeg', '6', 1),
(245, 'Maltesers Truffles Chocolates Gift Box', 'Asda', 'Maltesers Truffles Chocolates Gift Box\r\nSize - 200g', '2.84', '3.99', '8352', 3, 0, '2021-11-17 13:01:04', 'F2F05F77-0DD1-905C-61F8-F9F4637B8082.jpeg', '5', 1),
(246, 'Lindt Lindor Milk Chocolate Truffles Box', '', 'Lindt Lindor Milk Chocolate Truffles Box\r\nSize - 200g', '2.84', '4.99', '6376', 3, 0, '2021-11-17 13:02:28', '56AD3198-AA52-72DB-D4E7-45383C8FF48B.jpeg', '5', 1),
(247, 'Celebrations Chocolate Sharing Pouch Bag', 'Asda', 'Celebrations Chocolate Sharing Pouch Bag\r\nSize - 400g', '2.43', '3.99', '164', 4, 0, '2021-11-17 13:03:19', '213B92CF-5EFC-1DEF-26C6-738386906927.jpeg', '6', 1),
(248, 'Cadbury Heroes Chocolate Pouch', 'Asda', 'Cadbury Heroes Chocolate Pouch\r\nSize - 357g', '2.84', '3.99', '9571', 4, 0, '2021-11-17 13:04:01', '57595783-6590-FE5B-BBFB-B5292D8B9D34.jpeg', '5', 1),
(249, 'Ferrero Rocher Rocher Chocolate Pralines Gift Box of Chocolate 16 Pieces', 'Asda', 'Ferrero Rocher Rocher Chocolate Pralines Gift Box of Chocolate 16 Pieces\r\nSize - 200g', '3.24', '4.99', '8087', 4, 0, '2021-11-17 13:04:57', '19739B30-F783-F0C8-3F5B-9710EE3592A5.jpeg', '5', 1),
(250, 'Border Beautifully Crafted Biscuits Light & Chocolatey Viennese Whirls', 'Asda', 'Border Beautifully Crafted Biscuits Light & Chocolatey Viennese Whirls\r\nSize - 150g', '1.26', '2.99', '6504', 2, 0, '2021-11-17 13:06:13', '31D064FE-178E-7655-92B6-8E3910AE36D0.jpeg', '6', 1),
(251, 'Border Beautifully Crafted Biscuits Lemon Drizzle Melts', 'Asda', 'Border Beautifully Crafted Biscuits Lemon Drizzle Melts\r\nSize - 150g', '1.26', '2.99', '4881', 2, 0, '2021-11-17 13:06:49', '4EBC1D0C-8FE6-E153-47B8-951B3CFBBEB8.jpeg', '6', 1),
(252, 'Starbucks Toffee Nut Latte by Dolce Gusto Coffee Pods', 'Asda', 'Enjoy the warmth of toasted nuts, blended with smooth espresso and creamy milk. Coffee pods compatible with NESCAFE® Dolce Gusto® coffee pod machines, 6 servings per box. Perfect for the holiday season at home. Bring home Starbucks holiday favourites. \r\n\r\nSize - 12pk\r\n\r\nNet Content : 127,8 Grams\r\n\r\nAllergy Advice\r\nMay Contain: Soya. Contains: Milk.', '1.22', '3.99', '1745', 1, 0, '2021-11-17 13:08:02', '3B632382-7A05-61CF-A9DC-C0055CAB4388.jpeg', '5', 1),
(253, 'Starbucks Cappuccino Premium Instant Coffee Sachets 5 Pack', 'Asda', 'Starbucks Cappuccino Premium Instant Coffee with rich & velvety notes. Expertly blended together with dairy milk for a thick topping of foam. Crafted with high quality 100% Arabica coffee. 5 individual serving sticks per box. Committed to 100% Ethical Coffee Sourcing in partnership with Conservation International. Enjoy Starbucks Coffee at home.\r\n\r\nSize - 5pk\r\n\r\nNet Content : 14 Grams\r\n\r\nAllergy Advice\r\nContains: Milk.', '1.22', '3.99', '2221', 1, 0, '2021-11-17 13:08:37', '1AD4E115-3B91-A31B-E981-064FC8118A60.jpeg', '2', 1),
(254, 'Twinings Superblends Matcha Green Tea with Cranberrry & Lime 20 Teabags', 'Amazon', 'Blended in flavours of Cranberry & Lime to brighten, lift and soften the taste of Matcha in this blend. It\'s juicy, fresh tasting and easy to drink.\r\n\r\nSize - 20 Teabags', '1.90', '3.99', '6657', 0, 0, '2021-11-17 13:09:57', '639DAFA6-DF3E-7083-FD46-6DDD866EC8AC.jpeg', '4', 1),
(255, 'Twinings Superblends Beetroot Tea with Ginger & Orange, 20 Teabags', 'Amazon', 'Orange and Ginger Flavoured Infusion with Beetroot and added Thiamin.\r\nSize - 20 Teabags', '1.90', '3.99', '3158', 0, 0, '2021-11-17 13:11:03', 'D5DC37E6-1EB4-3142-D1D3-26ACFB59F794.jpeg', '4', 1),
(256, 'Twinings Superblends Focus with Mango, Pineapple & Ginseng, 20 Teabags', 'Amazon', 'We all need help sometimes to see the wood for the trees. This is the inspiration behind this carefully crafted naturally caffeine free Focus blend. A moreish flavour.\r\n\r\nSize - 20 Teabags', '1.90', '3.99', '294', 0, 0, '2021-11-17 13:15:27', '8DF02640-703E-1AFE-A3B6-D37B69EDD84C.jpeg', '4', 1),
(257, 'Twinings Superblends Defence with Citrus, Ginger, Green Tea & Echinacea, 80 Teabags', 'Amazon', 'A vibrant, unique blend with green tea, herbal ingredients and the delicious flavours of citrus fruits. The addition of a little ginger into the mix helps to make this Defence blend warm and smooth.\r\n\r\nSize - 20 Teabags', '1.90', '3.99', '7538', 0, 0, '2021-11-17 13:16:51', '0F49F4C2-68ED-97FB-8ABC-AD3A4602DEA7.jpeg', '4', 1),
(258, 'Twinings Superblends Glow with Strawberry, Cucumber, Green Tea & Aloe Vera, 20 Teabags', 'Amazon', 'When your skin and hair glows, you radiate confidence and feel great. This is why we created this carefully crafted glow blend.\r\n\r\nSize - 20 Teabags', '1.90', '3.99', '9762', 0, 0, '2021-11-17 13:17:56', '26A6AC76-E288-1180-8C99-FF5229B2E315.jpeg', '4', 1),
(259, 'Twinings Superblends Detox with Lemon, Ginger, Burdock Root & Fennel, 20 Teabags', 'Amazon', 'Selenium contributes to the protection of cells from oxidative stress.  Enjoy at least 1 cup a day as part of a varied and balanced diet and a healthy lifestyle.\r\n\r\nSize - 20 Teabags', '1.90', '3.99', '3118', 0, 0, '2021-11-17 13:19:21', '406653AD-54B4-3EDC-F72E-DF2F7DA0F88B.jpeg', '4', 1),
(260, 'Galaxy Truffles Hot Chocolate', 'Asda', 'Truffles Milk Chocolate. Add milk. A rich and smooth Galaxy truffles drink. Made with Galaxy chocolate. \r\n\r\nSuitable for vegetarians.\r\n\r\nNet Content : 300 Grams\r\n\r\nAllergy Advice\r\nContains: Milk, Soya.', '2.26', '3.99', '1231', 1, 0, '2021-11-17 13:19:57', 'CC8C27BC-6BF4-C666-D9A3-BEEACDD040C0.jpeg', '6', 1),
(261, 'Face Cream', NULL, 'Face Cream', '2.50', '10.00', '74', 0, 1, '2021-11-18 07:10:39', 'C0586973-DA67-AFA1-4A88-295C584FD405.png', '1', 1),
(262, 'HOME SWEET HOME', '', '', '0', '0', '9902', 0, 0, '2021-11-18 11:37:14', '0222DA66-1D28-8544-89B6-B4E4CFF29A6C.jpeg', '1', 1),
(263, 'Little Ones', '', 'For little ones', '0.00', '0.00', '1951', 0, 0, '2021-11-18 12:00:23', '5EA5B8E9-37D6-8D78-B388-826FB75E48DA.jpeg', '1', 1),
(264, 'Food', '', 'Food', '0', '0', '5982', 0, 0, '2021-11-18 12:03:16', 'B877FB98-493B-E570-F20F-FB80B2621679.jpeg', '1', 1),
(265, 'Mr', '', 'Mr', '0', '0', '6275', 0, 0, '2021-11-18 12:03:49', '685B2AB0-B4AF-21C1-F1D6-62A5AA29B0AF.jpeg', '1', 1),
(266, 'Christmas Boxx', '', 'Christmas', '19.50', '29.99', '1537', 0, 0, '2021-11-18 13:24:22', '1A254401-6940-A071-5744-06FAF3103D3F.jpeg', '8', 0),
(267, 'Mr. Stainless Steel Men\'s Manicure Set', 'https://www.eapollowholesale.co.uk/mr-stainless-steel-men-s-manicure-kit-6pcs.html', 'Kit includes - Nail clippers, angled clippers, tweezers, Cuticle blade, nail file and PVC carry case.', '2.10', '5.99', '6500', 4, 0, '2021-11-24 18:26:41', 'CED2F32B-32BA-FA8C-0F1B-2CDD061512B8.jpeg', '11', 1),
(268, 'Glitter Compact Mirror - Pink', 'EApollo ', 'Glitter Compact Mirror - Pink', '1.50', '3.99', '5018', 4, 0, '2021-11-27 19:20:50', '9E068C77-56F9-5518-7862-090BA68063FD.jpeg', '8', 1),
(269, 'WHITE 3-IN-1 BEARD SHAPER & COMB', 'Cutprice', 'WHITE 3-IN-1 BEARD SHAPER & COMB\r\n\r\nColour: WHITE', '0.82', '2.49', '2227', 4, 0, '2021-11-27 19:37:35', '31EBE281-0F28-D760-42DE-1B2E35775748.jpeg', '12', 1),
(270, 'BLACK 3-IN-1 BEARD SHAPER & COMB', 'Cut price', 'BLACK 3-IN-1 BEARD SHAPER & COMB \r\n\r\nColour : WHITE', '0.82', '2.49', '6429', 4, 0, '2021-11-27 19:43:08', '0BE399C3-835E-B80F-C9D7-128435E50C58.jpeg', '11', 1),
(271, 'Face Cream', 'www.bespokeboxx.co.uk', 'rewrew', '2.50', '9.99', '3697', NULL, 1, '2021-11-28 23:35:02', 'B6613481-928E-2285-8434-FFDCEF4B9D70.png', '32', 1),
(272, 'Face Cream', '', 'SDGGDF', '1.85', '22', '3840', NULL, 1, '2021-11-30 00:49:02', '4156AEC9-3469-FD1A-F268-806F4D7221EE.png', '2', 1),
(273, 'Small', 'Ebay', 'Small Black Boxx\r\nSize - W28 x D21 x H12', '4.99', '5.99', '5451', 4, 0, '2021-11-30 01:41:21', 'DDA1F409-1FCF-8570-4AA6-9509F5A0145F.jpeg', '11', 1),
(274, 'Small', 'Ebay', 'Small Grey Boxx\r\nSize - W28 x D21 x H12', '4.99', '5.99', '2611', 3, 0, '2021-11-30 01:43:23', 'AD13C9BE-B410-EFED-ADC3-79E43BA8D5A5.jpeg', '10', 1),
(275, 'Small', 'Ebay', 'Small Brown Boxx\r\nSize - W28 x D21 x H12', '4.99', '5.99', '2151', 2, 0, '2021-11-30 01:52:54', '28046062-A7A6-59B9-5936-027B65B37248.jpeg', '7', 1),
(276, 'Medium', 'Ebay', 'Medium Black Boxx\r\nSize - W33 x D25 x H15 cm', '6.00', '7.99', '4295', 8, 0, '2021-11-30 01:56:34', '39BA09FB-C343-1270-0238-F3C4E3D9FDCB.jpeg', '11', 1),
(277, 'Medium', 'Ebay', 'Medium Brown Boxx\r\nSize - W33 x D25 x H15', '6.00', '7.99', '8718', 6, 0, '2021-11-30 02:00:08', 'D0906191-6FF1-A00B-3EA2-85A9DCB4249B.jpeg', '6', 1),
(278, 'Medium', 'Ebay', 'Medium Grey Boxx', '6.00', '7.99', '6885', 7, 0, '2021-11-30 02:01:19', '465C252F-E37F-2245-AB3B-DFA7E65D8C60.jpeg', '10', 1),
(279, 'Large', 'Ebay', 'Large Black Boxx\r\nSize - W36 x D29 x H18 cm', '6.00', '9.99', '4327', 12, 0, '2021-11-30 02:11:42', 'BC460676-A719-40C4-D144-EE372BFD0238.jpeg', '11', 1),
(280, 'Large', 'Ebay', 'Large Grey Boxx\r\nSize - W36 x D29 x H18 cm', '6.00', '9.99', '1240', 11, 0, '2021-11-30 02:13:54', '3A334BE0-88B1-5FAE-2D78-7EEDA4AB906C.jpeg', '10', 1),
(281, 'Large', 'Ebay', 'Large Brown Boxx\r\nSize - W36 x D29 x H18 cm', '6.00', '9.99', '5572', 10, 0, '2021-11-30 02:15:14', 'A2DCF3FD-A333-C4E4-D026-F1970292395C.jpeg', '7', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_to_category`
--

CREATE TABLE `products_to_category` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_to_category`
--

INSERT INTO `products_to_category` (`id`, `product_id`, `category_id`, `created_at`) VALUES
(192, 109, 10, '2021-11-09 20:53:59'),
(193, 110, 10, '2021-11-09 20:54:25'),
(194, 111, 10, '2021-11-09 20:54:45'),
(195, 112, 10, '2021-11-09 20:55:25'),
(291, 84, 12, '2021-11-10 09:22:06'),
(292, 85, 12, '2021-11-10 09:22:43'),
(294, 87, 12, '2021-11-10 09:26:49'),
(881, 198, 6, '2021-11-25 12:53:33'),
(905, 209, 6, '2021-11-25 13:17:14'),
(942, 264, 14, '2021-11-25 14:11:36'),
(943, 265, 14, '2021-11-25 14:11:44'),
(944, 262, 14, '2021-11-25 14:11:52'),
(945, 263, 14, '2021-11-25 14:11:58'),
(949, 119, 12, '2021-11-25 14:43:39'),
(970, 254, 5, '2021-11-25 17:38:05'),
(979, 113, 10, '2021-11-25 18:05:30'),
(997, 267, 4, '2021-11-27 13:53:41'),
(998, 128, 4, '2021-11-27 13:54:20'),
(999, 129, 4, '2021-11-27 13:55:20'),
(1000, 132, 4, '2021-11-27 13:56:02'),
(1001, 133, 4, '2021-11-27 13:58:13'),
(1002, 134, 4, '2021-11-27 13:58:22'),
(1003, 135, 4, '2021-11-27 13:58:33'),
(1005, 137, 4, '2021-11-27 13:59:16'),
(1006, 136, 4, '2021-11-27 13:59:26'),
(1007, 138, 4, '2021-11-27 14:08:24'),
(1008, 140, 4, '2021-11-27 14:14:07'),
(1009, 141, 4, '2021-11-27 14:17:08'),
(1010, 158, 4, '2021-11-27 14:18:45'),
(1011, 160, 4, '2021-11-27 14:18:59'),
(1012, 161, 4, '2021-11-27 14:21:05'),
(1014, 229, 4, '2021-11-27 14:27:35'),
(1020, 232, 4, '2021-11-27 14:28:38'),
(1021, 231, 4, '2021-11-27 14:28:45'),
(1022, 234, 4, '2021-11-27 14:30:10'),
(1023, 235, 4, '2021-11-27 14:30:59'),
(1024, 235, 9, '2021-11-27 14:30:59'),
(1025, 236, 4, '2021-11-27 14:32:18'),
(1026, 236, 9, '2021-11-27 14:32:18'),
(1027, 237, 4, '2021-11-27 14:33:52'),
(1028, 237, 9, '2021-11-27 14:33:52'),
(1029, 238, 4, '2021-11-27 14:36:08'),
(1030, 238, 9, '2021-11-27 14:36:08'),
(1031, 239, 4, '2021-11-27 14:36:57'),
(1032, 239, 9, '2021-11-27 14:36:57'),
(1033, 240, 4, '2021-11-27 14:37:13'),
(1034, 240, 9, '2021-11-27 14:37:13'),
(1038, 157, 4, '2021-11-27 14:40:54'),
(1039, 156, 4, '2021-11-27 14:40:59'),
(1040, 151, 4, '2021-11-27 14:42:57'),
(1041, 152, 4, '2021-11-27 14:43:24'),
(1042, 153, 4, '2021-11-27 14:44:01'),
(1043, 154, 4, '2021-11-27 14:44:25'),
(1044, 162, 4, '2021-11-27 14:56:01'),
(1053, 259, 5, '2021-11-27 15:38:10'),
(1054, 257, 5, '2021-11-27 15:38:17'),
(1055, 258, 5, '2021-11-27 15:38:24'),
(1056, 255, 5, '2021-11-27 15:38:34'),
(1062, 251, 5, '2021-11-27 15:42:24'),
(1063, 250, 5, '2021-11-27 15:42:37'),
(1065, 245, 5, '2021-11-27 15:44:48'),
(1067, 246, 5, '2021-11-27 15:46:24'),
(1069, 247, 5, '2021-11-27 15:49:04'),
(1070, 248, 5, '2021-11-27 15:49:51'),
(1071, 249, 5, '2021-11-27 15:51:15'),
(1072, 260, 5, '2021-11-27 15:54:14'),
(1074, 252, 5, '2021-11-27 15:56:57'),
(1075, 253, 5, '2021-11-27 15:57:06'),
(1076, 244, 5, '2021-11-27 15:58:32'),
(1077, 243, 5, '2021-11-27 16:00:32'),
(1078, 242, 5, '2021-11-27 16:02:38'),
(1079, 241, 5, '2021-11-27 16:04:39'),
(1080, 142, 4, '2021-11-27 16:19:46'),
(1081, 142, 9, '2021-11-27 16:19:46'),
(1083, 115, 9, '2021-11-27 16:57:36'),
(1084, 116, 9, '2021-11-27 16:57:52'),
(1086, 118, 9, '2021-11-27 16:59:19'),
(1087, 117, 9, '2021-11-27 16:59:31'),
(1088, 120, 9, '2021-11-27 17:01:38'),
(1089, 121, 9, '2021-11-27 17:02:00'),
(1090, 122, 9, '2021-11-27 17:02:26'),
(1091, 123, 9, '2021-11-27 17:02:37'),
(1092, 124, 9, '2021-11-27 17:04:19'),
(1093, 125, 9, '2021-11-27 17:04:55'),
(1094, 145, 9, '2021-11-27 17:05:09'),
(1095, 130, 9, '2021-11-27 17:06:35'),
(1096, 131, 9, '2021-11-27 17:06:51'),
(1097, 143, 9, '2021-11-27 17:08:47'),
(1098, 144, 9, '2021-11-27 17:09:32'),
(1099, 146, 9, '2021-11-27 17:10:28'),
(1100, 147, 9, '2021-11-27 17:10:55'),
(1101, 148, 9, '2021-11-27 17:11:08'),
(1103, 149, 9, '2021-11-27 17:11:48'),
(1104, 150, 9, '2021-11-27 17:13:30'),
(1105, 192, 9, '2021-11-27 17:16:31'),
(1108, 167, 6, '2021-11-27 17:27:53'),
(1110, 168, 6, '2021-11-27 17:30:14'),
(1111, 170, 6, '2021-11-27 17:31:36'),
(1112, 171, 6, '2021-11-27 17:32:04'),
(1113, 172, 6, '2021-11-27 17:32:15'),
(1114, 175, 6, '2021-11-27 17:34:21'),
(1115, 176, 6, '2021-11-27 17:35:51'),
(1116, 177, 6, '2021-11-27 17:37:29'),
(1117, 178, 5, '2021-11-27 17:40:27'),
(1118, 178, 6, '2021-11-27 17:40:27'),
(1120, 180, 5, '2021-11-27 17:41:10'),
(1121, 180, 6, '2021-11-27 17:41:10'),
(1125, 185, 6, '2021-11-27 17:46:59'),
(1126, 184, 6, '2021-11-27 17:49:02'),
(1127, 186, 6, '2021-11-27 17:50:41'),
(1128, 187, 6, '2021-11-27 17:51:37'),
(1129, 188, 6, '2021-11-27 17:51:55'),
(1130, 189, 6, '2021-11-27 17:54:08'),
(1131, 190, 6, '2021-11-27 17:54:41'),
(1134, 194, 6, '2021-11-27 17:57:26'),
(1135, 195, 6, '2021-11-27 17:58:22'),
(1136, 196, 6, '2021-11-27 18:35:18'),
(1137, 197, 6, '2021-11-27 18:36:20'),
(1138, 199, 6, '2021-11-27 18:37:24'),
(1139, 200, 6, '2021-11-27 18:39:01'),
(1140, 201, 6, '2021-11-27 18:40:31'),
(1141, 202, 6, '2021-11-27 18:41:03'),
(1145, 203, 6, '2021-11-27 18:43:32'),
(1146, 204, 6, '2021-11-27 18:43:49'),
(1148, 206, 6, '2021-11-27 18:45:18'),
(1149, 207, 6, '2021-11-27 18:46:56'),
(1150, 208, 6, '2021-11-27 18:47:26'),
(1151, 205, 6, '2021-11-27 18:47:53'),
(1152, 210, 6, '2021-11-27 18:48:55'),
(1153, 211, 6, '2021-11-27 18:51:00'),
(1154, 212, 6, '2021-11-27 18:52:27'),
(1155, 212, 6, '2021-11-27 18:52:27'),
(1156, 215, 6, '2021-11-27 18:53:51'),
(1157, 217, 6, '2021-11-27 18:54:13'),
(1158, 218, 6, '2021-11-27 18:54:33'),
(1159, 219, 6, '2021-11-27 18:54:54'),
(1160, 220, 6, '2021-11-27 18:57:08'),
(1161, 220, 6, '2021-11-27 18:57:08'),
(1162, 221, 6, '2021-11-27 18:59:16'),
(1163, 222, 6, '2021-11-27 19:02:35'),
(1164, 223, 6, '2021-11-27 19:05:19'),
(1165, 224, 6, '2021-11-27 19:07:23'),
(1166, 225, 6, '2021-11-27 19:10:51'),
(1167, 191, 6, '2021-11-27 19:14:49'),
(1168, 193, 9, '2021-11-27 19:16:09'),
(1169, 268, 4, '2021-11-27 19:20:50'),
(1179, 270, 4, '2021-11-27 19:43:08'),
(1180, 269, 4, '2021-11-27 19:43:13'),
(1183, 163, 5, '2021-11-27 19:45:17'),
(1184, 163, 6, '2021-11-27 19:45:17'),
(1189, 165, 5, '2021-11-27 19:46:06'),
(1190, 165, 6, '2021-11-27 19:46:06'),
(1191, 169, 5, '2021-11-27 19:46:22'),
(1192, 169, 6, '2021-11-27 19:46:22'),
(1193, 164, 5, '2021-11-27 19:46:37'),
(1194, 164, 6, '2021-11-27 19:46:37'),
(1197, 166, 5, '2021-11-27 19:47:58'),
(1198, 166, 6, '2021-11-27 19:47:58'),
(1199, 181, 5, '2021-11-28 11:18:38'),
(1200, 181, 6, '2021-11-28 11:18:38'),
(1201, 182, 5, '2021-11-28 11:18:49'),
(1202, 182, 6, '2021-11-28 11:18:49'),
(1203, 183, 5, '2021-11-28 11:19:31'),
(1204, 183, 6, '2021-11-28 11:19:31'),
(1264, 233, 4, '2021-11-30 02:47:39'),
(1267, 275, 3, '2021-11-30 03:29:58'),
(1268, 274, 3, '2021-11-30 03:30:10'),
(1270, 104, 3, '2021-11-30 03:30:32'),
(1271, 277, 3, '2021-11-30 03:30:44'),
(1272, 278, 3, '2021-11-30 03:31:01'),
(1273, 276, 3, '2021-11-30 03:31:08'),
(1274, 106, 3, '2021-11-30 03:31:42'),
(1275, 281, 3, '2021-11-30 03:31:53'),
(1276, 280, 3, '2021-11-30 03:32:04'),
(1277, 279, 3, '2021-11-30 03:32:19'),
(1278, 91, 3, '2021-11-30 04:00:46'),
(1279, 273, 3, '2021-11-30 04:15:58'),
(1280, 256, 5, '2021-11-30 05:10:37'),
(1282, 266, 11, '2021-11-30 05:20:03'),
(1283, 155, 4, '2021-11-30 06:26:45');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `description`, `status`, `created_at`, `is_deleted`) VALUES
(3, 'Hampers', 'Hampers', 1, '2021-08-04 23:37:09', 0),
(4, 'Beauty & Care', 'Beauty & Care', 1, '2021-08-05 21:59:56', 0),
(5, 'Food & Drink', 'Food & Drink', 1, '2021-08-05 22:00:14', 0),
(6, 'Home & Leisure', 'Home & Leisure', 1, '2021-08-05 22:00:33', 0),
(9, 'Little Ones', 'Little Ones', 1, '2021-08-05 22:01:12', 0),
(10, 'Filling', 'Hamper filling to fill the basket.', 1, '2021-08-19 22:48:03', 0),
(11, 'HOTM', 'Hamper Of The Month', 1, '2021-09-21 20:11:48', 0),
(12, 'Hamper Colour', 'Hamper Colour', 1, '2021-10-02 04:04:51', 0),
(14, 'Inspirations', 'A range of Boxx\'s designed to help you vision your Boxx.', 1, '2021-11-18 10:29:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_properties`
--

CREATE TABLE `product_properties` (
  `id` int(11) NOT NULL,
  `property_name` varchar(255) DEFAULT NULL,
  `property_value` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_properties`
--

INSERT INTO `product_properties` (`id`, `property_name`, `property_value`, `product_id`) VALUES
(256, 'FillsSmall', '', 109),
(257, 'FillsMedium', '', 109),
(258, 'FillsLarge', '', 109),
(259, 'FillsSmall', '', 110),
(260, 'FillsMedium', '', 110),
(261, 'FillsLarge', '', 110),
(262, 'FillsSmall', '', 111),
(263, 'FillsMedium', '', 111),
(264, 'FillsLarge', '', 111),
(265, 'FillsSmall', '', 112),
(266, 'FillsMedium', '', 112),
(267, 'FillsLarge', '', 112),
(1577, 'FillsSmall', '20', 198),
(1578, 'FillsMedium', '15', 198),
(1579, 'FillsLarge', '10', 198),
(1613, 'FillsSmall', '20', 209),
(1614, 'FillsMedium', '15', 209),
(1615, 'FillsLarge', '10', 209),
(1721, 'FillsSmall', '20', 254),
(1722, 'FillsMedium', '15', 254),
(1723, 'FillsLarge', '10', 254),
(1792, 'FillsSmall', '13', 267),
(1793, 'FillsMedium', '10', 267),
(1794, 'FillsLarge', '10', 267),
(1795, 'FillsSmall', '10', 128),
(1796, 'FillsMedium', '10', 128),
(1797, 'FillsLarge', '10', 128),
(1798, 'FillsSmall', '13', 129),
(1799, 'FillsMedium', '10', 129),
(1800, 'FillsLarge', '10', 129),
(1801, 'FillsSmall', '5', 132),
(1802, 'FillsMedium', '5', 132),
(1803, 'FillsLarge', '5', 132),
(1804, 'FillsSmall', '25', 133),
(1805, 'FillsMedium', '20', 133),
(1806, 'FillsLarge', '13', 133),
(1807, 'FillsSmall', '24', 134),
(1808, 'FillsMedium', '20', 134),
(1809, 'FillsLarge', '13', 134),
(1810, 'FillsSmall', '25', 135),
(1811, 'FillsMedium', '20', 135),
(1812, 'FillsLarge', '13', 135),
(1816, 'FillsSmall', '25', 137),
(1817, 'FillsMedium', '20 ', 137),
(1818, 'FillsLarge', '13', 137),
(1819, 'FillsSmall', '25', 136),
(1820, 'FillsMedium', '20', 136),
(1821, 'FillsLarge', '13', 136),
(1822, 'FillsSmall', '90', 138),
(1823, 'FillsMedium', '70', 138),
(1824, 'FillsLarge', '50', 138),
(1825, 'FillsSmall', '60', 140),
(1826, 'FillsMedium', '35', 140),
(1827, 'FillsLarge', '25', 140),
(1828, 'FillsSmall', '16', 141),
(1829, 'FillsMedium', '11', 141),
(1830, 'FillsLarge', '10', 141),
(1831, 'FillsSmall', '25', 158),
(1832, 'FillsMedium', '20', 158),
(1833, 'FillsLarge', '16', 158),
(1834, 'FillsSmall', '25', 160),
(1835, 'FillsMedium', '20', 160),
(1836, 'FillsLarge', '16', 160),
(1837, 'FillsSmall', '50', 161),
(1838, 'FillsMedium', '35', 161),
(1839, 'FillsLarge', '30', 161),
(1843, 'FillsSmall', '25', 229),
(1844, 'FillsMedium', '20', 229),
(1845, 'FillsLarge', '13', 229),
(1861, 'FillsSmall', '25', 232),
(1862, 'FillsMedium', '20', 232),
(1863, 'FillsLarge', '13', 232),
(1864, 'FillsSmall', '25', 231),
(1865, 'FillsMedium', '20', 231),
(1866, 'FillsLarge', '13', 231),
(1867, 'FillsSmall', '12', 234),
(1868, 'FillsMedium', '10', 234),
(1869, 'FillsLarge', '10', 234),
(1870, 'FillsSmall', '10', 235),
(1871, 'FillsMedium', '10', 235),
(1872, 'FillsLarge', '10', 235),
(1873, 'FillsSmall', '25', 236),
(1874, 'FillsMedium', '20', 236),
(1875, 'FillsLarge', '13', 236),
(1876, 'FillsSmall', '35', 237),
(1877, 'FillsMedium', '25', 237),
(1878, 'FillsLarge', '16', 237),
(1879, 'FillsSmall', '40', 238),
(1880, 'FillsMedium', '35', 238),
(1881, 'FillsLarge', '20', 238),
(1882, 'FillsSmall', '40', 239),
(1883, 'FillsMedium', '35', 239),
(1884, 'FillsLarge', '20', 239),
(1885, 'FillsSmall', '40', 240),
(1886, 'FillsMedium', '35', 240),
(1887, 'FillsLarge', '20', 240),
(1897, 'FillsSmall', '35', 157),
(1898, 'FillsMedium', '20', 157),
(1899, 'FillsLarge', '17', 157),
(1900, 'FillsSmall', '35', 156),
(1901, 'FillsMedium', '20', 156),
(1902, 'FillsLarge', '17', 156),
(1903, 'FillsSmall', '25', 151),
(1904, 'FillsMedium', '20', 151),
(1905, 'FillsLarge', '13', 151),
(1906, 'FillsSmall', '25', 152),
(1907, 'FillsMedium', '20', 152),
(1908, 'FillsLarge', '13', 152),
(1909, 'FillsSmall', '25', 153),
(1910, 'FillsMedium', '20', 153),
(1911, 'FillsLarge', '13', 153),
(1912, 'FillsSmall', '25', 154),
(1913, 'FillsMedium', '20', 154),
(1914, 'FillsLarge', '13', 154),
(1915, 'FillsSmall', '17', 162),
(1916, 'FillsMedium', '13', 162),
(1917, 'FillsLarge', '13', 162),
(1942, 'FillsSmall', '35', 259),
(1943, 'FillsMedium', '20', 259),
(1944, 'FillsLarge', '17', 259),
(1945, 'FillsSmall', '35', 257),
(1946, 'FillsMedium', '20', 257),
(1947, 'FillsLarge', '17', 257),
(1948, 'FillsSmall', '35', 258),
(1949, 'FillsMedium', '20', 258),
(1950, 'FillsLarge', '17', 258),
(1951, 'FillsSmall', '35', 255),
(1952, 'FillsMedium', '20', 255),
(1953, 'FillsLarge', '17', 255),
(1969, 'FillsSmall', '30', 251),
(1970, 'FillsMedium', '20', 251),
(1971, 'FillsLarge', '16', 251),
(1972, 'FillsSmall', '30', 250),
(1973, 'FillsMedium', '20', 250),
(1974, 'FillsLarge', '16', 250),
(1978, 'FillsSmall', '50', 245),
(1979, 'FillsMedium', '40', 245),
(1980, 'FillsLarge', '30', 245),
(1984, 'FillsSmall', '40', 246),
(1985, 'FillsMedium', '30', 246),
(1986, 'FillsLarge', '20', 246),
(1990, 'FillsSmall', '60', 247),
(1991, 'FillsMedium', '50', 247),
(1992, 'FillsLarge', '33', 247),
(1993, 'FillsSmall', '60', 248),
(1994, 'FillsMedium', '50', 248),
(1995, 'FillsLarge', '33', 248),
(1996, 'FillsSmall', '33', 249),
(1997, 'FillsMedium', '25', 249),
(1998, 'FillsLarge', '16', 249),
(1999, 'FillsSmall', '30', 260),
(2000, 'FillsMedium', '16', 260),
(2001, 'FillsLarge', '13', 260),
(2005, 'FillsSmall', '20', 252),
(2006, 'FillsMedium', '17', 252),
(2007, 'FillsLarge', '15', 252),
(2008, 'FillsSmall', '20', 253),
(2009, 'FillsMedium', '17', 253),
(2010, 'FillsLarge', '15', 253),
(2011, 'FillsSmall', '50', 244),
(2012, 'FillsMedium', '35', 244),
(2013, 'FillsLarge', '30', 244),
(2014, 'FillsSmall', '50', 243),
(2015, 'FillsMedium', '30', 243),
(2016, 'FillsLarge', '35', 243),
(2017, 'FillsSmall', '100', 242),
(2018, 'FillsMedium', '50', 242),
(2019, 'FillsLarge', '30', 242),
(2020, 'FillsSmall', '100', 241),
(2021, 'FillsMedium', '50', 241),
(2022, 'FillsLarge', '30', 241),
(2023, 'FillsSmall', '17', 142),
(2024, 'FillsMedium', '15', 142),
(2025, 'FillsLarge', '12', 142),
(2030, 'FillsSmall', '60', 115),
(2031, 'FillsMedium', '50', 115),
(2032, 'FillsLarge', '33', 115),
(2033, 'FillsSmall', '60', 116),
(2034, 'FillsMedium', '50', 116),
(2035, 'FillsLarge', '33', 116),
(2039, 'FillsSmall', '60', 118),
(2040, 'FillsMedium', '50', 118),
(2041, 'FillsLarge', '33', 118),
(2042, 'FillsSmall', '60', 117),
(2043, 'FillsMedium', '50', 117),
(2044, 'FillsLarge', '33', 117),
(2045, 'FillsSmall', '33', 120),
(2046, 'FillsMedium', '25', 120),
(2047, 'FillsLarge', '17', 120),
(2048, 'FillsSmall', '33', 121),
(2049, 'FillsMedium', '25', 121),
(2050, 'FillsLarge', '17', 121),
(2051, 'FillsSmall', '33', 122),
(2052, 'FillsMedium', '25', 122),
(2053, 'FillsLarge', '17', 122),
(2054, 'FillsSmall', '33', 123),
(2055, 'FillsMedium', '25', 123),
(2056, 'FillsLarge', '17', 123),
(2057, 'FillsSmall', '10', 124),
(2058, 'FillsMedium', '5', 124),
(2059, 'FillsLarge', '5', 124),
(2060, 'FillsSmall', '5', 125),
(2061, 'FillsMedium', '10', 125),
(2062, 'FillsLarge', '10', 125),
(2063, 'FillsSmall', '5', 145),
(2064, 'FillsMedium', '10', 145),
(2065, 'FillsLarge', '10', 145),
(2066, 'FillsSmall', '40', 130),
(2067, 'FillsMedium', '30', 130),
(2068, 'FillsLarge', '20', 130),
(2069, 'FillsSmall', '40', 131),
(2070, 'FillsMedium', '30', 131),
(2071, 'FillsLarge', '20', 131),
(2072, 'FillsSmall', '33', 143),
(2073, 'FillsMedium', '20', 143),
(2074, 'FillsLarge', '15', 143),
(2075, 'FillsSmall', '33', 144),
(2076, 'FillsMedium', '20', 144),
(2077, 'FillsLarge', '15', 144),
(2078, 'FillsSmall', '40', 146),
(2079, 'FillsMedium', '33', 146),
(2080, 'FillsLarge', '25', 146),
(2081, 'FillsSmall', '40', 147),
(2082, 'FillsMedium', '33', 147),
(2083, 'FillsLarge', '25', 147),
(2084, 'FillsSmall', '40', 148),
(2085, 'FillsMedium', '33', 148),
(2086, 'FillsLarge', '25', 148),
(2090, 'FillsSmall', '5', 149),
(2091, 'FillsMedium', '5', 149),
(2092, 'FillsLarge', '5', 149),
(2093, 'FillsSmall', '33', 150),
(2094, 'FillsMedium', '25', 150),
(2095, 'FillsLarge', '15', 150),
(2096, 'FillsSmall', '10', 192),
(2097, 'FillsMedium', '15', 192),
(2098, 'FillsLarge', '5', 192),
(2105, 'FillsSmall', '70', 167),
(2106, 'FillsMedium', '40', 167),
(2107, 'FillsLarge', '20', 167),
(2111, 'FillsSmall', '20', 168),
(2112, 'FillsMedium', '15', 168),
(2113, 'FillsLarge', '10', 168),
(2114, 'FillsSmall', '80', 170),
(2115, 'FillsMedium', '40', 170),
(2116, 'FillsLarge', '30', 170),
(2117, 'FillsSmall', '80', 171),
(2118, 'FillsMedium', '40', 171),
(2119, 'FillsLarge', '30', 171),
(2120, 'FillsSmall', '80', 172),
(2121, 'FillsMedium', '40', 172),
(2122, 'FillsLarge', '30', 172),
(2123, 'FillsSmall', '35', 175),
(2124, 'FillsMedium', '20', 175),
(2125, 'FillsLarge', '15', 175),
(2126, 'FillsSmall', '20', 176),
(2127, 'FillsMedium', '12', 176),
(2128, 'FillsLarge', '10', 176),
(2129, 'FillsSmall', '10', 177),
(2130, 'FillsMedium', '5', 177),
(2131, 'FillsLarge', '5', 177),
(2132, 'FillsSmall', '30', 178),
(2133, 'FillsMedium', '25', 178),
(2134, 'FillsLarge', '20', 178),
(2138, 'FillsSmall', '30', 180),
(2139, 'FillsMedium', '25', 180),
(2140, 'FillsLarge', '20', 180),
(2150, 'FillsSmall', '25', 185),
(2151, 'FillsMedium', '20', 185),
(2152, 'FillsLarge', '17', 185),
(2153, 'FillsSmall', '40', 184),
(2154, 'FillsMedium', '33', 184),
(2155, 'FillsLarge', '25', 184),
(2156, 'FillsSmall', '35', 186),
(2157, 'FillsMedium', '25', 186),
(2158, 'FillsLarge', '20', 186),
(2159, 'FillsSmall', '1', 187),
(2160, 'FillsMedium', '1', 187),
(2161, 'FillsLarge', '1', 187),
(2162, 'FillsSmall', '1', 188),
(2163, 'FillsMedium', '1', 188),
(2164, 'FillsLarge', '1', 188),
(2165, 'FillsSmall', '10', 189),
(2166, 'FillsMedium', '5', 189),
(2167, 'FillsLarge', '5', 189),
(2168, 'FillsSmall', '10', 190),
(2169, 'FillsMedium', '5', 190),
(2170, 'FillsLarge', '5', 190),
(2177, 'FillsSmall', '30', 194),
(2178, 'FillsMedium', '25', 194),
(2179, 'FillsLarge', '20', 194),
(2180, 'FillsSmall', '30', 195),
(2181, 'FillsMedium', '25', 195),
(2182, 'FillsLarge', '20', 195),
(2183, 'FillsSmall', '15', 196),
(2184, 'FillsMedium', '10', 196),
(2185, 'FillsLarge', '10', 196),
(2186, 'FillsSmall', '15', 197),
(2187, 'FillsMedium', '10', 197),
(2188, 'FillsLarge', '10', 197),
(2189, 'FillsSmall', '30', 199),
(2190, 'FillsMedium', '25', 199),
(2191, 'FillsLarge', '20', 199),
(2192, 'FillsSmall', '33', 200),
(2193, 'FillsMedium', '20', 200),
(2194, 'FillsLarge', '17', 200),
(2195, 'FillsSmall', '45', 201),
(2196, 'FillsMedium', '25', 201),
(2197, 'FillsLarge', '20', 201),
(2198, 'FillsSmall', '45', 202),
(2199, 'FillsMedium', '25', 202),
(2200, 'FillsLarge', '20', 202),
(2210, 'FillsSmall', '10', 203),
(2211, 'FillsMedium', '5', 203),
(2212, 'FillsLarge', '5', 203),
(2213, 'FillsSmall', '10', 204),
(2214, 'FillsMedium', '5', 204),
(2215, 'FillsLarge', '5', 204),
(2219, 'FillsSmall', '15', 206),
(2220, 'FillsMedium', '13', 206),
(2221, 'FillsLarge', '10', 206),
(2222, 'FillsSmall', '25', 207),
(2223, 'FillsMedium', '15', 207),
(2224, 'FillsLarge', '10', 207),
(2225, 'FillsSmall', '25', 208),
(2226, 'FillsMedium', '15', 208),
(2227, 'FillsLarge', '10', 208),
(2228, 'FillsSmall', '25', 205),
(2229, 'FillsMedium', '15', 205),
(2230, 'FillsLarge', '10', 205),
(2231, 'FillsSmall', '5', 210),
(2232, 'FillsMedium', '5', 210),
(2233, 'FillsLarge', '5', 210),
(2234, 'FillsSmall', '5', 211),
(2235, 'FillsMedium', '5', 211),
(2236, 'FillsLarge', '5', 211),
(2237, 'FillsSmall', '5', 212),
(2238, 'FillsSmall', '5', 212),
(2239, 'FillsMedium', '5', 212),
(2240, 'FillsMedium', '5', 212),
(2241, 'FillsLarge', '5', 212),
(2242, 'FillsLarge', '5', 212),
(2243, 'FillsSmall', '5', 215),
(2244, 'FillsMedium', '5', 215),
(2245, 'FillsLarge', '5', 215),
(2246, 'FillsSmall', '5', 217),
(2247, 'FillsMedium', '5', 217),
(2248, 'FillsLarge', '5', 217),
(2249, 'FillsSmall', '5', 218),
(2250, 'FillsMedium', '5', 218),
(2251, 'FillsLarge', '5', 218),
(2252, 'FillsSmall', '5', 219),
(2253, 'FillsMedium', '5', 219),
(2254, 'FillsLarge', '5', 219),
(2255, 'FillsSmall', '5', 220),
(2256, 'FillsSmall', '5', 220),
(2257, 'FillsMedium', '5', 220),
(2258, 'FillsMedium', '5', 220),
(2259, 'FillsLarge', '5', 220),
(2260, 'FillsLarge', '5', 220),
(2261, 'FillsSmall', '30', 221),
(2262, 'FillsMedium', '15', 221),
(2263, 'FillsLarge', '10', 221),
(2264, 'FillsSmall', '20', 222),
(2265, 'FillsMedium', '13', 222),
(2266, 'FillsLarge', '10', 222),
(2267, 'FillsSmall', '25', 223),
(2268, 'FillsMedium', '17', 223),
(2269, 'FillsLarge', '15', 223),
(2270, 'FillsSmall', '35', 224),
(2271, 'FillsMedium', '30', 224),
(2272, 'FillsLarge', '25', 224),
(2273, 'FillsSmall', '35', 225),
(2274, 'FillsMedium', '30', 225),
(2275, 'FillsLarge', '25', 225),
(2276, 'FillsSmall', '10', 191),
(2277, 'FillsMedium', '5', 191),
(2278, 'FillsLarge', '5', 191),
(2279, 'FillsSmall', '10', 193),
(2280, 'FillsMedium', '5', 193),
(2281, 'FillsLarge', '5', 193),
(2282, 'FillsSmall', '10', 268),
(2283, 'FillsMedium', '5', 268),
(2284, 'FillsLarge', '5', 268),
(2288, 'FillsSmall', '50', 270),
(2289, 'FillsMedium', '30', 270),
(2290, 'FillsLarge', '20', 270),
(2291, 'FillsSmall', '50', 269),
(2292, 'FillsMedium', '30', 269),
(2293, 'FillsLarge', '20', 269),
(2297, 'FillsSmall', '25', 163),
(2298, 'FillsMedium', '15', 163),
(2299, 'FillsLarge', '12', 163),
(2306, 'FillsSmall', '25', 165),
(2307, 'FillsMedium', '15', 165),
(2308, 'FillsLarge', '12', 165),
(2309, 'FillsSmall', '25', 169),
(2310, 'FillsMedium', '15', 169),
(2311, 'FillsLarge', '12', 169),
(2312, 'FillsSmall', '25', 164),
(2313, 'FillsMedium', '15', 164),
(2314, 'FillsLarge', '12', 164),
(2318, 'FillsSmall', '40', 166),
(2319, 'FillsMedium', '30', 166),
(2320, 'FillsLarge', '25', 166),
(2321, 'FillsSmall', '33', 181),
(2322, 'FillsMedium', '30', 181),
(2323, 'FillsLarge', '25', 181),
(2324, 'FillsSmall', '33', 182),
(2325, 'FillsMedium', '30', 182),
(2326, 'FillsLarge', '25', 182),
(2327, 'FillsSmall', '40', 183),
(2328, 'FillsMedium', '25', 183),
(2329, 'FillsLarge', '20', 183),
(2496, 'FillsSmall', '25', 233),
(2497, 'FillsMedium', '20', 233),
(2498, 'FillsLarge', '13', 233),
(2505, 'Size', 'W28 x D21 x H12 cm', 275),
(2506, 'Colour', 'Brown', 275),
(2507, 'Boxx_Size', 'Small', 275),
(2508, 'Size', 'W28 x D21 x H12 cm', 274),
(2509, 'Colour', 'Grey', 274),
(2510, 'Boxx_Size', 'Small', 274),
(2514, 'Size', 'W33 x D25 x H15 cm', 104),
(2515, 'Colour', 'White', 104),
(2516, 'Boxx_Size', 'Medium', 104),
(2517, 'Size', 'W33 x D25 x H15 cm', 277),
(2518, 'Colour', 'Brown', 277),
(2519, 'Boxx_Size', 'Medium', 277),
(2520, 'Size', 'W33 x D25 x H15 cm', 278),
(2521, 'Colour', 'Grey', 278),
(2522, 'Boxx_Size', 'Medium', 278),
(2523, 'Size', 'W33 x D25 x H15 cm', 276),
(2524, 'Colour', 'Black', 276),
(2525, 'Boxx_Size', 'Medium', 276),
(2526, 'Size', 'W36 x D29 x H18 cm', 106),
(2527, 'Colour ', 'White', 106),
(2528, 'Boxx_Size', 'Large', 106),
(2529, 'Size', 'W36 x D29 x H18 cm', 281),
(2530, 'Colour', 'Brown', 281),
(2531, 'Boxx_Size', 'Large', 281),
(2532, 'Size', 'W36 x D29 x H18 cm', 280),
(2533, 'Colour', 'Grey', 280),
(2534, 'Boxx_Size', 'Large', 280),
(2535, 'Size', 'W36 x D29 x H18 cm', 279),
(2536, 'Colour', 'Black', 279),
(2537, 'Boxx_Size', 'Large', 279),
(2538, 'Size', 'W28 x D21 x H12 cm', 91),
(2539, 'Colour', 'White', 91),
(2540, 'Boxx_Size', 'Small', 91),
(2541, 'Size', 'W28 x D21 x H12 cm', 273),
(2542, 'Colour', 'Black', 273),
(2543, 'Boxx_Size', 'Small', 273),
(2544, 'FillsSmall', '35', 256),
(2545, 'FillsMedium', '20', 256),
(2546, 'FillsLarge', '17', 256),
(2554, 'Prod 1', 'WHITE MEDIUM BOXX', 266),
(2555, 'Prod 2', 'LIMITED EDITION RED & GREEN FILLING', 266),
(2556, 'Prod 4', 'YANKEE CANDLE - CANDY CANE MEDIUM JAR ', 266),
(2557, 'Prod 5', 'PENGUIN CHRISTMAS MUG FILLED WITH 12 PEPPERMINT CANDY CANES', 266),
(2558, 'Prod 6', 'ELF PLUSH TOY 30cm', 266),
(2559, 'Prod 7', 'TERRY\'S ORANGE CHOCOLATE 157g', 266),
(2560, 'Prod 8 ', 'PANETTONE (ASSORTED FLAVOURS)', 266),
(2561, 'FillsSmall', '35', 155),
(2562, 'FillsMedium', '20', 155),
(2563, 'FillsLarge', '17', 155);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_type_id` int(11) DEFAULT '5',
  `token` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `password`, `first_name`, `last_name`, `email`, `user_type_id`, `token`, `status`, `is_deleted`, `created_at`, `last_login`) VALUES
(25, NULL, NULL, NULL, 'shivampanday.sp@gmail.com', 6, 'f1fd474933e800af69a66a62fa270902', 1, 0, '2021-11-30 05:16:53', NULL),
(26, NULL, NULL, NULL, 'shivampanday.sp@gmail.com', 6, 'a0eb8b10ab80d0a3d554573d731d8916', 1, 0, '2021-12-03 21:50:35', NULL),
(27, '$2y$10$lOepDFrI2mFgfxHi8vVgi.ETZM5YI9LwRCe9YPNYXdwf7gEI1ju1W', 'Shivam', 'Panday', 'shivampanday.sp@gmail.com', 5, '3a04d63f97062a1a095998fc0a307252', 1, 0, '2021-12-03 22:01:50', '2021-12-03 22:01:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT 'United Kingdom',
  `post_code` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `first_name`, `last_name`, `phone_number`, `address_line_1`, `city`, `country`, `post_code`, `is_deleted`, `created_at`) VALUES
(15, 25, 'Shivam', 'Panday', '07397996479', '103 Harpe Inge', 'Huddersfield', 'United Kingdom', 'HD5 9RA', 0, '2021-11-30 05:16:59'),
(16, 26, 'Raj', 'Sodha', '07548606680', '6, Slatewalk Way', 'Leicester', 'United Kingdom', 'LE3 8HU', 0, '2021-12-03 21:50:42'),
(17, 27, 'Raj', 'Sodha', '07548606680', '3 Ravensworth Close', 'Leicester', 'United Kingdom', 'LE5 1GH', 0, '2021-12-03 22:02:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `role`, `status`, `created_at`, `is_deleted`) VALUES
(1, 'Engineer', 1, '2021-08-02 15:41:48', 0),
(3, 'Admin', 1, '2021-08-02 21:33:05', 0),
(4, 'ReadOnly', 1, '2021-08-02 21:52:38', 0),
(5, 'Customer', 1, '2021-08-02 22:12:55', 0),
(6, 'Guest', 1, '2021-08-03 00:40:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `visitor_activity_logs`
--

CREATE TABLE `visitor_activity_logs` (
  `id` int(11) NOT NULL,
  `user_ip_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `page_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `referrer_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `count` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `visitor_activity_logs`
--

INSERT INTO `visitor_activity_logs` (`id`, `user_ip_address`, `user_agent`, `page_url`, `referrer_url`, `count`, `created_on`) VALUES
(632, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.55 Safari/537.36', 'https://test5.local:8890/', '/', 0, '2021-12-03 21:49:32'),
(633, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', 'https://test5.local:8890/', '/', 0, '2022-09-29 23:05:09'),
(634, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Mobile Safari/537.36', 'https://test5.local:8890/', '/', 0, '2022-09-29 23:05:46'),
(635, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Mobile Safari/537.36', 'https://test5.local:8890/', '/', 1, '2022-09-29 23:10:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_type_id` (`user_type_id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_messages`
--
ALTER TABLE `gift_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_to_category`
--
ALTER TABLE `products_to_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_properties`
--
ALTER TABLE `product_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_type_id` (`user_type_id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor_activity_logs`
--
ALTER TABLE `visitor_activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `gift_messages`
--
ALTER TABLE `gift_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;

--
-- AUTO_INCREMENT for table `products_to_category`
--
ALTER TABLE `products_to_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1284;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_properties`
--
ALTER TABLE `product_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2564;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `visitor_activity_logs`
--
ALTER TABLE `visitor_activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=636;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD CONSTRAINT `admin_user_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order_details` (`id`);

--
-- Constraints for table `products_to_category`
--
ALTER TABLE `products_to_category`
  ADD CONSTRAINT `products_to_category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `products_to_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`);

--
-- Constraints for table `product_properties`
--
ALTER TABLE `product_properties`
  ADD CONSTRAINT `product_properties_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`);

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
