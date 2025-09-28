# Guide de Déploiement - Smart School Management System

## 📋 Table des Matières
1. [Prérequis](#prérequis)
2. [Installation de PHP 8.4](#installation-de-php-84)
3. [Configuration d'Apache](#configuration-dapache)
4. [Configuration de MariaDB](#configuration-de-mariadb)
5. [Déploiement du Projet](#déploiement-du-projet)
6. [Configuration de l'Application](#configuration-de-lapplication)
7. [Sécurisation](#sécurisation)
8. [Optimisation](#optimisation)
9. [Maintenance](#maintenance)
10. [Troubleshooting](#troubleshooting)

---

## 🔧 Prérequis

### Informations Système
- **Serveur**: VPS Ubuntu (18.04+ recommandé)
- **Web Server**: Apache (déjà installé)
- **Base de Données**: MariaDB (déjà installé)
- **PHP**: Version 8.4 (à installer)
- **Framework**: CodeIgniter 3

### Accès Requis
- Accès SSH root ou sudo au serveur
- Nom de domaine (optionnel mais recommandé)
- Certificat SSL (Let's Encrypt recommandé)

---

## 🐘 Installation de PHP 8.4

### Étape 1: Mise à jour du système
```bash
sudo apt update && sudo apt upgrade -y
```

### Étape 2: Ajouter le repository PHP
```bash
# Installer les dépendances
sudo apt install -y software-properties-common ca-certificates lsb-release apt-transport-https

# Ajouter le repository Ondrej
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
```

### Étape 3: Installer PHP 8.4 et ses extensions
```bash
# Installation de PHP 8.4 et modules essentiels
sudo apt install -y php8.4 php8.4-fpm php8.4-cli php8.4-common php8.4-mysql \
    php8.4-zip php8.4-gd php8.4-mbstring php8.4-curl php8.4-xml \
    php8.4-bcmath php8.4-json php8.4-intl php8.4-readline \
    php8.4-imagick php8.4-dom php8.4-fileinfo

# Modules Apache pour PHP
sudo apt install -y libapache2-mod-php8.4
```

### Étape 4: Vérifier l'installation
```bash
php -v
# Doit afficher PHP 8.4.x
```

### Étape 5: Configuration PHP
```bash
# Éditer le fichier de configuration
sudo nano /etc/php/8.4/apache2/php.ini
```

**Modifications recommandées:**
```ini
# Augmenter les limites pour l'application scolaire
memory_limit = 256M
upload_max_filesize = 64M
post_max_size = 64M
max_execution_time = 300
max_input_vars = 3000

# Configuration timezone
date.timezone = Africa/Bamako

# Configuration pour la sécurité
expose_php = Off
display_errors = Off
log_errors = On
error_log = /var/log/php/error.log

# Configuration session
session.save_handler = files
session.save_path = /var/lib/php/sessions
session.gc_maxlifetime = 7200
```

### Étape 6: Créer le dossier de logs
```bash
sudo mkdir -p /var/log/php
sudo chown www-data:www-data /var/log/php
```

---

## 🌐 Configuration d'Apache

### Étape 1: Activer les modules nécessaires
```bash
sudo a2enmod rewrite
sudo a2enmod ssl
sudo a2enmod headers
sudo a2enmod deflate
sudo systemctl restart apache2
```

### Étape 2: Utiliser la configuration Apache existante

**Vous avez déjà un fichier de configuration préparé. Copiez-le sur le serveur :**

```bash
# Copier le fichier de configuration depuis votre projet local
sudo cp /home/mounkaila/PhpstormProjects/ecole/school.ptrniger.conf /etc/apache2/sites-available/

# Ou si vous transférez depuis une machine distante
scp /home/mounkaila/PhpstormProjects/ecole/school.ptrniger.conf user@votre-serveur:/tmp/
sudo mv /tmp/school.ptrniger.conf /etc/apache2/sites-available/
```

**Créer également la configuration HTTP (redirection vers HTTPS) :**
```bash
sudo nano /etc/apache2/sites-available/school.ptrniger-http.conf
```

```apache
<VirtualHost *:80>
    ServerName school.ptrniger.com
    DocumentRoot /var/www/ecole

    # Redirection permanente vers HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Logs temporaires
    ErrorLog ${APACHE_LOG_DIR}/school.ptrniger-http-error.log
    CustomLog ${APACHE_LOG_DIR}/school.ptrniger-http-access.log combined
</VirtualHost>
```

### Étape 3: Installer et configurer Let's Encrypt AVANT d'activer HTTPS

```bash
# Installer Certbot
sudo apt update
sudo apt install certbot python3-certbot-apache -y

# Activer d'abord la configuration HTTP
sudo a2ensite school.ptrniger-http.conf
sudo a2dissite 000-default.conf
sudo systemctl reload apache2

# Créer les certificats SSL pour school.ptrniger.com
sudo certbot --apache -d school.ptrniger.com

# Alternativement, pour créer manuellement les certificats :
sudo certbot certonly --apache -d school.ptrniger.com
```

### Étape 4: Activer la configuration HTTPS
```bash
# Une fois les certificats créés, activer la configuration HTTPS
sudo a2ensite school.ptrniger.conf
sudo systemctl reload apache2

# Vérifier que les certificats sont bien créés
sudo ls -la /etc/letsencrypt/live/school.ptrniger.com/

# Vérifier la configuration Apache
sudo apache2ctl configtest
```

### Étape 5: Configuration automatique du renouvellement SSL
```bash
# Tester le renouvellement
sudo certbot renew --dry-run

# Ajouter le renouvellement automatique au crontab
sudo crontab -e
# Ajouter cette ligne pour renouveler tous les jours à 2h30 :
# 30 2 * * * /usr/bin/certbot renew --quiet --post-hook "systemctl reload apache2"
```

---

## 🗃️ Configuration de MariaDB

### Étape 1: Sécuriser MariaDB
```bash
sudo mysql_secure_installation
```

**Réponses recommandées:**
- Enter current password: `[Entrée si pas de mot de passe]`
- Set root password: `Y` et définir un mot de passe fort
- Remove anonymous users: `Y`
- Disallow root login remotely: `Y`
- Remove test database: `Y`
- Reload privilege tables: `Y`

### Étape 2: Créer la base de données et l'utilisateur
```bash
sudo mysql -u root -p
```

```sql
-- Créer la base de données
CREATE DATABASE ecole CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Créer l'utilisateur dédié
CREATE USER 'ecole_user'@'localhost' IDENTIFIED BY 'MotDePasseSecurise123!';

-- Accorder tous les privilèges sur la base de données
GRANT ALL PRIVILEGES ON ecole.* TO 'ecole_user'@'localhost';

-- Appliquer les changements
FLUSH PRIVILEGES;

-- Vérifier
SHOW DATABASES;
EXIT;
```

### Étape 3: Optimiser MariaDB
```bash
sudo nano /etc/mysql/mariadb.conf.d/50-server.cnf
```

**Ajout des optimisations:**
```ini
[mysqld]
# Configuration pour applications web
innodb_buffer_pool_size = 256M
innodb_file_per_table = 1
innodb_flush_method = O_DIRECT
innodb_log_file_size = 64M

# Optimisation des connexions
max_connections = 100
wait_timeout = 600
interactive_timeout = 600

# Cache des requêtes
query_cache_type = 1
query_cache_size = 32M
query_cache_limit = 2M

# Configuration UTF8
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci
```

```bash
sudo systemctl restart mariadb
```

---

## 🚀 Déploiement du Projet

### Étape 1: Créer le répertoire web
```bash
sudo mkdir -p /var/www/ecole
sudo chown www-data:www-data /var/www/ecole
```

### Étape 2: Transférer les fichiers et la configuration Apache
**Option A: Via Git (recommandé)**
```bash
cd /var/www
sudo git clone https://github.com/votre-username/ecole.git
sudo chown -R www-data:www-data ecole/
```

**Option B: Via SCP/SFTP**
```bash
# Depuis votre machine locale - Transférer les fichiers du projet
scp -r /home/mounkaila/PhpstormProjects/ecole/* user@votre-serveur:/tmp/ecole-files/
sudo mv /tmp/ecole-files/* /var/www/ecole/

# Transférer spécifiquement le fichier de configuration Apache
scp /home/mounkaila/PhpstormProjects/ecole/school.ptrniger.conf user@votre-serveur:/tmp/
sudo mv /tmp/school.ptrniger.conf /etc/apache2/sites-available/
```

**Option C: Via rsync (recommandé pour les mises à jour)**
```bash
# Depuis votre machine locale
rsync -avz --exclude 'node_modules' --exclude '.git' --exclude '*.log' \
    /home/mounkaila/PhpstormProjects/ecole/ user@serveur:/var/www/ecole/

# Transférer la configuration Apache séparément
scp /home/mounkaila/PhpstormProjects/ecole/school.ptrniger.conf user@serveur:/tmp/
sudo mv /tmp/school.ptrniger.conf /etc/apache2/sites-available/
```

### Étape 3: Ajuster les permissions
```bash
sudo chown -R www-data:www-data /var/www/ecole/
sudo find /var/www/ecole/ -type f -exec chmod 644 {} \;
sudo find /var/www/ecole/ -type d -exec chmod 755 {} \;

# Permissions spéciales pour les dossiers d'upload
sudo chmod -R 775 /var/www/ecole/uploads/
sudo chmod -R 775 /var/www/ecole/application/logs/
sudo chmod -R 775 /var/www/ecole/application/cache/
```

### Étape 4: Configurer .htaccess
```bash
sudo nano /var/www/ecole/.htaccess
```

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]

# Sécurité
<Files "config.php">
    Require all denied
</Files>

<Files "database.php">
    Require all denied
</Files>

# Forcer HTTPS (si SSL configuré)
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Protection contre les attaques
<IfModule mod_headers.c>
    Header always set X-Frame-Options DENY
    Header always set X-Content-Type-Options nosniff
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
</IfModule>
```

---

## ⚙️ Configuration de l'Application

### Étape 1: Configuration de la base de données
```bash
sudo nano /var/www/ecole/application/config/database.php
```

**Configuration:**
```php
$db['default'] = array(
    'dsn'       => '',
    'hostname'  => 'localhost',
    'username'  => 'ecole_user',
    'password'  => 'MotDePasseSecurise123!',
    'database'  => 'ecole',
    'dbdriver'  => 'mysqli',
    'dbprefix'  => '',
    'pconnect'  => FALSE,
    'db_debug'  => FALSE, // FALSE en production
    'cache_on'  => FALSE,
    'cachedir'  => '',
    'char_set'  => 'utf8mb4',
    'dbcollat'  => 'utf8mb4_unicode_ci',
    'swap_pre'  => '',
    'encrypt'   => FALSE,
    'compress'  => FALSE,
    'stricton'  => FALSE,
    'failover'  => array(),
    'save_queries' => TRUE
);
```

### Étape 2: Configuration générale
```bash
sudo nano /var/www/ecole/application/config/config.php
```

**Modifications importantes:**
```php
// URL de base - Utiliser votre domaine
$config['base_url'] = 'https://school.ptrniger.com/';

// Environment de production
$config['environment'] = 'production';

// Sécurité
$config['encryption_key'] = 'votre-cle-de-cryptage-super-secrete-32-caracteres';

// Configuration des sessions
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ecole_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = '/var/lib/php/sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

// CSRF Protection
$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;

// Logs
$config['log_threshold'] = 1; // 0 = Disable, 1 = Error, 2 = Debug, 3 = Info, 4 = All
$config['log_path'] = '/var/log/ecole/';
```

### Étape 3: Créer le dossier de logs de l'application
```bash
sudo mkdir -p /var/log/ecole
sudo chown www-data:www-data /var/log/ecole
sudo chmod 755 /var/log/ecole
```

### Étape 4: Importer la base de données
```bash
# Si vous avez un dump SQL
mysql -u ecole_user -p ecole < votre-dump.sql

# Pour importer le fichier evalution.sql spécifiquement
mysql -u ecole_user -p ecole < /var/www/ecole/application/controllers/Asql/evalution.sql
```

---

## 🔒 Sécurisation

### Étape 1: Configuration du pare-feu UFW
```bash
sudo ufw enable
sudo ufw allow 22/tcp   # SSH
sudo ufw allow 80/tcp   # HTTP
sudo ufw allow 443/tcp  # HTTPS
sudo ufw status
```

### Étape 2: Vérification des certificats SSL (déjà configurés)

```bash
# Vérifier que les certificats sont actifs
sudo certbot certificates

# Vérifier l'expiration des certificats
sudo certbot renew --dry-run

# Tester HTTPS
curl -I https://school.ptrniger.com

# Vérifier la configuration SSL
openssl s_client -connect school.ptrniger.com:443 -servername school.ptrniger.com < /dev/null
```

**Si vous devez renouveler manuellement :**
```bash
# Renouveler les certificats
sudo certbot renew

# Recharger Apache après renouvellement
sudo systemctl reload apache2
```

### Étape 3: Configuration Fail2Ban
```bash
sudo apt install fail2ban -y

# Configuration pour Apache
sudo nano /etc/fail2ban/jail.local
```

```ini
[DEFAULT]
bantime = 3600
findtime = 600
maxretry = 5

[apache-auth]
enabled = true

[apache-badbots]
enabled = true

[apache-noscript]
enabled = true

[apache-overflows]
enabled = true

[ssh]
enabled = true
port = ssh
filter = sshd
logpath = /var/log/auth.log
maxretry = 3
```

```bash
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### Étape 4: Renforcement des permissions
```bash
# Interdire l'exécution de PHP dans uploads
sudo nano /var/www/ecole/uploads/.htaccess
```

```apache
<Files "*.php">
    Require all denied
</Files>
```

---

## ⚡ Optimisation

### Étape 1: Configuration du cache Apache
```bash
sudo a2enmod expires
sudo a2enmod headers
sudo systemctl restart apache2
```

### Étape 2: Optimisation PHP OPcache
```bash
sudo nano /etc/php/8.4/apache2/conf.d/10-opcache.ini
```

```ini
; Configuration OPcache pour production
opcache.enable=1
opcache.enable_cli=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.max_wasted_percentage=5
opcache.use_cwd=1
opcache.validate_timestamps=1
opcache.revalidate_freq=2
opcache.save_comments=1
```

### Étape 3: Optimisation système
```bash
# Configuration logrotate pour les logs
sudo nano /etc/logrotate.d/ecole
```

```
/var/log/ecole/*.log {
    daily
    missingok
    rotate 52
    compress
    delaycompress
    notifempty
    create 644 www-data www-data
}
```

### Étape 4: Monitoring de base
```bash
# Installation de htop pour le monitoring
sudo apt install htop iotop -y

# Script de monitoring simple
sudo nano /usr/local/bin/check-ecole.sh
```

```bash
#!/bin/bash
# Script de vérification de l'application
STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost)
if [ $STATUS -ne 200 ]; then
    echo "$(date): Application down - HTTP $STATUS" >> /var/log/ecole/monitoring.log
    # Redémarrer Apache si nécessaire
    sudo systemctl restart apache2
fi
```

```bash
sudo chmod +x /usr/local/bin/check-ecole.sh

# Ajouter au crontab
echo "*/5 * * * * /usr/local/bin/check-ecole.sh" | sudo tee -a /etc/crontab
```

---

## 🔧 Maintenance

### Sauvegarde automatique
```bash
sudo nano /usr/local/bin/backup-ecole.sh
```

```bash
#!/bin/bash
BACKUP_DIR="/backup/ecole"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="ecole"
DB_USER="ecole_user"
DB_PASS="MotDePasseSecurise123!"

# Créer le dossier de sauvegarde
mkdir -p $BACKUP_DIR

# Sauvegarde de la base de données
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Sauvegarde des fichiers
tar -czf $BACKUP_DIR/files_$DATE.tar.gz -C /var/www ecole --exclude='ecole/application/logs/*'

# Nettoyer les anciennes sauvegardes (garder 30 jours)
find $BACKUP_DIR -name "*.gz" -mtime +30 -delete

echo "Backup completed: $DATE"
```

```bash
sudo chmod +x /usr/local/bin/backup-ecole.sh

# Programmer la sauvegarde quotidienne à 2h du matin
echo "0 2 * * * /usr/local/bin/backup-ecole.sh" | sudo tee -a /etc/crontab
```

### Mise à jour du système
```bash
# Script de mise à jour automatique
sudo nano /usr/local/bin/update-system.sh
```

```bash
#!/bin/bash
apt update
apt upgrade -y
apt autoremove -y
systemctl restart apache2
systemctl restart mariadb
```

---

## 🔍 Troubleshooting

### Commandes de diagnostic
```bash
# Vérifier les logs Apache
sudo tail -f /var/log/apache2/ecole_error.log

# Vérifier les logs PHP
sudo tail -f /var/log/php/error.log

# Vérifier les logs de l'application
sudo tail -f /var/log/ecole/log-$(date +%Y-%m-%d).php

# Vérifier le statut des services
sudo systemctl status apache2
sudo systemctl status mariadb

# Tester la configuration Apache
sudo apache2ctl configtest

# Vérifier les permissions
ls -la /var/www/ecole/

# Tester la connectivité base de données
mysql -u ecole_user -p ecole -e "SELECT 1;"
```

### Problèmes courants

**1. Erreur 500 - Internal Server Error**
```bash
# Vérifier les logs
sudo tail -f /var/log/apache2/ecole_error.log

# Vérifier les permissions
sudo chown -R www-data:www-data /var/www/ecole/
```

**2. Base de données non accessible**
```bash
# Vérifier MariaDB
sudo systemctl status mariadb

# Tester la connexion
mysql -u ecole_user -p
```

**3. Problèmes de performance**
```bash
# Vérifier l'utilisation des ressources
htop
iotop

# Analyser les logs de requêtes lentes
sudo nano /etc/mysql/mariadb.conf.d/50-server.cnf
# Ajouter: slow_query_log = 1
```

---

## ✅ Checklist de Déploiement

### Configuration Système
- [ ] PHP 8.4 installé et configuré
- [ ] Apache configuré avec modules nécessaires
- [ ] MariaDB sécurisé et optimisé
- [ ] Pare-feu UFW configuré (ports 22, 80, 443)

### Configuration du Projet
- [ ] Base de données `ecole` créée
- [ ] Utilisateur `ecole_user` configuré avec permissions
- [ ] Fichiers du projet transférés dans `/var/www/ecole/`
- [ ] Fichier `school.ptrniger.conf` copié dans `/etc/apache2/sites-available/`
- [ ] Permissions correctement définies (www-data:www-data)

### Configuration Apache & SSL
- [ ] Configuration HTTP (`school.ptrniger-http.conf`) activée
- [ ] Certificats SSL créés avec Let's Encrypt pour `school.ptrniger.com`
- [ ] Configuration HTTPS (`school.ptrniger.conf`) activée
- [ ] Redirection HTTP vers HTTPS fonctionnelle
- [ ] Renouvellement automatique SSL configuré

### Configuration Application
- [ ] `application/config/database.php` mis à jour
- [ ] `application/config/config.php` avec `base_url = https://school.ptrniger.com/`
- [ ] Clé de cryptage définie
- [ ] Environment mis à `production`
- [ ] Permissions uploads/ et logs/ configurées

### Sécurité & Maintenance
- [ ] Fail2Ban installé et configuré
- [ ] Sauvegardes automatiques configurées
- [ ] Monitoring de base en place
- [ ] Tests fonctionnels effectués
- [ ] Accès HTTPS fonctionnel à https://school.ptrniger.com

### Commandes de vérification finale
```bash
# Vérifier Apache
sudo apache2ctl configtest
sudo systemctl status apache2

# Vérifier SSL
curl -I https://school.ptrniger.com

# Vérifier les logs
sudo tail -f /var/log/apache2/school.ptrniger-error.log

# Tester la base de données
mysql -u ecole_user -p ecole -e "SELECT 1;"
```

---

## 📞 Support

En cas de problème, vérifiez dans l'ordre :
1. Les logs Apache et PHP
2. Les permissions des fichiers
3. La configuration de la base de données
4. Les paramètres de l'application

**Fichiers de configuration importants :**
- Apache: `/etc/apache2/sites-available/ecole.conf`
- PHP: `/etc/php/8.4/apache2/php.ini`
- MariaDB: `/etc/mysql/mariadb.conf.d/50-server.cnf`
- Application: `/var/www/ecole/application/config/`

---

*Guide créé pour le déploiement du Smart School Management System*
*Version: 1.0 - Date: $(date +%Y-%m-%d)*