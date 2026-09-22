# public/js

Contient le JavaScript côté navigateur.

## `app.js`
Gère le lecteur audio : lorsqu'un bouton `.play-button` est utilisé, le script récupère le fichier audio et les informations du morceau depuis les attributs `data-*`, puis met à jour le lecteur.

La recherche n'est pas déclenchée automatiquement par JavaScript : elle est soumise par le formulaire avec Entrée ou le bouton Filtrer.
