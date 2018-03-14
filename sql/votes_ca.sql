SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE `votes_ca`;

CREATE TABLE `votes_ca` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `college` varchar(50) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `votes_ca`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `votes_ca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

INSERT INTO `votes_ca` (`nom`, `college`, `votes`) VALUES
('Blanc', "G1", 0),
('Blanc', "G2", 0),
('Blanc', "G3", 0),
('Blanc', "IE2", 0),
('Blanc', "IE34", 0),
('Blanc', "IE5", 0);