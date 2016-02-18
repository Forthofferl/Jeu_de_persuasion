
DROP TABLE IF EXISTS `pp_joueurs`;
DROP TABLE IF EXISTS `pp_sujets`;
DROP TABLE IF EXISTS `pp_parties`;  
DROP TABLE IF EXISTS `pp_arguments`;

CREATE TABLE IF NOT EXISTS `pp_joueurs` (
  `idJoueur` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `sexe` char(1) NOT NULL,
  `age` int(10) unsigned NOT NULL,
  `nbV` int(10) unsigned NOT NULL,
  `nbD` int(10) unsigned NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `resetToken` varchar(255) DEFAULT NULL,
  `resetCompleted` varchar(3) DEFAULT 'Non',
  PRIMARY KEY (`idJoueur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `pp_sujets` (
  `idSujet` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `nomTheme` varchar(40) NOT NULL,
  PRIMARY KEY (`idSujet`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `pp_parties` (
  `idPartie` int(11) NOT NULL AUTO_INCREMENT,
  `idSujet` int(11) NOT NULL,
  `nbArg` int(10) unsigned NOT NULL,
  `idJoueurGagnant` int(11) DEFAULT NULL,
  `idJoueurPerdant` int(11) NOT NULL,
  PRIMARY KEY (`idPartie`),
  UNIQUE KEY `idSujet` (`idSujet`),
  UNIQUE KEY `idJoueurPerdant` (`idJoueurPerdant`),
  KEY `idJoueurGagnant` (`idJoueurGagnant`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

ALTER TABLE `pp_parties`
  ADD CONSTRAINT `pp_parties_ibfk_5` FOREIGN KEY (`idJoueurPerdant`) REFERENCES `pp_joueurs` (`idJoueur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pp_parties_ibfk_3` FOREIGN KEY (`idJoueurGagnant`) REFERENCES `pp_joueurs` (`idJoueur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pp_parties_ibfk_4` FOREIGN KEY (`idSujet`) REFERENCES `pp_sujets` (`idSujet`) ON DELETE CASCADE ON UPDATE CASCADE;
  
CREATE TABLE IF NOT EXISTS `pp_arguments` (
  `idArg` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  `idPartie` int(11) NOT NULL,
  `idJoueur1` int(11) NOT NULL,
  `nbVote` int(11) NOT NULL,
  PRIMARY KEY (`idArg`),
  KEY `idPartie` (`idPartie`),
  KEY `idJoueur1` (`idJoueur1`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

ALTER TABLE `pp_arguments`
  ADD CONSTRAINT `pp_arguments_ibfk_2` FOREIGN KEY (`idJoueur1`) REFERENCES `pp_joueurs` (`idJoueur`) ON DELETE CASCADE,
  ADD CONSTRAINT `pp_arguments_ibfk_1` FOREIGN KEY (`idPartie`) REFERENCES `pp_parties` (`idPartie`) ON DELETE CASCADE;

CREATE TABLE IF NOT EXISTS `pp_partie_en_attente` (
  `idPartie_en_attente` int(11) NOT NULL AUTO_INCREMENT,
  `idJoueur` int(11) NOT NULL,
  `idSujet` int(10) NOT NULL,
  PRIMARY KEY (`idPartie_en_attente`),
  UNIQUE KEY `idJoueur` (`idJoueur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

ALTER TABLE `pp_partie_en_attente`
  ADD CONSTRAINT `pp_partie_en_attente_ibfk_idJoueur` FOREIGN KEY (`idJoueur`) REFERENCES `pp_joueurs` (`idJoueur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pp_partie_en_attente_ibfk_idSujet` FOREIGN KEY (`idSujet`) REFERENCES `pp_sujets` (`idSujet`) ON DELETE CASCADE ON UPDATE CASCADE;



INSERT INTO `pp_joueurs` (`idJoueur`, `pseudo`, `sexe`, `age`, `nbV`, `nbD`, `pwd`, `email`, `active`, `resetToken`, `resetCompleted`) VALUES
(0, 'GLaDOS', 'N', 0, 3, 2, '', 'ia@pfcls.me', '', NULL, 'Non');