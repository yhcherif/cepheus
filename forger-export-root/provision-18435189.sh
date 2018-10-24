#
# REQUIRES:
#		- site (the forge site instance)
#

cat > /etc/nginx/fastcgi_params << EOF
fastcgi_param   QUERY_STRING        \$query_string;
fastcgi_param   REQUEST_METHOD      \$request_method;
fastcgi_param   CONTENT_TYPE        \$content_type;
fastcgi_param   CONTENT_LENGTH      \$content_length;
fastcgi_param   SCRIPT_FILENAME     \$request_filename;
fastcgi_param   SCRIPT_NAME     \$fastcgi_script_name;
fastcgi_param   REQUEST_URI     \$request_uri;
fastcgi_param   DOCUMENT_URI        \$document_uri;
fastcgi_param   DOCUMENT_ROOT       \$document_root;
fastcgi_param   SERVER_PROTOCOL     \$server_protocol;
fastcgi_param   GATEWAY_INTERFACE   CGI/1.1;
fastcgi_param   SERVER_SOFTWARE     nginx/\$nginx_version;
fastcgi_param   REMOTE_ADDR     \$remote_addr;
fastcgi_param   REMOTE_PORT     \$remote_port;
fastcgi_param   SERVER_ADDR     \$server_addr;
fastcgi_param   SERVER_PORT     \$server_port;
fastcgi_param   SERVER_NAME     \$server_name;
fastcgi_param   HTTPS           \$https if_not_empty;
fastcgi_param   REDIRECT_STATUS     200;
fastcgi_param   HTTP_PROXY  "";
EOF

# Generate dhparams File If Necessary

if [ ! -f /etc/nginx/dhparams.pem ]
then
    openssl dhparam -out /etc/nginx/dhparams.pem 2048
fi

# Write The Nginx Server Block For The Site

rm "/etc/nginx/sites-available/beta.pinsdeal.ci"
rm "/etc/nginx/sites-available/www.beta.pinsdeal.ci"


cat > /etc/nginx/sites-available/beta.pinsdeal.ci << EOF
# FORGE CONFIG (DO NOT REMOVE!)
include forge-conf/beta.pinsdeal.ci/before/*;

server {
    listen 80;
    listen [::]:80;
    server_name beta.pinsdeal.ci;
    root /home/forge/beta.pinsdeal.ci/public;

    # FORGE SSL (DO NOT REMOVE!)
    # ssl_certificate;
    # ssl_certificate_key;

    ssl_protocols TLSv1.2;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-SHA384;
    ssl_prefer_server_ciphers on;
    ssl_dhparam /etc/nginx/dhparams.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    # FORGE CONFIG (DO NOT REMOVE!)
    include forge-conf/beta.pinsdeal.ci/server/*;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /var/log/nginx/beta.pinsdeal.ci-error.log error;

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}

# FORGE CONFIG (DO NOT REMOVE!)
include forge-conf/beta.pinsdeal.ci/after/*;
EOF


# Write The Configuration Directories

mkdir -p /etc/nginx/forge-conf/beta.pinsdeal.ci/before
mkdir -p /etc/nginx/forge-conf/beta.pinsdeal.ci/after
mkdir -p /etc/nginx/forge-conf/beta.pinsdeal.ci/server

# Enable The Nginx Sites

rm "/etc/nginx/sites-enabled/beta.pinsdeal.ci"
rm "/etc/nginx/sites-enabled/www.beta.pinsdeal.ci"

ln -s /etc/nginx/sites-available/beta.pinsdeal.ci /etc/nginx/sites-enabled/beta.pinsdeal.ci

# Write The Base Redirector For The Site

cat > /etc/nginx/forge-conf/beta.pinsdeal.ci/before/redirect.conf << EOF
# Redirect To Primary Domain...
server {
    listen 80;
    listen [::]:80;

    server_name www.beta.pinsdeal.ci;
    return 301 \$scheme://beta.pinsdeal.ci\$request_uri;
}
EOF

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

# Restart HHVM-FastCGI When Running HHVM


