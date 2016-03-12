

--
-- Base de données :  `persuasion_game`
--

-- --------------------------------------------------------

--
-- Structure de la table `pp_arguments`
--

CREATE TABLE IF NOT EXISTS `pp_arguments` (
  `idArg` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  `idPartie` int(11) NOT NULL,
  `idJoueur` int(11) NOT NULL,
  `nbVote` int(11) NOT NULL,
  PRIMARY KEY (`idArg`),
  KEY `idPartie` (`idPartie`),
  KEY `idJoueur1` (`idJoueur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


-- --------------------------------------------------------

--
-- Structure de la table `pp_coter_sujet`
--

CREATE TABLE IF NOT EXISTS `pp_coter_sujet` (
  `idPartie` int(11) NOT NULL,
  `idJoueur` int(11) NOT NULL,
  `coter` int(11) NOT NULL,
  PRIMARY KEY (`idPartie`,`idJoueur`),
  KEY `pp_coter_sujet_fk_idJoueur` (`idJoueur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pp_joueurs`
--

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
  PRIMARY KEY (`idJoueur`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


-- --------------------------------------------------------

--
-- Structure de la table `pp_parties`
--

CREATE TABLE IF NOT EXISTS `pp_parties` (
  `idPartie` int(11) NOT NULL,
  `idSujet` int(11) NOT NULL,
  `nbArg` int(10) unsigned NOT NULL,
  `idJoueurGagnant` int(11) DEFAULT NULL,
  `idJoueurPerdant` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPartie`),
  UNIQUE KEY `idSujet` (`idSujet`),
  UNIQUE KEY `idJoueurPerdant` (`idJoueurPerdant`),
  KEY `idJoueurGagnant` (`idJoueurGagnant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pp_partie_en_attente`
--

CREATE TABLE IF NOT EXISTS `pp_partie_en_attente` (
  `idPartie_en_attente` int(11) NOT NULL AUTO_INCREMENT,
  `idJoueur` int(11) NOT NULL,
  `idSujet` int(11) NOT NULL,
  `coterSujet` varchar(10) NOT NULL,
  `enAttenteDeJoueur` varchar(3) NOT NULL DEFAULT 'OUI',
  `placeSpectateurRestant` int(4) NOT NULL,
  PRIMARY KEY (`idPartie_en_attente`),
  UNIQUE KEY `idJoueur` (`idJoueur`),
  KEY `idSujet` (`idSujet`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `pp_partie_temporaire`
--

CREATE TABLE IF NOT EXISTS `pp_partie_temporaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idSujet` int(11) NOT NULL,
  `joueur1` int(11) DEFAULT NULL,
  `joueur2` int(11) DEFAULT NULL,
  `tourJoueur1` varchar(3) NOT NULL,
  `tourJoueur2` varchar(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `joueur1` (`joueur1`),
  UNIQUE KEY `joueur2` (`joueur2`),
  UNIQUE KEY `joueur1_2` (`joueur1`,`joueur2`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=153 ;



-- --------------------------------------------------------

--
-- Structure de la table `pp_sujets`
--

CREATE TABLE IF NOT EXISTS `pp_sujets` (
  `idSujet` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `nomTheme` varchar(40) NOT NULL,
  PRIMARY KEY (`idSujet`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `pp_arguments`
--
ALTER TABLE `pp_arguments`
  ADD CONSTRAINT `fk_idPartie_pp_arguments` FOREIGN KEY (`idPartie`) REFERENCES `pp_parties` (`idPartie`) ON DELETE CASCADE,
  ADD CONSTRAINT `pp_arguments_ibfk_2` FOREIGN KEY (`idJoueur`) REFERENCES `pp_joueurs` (`idJoueur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pp_coter_sujet`
--
ALTER TABLE `pp_coter_sujet`
  ADD CONSTRAINT `pp_coter_sujet_fk_idJoueur` FOREIGN KEY (`idJoueur`) REFERENCES `pp_joueurs` (`idJoueur`) ON DELETE CASCADE,
  ADD CONSTRAINT `pp_coter_sujet_fk_idPartie` FOREIGN KEY (`idPartie`) REFERENCES `pp_parties` (`idPartie`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pp_parties`
--
ALTER TABLE `pp_parties`
  ADD CONSTRAINT `pp_parties_ibfk_3` FOREIGN KEY (`idJoueurGagnant`) REFERENCES `pp_joueurs` (`idJoueur`) ON DELETE CASCADE,
  ADD CONSTRAINT `pp_parties_ibfk_4` FOREIGN KEY (`idSujet`) REFERENCES `pp_sujets` (`idSujet`) ON DELETE CASCADE,
  ADD CONSTRAINT `pp_parties_ibfk_5` FOREIGN KEY (`idJoueurPerdant`) REFERENCES `pp_joueurs` (`idJoueur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pp_partie_en_attente`
--
ALTER TABLE `pp_partie_en_attente`
  ADD CONSTRAINT `pp_partie_en_attente_fk_idJoueur` FOREIGN KEY (`idJoueur`) REFERENCES `pp_joueurs` (`idJoueur`) ON DELETE CASCADE,
  ADD CONSTRAINT `pp_partie_en_attente_fk_idSujet` FOREIGN KEY (`idSujet`) REFERENCES `pp_sujets` (`idSujet`) ON DELETE CASCADE;

