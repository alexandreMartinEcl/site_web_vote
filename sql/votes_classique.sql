SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE `votes_bdx`;

CREATE TABLE `votes_bdx` (
  `id` int(11) NOT NULL,
  `nom_liste` varchar(50) NOT NULL,
  `nom_liste_1` int(11) NOT NULL DEFAULT '0',
  `nom_liste_2` int(11) NOT NULL DEFAULT '0',
  `blanc` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `votes_bdx`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `votes_bdx`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `votes_bdx` (`nom_liste`, `nom_liste_1`, `nom_liste_2`, `blanc`) VALUES
('Ton choix', 0, 0, 0);

