# N. Cage Pool Supplies

*Welcome to N. Cage Pools. Well, Baby-O, it's not exactly mai-thais
and yatzee out here but... let's do it!*

## Quick Setup

All you need to do to run this project is run `vagrant up` and pop open your browser to [92.168.33.15](http://192.168.33.15) when it's finished.

If you don't have Vagrant installed, I can't help you, but these awesome [website](https://www.vagrantup.com/) can!

FYI, the `vagrant up` process can take a little bit. So while you wait for the site to boot.
Open [Reddit](https://www.reddit.com/)! Maybe look around [/r/funny](https://www.reddit.com/r/funny/) to kill sometime or Spotify and listen to Pendulum or Savant.

This project was not indorsed by Reddit, Pendulum or Savant, I thought you might want suggestions what to do while you wait or listen to.

## Style Guide

I usually like to follow [jQuery Style Guide](https://contribute.jquery.org/style-guide/js/) with my JavaScript/Babel.
PHP I like to follow closely to [Larevel's Style Guide](https://contribute.jquery.org/style-guide/js/)


## Credits / Technologies

- Andrew McRobb
- ScotchBox
- Larevel
- MySQL 5.5
- Node 6
- Gulp
- Browserify
- Sass (Scss)
- Redis

## About Root Files
- .editorconfig: Nifty file that helps developers define and maintain consistent coding styles between editors and IDEs.
- .gitignore: Ignore files/folders we don't want pushed to remote repo or production.
- README.md: I think you know what this means...
- Vagrantfile: Simple configuration file for our Vagrant box.
- gulpfile.js: Gulp task runner scripts for front-end.
- gulpconfig.json: Simple configuration file for our front-end assets.
- package.json: Our front-end dependancies.
- vagrant_up_bootstrap.sh: Our shell script that executes after our VM boots for the first time.
- yarn.lock: Helps keep consistent installs accross machines, where package.json fails.
