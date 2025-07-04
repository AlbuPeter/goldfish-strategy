-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Júl 04. 14:41
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `goldfish-strategy`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `coin` varchar(50) NOT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `avg_price` double NOT NULL DEFAULT 0,
  `last_update` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `portfolio`
--

INSERT INTO `portfolio` (`id`, `coin`, `amount`, `avg_price`, `last_update`) VALUES
(1, 'btc', 0, 0, '0000-00-00'),
(2, 'eth', 0, 0, '0000-00-00'),
(3, 'sol', 0, 0, '0000-00-00'),
(4, 'sui', 0, 0, '0000-00-00'),
(5, 'usdc', 0, 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `portfolio_history`
--

CREATE TABLE `portfolio_history` (
  `id` int(11) NOT NULL,
  `total_value` decimal(18,2) DEFAULT NULL,
  `recorded_at` datetime DEFAULT current_timestamp(),
  `invested` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `coin` varchar(10) NOT NULL,
  `amount` float NOT NULL,
  `price` float NOT NULL,
  `type` enum('buy','sell','usdc_add') NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', '123', '$2y$10$7/ggxsrTyvL/jCyFC6xp7uvp7J//6iHAmiMGaE3KhwMUwjNXhZMbO');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coin_unique` (`coin`);

--
-- A tábla indexei `portfolio_history`
--
ALTER TABLE `portfolio_history`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `portfolio_history`
--
ALTER TABLE `portfolio_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=323;

--
-- AUTO_INCREMENT a táblához `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
