#
# REQUIRES:
#       - site (the forge site instance)
#

# Configure WordPress CLI

cd /home/forge/beta.pinsdeal.ci/public
chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp
