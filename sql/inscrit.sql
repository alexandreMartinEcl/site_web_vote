SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE `inscrit`;
CREATE TABLE `inscrit` (
  `id` varchar(7) NOT NULL,
  `id_cotisant` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `cursus` varchar(15) NOT NULL,
  `hebergement` varchar(60) NOT NULL,
  `mail` text NOT NULL,
  `date_naissance` date NOT NULL,
  `id_garant` int(11) NOT NULL,
  `alcool` varchar(4) DEFAULT 'avec',
  `sub_date` date NOT NULL,
  `sub_time` time NOT NULL,
  `a_paye` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `inscrit`
  ADD PRIMARY KEY (`id`);

INSERT INTO `inscrit` (`id_cotisant`, `nom`, `prenom`, `cursus`, `hebergement`, `mail`, `date_naissance`, `id_garant`, `alcool`, `sub_date`, `sub_time`) VALUES
( 0, 'un_nom', 'un_prenom', 'ING-G1', 'B211', 'un_prenom.un_nom@centrale.centralelille.fr', '1901-01-01', 0, 'avec', '2018-01-01', '12:00:00');

