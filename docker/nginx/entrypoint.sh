#!/bin/sh
set -e

echo "Starting Nginx"

if [ "$SSL_ENABLED" = "true" ]; then
    echo "SSL enabled: loading HTTPS config"
    cp /etc/nginx/https.conf /etc/nginx/conf.d/default.conf
else
    echo "SSL disabled: loading HTTP config"
    cp /etc/nginx/http.conf /etc/nginx/conf.d/default.conf
fi

nginx -g 'daemon off;'
