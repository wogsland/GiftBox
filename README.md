# GoSizzle.io

## Table of Contents
1. [Set Up](#set-up)
1. [Branching Strategy](#branching)
1. [Testing](#testing)
1. [Deployment](#deployment)

## <a id="set-up"></a>Set Up

### URLs
(hosted on AWS)
- production: [www.gosizzle.io](https://www.gosizzle.io/)
- staging: [dev.gosizzle.io](http://dev.gosizzle.io)


### Github

Make sure you have access & set your project remote

    git remote add github git@github.com:GiveToken/GiftBox.git

*this assumes ssh; you could use `https://github.com/GiveToken/GiftBox.git` instead of `git@...` for https if you prefer*

You'll also need to

    cp config/credentials.php.example config/credentials.php

replacing the default credentials with whatever your choices are for local development,


### <a id="database"></a>MySQL Database

- Download and install [MySQL workbench](https://www.mysql.com/products/workbench/).

To create a local instance of the S!zzle database, use MySQL Workbench's Schema Transfer Wizard.

### Apache

If on a Mac, you can update `/etc/apache2/extra/httpd-vhosts.conf` to include something like

    <VirtualHost *:80>
        ServerAdmin username@gosizzle.io
        ServerName gosizzle.local
        ServerAlias *.gosizzle.local
        DocumentRoot "/Library/Webserver/Documents/GiftBox/public"

        <Directory "/Library/Webserver/Documents/GiftBox/public">
            Options -Indexes +FollowSymLinks +MultiViews
            AllowOverride All
            Require all granted
        </Directory>

        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel warn
    </VirtualHost>

and restart Apache. Then modify `/etc/hosts` to include

    127.0.0.1       gosizzle.local
    127.0.0.1       api.gosizzle.local

### <a id="composer"></a>Composer

[Composer](https://getcomposer.org/) is the PHP package manager used to bring in
3rd party PHP code. Once you have it in installed, cd to the project directory and
run

    composer install

which will create everything you need in the untracked vendor directory.

### <a id="bower"></a>Bower

[Bower](http://bower.io/) is a package manager used to bring in Polymer
components. Once you have it in installed, cd to the project directory and
run

    bower install

which will create everything you need in the untracked components directory.

### Optimization

Polymer's polybuild, YUI compressor & json-minify are tools optimize & minify an
app's code during the build process

    npm install
    npm install -g polybuild
    npm install -g yuicompressor
    npm install -g json-minify

NB: polybuild treats PHP like a comment and removes it.

## <a id="branching"></a>Branching Strategy

### Basic Tenets

1. All code on the `master` branch will always be production-ready. If it is not production-ready it should not be on `master`
2. The `develop` branch is not a sacred cow. It will be wise to occasionally blow away the `develop` branch and create a new one off of master.
3. Create branches off of `develop` (except hotfixes, create those off of `master`)
using the following convention:
  - `feature`, `bug`, or `hotfix`
    - `feature` is new functionality
    - `bug` is unexpected behavior in exisiting functionality
    - `hotfix` is a `bug` of the highest priority-- e.g. the site is down or Give Token is leaking sensitive data.
    - Exmples:
      - `bug/37-icons-broken-in-ie`
      - `feature/236-user-can-add-avatar`
      - `hotfix/76-repair-payment-gateway`
  - Forward slash
  - The GH issue number
  - dashes, never underscores
  - A meaningful and short description of the branch, generally related to the title of the GH issue
4. All code gets merged into `master` via pull request (PR).
5. All code get approved by the project lead before being merged via PR.
6. Commit messages begin with a present-tense verb, referencing the issue number,  
and describe some combination of what was done, where it was done, and why.
7. NEVER EVER EVER merge `develop` into `master`.

### Handling Merge Conflicts

Github has a great reference [here](https://help.github.com/articles/resolving-a-merge-conflict-from-the-command-line/).

## <a id="testing"></a>Testing

Presuming you have set up [Composer](#composer), then PHPUnit will be available
in your /vendor/bin directory. You'll need to setup your local parameters by

    cp src/Tests/local.php.example src/Tests/local.php

and making any necessary changes to `local.php`. To run all the tests, just reference the
configuration file:

    phpunit --bootstrap src/tests/autoload.php -c tests.xml

To also investigate the code coverage of the tests, you'll need the
[Xdebug PHP extension](http://xdebug.org/docs/install).
Make sure you put any unit tests in the `src/tests` directory and name them like
MyAwesomeTest.php.

For JavaScript testing,

    npm install -g mocha

## <a id="deployment"></a>Deployment

#### `develop` -> staging site

#### `master` -> production

### Build Script
The build script (`build.sh`) runs unit tests, warns you of any untracked or
uncommited files (**these will be included in the optional release to glcoud, but
are not yet tracked in github**), minifies JavaScript & CSS, Polybuilds the token
and optionally pushes to gcloud. For example, to deploy a test build,

    ./build.sh username

will do the above mentioned things and deploy to gcloud at
[username-dot-t-sunlight-757.appspot.com](https://username-dot-t-sunlight-757.appspot.com).
If we stick to using github usernames we can avoid collisions :smile:.
The full set of options is available in the help menu

    ./build.sh -h

The important caveat is that this script was written on OSX and may not work on
Cygwin or your favorite Windows version of Linux.

### <a id="deploy-staging"></a>Deploy to Staging

Any push to `develop` is automagically pulled onto the staging server except
during the QA period for new releases.

### <a id="deploy-production"></a>Deploy to Production

Log into the production webserver and

    git branch YYYYMMDD.backup
    git pull origin master
    composer install
