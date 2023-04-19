-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 19 apr 2023 om 15:49
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.6

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
-- Tabelstructuur voor tabel `koppeltakentags`
--

CREATE TABLE `koppeltakentags` (
  `takenId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geÃ«xporteerd voor tabel `koppeltakentags`
--

INSERT INTO `koppeltakentags` (`takenId`, `tagId`) VALUES
(38, 1),
(39, 1),
(39, 2),
(42, 2),
(43, 2),
(44, 1),
(45, 1),
(46, 2),
(47, 2),
(47, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `koppeltakenwerkdag`
--

CREATE TABLE `koppeltakenwerkdag` (
  `taakId` int(11) NOT NULL,
  `werkdagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geÃ«xporteerd voor tabel `koppeltakenwerkdag`
--

INSERT INTO `koppeltakenwerkdag` (`taakId`, `werkdagId`) VALUES
(47, 35),
(38, 31),
(39, 31),
(42, 32),
(43, 33),
(44, 33),
(45, 33),
(46, 34);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `koppelwerkdagopmerking`
--

CREATE TABLE `koppelwerkdagopmerking` (
  `werkdagId` int(11) NOT NULL,
  `opmerkingId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `logboek`
--

CREATE TABLE `logboek` (
  `id` int(11) NOT NULL,
  `stageId` int(11) NOT NULL,
  `weeknummer` int(11) NOT NULL,
  `maandagId` int(11) NOT NULL,
  `dinsdagId` int(11) NOT NULL,
  `woensdagId` int(11) NOT NULL,
  `donderdagId` int(11) NOT NULL,
  `vrijdagId` int(11) NOT NULL,
  `goedgekeurd` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geÃ«xporteerd voor tabel `logboek`
--

INSERT INTO `logboek` (`id`, `stageId`, `weeknummer`, `maandagId`, `dinsdagId`, `woensdagId`, `donderdagId`, `vrijdagId`, `goedgekeurd`) VALUES
(2, 9, 15, 31, 32, 33, 34, 35, 0),
(20, 9, 16, 71, 72, 73, 74, 75, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opmerkingen`
--

CREATE TABLE `opmerkingen` (
  `id` int(11) NOT NULL,
  `opmerking` text NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `stage`
--

CREATE TABLE `stage` (
  `id` int(11) NOT NULL,
  `bedrijf` varchar(50) NOT NULL,
  `praktijkbegeleiderId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `startdatum` date NOT NULL,
  `einddatum` date NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geÃ«xporteerd voor tabel `stage`
--

INSERT INTO `stage` (`id`, `bedrijf`, `praktijkbegeleiderId`, `studentId`, `startdatum`, `einddatum`, `active`) VALUES
(9, 'jazeker', 50, 48, '2023-04-13', '2023-04-27', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geÃ«xporteerd voor tabel `tags`
--

INSERT INTO `tags` (`id`, `naam`, `userid`) VALUES
(1, 'Programmeren', 48),
(2, 'Schoolopdracht', 48);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `taken`
--

CREATE TABLE `taken` (
  `id` int(11) NOT NULL,
  `taak` varchar(200) NOT NULL,
  `uur` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geÃ«xporteerd voor tabel `taken`
--

INSERT INTO `taken` (`id`, `taak`, `uur`) VALUES
(38, 'Taak 1', 6),
(39, 'Taak 2', 5),
(42, 'Taak 3', 3),
(43, 'Taak 4', 4),
(44, 'Taak 5', 4),
(45, 'Taak 6', 4),
(46, 'Taak 7', 3),
(47, 'Taak 8', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `wachtwoord` varchar(250) NOT NULL,
  `role` int(1) NOT NULL,
  `active` int(1) NOT NULL,
  `activationcode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geÃ«xporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `naam`, `email`, `wachtwoord`, `role`, `active`, `activationcode`) VALUES
(1, 'kevin', 'kevinka1239@gmail.com', 'Kevinka1', 1, 1, '0'),
(48, 'Shibin', 'panshibin2000@gmail.com', '123456', 2, 1, '6437fcf5782ea'),
(50, 'Jelle', 'Jelle@gmail.com', 'Test123', 3, 1, '6437fdc797918check');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkdag`
--

CREATE TABLE `werkdag` (
  `id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `ziek` int(2) NOT NULL,
  `vrij` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geÃ«xporteerd voor tabel `werkdag`
--

INSERT INTO `werkdag` (`id`, `datum`, `ziek`, `vrij`) VALUES
(31, '2023-04-17', 0, 0),
(32, '2023-04-18', 0, 0),
(33, '2023-04-19', 0, 0),
(34, '2023-04-20', 0, 0),
(35, '2023-04-21', 0, 0),
(66, '2023-04-19', 0, 0),
(67, '2023-04-20', 0, 0),
(68, '2023-04-21', 0, 0),
(69, '2023-04-22', 0, 0),
(70, '2023-04-23', 0, 0),
(71, '2023-04-19', 0, 0),
(72, '2023-04-20', 0, 0),
(73, '2023-04-21', 0, 0),
(74, '2023-04-22', 0, 0),
(75, '2023-04-23', 0, 0);

--
-- Indexen voor geÃ«xporteerde tabellen
--

--
-- Indexen voor tabel `koppeltakentags`
--
ALTER TABLE `koppeltakentags`
  ADD KEY `TakenId` (`takenId`),
  ADD KEY `TagId` (`tagId`);

--
-- Indexen voor tabel `koppeltakenwerkdag`
--
ALTER TABLE `koppeltakenwerkdag`
  ADD KEY `WerkdagId` (`werkdagId`),
  ADD KEY `TaakId` (`taakId`);

--
-- Indexen voor tabel `koppelwerkdagopmerking`
--
ALTER TABLE `koppelwerkdagopmerking`
  ADD KEY `OpmerkingenId` (`opmerkingId`),
  ADD KEY `werkdagId` (`werkdagId`);

--
-- Indexen voor tabel `logboek`
--
ALTER TABLE `logboek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Maandag` (`maandagId`),
  ADD KEY `Dinsdag` (`dinsdagId`),
  ADD KEY `Woensdag` (`woensdagId`),
  ADD KEY `Donderdag` (`donderdagId`),
  ADD KEY `Vrijdag` (`vrijdagId`),
  ADD KEY `StudentId` (`stageId`);

--
-- Indexen voor tabel `opmerkingen`
--
ALTER TABLE `opmerkingen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PraktijkbegeleiderDocent` (`userId`);

--
-- Indexen voor tabel `stage`
--
ALTER TABLE `stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Praktijkbegeleider` (`praktijkbegeleiderId`),
  ADD KEY `student` (`studentId`);

--
-- Indexen voor tabel `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexen voor tabel `taken`
--
ALTER TABLE `taken`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `werkdag`
--
ALTER TABLE `werkdag`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geÃ«xporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `logboek`
--
ALTER TABLE `logboek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT voor een tabel `opmerkingen`
--
ALTER TABLE `opmerkingen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `stage`
--
ALTER TABLE `stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `taken`
--
ALTER TABLE `taken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT voor een tabel `werkdag`
--
ALTER TABLE `werkdag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Beperkingen voor geÃ«xporteerde tabellen
--

--
-- Beperkingen voor tabel `koppeltakentags`
--
ALTER TABLE `koppeltakentags`
  ADD CONSTRAINT `TagId` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`),
  ADD CONSTRAINT `TakenId` FOREIGN KEY (`takenId`) REFERENCES `taken` (`id`);

--
-- Beperkingen voor tabel `koppeltakenwerkdag`
--
ALTER TABLE `koppeltakenwerkdag`
  ADD CONSTRAINT `TaakId` FOREIGN KEY (`taakId`) REFERENCES `taken` (`id`),
  ADD CONSTRAINT `WerkdagId` FOREIGN KEY (`werkdagId`) REFERENCES `werkdag` (`id`);

--
-- Beperkingen voor tabel `koppelwerkdagopmerking`
--
ALTER TABLE `koppelwerkdagopmerking`
  ADD CONSTRAINT `OpmerkingenId` FOREIGN KEY (`opmerkingId`) REFERENCES `opmerkingen` (`id`),
  ADD CONSTRAINT `koppelwerkdagopmerking_ibfk_1` FOREIGN KEY (`werkdagId`) REFERENCES `werkdag` (`id`);

--
-- Beperkingen voor tabel `logboek`
--
ALTER TABLE `logboek`
  ADD CONSTRAINT `Dinsdag` FOREIGN KEY (`dinsdagId`) REFERENCES `werkdag` (`id`),
  ADD CONSTRAINT `Donderdag` FOREIGN KEY (`donderdagId`) REFERENCES `werkdag` (`id`),
  ADD CONSTRAINT `Maandag` FOREIGN KEY (`maandagId`) REFERENCES `werkdag` (`id`),
  ADD CONSTRAINT `StageId` FOREIGN KEY (`stageId`) REFERENCES `stage` (`id`),
  ADD CONSTRAINT `Vrijdag` FOREIGN KEY (`vrijdagId`) REFERENCES `werkdag` (`id`),
  ADD CONSTRAINT `Woensdag` FOREIGN KEY (`woensdagId`) REFERENCES `werkdag` (`id`);

--
-- Beperkingen voor tabel `opmerkingen`
--
ALTER TABLE `opmerkingen`
  ADD CONSTRAINT `PraktijkbegeleiderDocent` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Beperkingen voor tabel `stage`
--
ALTER TABLE `stage`
  ADD CONSTRAINT `Praktijkbegeleider` FOREIGN KEY (`praktijkbegeleiderId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `student` FOREIGN KEY (`studentId`) REFERENCES `users` (`id`);

--
-- Beperkingen voor tabel `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `userid` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
