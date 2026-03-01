## 🦕

| Nom         | Paquet--Kremer                                                                                                                                                                                                                   |
|-------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Prénom      | Robin                                                                                                                                                                                                                            |
| Classe      | BUT3GP3RA2                                                                                                                                                                                                                       |
| Vidéo       | [Video démonstration](https://youtu.be/OpfWDm1_i9A)                                                                                                                                                                              |
| Commentaire | Dans la vidéo login ne disparait pas après la connexion cela a était corrigé et je pense que lors de l'import du csv cela a pris l'ancien CSV que j'avais export, un détail mais qui aurait pu mettre en doute la fonctionnalité |

---

## Initialisation de votre IDE

### PHPStorm

1. Ouvrir le projet dans PHPStorm
2. Installer les extensions Twig et Symfony
    - Aller dans File > Settings > Plugins
    - Installer les extensions (Twig, EA Inspection, PHP Annotations, .env files support)

### Visual Studio Code

1. Ouvrir le projet dans Visual Studio Code
2. Installer les extensions pour PHP, Twig et Symfony
    - Aller dans l'onglet Extensions
    - Installer les extensions (whatwedo.twig, TheNouillet.symfony-vscode, DEVSENSE.phptools-vscode,
      bmewburn.vscode-intelephense-client, zobo.php-intellisense)

## Installation en local

1. Cloner le projet
    - sur windows installer docker et une distro Ubuntu puis cloner le projet dans `\\wsl.localhost\Ubuntu\home\{user}\{dossier personnalisé}`

> [!WARNING]
> Sur windows la navigation sera trop lente c'est pourquoi on favorise un clone directement dans wsl

2. Ouvrer le projet dans votre IDE
3. Ouvrer un terminal à la racine du projet
4. Lancer le docker-compose
```bash
docker compose up -d 
```
5. Entrer dans le terminal de docker
```bash
docker compose exec php bash
```
6. Installez le nécessaire pour terminer l'installation
```bash
composer install
php bin/console tailwind:build
php bin/console doctrine:migrations:migrate #yes
php bin/console doctrine:fixtures:load #yes
```
7. Vous pouvez accèder à l'application sur http://localhost/

> [!NOTE]
> Si vous n'arrivez pas à acceder à localhost vous avez peut-être un conflit sur le port 80

## Utilisation

- N'hésitez pas à consulter la documentation de Symfony pour plus d'informations sur l'utilisation du framework : https://symfony.com/doc/current/index.html

- Notez comment fonctionne votre projet dans le fichier README.md et mettez à jour ce fichier au fur et à mesure de l'avancement de votre projet pour aider les autres développeurs à comprendre comment fonctionne votre projet.

- Commande import .csv produit
    ```bash
    php bin/console app:import-products [<filename>] #default import_produits.csv
    ```
    tester rapidement en important le csv précédemment exporté
    ```bash
    php bin/console app:import-products products.csv
    ```
- Commande création client
    ```bash
    php bin/console app:create-customer
    ```
    La commande est intuitive les données sont demandé les une après les autres, la commande s'occupe de vérifier la validité des données saisies.

---

## Développer
### Tailwind
Pour pouvoir observer les changements que vous éffectuais en temps réel laissait tourner dans un terminal dédié la commande suivante :

```bash
php bin/console tailwind:build --watch
```

Vous pouvez fermer votre terminal après la session de développement

### Environnement de développement
#### Docker php/composer

On peut facilement utiliser cette commande docker pour monter un environnement de développement à la racine du projet avec php 8.4. Essentiel pour développé en Symfony 7.4

```bash
docker run -it --rm `
    -v "${PWD}:/workspace" `
    -w /workspace `
    -u root `
    --name symfony-dev `
    --entrypoint /bin/bash `
    fbraz3/php-composer:8.4 `
    -c "git config --global --add safe.directory /workspace && exec /bin/bash"
```


---

## Fonctionnalité implémentée
### Mise en place du projet
- clone d'un boilerplate
- ajout .env.local
- ajout Tailwind sans Webpack
- Entité avec le maker
  - User
  - Product
- Rôle
  - User
  - Admin
  - Manager
- Fixtures pour 3 utilisateurs aux roles différents
- Système d'authentification (pas de formulaire d'inscription comme optionnel)

### Gestion des utilisateurs
- CRUD User généré par le maker et personnalisé
- Voter généré par le maker et personnalisé
- Implémentation du voter en concordance avec les exigences

### Gestion des produits
- CRUD Product généré par le maker et personnalisé
- Voter généré par le maker et personnalisé
- Implémentation du voter en concordance avec les exigences
- Requête personnalisée pour trier les produits par prix décroissant, utilisez pour afficher la liste
- Fonctionnalité d'export CSV au clique d'un bouton dans un service
- Commande Symfony pour importer un CSV
- Implémentation d'un Multi-step form avec condition

### Gestion des clients
- Entité
- Ajout de validation sur les champs
- CRUD customer généré par le maker et personnalisé
- Voter généré par le maker et personnalisé
- Implémentation du voter en concordance avec les exigences
- Commande Symfony pour créer des utilisateurs

## TODO
- [x] passé le projet en Symfony 7.4 (trouver comment faire)
  - [x] exploité le pseudo code du Multi-step form pour valider la fonctionnalité
### Optionnel
- [ ] Améliorer la qualité du code
- [ ] Implémenter des tests
- [ ] Améliorer l'UI
- [ ] Ajouté un formulaire d'inscription
- [ ] Rendre la sidebar rétractable avec le bouton burger
