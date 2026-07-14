-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 14 juil. 2026 à 17:36
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdd_musicaly`
--

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `spotify_id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('track','album','artist') COLLATE utf8mb4_general_ci NOT NULL,
  `rating` int DEFAULT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `spotify_id`, `type`, `rating`, `comment`, `created_at`) VALUES
(11, 1, '4ptPIXEOOzLtwMC9UZ3ObG', 'track', 5, 'L\'une de mes musiques préférées et de très loin. Knights of Cydonia est un morceau à part, le genre de titre qui te transporte dès les premières secondes et ne te lâche plus. L\'ambiance western qui ouvre le morceau installe immédiatement un décor cinématographique, presque épique, avant que les guitares et la rythmique viennent tout bousculer.\r\nCe qui rend ce titre aussi unique, c\'est la complexité de sa structure. Là où beaucoup de morceaux se contentent d\'un couplet-refrain classique, Knights of Cydonia enchaîne les mouvements comme une véritable odyssée musicale. Les harmonies sont riches, les mélodies se superposent et s\'entremêlent sans jamais perdre en cohérence. Chaque passage amène quelque chose de nouveau tout en servant le morceau dans son ensemble.\r\nCôté paroles, le message de résistance et de liberté colle parfaitement à l\'énergie du morceau. Ce n\'est pas juste un texte posé sur une instru, c\'est une vraie symbiose entre le fond et la forme. Et quand le refrain final explose, tout prend son sens.\r\nC\'est le genre de musique qui rappelle pourquoi Muse est un groupe à part. Un chef-d\'œuvre.', '2026-07-14 19:16:41'),
(12, 5, '63T7DJ1AFDD6Bn8VzG6JE8', 'track', 5, 'Un classique absolu du rock, une musique vraiment poignante. Le sitar qui ouvre le morceau donne immédiatement une tension unique, presque hypnotique, et la voix de Jagger vient porter des paroles sombres chargées de douleur et de colère. Le rythme effréné ne laisse aucun répit, il accompagne parfaitement ce sentiment d\'urgence et de désespoir qui traverse tout le titre. C\'est brut, intense, et pourtant incroyablement maîtrisé, le genre de morceau qui reste gravé dès la première écoute.', '2026-07-14 19:29:00'),
(13, 6, '0d28khcov6AiegSCpG5TuT', 'track', 5, 'Un morceau génial porté par une ligne de basse inoubliable et le rire moqueur de De La Soul. Le contraste entre les couplets sombres et le refrain aérien crée une atmosphère unique, à la fois groovy et mélancolique. Du pur Gorillaz.', '2026-07-14 19:33:39');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'Letwale', '$2y$10$W/n1MltiUAWhOwFMvoPHi.458ZLmIcIgGLpFomOckQSribtiYE/SC', '2026-05-29 22:50:38'),
(6, 'Luxray', '$2y$10$PdGsgLQSmqzllBGSc1biHOvP7iSa/lTbUawSnmnFaIoa8rvikuKGG', '2026-07-14 19:30:42'),
(5, 'Pierrot', '$2y$10$DDQj0A3OgKSQ6lCdyJIXve./ycTBU2wnw9OuVn73nGfnk/qAw6Qy.', '2026-07-14 19:19:24');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
