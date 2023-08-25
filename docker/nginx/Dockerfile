FROM nginx:1.22-alpine

RUN set -eux; \
    adduser -u 82 -D -S -G www-data www-data

ADD nginx.conf /etc/nginx/nginx.conf
ADD www.conf /etc/nginx/conf.d/default.conf
