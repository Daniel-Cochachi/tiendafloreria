FROM php:7.4-apache

# Desactivar MPMs conflictivos (dejar solo prefork)
RUN a2dismod mpm_event mpm_worker mpm_http2 || true

# Habilitar MPM prefork
RUN a2enmod mpm_prefork

# Habilitar mod_rewrite para .htaccess
RUN a2enmod rewrite

# Configurar DocumentRoot a la carpeta public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar la app
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Exponer puerto
EXPOSE 8080

# Ejecutar Apache
CMD ["apache2-foreground"]
