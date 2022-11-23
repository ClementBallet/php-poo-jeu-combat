# TP POO - Jeu de combat

<br>

> 🚀 Voici un TP qui mettra en pratique les bases de la POO vues jusqu’à présent.

# Conditions du projet

Ce projet se fera à 2 obligatoirement (voire 3 si l’on est en nombre impair).

Pour ce qui est de l’organisation de travail, je laisse ce choix à votre convenance (pair programming, chacun de son côté avec gestion d’un dépôt Git à plusieurs, etc…).

# Cahier des charges

Nous allons créer un jeu. Chaque visiteur pourra créer un personnage (pas de mot de passe requis pour faire simple) avec lequel il pourra attaquer d'autres personnages. Le personnage attaqué se verra infliger un certain nombre de dégâts.

Un personnage est défini selon plusieurs caractéristiques :

- Son nom (unique).
- Ses points de vie.
- Sa force d’attaque
- Ses points d’attaques

Comment définir ces données :

- Les points de vie d'un personnage sont compris entre 0 et 100
- Au début d’une partie, chaque personnage possède 100 de points de vie
- En début de partie, chaque personnage jète le dé à 6 faces et obtient un score de force. Celui qui a le plus haut score de force commence également la partie.
- Le jeu se joue au tour par tour, c’est-à-dire que les 2 personnages jouent à tour de rôle en lançant le dé
- A chaque tour, un personnage lance le dé à 6 faces. Le résultat du lancé est multiplié par le résultat de la force obtenu avant le commencement de la partie. La somme de cette opération devient le nombre de dégâts subit par l’adversaire.
- Une fois arrivé à 100 points de dégâts, le personnage est mort (on le supprimera alors de la BDD).
- Une fois que le jeu est lancé, l’utilisateur ne peut plus interagir avec le système, c’est le script PHP qui se charge de jouer et de lancer le dé. Il assistera donc, impuissant, à la survit ou à la mort de son personnage. `<rire type="démoniaque">`Mouahaha`</rire>`

# Notions utilisées

Voici une liste vous indiquant les points techniques que l'on va mettre en pratique avec ce TP :

- Les attributs et méthodes
- l'instanciation de classe
- les constantes de classe (éventuellement)
- tout ce qui touche à la connexion à un SGBDR et à la manipulation de données stockées en base de données

# Démarche à suivre

## Pré-conception

Avant de s’attaquer au cœur du script, il faut réfléchir à son organisation.

>❓ De quoi aura-t-on besoin ?

Puisque nous travaillerons avec des personnages, nous aurons besoin de les stocker pour qu'ils puissent durer dans le temps. L'utilisation d'une base de données sera donc indispensable.

Le principe de base du jeu étant simple, nous n'aurons qu'une table **personnages** qui aura différents champs. Pour les définir, il faut réfléchir à ce qui caractérise un personnage. 

Ainsi, nous connaissons déjà les champs de cette table que nous avons défini au début : **nom** et **points de vie** (la force d’attaque et les points d’attaque ne seront utilisés que lors d’une partie et il ne sera pas forcément utile de les persister). Et bien sûr, il ne faudra pas oublier le plus important, à savoir l'identifiant du personnage pour que chaque personnage puisse être retrouvé via un id unique.

On pourra donc créer une table dans une nouvelle base de données via PhpMyAdmin.

## Première étape : le personnage

Qui dit personnages dit **objets** `Personnage`.

Pour construire une classe, vous devez répondre à deux questions importantes qui vont vous permettre d'établir le plan de votre classe :

- Quelles seront les caractéristiques de mes objets ?
- Quelles seront les fonctionnalités de mes objets ?

Voici comment procéder. Nous allons dans un premier temps dresser la liste des caractéristiques du personnage pour ensuite se pencher sur ses fonctionnalités.

