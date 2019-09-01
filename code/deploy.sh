#!/bin/bash

echo "Doing proper apache html folder linking"

unlink /var/www/html && ln -s /code/frontend/web/ /var/www/html

echo "Enabling short open tags"
sed -i "s/short_open_tag = Off/short_open_tag = On/g" /etc/php5/cli/php.ini
sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf

echo "Deploying app"
php /code/init --env=Development --overwrite=All

echo "Installing composer and dependencies"
. /code/install_composer.sh
cd /code && \
php /usr/bin/composer global require "fxp/composer-asset-plugin:~1.1.1" && \
php /usr/bin/composer update
