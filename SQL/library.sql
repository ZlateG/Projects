-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2023 at 01:45 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `short_bio` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `first_name`, `last_name`, `short_bio`, `is_deleted`) VALUES
(1, 'Горан', 'Стефановски', 'Горан Стефановски е роден 1952 година во Битола, во театарско семејство, мајка – актерка, татко – актер и режисер. Детството и младоста ги помунува во театарот, а потоа му го посветува и целиот живот.', 0),
(2, 'Кирил', 'Пејчиновиќ', 'Пејчиновиќ е роден во тетовското село Теарце во 1771 година. Првите почетоци од неговото образование биле во селото Лешок, а потоа продолжил во Дебарскиот манастир \"Свети Јован Бигорски\". ', 0),
(13, 'Гјорги', 'Абаџиев', 'јанскиот имот од родителите кои потекнувале од благороднички семејства. Тој ја носел титулата гроф и живеел мирен, богат и спокоен живот. Речиси целиот живот го поминал на имотот во Јасна Полјана, освен четири', 0),
(14, 'Ернест ', 'Хемингвеј', 'Ернест е роден дома, на дворјанскиот имот од родителите кои потекнувале од благороднички семејства. Тој ја носел титулата гроф и живеел мирен, богат и спокоен живот. Речиси целиот живот го поминал на имотот во Јасна Полјана, освен четири год', 0),
(15, 'Јован', 'Јован', 'рјанскиот имот од родителите кои потекнувале од благороднички семејства. Тој ја носел титулата гроф и живеел мирен, богат и спокоен живот. Речиси целиот живот го поминал на имотот во Јасна Полјана, освен четири год', 0),
(16, 'Виктор', 'Иго', '	рјанскиот имот од родителите кои потекнувале од благороднички семејства. Тој ја носел титулата гроф и живеел мирен, богат и спокоен живот. Речиси целиот живот го поминал на имотот во Јасна Полјана, освен четири год', 0),
(24, 'Григор', 'Прличев', 'Григор Прличев е роден на 18 јануари 1830/31 година во Охрид, а починал на 6 февруари 1893 година. Татко му починал кога тој бил шестмесечно бебе, па грижата за семјството паднала врз мајка му.', 0),
(25, 'Петре', 'М. Андреевски', 'Дениција — збирка поезија на македонскиот писател Петре М. Андреевски од 1968 година. Истата година, збирката била наградена со наградите „11 Октомври“ и „Браќа Миладиновци“.[1]', 0),
(26, 'Стојан ', 'Тарапуза', 'Тарапуза е роден на 29 декември 1933 година во Злетово, Пробиштипско. Основното образование го завршил во родното место и во Штип, а потоа учел во средното техничко училиште и на Вишата педагошка академија во Скопје. Работел како новинар во Детска радост,', 0);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author_id` int(11) NOT NULL,
  `published_at` date NOT NULL,
  `no_of_pages` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author_id`, `published_at`, `no_of_pages`, `image_url`, `category_id`, `is_deleted`) VALUES
