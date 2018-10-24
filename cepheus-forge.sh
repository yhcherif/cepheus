#
# REQUIRES:
#       - server (the forge server instance)
#       - event (the forge event instance)
#       - sudo_password (random password for sudo)
#       - db_password (random password for database user)
#       - callback (the callback URL)
#       - recipe_id (recipe id to run at the end)
#

sudo sed -i "s/#precedence ::ffff:0:0\/96  100/precedence ::ffff:0:0\/96  100/" /etc/gai.conf

# Upgrade The Base Packages

export DEBIAN_FRONTEND=noninteractive

apt-get update
apt-get upgrade -y

# Add A Few PPAs To Stay Current

apt-get install -y --force-yes software-properties-common

# apt-add-repository ppa:fkrull/deadsnakes-python2.7 -y
apt-add-repository ppa:nginx/development -y
apt-add-repository ppa:chris-lea/redis-server -y
apt-add-repository ppa:ondrej/apache2 -y

	apt-add-repository ppa:ondrej/php -y

# Setup MySQL 5.7 Repositories

    # sudo apt-key adv —keyserver pgp.mit.edu —recv-keys 5072E1F5
    # echo "deb http://repo.mysql.com/apt/ubuntu/ xenial mysql-5.7" | sudo tee /etc/apt/sources.list.d/mysql.list

# Setup MariaDB Repositories


# Setup Postgres 9.4 Repositories

# wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -
# sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt/ xenial-pgdg main" >> /etc/apt/sources.list.d/postgresql.list'

# Update Package Lists

apt-get update
# Base Packages

apt-get install -y --force-yes build-essential curl fail2ban gcc git libmcrypt4 libpcre3-dev \
make python2.7 python-pip sendmail supervisor ufw unattended-upgrades unzip whois zsh

# Install Python Httpie

pip install httpie

# Disable Password Authentication Over SSH

sed -i "/PasswordAuthentication yes/d" /etc/ssh/sshd_config
echo "" | sudo tee -a /etc/ssh/sshd_config
echo "" | sudo tee -a /etc/ssh/sshd_config
echo "PasswordAuthentication no" | sudo tee -a /etc/ssh/sshd_config
echo "PermitRootLogin no" | sudo tee -a /etc/ssh/sshd_config

# Restart SSH

ssh-keygen -A
service ssh restart

# Set The Hostname If Necessary


echo "divine-dawn" > /etc/hostname
sed -i 's/127\.0\.0\.1.*localhost/127.0.0.1	divine-dawn.localdomain divine-dawn localhost/' /etc/hosts
hostname divine-dawn


# Set The Timezone

# ln -sf /usr/share/zoneinfo/UTC /etc/localtime
ln -sf /usr/share/zoneinfo/UTC /etc/localtime

# Create The Root SSH Directory If Necessary

if [ ! -d /root/.ssh ]
then
	mkdir -p /root/.ssh
	touch /root/.ssh/authorized_keys
fi

# Setup Forge User

useradd forge
mkdir -p /home/forge/.ssh
mkdir -p /home/forge/.forge
adduser forge sudo

# Setup Bash For Forge User

chsh -s /bin/bash forge
cp /root/.profile /home/forge/.profile
cp /root/.bashrc /home/forge/.bashrc

# Set The Sudo Password For Forge

PASSWORD=$(mkpasswd KuXxrWIPIeFhwLnXA5fe)
usermod --password $PASSWORD forge

# Build Formatted Keys & Copy Keys To Forge


cat > /root/.ssh/authorized_keys << EOF
# Laravel Forge
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDWYurHdaSokCbAeRRafS5PRc65tlFdZ2VXFFjRjkdzkrarqQLG3FcGTVgXNBHb1AvjqUbsSED4o1L6tfbtzvGUejoqR+zkfmAf8PKxqWav+Hq48ZnGGErxivW+TOhK3z4pumCL9D7JATAkHsYM3ZcLfwBAfjQRnoT61KM7DSPz6SCK1JoaT+ZHBPcsi81QaSY24FHdsA4glTouhK0OO+etVUVJxw3K1Qk0Yg+v5mjrgm+JDDtfWQTMFkp/4dly8yYA78y0L7xE+5aOR2lyb4xwrExfUSGB6pkIGSwxb84Bug8me1gIaMYwBdNYg5/WYDmA4o5W2Ln1frEwGOTxKsZf worker@forge.laravel.com


