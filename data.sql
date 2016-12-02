-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Pát 02. pro 2016, 22:11
-- Verze serveru: 5.7.11-log
-- Verze PHP: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `eva`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `kosik`
--

CREATE TABLE `kosik` (
  `id_session` varchar(50) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produkt` int(11) NOT NULL,
  `ks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `objednavka`
--

CREATE TABLE `objednavka` (
  `id_objednavka` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `cena_obj` int(11) NOT NULL,
  `jmeno` varchar(50) NOT NULL,
  `adresa` varchar(50) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `doprava` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `objednavka`
--

INSERT INTO `objednavka` (`id_objednavka`, `id_user`, `cena_obj`, `jmeno`, `adresa`, `telefon`, `email`, `doprava`) VALUES
(1, 0, 119, 'Eva Testová', 'U krbu, Praha', '739 524 926', 'waikeri@seznam.cz', 'osobni');

-- --------------------------------------------------------

--
-- Struktura tabulky `objednavka_polozka`
--

CREATE TABLE `objednavka_polozka` (
  `id_produkt` int(11) NOT NULL,
  `id_objednavka` int(11) NOT NULL,
  `cena` int(11) NOT NULL,
  `ks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `objednavka_polozka`
--

INSERT INTO `objednavka_polozka` (`id_produkt`, `id_objednavka`, `cena`, `ks`) VALUES
(1, 1, 119, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `produkty`
--

CREATE TABLE `produkty` (
  `id_produkt` int(11) NOT NULL,
  `nazev` text NOT NULL,
  `cena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `produkty`
--

INSERT INTO `produkty` (`id_produkt`, `nazev`, `cena`) VALUES
(1, 'ovecka', 119),
(2, 'opicka', 329),
(3, 'pejsek', 159);

-- --------------------------------------------------------

--
-- Struktura tabulky `slevy`
--

CREATE TABLE `slevy` (
  `typ_slevy` varchar(50) NOT NULL,
  `hodnota` varchar(50) DEFAULT NULL,
  `sleva` int(11) DEFAULT NULL,
  `ks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `slevy`
--

INSERT INTO `slevy` (`typ_slevy`, `hodnota`, `sleva`, `ks`) VALUES
('kupon15', NULL, 15, 10);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `jmeno` varchar(50) NOT NULL,
  `adresa` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id_user`, `jmeno`, `adresa`, `email`) VALUES
(59, 'Evicka', 'U krbu 1, Praha', 'eva.cernikova@seznam.cz');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `objednavka`
--
ALTER TABLE `objednavka`
  ADD PRIMARY KEY (`id_objednavka`);

--
-- Klíče pro tabulku `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id_produkt`);

--
-- Klíče pro tabulku `slevy`
--
ALTER TABLE `slevy`
  ADD PRIMARY KEY (`typ_slevy`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `objednavka`
--
ALTER TABLE `objednavka`
  MODIFY `id_objednavka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
