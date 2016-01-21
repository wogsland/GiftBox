# GoSizzle.io

## Table of Contents
1. [Set Up](#set-up)
1. [Branching Strategy](#branching)
1. [Testing](#testing)
1. [Deployment](#deployment)

## <a id="set-up"></a>Set Up

### URLs
hosted on Google Cloud
- production: [www.givetoken.com](https://www.givetoken.com/) ([stone-timing-557.appspot.com](https://stone-timing-557.appspot.com/))
- staging: [dev.givetoken.com](http://dev.givetoken.com)
([http://t-sunlight-757.appspot.com/](https://t-sunlight-757.appspot.com/))

### Github

Make sure you have access & set your project remote

    git remote add github git@github.com:GiveToken/GiftBox.git

*this assumes ssh; you could use `https://github.com/GiveToken/GiftBox.git` instead of `git@...` for https if you prefer*

### <a id="database"></a>MySQL Database

- Download and install [MySQL workbench](https://www.mysql.com/products/workbench/).
- Get access to the [Google Developer Console](https://console.developers.google.com).

To create a local instance of the S!zzle database, refer [here](https://docs.google.com/document/d/1MXBCEeGCU5t-bE5zGqCAwAo6kwSL1o1dpUI_QhV_IQE/edit?usp=sharing) or just use MySQL Workbench's Schema Transfer Wizard.

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

### Google Cloud SDK

- Follow the instructions on the [sdk instructions page](https://cloud.google.com/sdk/)
- Be sure to restart your terminal
- `gcloud auth login`
- oAuth your Google account that has access to the project

#### Initialize/Configure the `gcloud` CLI

- `gcloud init PROJECT_ID` this is `stone-timing-557` for the production app. Thank Google for the awesome naming.
- For safety, open up the `.glcoud` file in the `stone-timing-557/` dir and remove the line `project = stone-timing-557`
  - this is to ensure that you always specify which project you are pushing your code to. You do not want to push staging code to production.
- `gcloud components update app` to add the neccessary gcloud CLI components

### <a id="composer"></a>Composer

[Composer](https://getcomposer.org/) is the PHP package manager used to bring in
3rd party PHP code. Once you have it in installed, cd to the project directory and
run

    composer install
    composer update

which will create everything you need in the untracked vendor directory.

### <a id="bower"></a>Bower

[Bower](http://bower.io/) is a package manager used to bring in Polymer
components. Once you have it in installed, cd to the project directory and
run

    bower install

which will create everything you need in the untracked components directory.

### Optimization

Polymer provides a tool to optimize & minify an app's code which you can get via

    npm install -g polybuild

and build the recruiting token with

    polybuild --maximum-crush recruiting_token.php

which creates `recruiting_token.build.html` & `recruiting_token.build.js`.
NB: it treats PHP like a comment and removes it.

Additionally, YUI compressor & json-minify are the tools we use for minimization:

    npm install -g yuicompressor
    npm install -g json-minify

## <a id="branching"></a>Branching Strategy

### Basic Tenets

1. All code on the `master` branch will always be production-ready. If it is not production-ready it should not be on `master`
2. The `develop` branch is not a sacred cow. It will be wise to occasionally blow away the `develop` branch and create a new one off of master.
3. Branch all topic branches off of the tip of `master`
4. All code gets merged into `master` via pull request (PR).
5. All code get approved by the project lead before being merged via PR.
6. Once code is approved for production and the PR has been merged, delete the branch on GH to declutter the branches view.
7. Commit messages begin with a present-tense verb and describe some combination of what was done, where it was done, and why-- Extra points for referencing the GH issue number.
8. Commit messages <= 50 columns. Anything longer should be broken up. Make use of the message paragraph-- i.e. `git commit` as opposed to `git commit -m "message"`
9. NEVER EVER EVER merge `develop` into `master`.

### Branch Naming

Branch names should follow the following convention:
- `feature`, `bug`, or `hotfix`
  - `feature` is new functionality
  - `bug` is unexpected behavior in exisiting functionality
  - `hotfix` is a `bug` of the highest priority-- e.g. the site is down or Give Token is leaking sensitive data.
- Forward slash
- The GH issue number
- dashes, never underscores
- A meaningful and short description of the branch, generally related to the title of the GH issue

##### Examples

- `bug/37-icons-broken-in-ie`
- `feature/236-user-can-add-avatar`
- `hotfix/76-repair-payment-gateway`

### Branching Off of Master

This is done by gitflow

### Merging with Develop

This should be done automatically using gitflow

### Handling Merge Conflicts

Github has a great reference [here](https://help.github.com/articles/resolving-a-merge-conflict-from-the-command-line/).

###  Pushing Code Live

once the PR has been approved and merged

- `git pull github master`
- Push code to production site, as described in the deployment procedures

Use [gitflow](http://jeffkreeftmeijer.com/2010/why-arent-you-using-git-flow/) and [cheatsheet](http://danielkummer.github.io/git-flow-cheatsheet/)for reference.

### Example Workflow from Start to Finish Feature.

- `git checkout develop`
- `git pull github develop`
- Either create the issue or find it on github and have it assigned to you.
- `git flow feature start [issue number]-<Issue Name>`
- Exhibit your brilliance
- `git add [files-to-add]`
- `git commit`
- Add commit message in vim editor that is displayed.
- `git pull github develop`
- `git flow feature finish [issue number]-<Issue Name>`
- `git push`
- [Deploy to staging site](#deploy-staging)
- QA on the staging site
- `git checkout master`
- `git pull github master`
- [Push code to production site](#deploy-production)
- profit

### Example Workflow from Start to Finish Hotfix. Used for bug fixes.

- `git checkout develop`
- `git pull github develop`
- Either create the issue or find it on github and have it assigned to you.
- `git flow hotfix start [issue number]-<Issue Name>`
- Exhibit your brilliance
- `git add [files-to-add]`
- `git commit`
- Add commit message in vim editor that is displayed.
- `git tag -a [version-bump]`
- `git pull github develop`
- `git flow hotfix finish [issue number]-<Issue Name>`
- `git push`
- [Deploy to staging site](#deploy-staging)
- QA on the staging site
- `git checkout master`
- `git pull github master`
- [Push code to production site](#deploy-production)
- avert profit loss

### Example Workflow from Start to Finish Publish. Used when you are unable to complete a feature or you are working in collaboration

User A
- `git checkout develop`
- `git pull github develop`
- Either create the issue or find it on github and have it assigned to you.
- `git flow feature start [issue number]-<Issue Name>`
- Exhibit your brilliance
- `git add [files-to-add]`
- `git commit`
- Add commit message in vim editor that is displayed.
- `git flow feature publish [issue number]-<Issue Name>`
- Go work on something else - checkout another branch

User B
- `git flow feature pull origin [issue number]-<Issue Name>`
- commit and finish feature and then push and deploy
- collaborate for profit!

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

## <a id="deployment"></a>Deployment

### Follow the Branching Procedures

Before you deploy anything, make sure you are following the [Give Token branching strategy](#branching).

When deploying using the following procedures, *be absolutely sure* that you are on the most up-to-date version of correct branch:

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

*assumptions: you have merged your topic branch into develop, pushed develop to the GH remote, and you are at the project root (i.e. `stone-timing-557/default/`)*

    git checkout develop
    git pull github develop
    ./build.sh staging

### <a id="deploy-production"></a>Deploy to Production
*assumptions: you have merged your pull request into master, pulled the GH master to your local machine, and you are at the project root (i.e. `stone-timing-557/default/`)*

    git checkout master
    git pull github master
    ./build.sh master

# GMP was here
