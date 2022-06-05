# If needed here is how to run npm install and npm commands
# FROM node:15.11-alpine

# COPY . /app
# WORKDIR /app
# RUN npm install
# RUN npm run build

FROM webdevops/php-nginx:8.0-alpine

# In case you were using NodeJS container above, use this COPY instead
# otherwise use one below this one
# COPY --from=0 /app /app

COPY . /app

WORKDIR /app

RUN mv /opt/docker/etc/nginx/vhost.conf /opt/docker/etc/nginx/vhost.conf.old
RUN cp /app/docker/vhost.conf /opt/docker/etc/nginx/vhost.conf
RUN cp -R /app/docker/supervisor-services/* /opt/docker/etc/supervisor.d/

# If you need to have cronjobs uncomment this line and add jobs to docker/crontab file
# IMPORTANT! Make sure to have an empty line at the end of crontab file otherwise this command will fail!
# RUN crontab docker/crontab

RUN chown -R nginx:nginx /app
RUN chmod +x /app/docker/entrypoint.sh

RUN composer install

# Artisan commands are inside docker/entrypoint.sh!
CMD ["/app/docker/entrypoint.sh"]
