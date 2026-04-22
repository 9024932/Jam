FROM php:8.2-apache

WORKDIR /var/www/html

# Use Render's dynamic PORT when available and keep Apache's document root simple.
COPY start-apache.sh /usr/local/bin/start-apache.sh
RUN chmod +x /usr/local/bin/start-apache.sh

COPY . /var/www/html/

EXPOSE 10000

CMD ["/usr/local/bin/start-apache.sh"]
