FROM ubuntu:22.04

# Install dependencies
env DEBIAN_FRONTEND=noninteractive
RUN apt-get update; apt-get install -y --no-install-recommends cron libpq-dev vim nginx php8.1-fpm php8.1-mbstring php8.1-xml php8.1-pgsql php8.1-curl

# Copy project code and install project dependencies
COPY --chown=www-data . /var/www/

# Copy project configurations
COPY ./etc/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./etc/nginx/default.conf /etc/nginx/sites-enabled/default
COPY .env_production /var/www/.env
COPY cron_script.sh /var/www/cron_script.sh
COPY docker_run.sh /docker_run.sh

RUN chmod 0644 /var/www/cron_script.sh

RUN crontab -l | { cat; echo "* * * * * bash /var/www/cron_script.sh"; } | crontab -

# Start command
CMD sh /docker_run.sh