(2, 'Book Title', 1, '2012-08-21', 321, 'https://matica.com.mk/wp-content/uploads/2021/08/VIDOE-PODGOREC-BELOTO-CIGANCE-PROSV-DELO.jpg', 1, 0),
(3, 'Book Title2', 1, '2012-08-21', 321, 'https://matica.com.mk/wp-content/uploads/2021/08/GRIGOR-PRLICEV-SERDAROT-GALIKUM.jpg', 1, 0),
(4, 'Book Title3', 2, '2012-08-21', 321, 'https://matica.com.mk/wp-content/uploads/2021/08/KORNEJ-CUKOVSKI-DOKTOR-OFBOLI-PANILI.jpg', 1, 0),
(5, 'Book Title4', 16, '2012-08-21', 321, 'https://matica.com.mk/wp-content/uploads/2021/08/VIDOE-PODGOREC-BELOTO-CIGANCE-PROSV-DELO.jpg', 1, 0),
(22, 'Сердарот', 24, '1956-07-04', 234, 'https://kupikniga.mk/wp-content/uploads/2022/08/%D0%A1%D0%B5%D1%80%D0%B4%D0%B0%D1%80%D0%BE%D1%82-717x1024.jpg', 4, 0),
(23, 'Дениција', 25, '1984-09-07', 321, 'https://shop.kniga.mk/media/catalog/product/cache/b47a71ccc15b7cd2d27472f26a084c24/n/e/nebeska-timjanovna.png', 4, 0),
(24, 'Сон на тркала', 26, '2015-08-04', 112, 'https://kupikniga.mk/wp-content/uploads/2018/03/son.jpg', 4, 0),
(25, 'Огледало', 2, '1965-06-04', 324, 'https://eu-central-1.linodeobjects.com/media.mkd.mk/d2c2a2496d6b8418b94265b1ce5c64b9.jpg', 2, 0),
(26, 'Клетници', 16, '1976-09-07', 32, 'https://feniks.net.mk/image/cache/catalog/knigi/vrvovi/vrv5/103_Kletnici_F-520x550h.jpg', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `is_deleted`) VALUES
(1, 'Comedy', 0),
(2, 'drama', 0),
(4, 'Tragedija', 0),
(5, 'Criminal', 0),
(6, 'Horor', 0),
(8, 'Historical fictions', 0),
(10, 'Travel', 0),
(11, 'Politics', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comments_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `is_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comments_id`, `user_id`, `book_id`, `comment`, `is_approved`) VALUES
(10, 6, 2, '2 многу добра книга, би ја препорачал на секој да ја прочита', 1),
(12, 8, 4, '4 многу добра книга, би ја препорачал на секој да ја прочита', 1),
(14, 7, 3, '6 многу добра книга, би ја препорачал на секој да ја прочита', 1),
(16, 7, 2, '8 многу добра книга, би ја препорачал на секој да ја прочита', 1),
(19, 6, 3, 'da be da', 1),
(20, 6, 5, 'Доколку не сте ја прочитале книгата тогаш би било добро да ја прочитате', 1),
(21, 5, 5, 'Nemoze da ja imame novata aplikacija gotova na vreme', 1),
(23, 10, 4, 'Uste eden komentar za testiranje ', 1),
(24, 10, 5, 'komentar 3 za odobruvanje ', 1),
(25, 10, 3, 'komentar 4 za odobruvanje\n', 1),
(26, 10, 2, 'komentar 5 za odobruvanje\n', 1),
(28, 11, 3, 'http://localhost/02_project/second-project-brainster-library/public/currentbook.php?book_id=5', 1),
(29, 11, 5, 'http://localhost/02_project/second-project-brainster-library/public/currentbook.php?book_id=5', 1),
(30, 11, 4, 'http://localhost/02_project/second-project-brainster-library/public/currentbook.php?book_id=5', 1),
(32, 11, 2, 'http://localhost/02_project/second-project-brainster-library/public/currentbook.php?book_id=5', 1),
(68, 5, 2, 'fesfsef', 1),
(71, 5, 4, 'rwerwerwerwe', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`note_id`, `user_id`, `book_id`, `note`) VALUES
(6, 7, 4, '1 на 77 та страна има многу добра порака'),
(7, 7, 4, '2 на 77 та страна има многу добра порака'),
(8, 7, 4, '3 на 77 та страна има многу добра порака'),
(90, 6, 3, 'zlatko на 66 та страна има многу добра порака'),
(92, 6, 5, 'дали има нешто подобро што го опишува животот ?\n\n'),
(93, 10, 4, 'da bi da'),
(103, 5, 2, 'asefasef'),
(109, 5, 3, 'њеадањда');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `removed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`cart_id`, `user_id`, `book_id`, `quantity`, `removed`) VALUES
(3, 6, 2, 1, 1),
(4, 6, 3, 1, 1),
(5, 6, 4, 1, 1),
(8, 6, 3, 1, 1),
(9, 6, 2, 1, 1),
(12, 5, 3, 1, 1),
(13, 5, 4, 1, 1),
(14, 5, 5, 1, 1),
(16, 5, 3, 1, 1),
(17, 5, 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_uid` varchar(50) NOT NULL,
  `user_pwd` varchar(255) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_uid`, `user_pwd`, `user_email`, `is_admin`) VALUES
(5, 'tea', '$2y$10$BETet.zB1piY/DALkM0Oq.OvXJJl8bB5MCgb.KAw2UqE1m5cr.fjC', 'teodora_stefanovska@yahoo.com', 1),
(6, 'zlatko', '$2y$10$VIqiRJ/ETWPRfu57sR37AOJhxc6Q9TXXN1ul6PQ5VFWEicNplchy.', 'zlat3ko.gurmeshev@gmail.com', 0),
(7, 'pero', '$2y$10$B9MU5s/aWq1wpNxbHlWn.OMB1LMqgUNyyuclaTtLEM/YFAdvQjxBm', 'pero.nakov@hotmail.com', 0),
(8, 'petko', '$2y$10$GwU4dYuXqM6FzuyxwdO0R.663S47ZLKB6z0Tc0iQ./1BEk.C1p8Ja', 'petko@gmail.com', 0),
(9, 'stanko', '$2y$10$.tXXSranik4RwrQqaaSCxeJj5JymZFB2fi670.aotORDulWxp2FOO', 'stanko@gmail.com', 0),
(10, 'nikola', '$2y$10$sRXmPUw3Kmvfcaczq13HTu94iJI/70rBWKF8CbwhEUSviny3j0vHG', 'nikola@mail.com', 0),
(11, 'mila', '$2y$10$N1UtlqKuLS93Dt5VRutWouU9yGJr7rhSoN3m0HOUXGCxuOzjzTaSO', 'mila@mail.com', 0),
(12, 'kami', '$2y$10$xST.yo5ohjLAHSJX5gVHqeMGRVGZ/JsSJKF4B2svCcU1bhJkCYtGK', 'kami@gmail.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comments_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comments_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`author_id`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
