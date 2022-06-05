#!/bin/bash

/usr/local/bin/php /app/artisan config:clear
/usr/local/bin/php /app/artisan migrate --force

supervisord
