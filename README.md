![Atom](https://raw.githubusercontent.com/gaelfoppolo/pierre-feuille-ciseaux-lezard-spock/master/vue/img/logo.png)

Le jeu Pierre Feuille Ciseaux Lézard Spock est un jeu non-coopératif fondamental, où deux joueurs s'affronte à l'aide de cinq « figures » que sont la pierre, la feuille, les ciseaux, le lézard et Spock et en suivant [quelques règles simples](http://pfcls.me/index.php?action=regles).

Notre site est disponibe à l'adresse **[pfcls.me](http://pfcls.me/)**.

Notre projet est sous licence **GNU GPLv3**, voir [LICENCE.md](https://raw.githubusercontent.com/gaelfoppolo/pierre-feuille-ciseaux-lezard-spock/master/LICENCE.md)

# Projet

Chaque personne a une façon particulière de jouer, adoptant un comportement et des stratégies qui lui sont propre. Partant de ce constat, les joueurs essaient de comprendre les séquences de coups de leur adversaire pour s'y opposer et trouver un modèle émergent. Notre projet s'inscrit dans cet optique, mais poussé à l'extrême en établissant des statistiques sur l'utilisation des différentes figures. Grâce à ces statistiques, notre IA élabore la meilleure stratégie de jeu pour chaque joueur afin de le battre de façon optimale à chaque coup.

Mais d'un point de vue plus général, nous nous intéressons à la découverte de motifs contextuels dans les séquences de coups de façon à mettre en lumière des corrélations cachées dans les données ou des tendances de jeu générales en fonctions du contexte. Nous avons définies deux paramètres contextuels : l'**âge** et le **sexe**. En partant de l'idée générale qu'un motif fréquent représente un comportement attendu, nous nous sommes posés les questions suivantes :

*Peut-on prévoir, à partir d'un motif fréquent et de données contextuelles, le prochain coup qui sera joué ?
Peut-on déduire, à partir d'un motif fréquent et de données contextuelles, une tendance de jeu ?*

**Pour en savoir sur le projet, le rapport complet est disponible sur [ce dépôt](https://github.com/gaelfoppolo/pfcls-rapport)**.

# Résultats

Nos résultats complets sont disponibles [ici.](http://pfcls.me/index.php?action=statistiques)

# Installation

## Exigences du système

- PHP
- MySQL

## Instructions

3. Importez le fichier `schema_bdd.sql` sur votre base de données SQL
4. Configurez le fichier `config/Config.php` avec vos paramètres
5. Uploadez les fichiers sur votre FTP
6. Enjoy !