EOF


cp /root/.ssh/authorized_keys /home/forge/.ssh/authorized_keys

# Create The Server SSH Key

ssh-keygen -f /home/forge/.ssh/id_rsa -t rsa -N ''

# Copy Source Control Public Keys Into Known Hosts File

ssh-keyscan -H github.com >> /home/forge/.ssh/known_hosts
ssh-keyscan -H bitbucket.org >> /home/forge/.ssh/known_hosts
ssh-keyscan -H gitlab.com >> /home/forge/.ssh/known_hosts

# Configure Git Settings

git config --global user.name "Youssouf Hamed CHERIF"
git config --global user.email "cedinho10@yahoo.fr"

# Add The Reconnect Script Into Forge Directory

cat > /home/forge/.forge/reconnect << EOF
#!/usr/bin/env bash

echo "# Laravel Forge" | tee -a /home/forge/.ssh/authorized_keys > /dev/null
echo \$1 | tee -a /home/forge/.ssh/authorized_keys > /dev/null

echo "# Laravel Forge" | tee -a /root/.ssh/authorized_keys > /dev/null
echo \$1 | tee -a /root/.ssh/authorized_keys > /dev/null

echo "Keys Added!"
EOF

# Setup Forge Home Directory Permissions

chown -R forge:forge /home/forge
chmod -R 755 /home/forge
chmod 700 /home/forge/.ssh/id_rsa

# Setup UFW Firewall

ufw allow 22
ufw allow 80
ufw allow 443
ufw --force enable

# Allow FPM Restart

echo "forge ALL=NOPASSWD: /usr/sbin/service php7.2-fpm reload" > /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php7.1-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php7.0-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php5.6-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php5-fpm reload" >> /etc/sudoers.d/php-fpm

	# Install Base PHP Packages


apt-get install -y --force-yes php7.2-cli php7.2-dev \
php7.2-pgsql php7.2-sqlite3 php7.2-gd \
php7.2-curl php7.2-memcached \
php7.2-imap php7.2-mysql php7.2-mbstring \
php7.2-xml php7.2-zip php7.2-bcmath php7.2-soap \
php7.2-intl php7.2-readline

apt-get install -y --force-yes php7.1-cli php7.1-dev \
php7.1-pgsql php7.1-sqlite3 php7.1-gd \
php7.1-curl php7.1-memcached \
php7.1-imap php7.1-mysql php7.1-mbstring \
php7.1-xml php7.1-zip php7.1-bcmath php7.1-soap \
php7.1-intl php7.1-readline


# Install Composer Package Manager

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Misc. PHP CLI Configuration

sudo sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.2/cli/php.ini
sudo sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.2/cli/php.ini
sudo sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.2/cli/php.ini
sudo sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.2/cli/php.ini


sudo sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.1/cli/php.ini
sudo sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.1/cli/php.ini
sudo sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.1/cli/php.ini
sudo sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.1/cli/php.ini

# Configure Sessions Directory Permissions

chmod 733 /var/lib/php/sessions
chmod +t /var/lib/php/sessions


	#
# REQUIRES:
#       - server (the forge server instance)
#		- site_name (the name of the site folder)
#

# Install Nginx & PHP-FPM

	apt-get install -y --force-yes nginx php7.2-fpm

# Generate dhparam File

openssl dhparam -out /etc/nginx/dhparams.pem 2048

# Tweak Some PHP-FPM Settings

sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.2/fpm/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.2/fpm/php.ini
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/7.2/fpm/php.ini
sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.2/fpm/php.ini
sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.2/fpm/php.ini

sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.1/fpm/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.1/fpm/php.ini
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/7.1/fpm/php.ini
sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.1/fpm/php.ini
sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.1/fpm/php.ini

# Configure FPM Pool Settings

