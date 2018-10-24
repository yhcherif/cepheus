#
# REQUIRES:
#       - site (the forge site instance)
#       - repository (the repository to deploy)
#		- composer (determines if composer install will be run)
#		- migrate (determines if migrate will be run)
#

set -e


# Remove The Current Site Directory

rm -rf /home/forge/test.pinsdeal.ci

ssh-keyscan -H bitbucket.org/ycherif/deal/admin >> /home/forge/.ssh/known_hosts

# Clone The Repository Into The Site

git clone -b master git@bitbucket.org/ycherif/deal/admin test.pinsdeal.ci

cd /home/forge/test.pinsdeal.ci

git submodule update --init --recursive

# Install Composer Dependencies If Requested

    cd /home/forge/test.pinsdeal.ci
    composer install --no-interaction --prefer-dist --optimize-autoloader

# Run Artisan Migrations If Requested


# Create Environment File If Necessary

if [ -f /home/forge/test.pinsdeal.ci/artisan ]
then

    if [ -f /home/forge/test.pinsdeal.ci/.env.example ]
    then
        cp /home/forge/test.pinsdeal.ci/.env.example /home/forge/test.pinsdeal.ci/.env
    else
        cat > /home/forge/test.pinsdeal.ci/.env << EOF
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=forge
DB_PASSWORD=TechnologyArtisans

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_KEY=
PUSHER_SECRET=
PUSHER_APP_ID=
EOF
    fi

    sed -i -r "s/APP_ENV=.*/APP_ENV=production/" /home/forge/test.pinsdeal.ci/.env
    sed -i -r "s/APP_DEBUG=.*/APP_DEBUG=false/" /home/forge/test.pinsdeal.ci/.env
    sed -i -r "s/DB_DATABASE=.*/DB_DATABASE=/" /home/forge/test.pinsdeal.ci/.env
    sed -i -r "s/DB_USERNAME=.*/DB_USERNAME=forge/" /home/forge/test.pinsdeal.ci/.env
    sed -i -r "s/DB_PASSWORD=.*/DB_PASSWORD=TechnologyArtisans/" /home/forge/test.pinsdeal.ci/.env
    php /home/forge/test.pinsdeal.ci/artisan key:generate || true
fi
