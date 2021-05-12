# Test technique

## API de rendu de monnaie pour caisses automatiques

### Demande fonctionelle

On veut écrire un service web qui indique comment rendre la monnaie sur une somme.
Notre service est interrogé par des automates (par exemple, des caisses automatiques) 
chaque fois qu’ils ont une somme à rendre, afin de connaître le nombre de billets et pièces à rendre.
Les sommes sont toujours entières, sans centimes.
Notre service doit indiquer la monnaie optimale (par exemple, 1 billet de 10 au lieu de 5 pièces de 2).

Chaque automate a un nom de modèle, qui définit ses caractéristiques et notamment les billets et pièces auxquels il a accès.
Les modèles supportés actuellement sont :

- le modèle `mk1`, qui n'a accès qu'aux pièces de 1 ;
- le modèle `mk2`, qui n’a accès qu’aux billets de 10, billets de 5 et pièces de 2.

### Contrainte technique

On souhaite que notre application puisse être étendue facilement pour supporter d'autres modèles futurs avec des caractéristiques complètement différentes (par exemple, un automate dont le fonctionnement est décrit par une base de données, ou par une API externe...).

### Votre objectif

Vous devez écrire une API qui puisse être interrogée par les automates pour déterminer la monnaie à rendre.

1. Écrire deux classes `Mk1Calculator` et `Mk2Calculator` qui implémentent `AppBundle\Calculator\CalculatorInterface` 
   pour les modèles d'automates `mk1` et `mk2`.
   Les classes doivent passer les tests unitaires dans `tests/` (executés avec `vendor/bin/phpunit`).
   Ajouter un test `Mk2CalculatorTest::testGetChangeHard`.
1. Écrire une classe `CalculatorRegistry` qui implémente `AppBundle\Registry\CalculatorRegistryInterface`.
1. Écrire le controlleur en utilisant le service `CalculatorRegistry`. 
   Le controlleur doit passer le test fonctionnel dans `features/change.feature` (executé avec `vendor/bin/behat`).


### Pour réaliser ce test

Vous aurez besoin d'avoir _Git_ installé sur votre machine. Dans l'idéal, vous aurez aussi besoin de _Docker_ pour utiliser plus facilement le projet. Mais c'est optionnel.

* Utilisez ce dépôt git comme template pour créer votre propre copie publique (bouton "Use this template").
* Clonez votre dépôt git en local.
* A la racine du projet, copiez le fichier _.env.dist_ vers _.env_. Si besoin, remplacez les valeurs par défaut dans ce dernier.
* Le projet peut être installé avec `make install`.
* Vous n'avez pas besoin d'installer de librairies et dépendances supplémentaires.
* Vous pouvez utiliser les autres actions du fichier `Makefile` pour valider votre solution.

Quand vous avez terminé :
* Mettez à jour votre dépôt avec votre réponse au test dans la branche `master`.
* Envoyez-nous l'URL de votre dépôt. Pour des raisons de lisibilité, nous vous invitons à squash les commits de votre travail en un seul.

### Nos points d'attention

- L'exécution des tests : assurez-vous que le projet peut être installé et que les tests tournent.
- La justesse des algorithmes : le problème est peut-être plus complexe que ce que vous pensez.
- La couverture : vos tests doivent couvrir au mieux les différents cas de figure.
- La lisibilité du code : toujours important pour permettre les revues de code et la maintenance.
- La maîtrise de Symfony : il y a de nombreuses manières de répondre aux questions, mais certaines sont meilleures que d'autres.