sed -i "s/^user = www-data/user = forge/" /etc/php/7.2/fpm/pool.d/www.conf
sed -i "s/^group = www-data/group = overwatch/" /etc/php/7.2/fpm/pool.d/www.conf
sed -i "s/;listen\.owner.*/listen.owner = overwatch/" /etc/php/7.2/fpm/pool.d/www.conf
sed -i "s/;listen\.group.*/listen.group = overwatch/" /etc/php/7.2/fpm/pool.d/www.conf
sed -i "s/;listen\.mode.*/listen.mode = 0666/" /etc/php/7.2/fpm/pool.d/www.conf
sed -i "s/;request_terminate_timeout.*/request_terminate_timeout = 60/" /etc/php/7.2/fpm/pool.d/www.conf


sed -i "s/^user = www-data/user = overwatch/" /etc/php/7.1/fpm/pool.d/www.conf
sed -i "s/^group = www-data/group = overwatch/" /etc/php/7.1/fpm/pool.d/www.conf
sed -i "s/;listen\.owner.*/listen.owner = overwatch/" /etc/php/7.1/fpm/pool.d/www.conf
sed -i "s/;listen\.group.*/listen.group = overwatch/" /etc/php/7.1/fpm/pool.d/www.conf
sed -i "s/;listen\.mode.*/listen.mode = 0666/" /etc/php/7.1/fpm/pool.d/www.conf
sed -i "s/;request_terminate_timeout.*/request_terminate_timeout = 60/" /etc/php/7.1/fpm/pool.d/www.conf

# Configure Primary Nginx Settings

sed -i "s/user www-data;/user overwatch;/" /etc/nginx/nginx.conf
sed -i "s/worker_processes.*/worker_processes auto;/" /etc/nginx/nginx.conf
sed -i "s/# multi_accept.*/multi_accept on;/" /etc/nginx/nginx.conf
sed -i "s/# server_names_hash_bucket_size.*/server_names_hash_bucket_size 128;/" /etc/nginx/nginx.conf

# Configure Gzip

cat > /etc/nginx/conf.d/gzip.conf << EOF
gzip_comp_level 5;
gzip_min_length 256;
gzip_proxied any;
gzip_vary on;

gzip_types
application/atom+xml
application/javascript
application/json
application/rss+xml
application/vnd.ms-fontobject
application/x-font-ttf
application/x-web-app-manifest+json
application/xhtml+xml
application/xml
font/opentype
image/svg+xml
image/x-icon
text/css
text/plain
text/x-component;

EOF

# Disable The Default Nginx Site

rm /etc/nginx/sites-enabled/default
rm /etc/nginx/sites-available/default
service nginx restart

# Install A Catch All Server

cat > /etc/nginx/sites-available/catch-all << EOF
server {
    return 404;
}
EOF

ln -s /etc/nginx/sites-available/catch-all /etc/nginx/sites-enabled/catch-all

# Restart Nginx & PHP-FPM Services

# Restart Nginx & PHP-FPM Services

service nginx restart
service nginx reload

if [ ! -z "\$(ps aux | grep php-fpm | grep -v grep)" ]
then
    service php7.2-fpm restart > /dev/null 2>&1
    service php7.1-fpm restart > /dev/null 2>&1
    service php7.0-fpm restart > /dev/null 2>&1
    service php5.6-fpm restart > /dev/null 2>&1
    service php5-fpm restart > /dev/null 2>&1
fi

# Add Forge User To www-data Group

usermod -a -G www-data forge
id forge
groups forge


curl --silent --location https://deb.nodesource.com/setup_8.x | bash -

apt-get update

sudo apt-get install -y --force-yes nodejs

npm install -g pm2
npm install -g gulp
npm install -g yarn

    #
# REQUIRES:
#		- server (the forge server instance)
#		- db_password (random password for mysql user)
#

# Set The Automated Root Password

export DEBIAN_FRONTEND=noninteractive

debconf-set-selections <<< "mysql-community-server mysql-community-server/data-dir select ''"
debconf-set-selections <<< "mysql-community-server mysql-community-server/root-pass password @SqLP@s5Buzzy"
debconf-set-selections <<< "mysql-community-server mysql-community-server/re-root-pass password @SqLP@s5Buzzy"

