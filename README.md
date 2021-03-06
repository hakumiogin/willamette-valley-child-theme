# Theme for Willamettevalley.org.

This theme is a fully block based theme, built using only a single template file. I had the idea that blocks were meant to be composable (ie, blocks used inside of blocks, allowing for very complicated layouts in the editor), so the entire site is built with that idea in mind. The composable blocks were preconfigured as block patterns. This gives the users a remarkable amount of power, but also had the downside that user generated patterns do not have classes, meaning there is an abudence of SASS and JS that targets very specific html configurations. It's also meant that most new block design proprosals have been possible to make in the editor, without additional styles, generated or otherwise.

Lastly, this site was built as a child theme of the Tonik Starter theme (https://labs.tonik.pl/theme/), which this theme relies on a heavily modified version of to run properly. Lastly, Tonik's templating system is broken (or ill conceived), and some of the templating code is misplaced because of it.

I am resposible for almost all of the code in this repo, though I work with other developers, especially on the backend things.

## Contents

1	Clone and build the site

1.1	Gotchas / Need-to-haves

2	Building during development

3	Get media files

4	Get the database

5	Set up Apache/MySQL locally


## Clone and build the site

Note: If you are not running as root, any installation commands here require you to run as sudo


Run `git clone --branch master uyz4sq2cgrby4@git.us-3.platform.sh:uyz4sq2cgrby4.git` WillametteValley

Navigate to the project root with cd WillametteValley

Run `platform build`

`Platform build` will run each of the following commands for you:


1. `composer install`
2. `yarn install`
3. `yarn run build:parent`
4. `yarn run build:child`

To begin developing, run `yarn run watch:child`

### Troubleshooting

If you get an error during composer install along the lines of ./.platform.settings.sh: line 2: $'\r': Command not found, then open that file in a text editor that can replace special characters (e.g. Notepad++), and replace \r\n with \n.

Install Node.js v12+ if not present (validate version with node --version) - https://phoenixnap.com/kb/update-node-js-version

If you get an Pngquant failed to build, make sure that libpng-dev is installed error, run sudo apt-get install libpng-dev and then npm install -g pngquant-bin

If after adding your Github token as part of composer update, please see https://stackoverflow.com/questions/26691681/composer-unexpectedvalueexception-error-will-trying-to-use-composer-to-install

If you get a make error during the "Building fresh packages" portion, try removing the yarn.lock file in the root and running `yarn install`

## Building during development

As changes are made to the child theme, you can run `yarn run watch:child` on the CLI to catch and build as they occur.

## Get media files

Run either `platform mount:download` or `rsync -e "ssh -i ~/.ssh/id_rsa" --archive --compress --human-readable --delete -v "uyz4sq2cgrby4-master-7rqtwti--app@ssh.us-3.platform.sh:web/wp-content/uploads/" "web/wp-content/uploads/"`.

## Get the database

To get the latest database, use the standard Platform controls:

Run `platform db:dump`

Set up Apache/MySQL locally

Set up your local LAMP stack to support the site.

Add vhosts and open port in apache config files

Alter wp-config-local.php to match your local database and port settings

The site should now be running locally.

