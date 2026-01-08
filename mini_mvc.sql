-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 08 jan. 2026 à 12:44
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mini_mvc`
--

-- --------------------------------------------------------

--
-- Structure de la table `historiqueachat`
--

CREATE TABLE `historiqueachat` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `panier_id` int(11) NOT NULL,
  `date_achat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `historiqueachat`
--

INSERT INTO `historiqueachat` (`id`, `date`, `utilisateur_id`, `panier_id`, `date_achat`) VALUES
(1, NULL, 9, 20, NULL),
(2, NULL, 9, 21, NULL),
(3, NULL, 9, 22, '2026-01-08 12:03:58'),
(4, NULL, 9, 23, '2026-01-08 12:10:43'),
(5, NULL, 9, 24, '2026-01-08 12:41:51');

-- --------------------------------------------------------

--
-- Structure de la table `ordinateurproduit`
--

CREATE TABLE `ordinateurproduit` (
  `id_ordinateur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `composants` text NOT NULL,
  `stock` int(11) NOT NULL,
  `url_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ordinateurproduit`
--

INSERT INTO `ordinateurproduit` (`id_ordinateur`, `nom`, `prix`, `description`, `composants`, `stock`, `url_img`) VALUES
(1, 'PC POUR LES PAUVRES', 799.99, 'PC pour les personnes à petit budget, parfait pour jouer à des jeux compétitifs en 1080p parfaitement et peux jouer au dernier triple AAA.', 'GPU : RTX 5060 8GB VRAM\r\nCPU : Ryzen 5 5600x\r\nCarte Mère : MSI B550 Gaming Plus Wifi6E\r\nRam : Corsair Vengeance 16GB DDR4\r\nSSD : 1to \r\n', 50, 'https://www.flowup.shop/web/image/product.product/7375/image_1024/PC%20Banger%20GEFORCE%20RTX%E2%84%A2%205060%20(16GB%20DDR4,%20SSD%20500Go%20M.2)?unique=1eb2b1e'),
(2, 'PC MID TIER', 1149.99, 'PC parfait pour jouer tout les jeux fluides en 1080p et même en 1440p ! ', 'GPU : RTX 5060 16GB VRAM \r\nCPU : Ryzen 5 9600x \r\nCarte Mère : MSI B850 Gaming Plus Wifi6E Ram : Corsair Vengeance 32GB DDR5 \r\nSSD : 1to\r\n', 10, 'https://www.flowup.shop/web/image/product.product/7402/image_1024/PC%20Savannah%20V2%20GeForce%20RTX%E2%84%A2%205060%20Ti%208GB%20%20(SSD%20500Go%20M.2)?unique=ae9c05a'),
(3, 'PC PREMIUM', 4999.99, 'PC de walide ', 'GPU : RTX 590 32GB VRAM \nCPU : Ultra 9 285K\nCarte Mère : MSI MPG Z890 Carbon WIFI DDR5\nRam : 64GB DDR5\nSSD : 1to\n', 3, 'https://www.flowup.shop/web/image/product.product/7277/image_1024/PC%20Touch%20Ultimate%20GEFORCE%20RTX%E2%84%A2%205090%20(Samsung%20990%20EVO%20Plus%202To)?unique=a14079e');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `utilisateur_id`, `produit_id`, `quantity`, `status`) VALUES
(17, 9, 2, 1, 'Abandon'),
(19, 9, 1, 1, 'Abandon'),
(20, 9, 1, 1, 'Payé'),
(21, 9, 2, 3, 'Payé'),
(22, 9, 2, 3, 'Confirmé'),
(23, 9, 1, 7, 'Confirmé'),
(24, 9, 3, 2, 'Confirmé');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `email`, `mdp`, `role`) VALUES
(9, 'Lam', 'lam@gmail.com', '$2y$10$Y2SUJEK9Nt058ql1DM0Yqu4LwNd2YEsRGll/hysanINsf9qESHI/e', 'Membre'),
(16, 'admin', 'admin@admin.com', '$2y$10$adBxyfa7WDb.ay0e8bXQZevXObTxi1lg/stOUOzqnMfYDukJ5MLcC', 'Admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `historiqueachat`
--
ALTER TABLE `historiqueachat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_panier_id` (`panier_id`),
  ADD KEY `fk_user_id_1` (`utilisateur_id`);

--
-- Index pour la table `ordinateurproduit`
--
ALTER TABLE `ordinateurproduit`
  ADD PRIMARY KEY (`id_ordinateur`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`utilisateur_id`),
  ADD KEY `fk_product_id` (`produit_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `historiqueachat`
--
ALTER TABLE `historiqueachat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `ordinateurproduit`
--
ALTER TABLE `ordinateurproduit`
  MODIFY `id_ordinateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `historiqueachat`
--
ALTER TABLE `historiqueachat`
  ADD CONSTRAINT `fk_panier_id` FOREIGN KEY (`panier_id`) REFERENCES `panier` (`id`),
  ADD CONSTRAINT `fk_user_id_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `panier` (`utilisateur_id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`produit_id`) REFERENCES `ordinateurproduit` (`id_ordinateur`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`utilisateur_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
