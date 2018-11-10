-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 10 Lis 2018, 20:40
-- Wersja serwera: 10.1.36-MariaDB
-- Wersja PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `plax_crm`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dzialania`
--

CREATE TABLE `dzialania` (
  `id` int(99) NOT NULL,
  `rodzaj` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `czas` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dzialanie_uzytkownik_kontakt`
--

CREATE TABLE `dzialanie_uzytkownik_kontakt` (
  `id` int(99) NOT NULL,
  `id_kontakt` int(99) NOT NULL,
  `id_uzytkownik` int(99) NOT NULL,
  `id_dzialanie` int(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `firmy`
--

CREATE TABLE `firmy` (
  `id` int(99) NOT NULL,
  `nazwa` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kontakty`
--

CREATE TABLE `kontakty` (
  `id` int(99) NOT NULL,
  `imie` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `telefon` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `inne` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kontakt_firma`
--

CREATE TABLE `kontakt_firma` (
  `id` int(99) NOT NULL,
  `id_kontakt` int(99) NOT NULL,
  `id_firma` int(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notatka_uzytkownik`
--

CREATE TABLE `notatka_uzytkownik` (
  `id` int(99) NOT NULL,
  `id_notatka` int(99) NOT NULL,
  `id_uzytkownik` int(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notatki`
--

CREATE TABLE `notatki` (
  `id` int(99) NOT NULL,
  `tytul` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `rodzaj` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `czas` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `tresc` text COLLATE utf8_polish_ci NOT NULL,
  `foto` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `umowa_uzytkownik_kontakt`
--

CREATE TABLE `umowa_uzytkownik_kontakt` (
  `id` int(99) NOT NULL,
  `id_kontakt` int(99) NOT NULL,
  `id_uzytkownik` int(99) NOT NULL,
  `id_umowa` int(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `umowy`
--

CREATE TABLE `umowy` (
  `id` int(99) NOT NULL,
  `fotografia` blob NOT NULL,
  `czas` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(99) NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `imie` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` int(11) NOT NULL,
  `data_dodania` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `aktywny` tinyint(1) NOT NULL,
  `uprawnienia` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dzialania`
--
ALTER TABLE `dzialania`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `dzialanie_uzytkownik_kontakt`
--
ALTER TABLE `dzialanie_uzytkownik_kontakt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kontakt` (`id_kontakt`,`id_uzytkownik`,`id_dzialanie`),
  ADD KEY `id_dzialanie` (`id_dzialanie`),
  ADD KEY `id_uzytkownik` (`id_uzytkownik`);

--
-- Indeksy dla tabeli `firmy`
--
ALTER TABLE `firmy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `kontakty`
--
ALTER TABLE `kontakty`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `kontakt_firma`
--
ALTER TABLE `kontakt_firma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kontakt` (`id_kontakt`,`id_firma`),
  ADD KEY `id_firma` (`id_firma`);

--
-- Indeksy dla tabeli `notatka_uzytkownik`
--
ALTER TABLE `notatka_uzytkownik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_notatka` (`id_notatka`,`id_uzytkownik`),
  ADD KEY `id_uzytkownik` (`id_uzytkownik`);

--
-- Indeksy dla tabeli `notatki`
--
ALTER TABLE `notatki`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `umowa_uzytkownik_kontakt`
--
ALTER TABLE `umowa_uzytkownik_kontakt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kontakt` (`id_kontakt`,`id_uzytkownik`,`id_umowa`),
  ADD KEY `id_uzytkownik` (`id_uzytkownik`),
  ADD KEY `id_umowa` (`id_umowa`);

--
-- Indeksy dla tabeli `umowy`
--
ALTER TABLE `umowy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `dzialania`
--
ALTER TABLE `dzialania`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `dzialanie_uzytkownik_kontakt`
--
ALTER TABLE `dzialanie_uzytkownik_kontakt`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `firmy`
--
ALTER TABLE `firmy`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `kontakty`
--
ALTER TABLE `kontakty`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `kontakt_firma`
--
ALTER TABLE `kontakt_firma`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `notatka_uzytkownik`
--
ALTER TABLE `notatka_uzytkownik`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `notatki`
--
ALTER TABLE `notatki`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `umowa_uzytkownik_kontakt`
--
ALTER TABLE `umowa_uzytkownik_kontakt`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `umowy`
--
ALTER TABLE `umowy`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `dzialanie_uzytkownik_kontakt`
--
ALTER TABLE `dzialanie_uzytkownik_kontakt`
  ADD CONSTRAINT `dzialanie_uzytkownik_kontakt_ibfk_1` FOREIGN KEY (`id_kontakt`) REFERENCES `kontakty` (`id`),
  ADD CONSTRAINT `dzialanie_uzytkownik_kontakt_ibfk_2` FOREIGN KEY (`id_dzialanie`) REFERENCES `dzialania` (`id`),
  ADD CONSTRAINT `dzialanie_uzytkownik_kontakt_ibfk_3` FOREIGN KEY (`id_uzytkownik`) REFERENCES `uzytkownicy` (`id`);

--
-- Ograniczenia dla tabeli `kontakt_firma`
--
ALTER TABLE `kontakt_firma`
  ADD CONSTRAINT `kontakt_firma_ibfk_1` FOREIGN KEY (`id_firma`) REFERENCES `firmy` (`id`),
  ADD CONSTRAINT `kontakt_firma_ibfk_2` FOREIGN KEY (`id_kontakt`) REFERENCES `kontakty` (`id`);

--
-- Ograniczenia dla tabeli `notatka_uzytkownik`
--
ALTER TABLE `notatka_uzytkownik`
  ADD CONSTRAINT `notatka_uzytkownik_ibfk_1` FOREIGN KEY (`id_notatka`) REFERENCES `notatki` (`id`),
  ADD CONSTRAINT `notatka_uzytkownik_ibfk_2` FOREIGN KEY (`id_uzytkownik`) REFERENCES `uzytkownicy` (`id`);

--
-- Ograniczenia dla tabeli `umowa_uzytkownik_kontakt`
--
ALTER TABLE `umowa_uzytkownik_kontakt`
  ADD CONSTRAINT `umowa_uzytkownik_kontakt_ibfk_1` FOREIGN KEY (`id_uzytkownik`) REFERENCES `uzytkownicy` (`id`),
  ADD CONSTRAINT `umowa_uzytkownik_kontakt_ibfk_2` FOREIGN KEY (`id_umowa`) REFERENCES `umowy` (`id`),
  ADD CONSTRAINT `umowa_uzytkownik_kontakt_ibfk_3` FOREIGN KEY (`id_kontakt`) REFERENCES `kontakty` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
