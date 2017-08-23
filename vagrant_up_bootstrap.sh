#!/usr/bin/env bash

# This file only runs 'once' after you run `vagrant up`. NO NEED TO MANUALLY RUN THIS!
# We simply make sure everything is setup and installed and build.

echo "This may take a while. Just imagine Iron Man assembling it's self for freakin' Tony Stark!"
# Additional package repositories.

# Add Yarn Packages
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list

# Make sure the stable PHP 7 is being installed.
sudo add-apt-repository ppa:ondrej/php

# Updates repositories.
sudo apt-get update                                     # We make sure everything is up-to date.

# Additional Software / Packages Installations

# Scotch Box 3 is still sorta busted with PHP 7. Temp fix.
sudo apt-get -y install php7.0                          # Install php 7.0
sudo apt-get -y install php-xml php7.0-xml              # Required for Larevel.
sudo apt-get -y install php-mbstring                    # Required for Composer / Larevel.
sudo apt-get -y install libapache2-mod-php7.0 libphp7.0-embed libssl-dev openssl php7.0-cgi php7.0-cli php7.0-common php7.0-dev php7.0-fpm php7.0-phpdbg
sudo apt-get -y install yarn                            # Install Yarn. You can use NPM, but I perfer Yarn.

sudo /usr/local/bin/composer self-update                # Usually composer with Scotch Box is older than 60 days.

# Install Ruby for Sass Lint.
sudo apt-get -y install ruby                            # Install ruby for Sass engine.
sudo gem install scss-lint                              # Install Scss-Lint for Scss linting.

# Upgrade Node 5 to 6. (for Autoprefixer)
sudo yarn cache clean -f                                # Clean up our global cache to safely install n
sudo yarn global add n                                  # Install n so we can easily switch node versions.
sudo n 6.11.2                                           # Install the latest version 6, while still stable in yarn/npm.

# Some minor configuration setup.
echo "cd /var/www" > /home/vagrant/.bash_profile        # Set the default directory to /var/www when logging in.

# Setup and build everything.
cd /var/www                                             # Change noasdasddirectory to our project root.
composer install                                        # Install required Laravel packages.
yarn install                                            # Install required Gulp packages.
yarn run dev                                            # Build our front-end assets!
mysql -u root -e "create database ncagepools"          # Create database for Larevel.
php artisan migrate                                     # Generate our tables for our store.
php artisan db:seed                                     # Seed our product tables from the API. (This may tak a while...)
echo "All done! Have fun Baby-O!"
