TP - Docker Avancé

Partie 1 - Dockerfile de l'Application (5 points)

Pour cette partie, j'ai choisi d'utiliser une application Symfony développée pendant le cours de Symfony. L'image Docker est créée avec succès et fonctionnelle.

Instructions
Assurez-vous d'avoir Docker installé sur votre machine.
Clonez ce dépôt sur votre système local.
Naviguez vers le répertoire contenant le Dockerfile.
bash
Copy code
cd chemin/vers/le/projet
Construisez l'image Docker en utilisant la commande suivante :
bash
Copy code
docker build -t tpnotedocker-www .
Votre image Docker est maintenant prête à être utilisée.
Partie 2 - Docker Compose (7 points)

Cette partie est partiellement fonctionnelle. Le conteneur Symfony et le conteneur de base de données se lancent, mais il y a des difficultés à établir une connexion avec PostgreSQL depuis Symfony.

Instructions
Assurez-vous d'avoir Docker Compose installé sur votre machine.
Naviguez vers le répertoire contenant le fichier docker-compose.yml.
bash
Copy code
cd chemin/vers/le/projet
Lancez les conteneurs en utilisant la commande suivante :
bash
Copy code
docker-compose up -d
Vérifiez les logs pour des erreurs potentielles.
bash
Copy code
docker-compose logs www_symfony
docker-compose logs postgresql_symfony
Assurez-vous que les conteneurs sont dans le même réseau Docker (rr-net).
Partie 3 - Déploiement avec Docker Swarm (6 points)

Malheureusement, cette partie n'a pas pu être réalisée dans le temps imparti. Cependant, vous pouvez explorer cette étape ultérieurement pour une compréhension plus approfondie du déploiement avec Docker Swarm.

À Faire
Mettez en place un cluster Docker Swarm.
Modifiez le fichier docker-compose.yml pour fonctionner avec Docker Swarm.
Déployez l'application avec Docker Swarm en utilisant la commande :
bash
Copy code
docker stack deploy -c docker-compose.yml nom_du_stack
Cela permettra de répartir l'application sur plusieurs nœuds du cluster Docker Swarm.
