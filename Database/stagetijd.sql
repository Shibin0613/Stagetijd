-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 05 apr 2023 om 15:27
-- Serverversie: 10.4.27-MariaDB
-- PHP-versie: 8.1.12

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `koppeltakenwerkdag`
--

CREATE TABLE `koppeltakenwerkdag` (
  `taakId` int(11) NOT NULL,
  `werkdagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `koppelwerkdagopmerking`
--

CREATE TABLE `koppelwerkdagopmerking` (
  `werkdagId` int(11) NOT NULL,
  `opmerkingId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opmerkingen`
--

CREATE TABLE `opmerkingen` (
  `id` int(11) NOT NULL,
  `opmerking` text NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `stage`
--

INSERT INTO `stage` (`id`, `bedrijf`, `praktijkbegeleiderId`, `studentId`, `startdatum`, `einddatum`, `active`) VALUES
(3, 'kevin', 28, 27, '2023-04-15', '2023-04-30', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `taken`
--

CREATE TABLE `taken` (
  `id` int(11) NOT NULL,
  `taak` varchar(200) NOT NULL,
  `uur` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `activationcode` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `naam`, `email`, `wachtwoord`, `role`, `active`, `activationcode`) VALUES
(1, 'kevin', 'kevinka1239@gmail.com', 'Kevinka1', 1, 1, 0),
(21, 'Martijn', 'mn.graafsma@gmail.com', '', 1, 1, 64258),
(22, 'kevin', 'kevinka1239@gmail.com', '', 0, 0, 0),
(23, 'kevin', 'kevinka1239@gmail.com', '', 0, 0, 0),
(24, 'kevin', 'kevinka1239@gmail.com', '', 0, 0, 0),
(25, 'kevin', 'kevinka1239@gmail.com', '', 0, 0, 0),
(26, 'kevin', 'kevinka1239@gmail.com', '', 0, 0, 0),
(27, 'dinand', 'kevinka1239@gmail.com', '', 1, 0, 0),
(28, 'maarten', 'tim@gmail.com', '', 2, 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkdag`
--

CREATE TABLE `werkdag` (
  `id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `ziek` int(2) NOT NULL,
  `vrij` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexen voor geëxporteerde tabellen
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
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `logboek`
--
ALTER TABLE `logboek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `opmerkingen`
--
ALTER TABLE `opmerkingen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `stage`
--
ALTER TABLE `stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `taken`
--
ALTER TABLE `taken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT voor een tabel `werkdag`
--
ALTER TABLE `werkdag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
