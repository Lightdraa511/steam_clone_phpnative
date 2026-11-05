-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jan 2024 pada 03.22
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `steam`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `game`
--

CREATE TABLE `game` (
  `game_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `picture` varchar(225) NOT NULL DEFAULT 'gambargame/default.png',
  `description` text NOT NULL,
  `release_date` date NOT NULL,
  `developer` varchar(50) NOT NULL,
  `publisher` varchar(50) NOT NULL,
  `genre` varchar(15) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `game`
--

INSERT INTO `game` (`game_id`, `name`, `picture`, `description`, `release_date`, `developer`, `publisher`, `genre`, `price`) VALUES
(1, 'Minecraft', 'gambargame/minecraft.png', 'Minecraft is a game made up of blocks, creatures, and community. Blocks can be used to reshape the world or build fantastical creations. Creatures can be battled or befriended, depending on your playstyle. Experience epic adventures solo or with friends, there’s no wrong way to play.\r\nUnless you’re digging straight down.', '2023-12-01', 'MOJANG', 'MOJANG', 'survival', 500000),
(2, 'PUBG: BATTLEGROUNDS', 'gambargame/pubg.png', 'Play PUBG: BATTLEGROUNDS for free. Land on strategic locations, loot weapons and supplies, and survive to become the last team standing across various, diverse Battlegrounds. Squad up and join the Battlegrounds for the original Battle Royale experience that only PUBG: BATTLEGROUNDS', '2017-12-21', 'KRAFTON, Inc.', 'KRAFTON, Inc.', 'fps', 0),
(3, 'CSGO 2', 'gambargame/csgo.png', 'For over two decades, Counter-Strike has offered an elite competitive experience, one shaped by millions of players from across the globe. And now the next chapter in the CS story is about to begin. This is Counter-Strike 2.', '2012-08-22', 'Valve', 'Valve', 'fps', 0),
(4, 'RESIDENT EVIL 4 REMAKE', 'gambargame/re4.png', 'Survival is just the beginning. Six years have passed since the biological disaster in Raccoon City. Leon S. Kennedy, one of the survivors, tracks the president\'s kidnapped daughter to a secluded European village, where there is something terribly wrong with the locals.', '2023-03-24', 'CAPCOM Co., Ltd.', 'CAPCOM Co., Ltd.', 'survival', 830999),
(5, 'HUMAN FALL FLAT', 'gambargame/humanfallflat.png', 'Human Fall Flat is a hilarious, light-hearted platformer set in floating dreamscapes that can be played solo or with up to 8 players online. Free new levels keep its vibrant community rewarded.', '2016-07-22', 'No Brakes Games', 'Curve Games', 'survival', 125999),
(6, 'ELDEN RING', 'gambargame/eldenring.png', 'THE NEW FANTASY ACTION RPG. Rise, Tarnished, and be guided by grace to brandish the power of the Elden Ring and become an Elden Lord in the Lands Between.', '2024-01-01', 'FromSoftware Inc.', 'FromSoftware Inc.', 'survival', 599000),
(7, 'THE FINALS', 'gambargame/capsule_616x353.jpg', 'Join THE FINALS, the world-famous, free-to-play, combat-centered game show! Fight alongside your teammates in virtual arenas that you can alter, exploit, and even destroy. Build your own playstyle in this first-person shooter to win escalating tournaments and lasting fame.', '2023-12-08', 'Embark Studios', 'Embark Studios', 'fps', 0),
(36, 'Grand Theft Auto V', 'gambargame/gtav.jpg', 'Grand Theft Auto V for PC offers players the option to explore the award-winning world of Los Santos and Blaine County in resolutions of up to 4k and beyond, as well as the chance to experience the game running at 60 frames per second.', '2015-04-14', 'Rockstar North', 'Rockstar Games', 'Action', 307500),
(37, 'EA SPORTS FC™ 24', 'gambargame/FC24_standardkeyart_16x9.jpg', 'EA SPORTS FC™ 24 welcomes you to The World’s Game: the most true-to-football experience ever with HyperMotionV, PlayStyles optimised by Opta, and an enhanced Frostbite™ Engine.', '2023-09-28', ' EA Canada & EA Romania', 'Electronic Arts', 'Sports', 759000),
(38, 'WWE 2K23 ', 'gambargame/header.jpg', 'WWE 2K23 is Even Stronger with expanded features, gorgeous graphics and a deep roster of WWE Superstars and Legends. 2K Showcase returns as an interactive sports documentary focusing on the 20-year career of John Cena and WarGames is finally here!', '2023-03-16', ' Visual Concepts', '2K', 'Sports', 649000),
(39, 'GOD OF WAR', 'gambargame/1god-of-war-ragnarok_169.png', 'GOW', '2024-01-23', 'GOW', 'GOW', 'action', 500000),
(40, 'baldur', 'gambargame/1BG.png', 'baldur', '2024-01-23', 'baldur', 'baldur', 'survival', 100000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `library`
--

CREATE TABLE `library` (
  `library_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `library`
--

INSERT INTO `library` (`library_id`, `user_id`, `game_id`) VALUES
(6, 11, 4),
(7, 11, 3),
(8, 11, 2),
(9, 12, 36),
(10, 12, 3),
(11, 12, 7),
(12, 12, 4),
(13, 12, 2),
(14, 12, 5),
(15, 11, 6),
(16, 11, 39),
(17, 11, 7),
(18, 11, 5),
(19, 12, 39);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `purchase_amount` decimal(10,2) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `user_id`, `game_id`, `purchase_amount`, `purchase_date`) VALUES
(24, 11, 4, '830999.00', '2024-01-12 17:50:42'),
(25, 11, 3, '0.00', '2024-01-12 23:42:55'),
(26, 11, 2, '0.00', '2024-01-12 23:43:10'),
(27, 12, 36, '307500.00', '2024-01-13 00:40:12'),
(28, 12, 3, '0.00', '2024-01-13 00:45:19'),
(29, 12, 7, '0.00', '2024-01-13 00:45:58'),
(30, 12, 4, '830999.00', '2024-01-13 00:46:45'),
(31, 12, 2, '0.00', '2024-01-13 00:49:26'),
(32, 12, 5, '125999.00', '2024-01-23 07:14:23'),
(33, 11, 6, '599000.00', '2024-01-23 07:16:02'),
(34, 11, 39, '500000.00', '2024-01-23 08:34:54'),
(35, 11, 7, '0.00', '2024-01-23 10:01:52'),
(36, 11, 5, '125999.00', '2024-01-23 10:03:01'),
(37, 12, 39, '500000.00', '2024-01-23 10:50:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `usertype` varchar(10) NOT NULL DEFAULT 'user',
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_user` varchar(225) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `photo_profile` varchar(225) NOT NULL DEFAULT 'gambaruser/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `usertype`, `username`, `email`, `password_user`, `fullname`, `photo_profile`) VALUES
(11, 'admin', 'Manager', 'dian@gmail.com', '$2y$10$wcahjqYrQZ0iGGjIOVd/QOx/E4gkoNymwWD4gRKDTWsp4rQhEPgbW', 'dianardiansah', 'gambaruser/yuta.jpg'),
(12, 'user', 'xx', 'xx@gmail.com', '$2y$10$niz85YSMlkcLWxjDzqI8Yu9L8Xm1VF2k8O7xPpEteLmTk80tX/4KC', 'xx', 'gambaruser/default.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`game_id`);

--
-- Indeks untuk tabel `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`library_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indeks untuk tabel `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `game`
--
ALTER TABLE `game`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `library`
--
ALTER TABLE `library`
  MODIFY `library_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `library`
--
ALTER TABLE `library`
  ADD CONSTRAINT `library_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `library_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`);

--
-- Ketidakleluasaan untuk tabel `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
