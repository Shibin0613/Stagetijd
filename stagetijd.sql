-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2023 at 03:32 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stagetijd`
--

-- --------------------------------------------------------

--
-- Table structure for table `koppeltakentags`
--

CREATE TABLE `koppeltakentags` (
  `takenId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `koppeltakenwerkdag`
--

CREATE TABLE `koppeltakenwerkdag` (
  `taakId` int(11) NOT NULL,
  `werkdagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `koppelwerkdagopmerking`
--

CREATE TABLE `koppelwerkdagopmerking` (
  `werkdagId` int(11) NOT NULL,
  `opmerkingId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logboek`
--

CREATE TABLE `logboek` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `weeknummer` int(11) NOT NULL,
  `maandagId` int(11) NOT NULL,
  `dinsdagId` int(11) NOT NULL,
  `woensdagId` int(11) NOT NULL,
  `donderdagId` int(11) NOT NULL,
  `vrijdagId` int(11) NOT NULL,
  `goedgekeurd` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `opmerkingen`
--

CREATE TABLE `opmerkingen` (
  `id` int(11) NOT NULL,
  `opmerking` text NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `stage`
--

CREATE TABLE `stage` (
  `id` int(11) NOT NULL,
  `bedrijf` varchar(50) NOT NULL,
  `praktijdbegeleiderId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `startdatum` date NOT NULL,
  `einddatum` date NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `taken`
--

CREATE TABLE `taken` (
  `id` int(11) NOT NULL,
  `taak` varchar(200) NOT NULL,
  `uur` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `wachtwoord` varchar(250) NOT NULL,
  `role` int(1) NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `werkdag`
--

CREATE TABLE `werkdag` (
  `id` int(11) NOT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `koppeltakentags`
--
ALTER TABLE `koppeltakentags`
  ADD KEY `TakenId` (`takenId`),
  ADD KEY `TagId` (`tagId`);

--
-- Indexes for table `koppeltakenwerkdag`
--
ALTER TABLE `koppeltakenwerkdag`
  ADD KEY `WerkdagId` (`werkdagId`),
  ADD KEY `TaakId` (`taakId`);

--
-- Indexes for table `koppelwerkdagopmerking`
--
ALTER TABLE `koppelwerkdagopmerking`
  ADD KEY `OpmerkingenId` (`opmerkingId`),
  ADD KEY `werkdagId` (`werkdagId`);

--
-- Indexes for table `logboek`
--
ALTER TABLE `logboek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Maandag` (`maandagId`),
  ADD KEY `Dinsdag` (`dinsdagId`),
  ADD KEY `Woensdag` (`woensdagId`),
  ADD KEY `Donderdag` (`donderdagId`),
  ADD KEY `Vrijdag` (`vrijdagId`),
  ADD KEY `StudentId` (`userId`);

--
-- Indexes for table `opmerkingen`
--
ALTER TABLE `opmerkingen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PraktijkbegeleiderDocent` (`userId`);

--
-- Indexes for table `stage`
--
ALTER TABLE `stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Praktijkbegeleider` (`praktijdbegeleiderId`),
  ADD KEY `student` (`studentId`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taken`
--
ALTER TABLE `taken`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `werkdag`
--
ALTER TABLE `werkdag`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logboek`
--
ALTER TABLE `logboek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opmerkingen`
--
ALTER TABLE `opmerkingen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stage`
--
ALTER TABLE `stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taken`
--
ALTER TABLE `taken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `werkdag`
--
ALTER TABLE `werkdag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `koppeltakentags`
--
ALTER TABLE `koppeltakentags`
  ADD CONSTRAINT `TagId` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`),
  ADD CONSTRAINT `TakenId` FOREIGN KEY (`takenId`) REFERENCES `taken` (`id`);

--
-- Constraints for table `koppeltakenwerkdag`
--
ALTER TABLE `koppeltakenwerkdag`
  ADD CONSTRAINT `TaakId` FOREIGN KEY (`taakId`) REFERENCES `taken` (`id`),
  ADD CONSTRAINT `WerkdagId` FOREIGN KEY (`werkdagId`) REFERENCES `werkdag` (`id`);

--
-- Constraints for table `koppelwerkdagopmerking`
--
ALTER TABLE `koppelwerkdagopmerking`
  ADD CONSTRAINT `OpmerkingenId` FOREIGN KEY (`opmerkingId`) REFERENCES `opmerkingen` (`id`),
  ADD CONSTRAINT `koppelwerkdagopmerking_ibfk_1` FOREIGN KEY (`werkdagId`) REFERENCES `werkdag` (`id`);

--
-- Constraints for table `logboek`
--
ALTER TABLE `logboek`
  ADD CONSTRAINT `Dinsdag` FOREIGN KEY (`dinsdagId`) REFERENCES `werkdag` (`id`),
  ADD CONSTRAINT `Donderdag` FOREIGN KEY (`donderdagId`) REFERENCES `werkdag` (`id`),
  ADD CONSTRAINT `Maandag` FOREIGN KEY (`maandagId`) REFERENCES `werkdag` (`id`),
  ADD CONSTRAINT `StudentId` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `Vrijdag` FOREIGN KEY (`vrijdagId`) REFERENCES `werkdag` (`id`),
  ADD CONSTRAINT `Woensdag` FOREIGN KEY (`woensdagId`) REFERENCES `werkdag` (`id`);

--
-- Constraints for table `opmerkingen`
--
ALTER TABLE `opmerkingen`
  ADD CONSTRAINT `PraktijkbegeleiderDocent` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `stage`
--
ALTER TABLE `stage`
  ADD CONSTRAINT `Praktijkbegeleider` FOREIGN KEY (`praktijdbegeleiderId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `student` FOREIGN KEY (`studentId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
