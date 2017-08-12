#!/usr/bin/env bash

# This file only runs 'once' after you run `vagrant up`. NO NEED TO MANUALLY RUN THIS!
# We simply make sure everything is setup and installed and build.

# Additional package repositories.

# Yarn
sudo curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
sudo echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

# Updates
sudo apt-get update                                  # We make sure everything is up-to date.

# Additional Software / Packages
sudo apt-get install -y php-mbstring php7.0-xml      # Required for Composer / Larevel.
sudo apt-get install -y yarn                         # Install Yarn. You can use NPM, but I perfer Yarn.
sudo apt-get install --reinstall `dpkg -l | grep 'ii  php7' | awk '{ printf($2" "); next}'` # Re-install PHP 7 For some reason the installation is busted in ScotchBox.
/usr/local/bin/composer self-update             # Usually composer with Scotchbox is older than 60 days.

# Some minor configuration setup.
echo "cd /var/www" > /home/vagrant/.bash_profile    # Set the default directory to /var/www when logging in.

# Setup and build everything.
composer install
yarn install
