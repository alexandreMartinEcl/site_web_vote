SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE `votants`;
CREATE TABLE `votants` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `cursus` varchar(50) NOT NULL DEFAULT 'centrale',
  `college` varchar(50) NOT NULL DEFAULT 'centrale',
  `mail` text NOT NULL,
  `date_naissance` date NOT NULL DEFAULT '1901-01-01',
  `nfc_code` varchar(20) DEFAULT '',
  `mot_de_passe` varchar(10) DEFAULT NULL,
  `a_vote` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `votants`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `votants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


INSERT INTO `votants` (`nom`, `prenom`, `cursus`, `mail`, `date_naissance`) VALUES
( 'un_nom', 'un_prenom', 'ING-G1', 'un_prenom.un_nom@centrale.centralelille.fr', '1901-01-13');

