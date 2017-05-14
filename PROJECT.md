# FLAP

## Présentation

FLAP, acronyme de __Fait Le Avec des Potes__ est née du besoin pour nous d'avoir
une plateforme où l'on pourrait se retrouver avec des créateurs pour porter des projets
de manière collaborative.

Le but du site est donc de permettre à n'importe qui de rejoindre la plateforme et
de pouvoir y proposer un projet qu'il ou elle souhaiterai construire avec d'autres personnes.
Par exemple, une envie de créer un graffiti original, une cabane ou un projet scientifique.

De plus, même sans avoir de projet, il suffit de se balader avec une peu de
curiosité sur le site pour rapidement trouver un projet dans lequel on se sent de
s'impliquer.

Cela est possible grâce à l'interaction riche entre les utilisateurs. Pour chaque
projet, ils peuvent exprimer leur avis et soutenir un projet en l'aimant, ou au
contraire trouver qu'il peut être néfaste, et donc le désapprouver.

Un projet qui est particulièrement intéressant peut être rejoins. Pour cela, rien
de plus simple que cliquer sur un bouton.

Les projets sont triés en fonction de l'intérêt qui leur est porté, et en fonction
de leur anciennetée, ainsi, tout les projets peuvent avoir une chance égale.

Pour permettre à certaines perles de sortir du lot, des projets peuvent aussi être
mit en avant.


## Réalisation

La réalisation n'a pas été très compliqué une fois l'architecture bien mise en place,
sur un modèle MVC (respectée tant bien que mal.)
Ayant déjà pas mal d'expérience dans la conception de site web, je connaissait déjà
certaines techinques et les bases.
La gestion des images à été pour moi le plus difficile. Ça, et le fait d'avoir à faire
un site web full-stack seul.

## Technologies

Le choix des technologies à été simple, vu qu'imposé. Toutefois, plusieurs choix
ont été important. Tout d'abord, le fait de séparer la logique pure et l'accès
aux bases de données dans un fichier avec une majuscule, tel que Utilisateurs.php,
puis de s'occuper de l'affichage en tant que tel dans user.php. Il à aussi été décidé
de faire un routeur principal dans index.php, puis de tout gérer de là, au lieu
d'avoir le nom des fichiers apparaître dans l'URL. Cela permet de changer cette URL
à souhait pour des besoins de SEO ou d'organisation. L'ajout de sécurité est également
important.

Un peu de javascript à été ajouté pour pouvoir voter sur un projet sans quitter
la page, mais cela reste sommaire.

Le design à été décidé comme étant sommaire, s'approchant des normes de Material Design
utilisé par Google pour Android et sur le web.

Une classe externe servant à génerer des UUID à également été utilisée. Elle permet
d'avoir un identifiant unique pour chaque projet, utilisateur, ou tout autre donnée,
et donc ne pas avoir de doublons.


## Notes

Le projet à été pensé dès le début pour quelque chose de beaucoup plus ambitieux,
et deviendra bien plus que ce qu'il est en ce moment. Toutefois, le résultat actuel
permet d'apprécier les fonctionnalités les plus basiques, et reste satisfaisant.
