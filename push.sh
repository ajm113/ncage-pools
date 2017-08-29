#!/bin/sh

# Our script variables

HOST="ubuntu@ec2-35-160-159-153.us-west-2.compute.amazonaws.com" # Our remote server for production.
ROOT_FOLDER=/var/www/                                            # Root folder of where our app sits.
KEY_FILE="/home/vagrant/Andrew-PC.pem"                           # [CHANGE THIS] Our pem file for SSH connection.

# Pushes our codebase into the remote server. Everything is done in one sweet ssh command! :)

yarn run clean          # We need to cleanup anything that isn't in use before rsync.
yarn run production     # Make sure all the static content we generate is production ready.

# Upload our app!
rsync -r -avz -e "ssh -i $KEY_FILE" --delete ./ \
    --exclude push.sh \
    --exclude connect_remote.sh \
    --exclude README.md \
    --exclude gulpfile.js \
    --exclude vagrant_up_bootstrap.sh \
    --exclude yarn.lock \
    --exclude package.json \
    --exclude gulpfile-config.json \
    --exclude ncage-analytics-body-code.js \
    --exclude Vagrantfile \
    --exclude Andrew-PC.pem \
    --exclude scss-lint.yml \
    --exclude phpunit.xml \
    --exclude project.todo \
    --exclude ".editorconfig" \
    --exclude ".gitignore" \
    --exclude ".git" \
    --exclude node_modules \
    --exclude ".env" \
    $HOST:$ROOT_FOLDER

ssh -i $KEY_FILE $HOST "cd $ROOT_FOLDER && mv .env_production .env && php artisan migrate:refresh --seed && exit"
