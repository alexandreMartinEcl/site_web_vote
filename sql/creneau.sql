SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE `creneau`;

CREATE TABLE `creneau` (
  `id` int(11) NOT NULL,
  `type` char(10) NOT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `heure_fin_login` time NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `creneau`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `creneau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `creneau` (`type`, `date`, `heure_debut`, `heure_fin`) VALUES
('ca', '2018-02-03', '00:00:00', '23:55:00'),
('event', '2018-02-10', '00:00:00', '23:55:00'),
('bdx', '2018-02-01', '16:00:00', '23:55:00');

