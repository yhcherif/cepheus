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
