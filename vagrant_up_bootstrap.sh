#!/usr/bin/env bash
# This file only runs 'once' after you run `vagrant up`.
# We simply make sure everything is setup and installed and built.

# Additional package repositories.

# Yarn
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

# Updates
apt-get update                          # We make sure everything is up-to date.
/usr/local/bin/composer self-update     # Usually composer with Scotchbox is older than 60 days.

# Additional Software / Packages
apt-get install -y yarn                 # Install Yarn. You can use NPM, but I perfer Yarn.
yarn global add browserify              # Install browserify to properly bundle our js.

# Setup and build our front-end.
cd /var/www                             # In order to setup our non-global dependancies we must cd to the project.
yarn install                            # Install our dependancies to install our project