>💡 Pour mieux morceler le code et travailler plus proprement, il est demandé de traiter les données (c'est-à-dire l'exécution de requêtes permettant d'aller effectuer des opérations en BDD) **dans une autre classe**.<br>
On peut même imaginer une classe de connexion à la base de données avec l’instanciation de PDO et une autre classe qui va effectuer des actions (créer, lire, modifier et supprimer).

### Les caractéristiques du personnage

Comme on l’a précisé précédemment, les attributs de la classe pourront représenter un enregistrement présent en BDD (nom, points de vie), mais il faudra aussi rajouter la gestion des points de force et d’attaque.

Maintenant que nous avons déterminé les caractéristiques d'un objet `Personnage`, nous savons quels attributs (ou propriétés, c’est la même chose) placer dans notre classe. 

### Les fonctionnalités d'un personnage

Comme nous l'avons dit, pour obtenir les méthodes d'un objet, il faut se demander quelles seront les fonctionnalités de ces entités. Ici, **que pourra faire un personnage** ? Relisez les consignes du début et répondez clairement à cette question.

Un personnage doit pouvoir :

- **Attaquer** un autre personnage
- **Recevoir** des dégâts

À chaque fonctionnalité correspond une méthode. 

## Seconde étape : stockage en base de données

On cherche maintenant à pouvoir stocker nos personnages dans une base de données (cf TP sur la connexion à la base de données avec la POO). 

Au cas où certains seraient tentés de placer cette partie dans la classe `Personnage`, en POO, on va respecter au moins une règle fondamentale : **une classe, un rôle**.

La classe `Personnage` a pour rôle de **représenter** un personnage présent en BDD. Elle n'a en aucun cas pour rôle de les **gérer**. Cette gestion sera le rôle d'une autre classe.

On reprend notre réflexion de la même manière que pour la classe `Personnage` :

- Quelles seront les caractéristiques de cette classe ?
- Quelles seront ses fonctionnalités ?

### Les fonctionnalités de la classe en lien avec la BDD

On pourra :

- Créer un nouveau personnage
- Lire les informations d’un personnage
- Modifier un personnage
- Supprimer un personnage

Ces étapes peuvent être regroupées en 1 acronyme : le [CRUD](https://fr.wikipedia.org/wiki/CRUD) (Create, Read, Update, Delete). Ces 4 actions représentent les 4 opérations de base pour la persistance des données dans une base de données.

Mais on pourrait très bien ajouter dans notre classe quelques fonctionnalités qui pourront nous être utiles, telles que :

- Compter le nombre de personnages
- Récupérer une liste de plusieurs personnages
- Savoir si un personnage existe

## Troisième étape : création du dé

Créer une classe `De` qui permettra de gérer le lancement du dé. 

Il pourra comporter une propriété `faces` pour gérer le nombre de faces. Il sera de 6 faces de base mais on pourrait imaginer un dé à plus de faces pour une version ultérieure du jeu.

Une méthode permettra de lancé le dé. Cette méthode renverra un entier aléatoire de 1 à 6. 

## Quatrième étape : utilisation des classes

Maintenant, il suffit d’utiliser nos classes en les instanciant et en invoquant les méthodes souhaitées sur nos objets. Le but est de se mettre d'accord sur le déroulement du jeu.

Celui-ci se voulant simple, nous n'aurons besoin que d'un seul fichier. Commençons par le début : que doit afficher notre mini-jeu lorsqu'on ouvre la page `index.php` pour la première fois ? 

- Il doit afficher un formulaire nous demandant le nom du personnage qu'on veut créer ou utiliser.

Vient ensuite la partie traitement :

- Le joueur a cliqué sur un bouton **Créer ce personnage**. Le script devra créer un objet `Personnage` en passant au constructeur les informations demandées (le nom du personnage). Il faudra ensuite s'assurer que le personnage ait un nom valide et qu'il n'existe pas déjà. Après ces vérifications, l'enregistrement en BDD pourra se faire. Pour savoir si le nom du personnage est valide, implémenter une méthode `estValide()` par exemple qui retournera `true` ou  `false` suivant si le nom est valide ou pas. **Un nom est valide s'il n'est pas vide.**
- Le joueur a cliqué sur un bouton **Utiliser ce personnage**. Le script devra vérifier si le personnage existe bien en BDD. Si c'est le cas, on le récupère de la BDD. Sinon on peut afficher un petit message d’erreur.
- Afficher en haut de page le nombre de personnages créés
- Une fois que nous avons un personnage, afficher la liste des autres personnages créés avec leurs noms. Il devra être possible de cliquer sur le nom du personnage pour le combattre.
- Pour avoir des personnages déjà créés dans le jeu on pourra les instancier avec la classe `Personnage` avant le script du jeu, par exemple :
    - Saroumane
    - Sauron
    - Gollum
- Ensuite, lorsque que ces 2 étapes ont été faites par l’utilisateur (création/choix du personnage et choix de l’adversaire), on peut lancer le jeu : il se présente sous la forme d’une succession de phrases au tour par tour. Par exemple :
    - “Gimli possède 100 points de vie. Saroumane possède 100 points de vie.”
    - “Gimli lance le dé pour connaitre sa force, il fait 5. Saroumane lance le dé pour connaitre sa force, il fait 3. Gimli commence le combat car il a plus de force !”
    - “Gimli lance le dé, il fait 2. Saroumane subit 10 de dégâts, il possède 90 points de vie !”
    - “Saroumane lance le dé, il fait 4. Gimli subit 12 de dégâts, il possède 88 points de vie !”
    - Ainsi de suite, jusqu’à ce que l’un des 2 personnages meurt…

# Améliorations possibles

- Gestion d’un bouclier : à chaque lancé de dé au tour par tour, si le résultat est supérieur ou égal à 4 cela enclenche un bouclier qui réduit de moitié les dégâts subit par l’adversaire au tour suivant
- Gestion de combats à l’infini : si le personnage de l’utilisateur n’est pas mort à la fin de la partie, alors une nouvelle partie est commencée avec un autre adversaire, jusqu’à ce que mort s’en suive. On peut d’ailleurs imaginer que le joueur obtient une potion de guérison qui lui octroie un gain de 30 points de vie entre chaque parties.

![http://images-cdn.fantasyflightgames.com/filer_public/00/6e/006e18e0-cd00-4083-9ce6-42ead3f90f05/jme01_preview_1.jpg](http://images-cdn.fantasyflightgames.com/filer_public/00/6e/006e18e0-cd00-4083-9ce6-42ead3f90f05/jme01_preview_1.jpg)