#!/bin/bash

echo "Applying migrations"
sleep 10 && php /code/yii migrate --interactive=0
#
#a2enmod rewrite
#source /etc/apache2/envvars
#
## Start apache and monitor its logs
#tail -F /var/log/apache2/* & exec apache2 -D FOREGROUND