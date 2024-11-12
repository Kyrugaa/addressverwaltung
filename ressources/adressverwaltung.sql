-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 12. Nov 2024 um 08:29
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `adressverwaltung`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `house_number` varchar(10) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `addresses`
--

INSERT INTO `addresses` (`id`, `person_id`, `street`, `house_number`, `postal_code`, `city`) VALUES
(3, 4, 'Musterstrasse', '6', '6666', 'Niederurnen'),
(4, 5, 'Musteriusstrasse', '2', '8888', 'Ennenda'),
(6, 7, 'Lolhausen', '1', '3333', 'Jona'),
(7, 8, 'Musterstrasse', '2', '6666', 'Ennenda');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `persons`
--

CREATE TABLE `persons` (
  `id` int(11) NOT NULL,
  `salutation` varchar(50) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `homepage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `persons`
--

INSERT INTO `persons` (`id`, `salutation`, `firstname`, `lastname`, `email`, `mobile_number`, `phone_number`, `homepage`) VALUES
(4, 'Herr', 'Joel', 'Marti', 'joel.marti@wtl.ch', '0000000000', '0000000000', 'www.google.com'),
(5, 'Bitte wählen', 'Elia', 'Schudel', 'elia.schudel@wtl.ch', '1111111111', '1111111111', ''),
(7, 'Herr', 'Marco', 'Musolf', 'marco.musolf@wtl.ch', '2222222222', '2222222222', ''),
(8, 'Herr', 'sadfasdfa', 'fafddasf', 'joel.marti@wtl.ch', '0000000000', '0000000000', '');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indizes für die Tabelle `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `persons`
--
ALTER TABLE `persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
