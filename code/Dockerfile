FROM tutum/apache-php

ADD . /code

RUN unlink /var/www/html
RUN ln -s /code/frontend/web/ /var/www/html

# Installing git to install dependencies later
#RUN apt-get update && \
#    apt-get install -y \
#      git zlib1g-dev php5-curl php5-cli php5-intl php5-mysqlnd php5-gd php5-fpm \
#          && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

RUN cd /code && php /usr/bin/composer global require "fxp/composer-asset-plugin:~1.1.1" && php /usr/bin/composer update
RUN php /code/init  --env=Development --overwrite=All
#RUN php /code/yii migrate --interactive=false

RUN sed -i "s/short_open_tag = Off/short_open_tag = On/g" /etc/php5/cli/php.ini

WORKDIR /code

EXPOSE 80

#ADD migrate.sh /migrate.sh
#RUN chmod +x /migrate.sh

ENV ALLOW_OVERRIDE true

#ENTRYPOINT ["/code/yii", "migrate"]

#CMD php -S 0.0.0.0:8000 -t /app/frontend/web