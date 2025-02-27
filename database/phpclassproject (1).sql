-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2025 at 06:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpclassproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ctid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ctid`, `name`, `image`) VALUES
(9, 'Mens', 'banner-02.jpg'),
(10, 'Womens', 'banner-01.jpg'),
(11, 'Accessories', 'banner-03.jpg'),
(12, 'Bags', 'banner-08.jpg'),
(13, 'Watches', 'banner-07.jpg'),
(14, 'Kids', 'banner-06.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `empid` int(11) NOT NULL,
  `empname` varchar(100) NOT NULL,
  `empemail` varchar(100) NOT NULL,
  `empphone` varchar(100) NOT NULL,
  `emppass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`empid`, `empname`, `empemail`, `empphone`, `emppass`) VALUES
(1, 'Jhon', 'jhon@gmail.com', '03033851771', '$2y$10$4Q3lobXnzEgR4lLsE7z0Uucr2XjONmEsmopm0P/bvTuSaq37BvLoe');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackid` int(11) NOT NULL,
  `feedbackemail` varchar(100) NOT NULL,
  `feedbackmsg` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedbackid`, `feedbackemail`, `feedbackmsg`) VALUES
(1, 'iamkhansharjeel@gmail.com', 'testing \r\n');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoiceid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `totalproductquantity` int(11) NOT NULL,
  `itemcount` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `order_type` varchar(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `order_numbers` varchar(50) NOT NULL,
  `invoicedate` date NOT NULL,
  `invoicetime` time NOT NULL,
  `userphone` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoiceid`, `username`, `useremail`, `totalproductquantity`, `itemcount`, `subtotal`, `order_type`, `payment_method`, `order_numbers`, `invoicedate`, `invoicetime`, `userphone`) VALUES
(4, 'user', 'user@gmail.com', 1, 1, 150, 'Pickup', 'Credit Card', '', '2025-02-27', '10:36:27', 2147483647),
(5, 'user', 'user@gmail.com', 2, 1, 3000, 'Home Delivery', 'Cheque', '1000002539015927', '2025-02-27', '10:48:33', 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `useremail` varchar(100) NOT NULL,
  `userphone` varchar(15) NOT NULL,
  `useraddress` varchar(200) NOT NULL,
  `username` varchar(50) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productprice` int(11) NOT NULL,
  `productquantity` int(11) NOT NULL,
  `productimage` varchar(200) NOT NULL,
  `producttotal` int(11) NOT NULL,
  `order_type` varchar(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `orderdate` date NOT NULL,
  `ordertime` time NOT NULL,
  `orderstatus` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderid`, `userid`, `useremail`, `userphone`, `useraddress`, `username`, `productname`, `productprice`, `productquantity`, `productimage`, `producttotal`, `order_type`, `payment_method`, `order_number`, `orderdate`, `ordertime`, `orderstatus`) VALUES
(5, 9, 'user@gmail.com', '03033851771', 'Korangi', 'user', 'Shirt', 200, 2, 'product-14.jpg', 400, '', '', '', '2025-02-27', '10:30:14', 'Pending'),
(6, 9, 'user@gmail.com', '03033851771', 'Korangi', 'user', 'School Bag', 150, 1, 'gallery-01.jpg', 150, 'Pickup', 'Credit Card', '', '2025-02-27', '10:36:27', 'Pending'),
(7, 9, 'user@gmail.com', '03033851771', 'Karachi', 'user', 'Cotton Suit', 1500, 2, 'product-02.jpg', 3000, 'Home Delivery', 'Cheque', '1000002539015927', '2025-02-27', '10:48:33', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `image` varchar(200) NOT NULL,
  `categoryid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `quantity`, `description`, `image`, `categoryid`) VALUES
(24, 'Lightweight Jacket', '58.79', '5', 'Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare feugiat.', 'product-detail-01.jpg', 9),
(25, 'Cotton Suit', '1500', '20', 'asasasasasas', 'product-02.jpg', 10),
(26, 'Smart Watch', '200', '200', 'sasasasasasa', 'product-06.jpg', 13),
(27, 'Belt', '15', '5', 'vcvcvcvcv', 'product-12.jpg', 11),
(28, 'School Bag', '150', '350', 'asasasasas', 'gallery-01.jpg', 12),
(29, 'Shirt', '200', '20', 'dsdsdsdsd', 'product-14.jpg', 14);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_phone` varchar(11) NOT NULL,
  `user_role_type` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_phone`, `user_role_type`) VALUES
(3, 'Sharjeel khan', 'Iamkhansharjeel@gmail.com', '$2y$10$c2w8U122Hbgxzv9IciOat.6VXATaihtW3HKRri2TGOsCjVp8qMFqm', '03033851771', 'user'),
(4, 'Hussnain', 'hussnian@gmail.com', '$2y$10$dXX1mdEAyun5Jv7MTGxyWOokg6AwVWAmQ.rD9Cd2.i.CvAgGAD3U6', '03093739770', 'user'),
(5, 'Touqeer', 'Touqeer@gmail.com', '$2y$10$X5xjmJJnHBfqtaH532lUruXs4AK3aKD4oSyRvfE4yzaPDDxIVKnW2', '03093739770', 'user'),
(7, 'ADMIN', 'admin@gmail.com', '$2y$10$CL2jhflfTxIhSBGevVy3MeWqa7fbcUeiw8f9KmAyca59sB0TrB50W', '03033851771', 'admin'),
(8, 'Jhon', 'jhon@gmail.com', '$2y$10$4Q3lobXnzEgR4lLsE7z0Uucr2XjONmEsmopm0P/bvTuSaq37BvLoe', '03033851771', 'employee'),
(9, 'user', 'user@gmail.com', '$2y$10$jIMe2.cTIG4z5JULv69/LeA5MRxxvZbGgdL/RF3LdI12.lZjYu9S2', '03033851771', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ctid`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`empid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoiceid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryid` (`categoryid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ctid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `empid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoiceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`categoryid`) REFERENCES `categories` (`ctid`),
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categoryid`) REFERENCES `categories` (`ctid`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`categoryid`) REFERENCES `categories` (`ctid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
