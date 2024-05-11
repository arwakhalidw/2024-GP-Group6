-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11 مايو 2024 الساعة 08:46
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adprediction`
--

-- --------------------------------------------------------

--
-- بنية الجدول `inquirer`
--

CREATE TABLE `inquirer` (
  `name` varchar(100) NOT NULL,
  `password` varchar(999) NOT NULL,
  `inquirerId` int(11) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `inquirer`
--

INSERT INTO `inquirer` (`name`, `password`, `inquirerId`, `email`) VALUES
('NEWINQ', '$2y$10$SOCbQlfHlftcLNnVJy/Gk.vFbEZPJKFv1g74SkFcNaVHOGxDfkHr2', 19, 'newinq@email.com'),
('atheer', '$2y$10$ZicuP5WKNj/qa.ML3jLrjudEAiqTxeVyUPg8fPO8Y8hN6OtlOUvai', 20, 'atheerinq@email.com'),
('atheer', '$2y$10$hMdUv4bTwJoiXJNcjce8c.88I/6iP/eid6NtLZKgaOE/eQDibK5/m', 21, 'atheer@gmail.com'),
('atheer', '$2y$10$FKC5EMm.JxzVv2SQSBJoluyoS20X6kXnsWKvFJ5uJCSEjbyhwIc3y', 22, 'atheer@hotmail.com'),
('atheer banafa', '$2y$10$/vBKvgqEI0CZ9hQ9twHhiOUjjL/EV.Tml0XuIsqSjCs//zo5RTCDa', 23, 'atheer1@outlook.com'),
('atheer', 'password', 24, 'email@email.com'),
('a', 'password', 25, 'a@gmail.com'),
('a a', 'Password1', 26, 'a@a.com'),
('Noura', 'Noura2030', 27, 'noura@gmail.com');

-- --------------------------------------------------------

--
-- بنية الجدول `patient`
--

CREATE TABLE `patient` (
  `PatientID` varchar(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `phoneNo` int(15) NOT NULL,
  `Age` int(11) NOT NULL,
  `Gender` varchar(7) NOT NULL,
  `physiologist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `patient`
--

INSERT INTO `patient` (`PatientID`, `FirstName`, `LastName`, `DOB`, `phoneNo`, `Age`, `Gender`, `physiologist`) VALUES
('0000000000', 'a', 'a', '1988-02-01', 0, 36, 'male', 33),
('1111111111', 'Ahmed', 'Ali', '1952-04-27', 0, 72, 'male', 33),
('2222222222', 'Khalid', 'Hasan', '1955-10-12', 0, 69, 'male', 34),
('2345333333', 'ss', 'aa', '1955-12-12', 123434567, 68, 'female', 33);

-- --------------------------------------------------------

--
-- بنية الجدول `physiologist`
--

CREATE TABLE `physiologist` (
  `name` varchar(100) NOT NULL,
  `password` varchar(999) NOT NULL,
  `physiologistId` int(11) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `physiologist`
--

INSERT INTO `physiologist` (`name`, `password`, `physiologistId`, `email`) VALUES
('a', '$2y$10$IqxhAenUfPBfXFi86KoL.e1JS1TV3BDiSbZZq4cIYglHJqvKGWVYK', 25, 'asdsad@aaa.com'),
('NEW', '$2y$10$2XiP./Tzmzvp3hJfqng3EedvPCR/2qRJf/1gxJDP2yOAOaM7AV4p.', 26, 'new@email.com'),
('aa aa', '$2y$10$U/.fZA/SSsW7JKDQFSN2Dusv8.LXe2/R.xHR24NpUtt2XSpCzi.7e', 27, 'newphys@email.com'),
('Neww', '$2y$10$LXAcfmlUZgcy8cniEEkFh.FYPV9DuS5emI3IZlgI85fnLJ.VQH5K6', 28, 'neww@email.com'),
('atheer', '$2y$10$ewAQiffLGEiw3FY7oGiKNORJ7DPIk02qOpWnVcCTBrvJbVoeV.Xbm', 29, 'atheer@email.com'),
('atheer', '$2y$10$P7Xo0dvdYSm4B8ZMq9YIZONsYFjQuJj.ccqMAzCP9pZL2nwKjaHES', 30, 'atheer@newemail.com'),
('atheer banafa', '$2y$10$CopAenrKRLgJd8R/N75Bs.wBkckkP4eowUTaFZJ6tWFd2sq4DwXCK', 31, 'atheerb@gmail.com'),
('atheer', '$2y$10$SHePCQfYInoFjkrhsFb/SO8cl5OqJxCJ7BynsFfvjz1KjJlyEdV/m', 32, 'atheer@outlook.com'),
('atheer', 'password', 33, 'atheernew@gmail.com'),
('atheer', 'pass', 34, 'atheerbb@gmail.com'),
('Atheer Banafa', 'Password1', 35, 'atheerbanafa@gmail.com'),
('Ahmad', 'Ahmad2030', 36, 'ahmad@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inquirer`
--
ALTER TABLE `inquirer`
  ADD PRIMARY KEY (`inquirerId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`PatientID`);

--
-- Indexes for table `physiologist`
--
ALTER TABLE `physiologist`
  ADD PRIMARY KEY (`physiologistId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inquirer`
--
ALTER TABLE `inquirer`
  MODIFY `inquirerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `physiologist`
--
ALTER TABLE `physiologist`
  MODIFY `physiologistId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
