#!/bin/sh
set -e

echo "Starting Nginx"

if [ "$SSL_ENABLED" = "true" ]; then
    echo "SSL enabled: loading HTTPS config"
    cp /etc/nginx/templates/https.conf /etc/nginx/conf.d/default.conf
else
    echo "SSL disabled: loading HTTP config"
    cp /etc/nginx/templates/http.conf /etc/nginx/conf.d/default.conf
fi

nginx -g 'daemon off;'
