#!/usr/bin/env bash

# Upload our repository
rsync -r -avz -e "ssh -i Andrew-PC.pem" --delete ./ \
    --exclude push.sh \
    --exclude connect_remote.sh \
    --exclude README.md \
    --exclude gulpfile.js \
    --exclude vagrant_up_bootstrap.sh \
    --exclude yarn.lock \
    --exclude package.json \
    --exclude gulpfile-connect.json \
    --exclude Vagrantfile \
    --exclude Andrew-PC.pem \
    --exclude .editorconfig \
    --exclude node_modules \
    --exclude .vagrant \
    --exclude .gitignore \
    --exclude resources/assets/ \
    --exclude vendor/laravel/framework/.git \
    ubuntu@ec2-35-160-159-153.us-west-2.compute.amazonaws.com:/var/www/
