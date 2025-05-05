#!/bin/bash

# Move to the app directory (change if needed)
cd /var/www/html/info-app

# Check if Composer is installed
if ! command -v php /usr/local/bin/composer &> /dev/null; then
    echo "Composer not found. Installing..."
    EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

    if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; then
        >&2 echo 'ERROR: Invalid Composer installer signature'
        rm composer-setup.php
        exit 1
    fi

    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    rm composer-setup.php
else
    echo "Composer already installed."
fi
cd /usr/local/bin
sudo chmod +x composer

cd /var/www/html/info-app
# Run Composer install
php /usr/local/bin/composer install --no-dev --optimize-autoloader