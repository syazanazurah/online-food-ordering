# =============================================================================
# NomNom — Dockerfile (web service)
# Builds the application image used by the `web` service in docker-compose.yml
#
# Base: php:8.3.14-apache  (PHP 8.3.14 + Apache 2.4 on Debian Bookworm)
# =============================================================================

FROM php:8.3.14-apache

# ----------------------------------------------------------------------------
# PHP extensions required by the food ordering app
#   - mysqli + pdo_mysql  : prepared-statement-safe database access (MariaDB)
# ----------------------------------------------------------------------------
RUN docker-php-ext-install mysqli pdo pdo_mysql

# ----------------------------------------------------------------------------
# Enable Apache mod_rewrite so .htaccess clean-URL rewrites work
# (e.g. /menu -> menu.php), matching the routing plan in README.md
# ----------------------------------------------------------------------------
RUN a2enmod rewrite

# ----------------------------------------------------------------------------
# Allow .htaccess to override directives (RewriteRule, AuthType, etc.)
# Default Debian Apache sets AllowOverride None, which silently disables
# every .htaccess in the project. Switch it to All for /var/www/.
# ----------------------------------------------------------------------------
RUN sed -ri 's!<Directory /var/www/>.*!&\n\tAllowOverride All!' /etc/apache2/apache2.conf \
    || sed -ri 's!AllowOverride None!AllowOverride All!' /etc/apache2/apache2.conf

# ----------------------------------------------------------------------------
# Document root: copy the application in. In docker-compose.yml the bind
# mount overrides this for live editing during development.
# ----------------------------------------------------------------------------
COPY . /var/www/html/

EXPOSE 80