# Install MySQL

apt-get install -y --allow-unauthenticated mysql-server

# Configure Password Expiration

echo "default_password_lifetime = 0" >> /etc/mysql/mysql.conf.d/mysqld.cnf

# Configure Access Permissions For Root & Forge Users

sed -i '/^bind-address/s/bind-address.*=.*/bind-address = */' /etc/mysql/mysql.conf.d/mysqld.cnf
mysql --user="root" --password="@SqLP@s5Buzzy" -e "GRANT ALL ON *.* TO root@'127.0.0.1' IDENTIFIED BY '@SqLP@s5Buzzy';"
mysql --user="root" --password="@SqLP@s5Buzzy" -e "GRANT ALL ON *.* TO root@'%' IDENTIFIED BY '@SqLP@s5Buzzy';"
service mysql restart

mysql --user="root" --password="@SqLP@s5Buzzy" -e "CREATE USER 'forge'@'45.33.69.169' IDENTIFIED BY '@SqLP@s5Buzzy';"
mysql --user="root" --password="@SqLP@s5Buzzy" -e "GRANT ALL ON *.* TO 'forge'@'45.33.69.169' IDENTIFIED BY '@SqLP@s5Buzzy' WITH GRANT OPTION;"
mysql --user="root" --password="@SqLP@s5Buzzy" -e "GRANT ALL ON *.* TO 'forge'@'%' IDENTIFIED BY '@SqLP@s5Buzzy' WITH GRANT OPTION;"
mysql --user="root" --password="@SqLP@s5Buzzy" -e "FLUSH PRIVILEGES;"

# Create The Initial Database If Specified

mysql --user="root" --password="@SqLP@s5Buzzy" -e "CREATE DATABASE cepheus CHARACTER SET utf8 COLLATE utf8_unicode_ci;"


# Install & Configure Redis Server

apt-get install -y redis-server
sed -i 's/bind 127.0.0.1/bind 0.0.0.0/' /etc/redis/redis.conf
service redis-server restart
# Install & Configure Memcached

apt-get install -y memcached
sed -i 's/-l 127.0.0.1/-l 0.0.0.0/' /etc/memcached.conf
service memcached restart
# Install & Configure Beanstalk

apt-get install -y --force-yes beanstalkd
sed -i "s/BEANSTALKD_LISTEN_ADDR.*/BEANSTALKD_LISTEN_ADDR=0.0.0.0/" /etc/default/beanstalkd
sed -i "s/#START=yes/START=yes/" /etc/default/beanstalkd

service beanstalkd start
sleep 5
service beanstalkd restart

# Configure Supervisor Autostart

systemctl enable supervisor.service
service supervisor start

# Configure Swap Disk

if [ -f /swapfile ]; then
    echo "Swap exists."
else
    fallocate -l 1G /swapfile
    chmod 600 /swapfile
    mkswap /swapfile
    swapon /swapfile
    echo "/swapfile none swap sw 0 0" >> /etc/fstab
    echo "vm.swappiness=30" >> /etc/sysctl.conf
    echo "vm.vfs_cache_pressure=50" >> /etc/sysctl.conf
fi

# Setup Unattended Security Upgrades

cat > /etc/apt/apt.conf.d/50unattended-upgrades << EOF
Unattended-Upgrade::Allowed-Origins {
    "Ubuntu xenial-security";
};
Unattended-Upgrade::Package-Blacklist {
    //
};
EOF

cat > /etc/apt/apt.conf.d/10periodic << EOF
APT::Periodic::Update-Package-Lists "1";
APT::Periodic::Download-Upgradeable-Packages "1";
APT::Periodic::AutocleanInterval "7";
APT::Periodic::Unattended-Upgrade "1";
EOF

curl --insecure --data "event_id=13512531&server_id=161152&sudo_password=KuXxrWIPIeFhwLnXA5fe&db_password=VxXEzoyNyvre3ssaEa9j&recipe_id=" https://forge.laravel.com/provisioning/callback/app
