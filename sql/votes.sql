SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE `votes_bdx`;

CREATE TABLE `votes_bdx` (
  `id` int(11) NOT NULL,
  `nom_liste` varchar(50) NOT NULL,
  `a_rejeter` int(11) NOT NULL DEFAULT '0',
  `insuffisant` int(11) NOT NULL DEFAULT '0',
  `passable` int(11) NOT NULL DEFAULT '0',
  `assez_bien` int(11) NOT NULL DEFAULT '0',
  `bien` int(11) NOT NULL DEFAULT '0',
  `tres_bien` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `votes_bdx`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `votes_bdx`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `votes_bdx` (`nom_liste`, `a_rejeter`, `insuffisant`, `passable`, `assez_bien`, `bien`, `tres_bien`) VALUES
('nom_liste_1', 0, 0, 0, 0, 0, 0),
('nom_liste_2', 0, 0, 0, 0, 0, 0),
('nom_liste_3', 0, 0, 0, 0, 0, 0);

