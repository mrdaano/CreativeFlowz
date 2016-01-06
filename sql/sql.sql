-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Gegenereerd op: 06 jan 2016 om 14:14
-- Serverversie: 5.5.42
-- PHP-versie: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `parent` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `category`
--

INSERT INTO `category` (`id`, `name`, `parent`) VALUES
(4, 'Test', NULL),
(5, 'aap', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `country` varchar(200) NOT NULL,
  `cityname` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `customer`
--

CREATE TABLE `customer` (
  `user_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `street` varchar(300) NOT NULL,
  `zip` varchar(15) NOT NULL,
  `housenumber` int(11) NOT NULL,
  `addition` varchar(2) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `company_taxnumber` varchar(45) DEFAULT NULL,
  `company_name` varchar(300) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dia`
--

CREATE TABLE `dia` (
  `slideshow_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `domain`
--

CREATE TABLE `domain` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `url` varchar(300) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `domain`
--

INSERT INTO `domain` (`id`, `name`, `url`) VALUES
(1, 'test', 'test.nl');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `employee`
--

CREATE TABLE `employee` (
  `user_id` int(11) NOT NULL,
  `moderator` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `employee`
--

INSERT INTO `employee` (`user_id`, `moderator`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `general_settings`
--

CREATE TABLE `general_settings` (
  `name` varchar(45) NOT NULL,
  `value` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `name` varchar(300) DEFAULT NULL,
  `path` varchar(300) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `media`
--

INSERT INTO `media` (`id`, `name`, `path`) VALUES
(2, '8EK22FC.png', 'media/2016-01');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tax` int(11) NOT NULL DEFAULT '21'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order_line`
--

CREATE TABLE `order_line` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `page_management`
--

CREATE TABLE `page_management` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `domain_id` int(11) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `slideshow_id` int(11) DEFAULT NULL,
  `keyword` varchar(1000) DEFAULT NULL,
  `name` varchar(80) NOT NULL,
  `homepage` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `page_management`
--

INSERT INTO `page_management` (`id`, `title`, `content`, `domain_id`, `position`, `slideshow_id`, `keyword`, `name`, `homepage`) VALUES
(1, 'Home', '<p>Hoi, doei.</p>\r\n', 1, NULL, NULL, 'niksÂ§', 'Home', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `code` varchar(45) NOT NULL,
  `secondhand` tinyint(1) NOT NULL,
  `description` text NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `price` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `product`
--

INSERT INTO `product` (`id`, `name`, `code`, `secondhand`, `description`, `supplier_id`, `price`) VALUES
(2, 'Maak het warm', 'adbda876', 0, '										Inductiewarmer																	', 1, '8,93'),
(4, 'pinguin', '1234', 0, '123									', 1, '12');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(4, 4),
(4, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product_media`
--

CREATE TABLE `product_media` (
  `product_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `slideshow`
--

CREATE TABLE `slideshow` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `website` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `website`) VALUES
(1, 'daan', 'daank.daan');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(300) NOT NULL,
  `lastname` varchar(300) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(300) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `password`, `email`) VALUES
(1, 'admin', 'admin', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'admin@admin.nl');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_category_category1_idx` (`parent`);

--
-- Indexen voor tabel `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexen voor tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  ADD KEY `fk_customer_city1_idx` (`city_id`);

--
-- Indexen voor tabel `dia`
--
ALTER TABLE `dia`
  ADD PRIMARY KEY (`slideshow_id`,`media_id`),
  ADD KEY `fk_slideshow_line_media1_idx` (`media_id`);

--
-- Indexen voor tabel `domain`
--
ALTER TABLE `domain`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexen voor tabel `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id_UNIQUE` (`user_id`);

--
-- Indexen voor tabel `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `general_settingscol_UNIQUE` (`name`);

--
-- Indexen voor tabel `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexen voor tabel `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_users1_idx` (`user_id`);

--
-- Indexen voor tabel `order_line`
--
ALTER TABLE `order_line`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `fk_order_regel_products1_idx` (`product_id`);

--
-- Indexen voor tabel `page_management`
--
ALTER TABLE `page_management`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_page_management_domain1_idx` (`domain_id`),
  ADD KEY `fk_page_management_slideshow1_idx` (`slideshow_id`);

--
-- Indexen voor tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_products_supplier1_idx` (`supplier_id`);

--
-- Indexen voor tabel `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `fk_product_category_category1_idx` (`category_id`);

--
-- Indexen voor tabel `product_media`
--
ALTER TABLE `product_media`
  ADD PRIMARY KEY (`product_id`,`media_id`),
  ADD KEY `fk_product_media_media1_idx` (`media_id`);

--
-- Indexen voor tabel `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `fk_shoppingcart_products1_idx` (`product_id`);

--
-- Indexen voor tabel `slideshow`
--
ALTER TABLE `slideshow`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexen voor tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT voor een tabel `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `domain`
--
ALTER TABLE `domain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `page_management`
--
ALTER TABLE `page_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT voor een tabel `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk_category_category1` FOREIGN KEY (`parent`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_customer_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_customer_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `dia`
--
ALTER TABLE `dia`
  ADD CONSTRAINT `fk_slideshow_line_media1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_slideshow_line_slideshow1` FOREIGN KEY (`slideshow_id`) REFERENCES `slideshow` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `fk_employee_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_orders_users1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `order_line`
--
ALTER TABLE `order_line`
  ADD CONSTRAINT `fk_order_regel_orders1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_regel_products1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `page_management`
--
ALTER TABLE `page_management`
  ADD CONSTRAINT `fk_page_management_domain1` FOREIGN KEY (`domain_id`) REFERENCES `domain` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_page_management_slideshow1` FOREIGN KEY (`slideshow_id`) REFERENCES `slideshow` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_products_supplier1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `fk_product_category_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_category_products1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `product_media`
--
ALTER TABLE `product_media`
  ADD CONSTRAINT `fk_product_media_media1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_media_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD CONSTRAINT `fk_shoppingcart_products1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_shoppingcart_users1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
