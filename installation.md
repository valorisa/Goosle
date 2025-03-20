# Goosle

Goosle est un méta-moteur de recherche rapide et orienté confidentialité, conçu pour fournir des résultats de recherche pertinents sans traqueurs, publicités ou distractions inutiles. Il agrège les résultats de plusieurs moteurs de recherche (comme DuckDuckGo, Google, Qwant, etc.) et propose également des fonctionnalités de recherche d'images, d'actualités et de liens magnétiques.

## Fonctionnalités

- **Recherche Web** : Résultats provenant de DuckDuckGo, Google, Qwant, Brave et Wikipédia.
- **Recherche d'images** : Résultats provenant de Yahoo! Images, Qwant, Pixabay et Openverse.
- **Recherche d'actualités** : Actualités récentes via Qwant News, Yahoo! News, Brave et Hacker News.
- **Recherche de liens magnétiques** : Recherche sécurisée de torrents sur des sites populaires comme LimeTorrents, The Pirate Bay, YTS, etc.
- **Aucun traqueur ni cookie** : Goosle respecte votre vie privée.
- **Interface simple et rapide** : Conçu pour être facile à utiliser et léger.

## Installation

### Prérequis

- Un serveur web avec PHP 7.4 ou supérieur (Apache, Nginx, etc.).
- Accès à un terminal pour exécuter des commandes.

### Étapes d'installation

1. **Cloner le dépôt** :
   ```bash
   git clone https://github.com/valorisa/Goosle.git
   ```
   
2. **Configurer Goosle** :

Copiez le fichier ```config.default.php``` en ```config.php```:

```bash
cp config.default.php config.php
```

Modifiez ```config.php``` pour définir vos préférences (moteurs de recherche, clé d'accès, etc.).

Configurer le serveur web :
Pour Nginx, ajoutez un fichier de configuration comme suit :

```nginx
server {
    listen 80;
    server_name localhost;
    root /chemin/vers/Goosle;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

Pour Apache, assurez-vous que le module ```mod_rewrite``` est activé et renommez ```goosle.htaccess``` en ```.htaccess```.

Configurer PHP-FPM :
Assurez-vous que PHP-FPM est installé et configuré pour écouter sur 127.0.0.1:9000.

Accéder à Goosle :
Ouvrez votre navigateur à l'adresse http://localhost/ (ou l'URL de votre serveur).

Utilisation

Recherche Web : Entrez votre requête dans la barre de recherche et appuyez sur Entrée.

Recherche d'images : Cliquez sur l'onglet "Images" pour effectuer une recherche d'images.

Recherche d'actualités : Cliquez sur l'onglet "Actualités" pour voir les dernières actualités.

Recherche de liens magnétiques : Cliquez sur l'onglet "Magnets" pour rechercher des torrents.

Configuration avancée

Clé d'accès

Pour protéger votre instance Goosle, vous pouvez activer une clé d'accès dans config.php :

```php
'hash_auth' => 'on', // Active l'authentification par clé
'hash' => 'votre_clé_secrète', // Définissez votre clé secrète
```

Cache

Goosle prend en charge deux types de cache :

APCu : Pour une mise en cache en mémoire (recommandé si disponible).
Fichier : Pour une mise en cache sur le disque.
Configurez le cache dans config.php :

```php
'cache_type' => 'apcu', // ou 'file'
'cache_time' => 8, // Durée de conservation du cache en heures
```

Moteurs de recherche

Vous pouvez activer ou désactiver des moteurs de recherche dans config.php. Par exemple :

```php
'web' => array(
    'duckduckgo' => 'on',
    'google' => 'on',
    'qwant' => 'on',
    'brave' => 'on',
    'wikipedia' => 'on'
),
```

Contribuer

Les contributions sont les bienvenues ! Voici comment contribuer au projet :

Forker le dépôt : Cliquez sur "Fork" en haut à droite de la page du dépôt.
Cloner votre fork :

```bash
git clone https://github.com/votre-utilisateur/Goosle.git
```

Créer une branche :
```bash
git checkout -b votre-branche
```

Faire vos modifications : Ajoutez des fonctionnalités, corrigez des bugs, etc.
Pousser vos modifications :
```bash
git push origin votre-branche
```
Ouvrir une Pull Request : Rendez-vous sur GitHub et ouvrez une PR pour proposer vos modifications.

Licence

Goosle est distribué sous licence GPL-3.0. Vous êtes libre de l'utiliser, de le modifier et de le redistribuer selon les termes de cette licence.

Auteur

Arnan de Gans : Créateur original de Goosle.
valorisa : Mainteneur du fork.
Remerciements

Merci à tous les contributeurs qui ont aidé à améliorer Goosle.
Merci aux moteurs de recherche et API utilisés pour fournir des résultats de qualité.
Pour plus d'informations, consultez la documentation officielle.
