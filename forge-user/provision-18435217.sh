#
# REQUIRES:
#       - site (the forge site instance)
#		- database (the desired database name)
#		- user (the MySQL user)
#

# Download & Install WordPress

wget http://wordpress.org/latest.tar.gz
tar -xf /home/forge/latest.tar.gz -C /home/forge/beta.pinsdeal.ci/public --strip-components=1

# Install WordPress CLI

cd /home/forge/beta.pinsdeal.ci/public
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar

# Configure The Wordpress Installation

rm wp-config.php

php wp-cli.phar core config --dbname="wordpress" --dbuser="wordpress" --dbpass="wordpress"

# Clean Downloads

rm /home/forge/latest.tar.gz

# Move WordPress CLI

cd /home/forge/beta.pinsdeal.ci/public
chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp
