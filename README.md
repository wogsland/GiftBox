# GiftBox

## Table of Contents
1. [General Info](#general-info)
2. [Branching Strategy](#branching)
3. [Deployment Information](#deployment)

View at stone-timing-557.appspot.com

## <a name="general-info"></a>General Info

### URLs
hosted on Google Cloud
- production: [givetoken.com](http://givetoken.com/)
- staging: [http://t-sunlight-757.appspot.com/](http://t-sunlight-757.appspot.com/)

## <a name="database"></a>Database Management

### Creating a Local Instance of your database.

#### Assumptions:
- You have downloaded and installed MySQL workbench and have created your local instance
- You have access to the Google Developer Console linked in the following file.

To create a local instance of the givetoken database. Refer [here](https://docs.google.com/document/d/1MXBCEeGCU5t-bE5zGqCAwAo6kwSL1o1dpUI_QhV_IQE/edit?usp=sharing).

## <a name="composer"></a>Composer

[Composer](https://getcomposer.org/) is the PHP package manager used to bring in
3rd party code. Once you have it in installed, cd to the project directory and
run

    composer install
    composer update

which will create everything you need in the untracked vendor directory.

## <a name="branching"></a>Branching Strategy

### Basic Tenets

1. All code on the `master` branch will always be production-ready. If it is not production-ready it should not be on `master`
2. The `staging` branch is not a sacred cow. It will be wise to occasionally blow away the `staging` branch and create a new one off of master.
3. Branch all topic branches off of the tip of `master`
4. All code gets merged into `master` via pull request.
5. All code get approved by the project lead before being merged via PR.
6. Once code is approved for production and the PR has been merged, delete the branch on GH to declutter the branches view.
7. Commit messages begin with a present-tense verb and describe some combination of what was done, where it was done, and why-- Extra points for referencing the GH issue number.
8. Commit messages <= 50 columns. Anything longer should be broken up. Make use of the message paragraph-- i.e. `git commit` as opposed to `git commit -m "message"`
9. NEVER EVER EVER merge `staging` into `master`.

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

if you happen to run into merge conflicts:

- `git checkout [branch_youre_trying_to_merge_to]`
- `git status`
- Open the file that contains conflicts in your text editor of choice
- Look for `<<<<<<< HEAD` The conflict starts here and there can be more than one.
- Everything bewteen `<<<<<<< HEAD` and `=======` represents the code that's on the branch you are **merging to**
- Everything bewteen `=======` and `======= branch name or commit id` represents the code that's on the branch you want to **merge in**

<code><<<<<<< HEAD
<br>
  some code that does cool stuff (usually from master or staging)
<br>
=======</code>

<code>
  some new code that does even cooler stuff (from the branch you are merging in)
<br>
======= Name of branch that is being merged in or commit id
</code>

- Keep or remove any code that you don't want or shouldn't be included
- Delete all `<<<<<<< HEAD` and `=======` lines
- Save the file and switch to your terminal
- `git status`
- `git add [name_of_file]` or `git add .` (adds all files that were changed)
- `git commit -m "Fix merge conflicts"`
- `git push origin [branch_name]` (push to the branch you were initially trying to merge into)

###  Pushing Code Live

once the PR has been approved and merged

- `git pull github master`
- Push code to production site, as described in the deployment procedures

Use [gitflow](http://jeffkreeftmeijer.com/2010/why-arent-you-using-git-flow/) and [cheatsheet](http://danielkummer.github.io/git-flow-cheatsheet/)for reference.
### Example Workflow from Start to Finish Feature.
___

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
___

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

### Example Workflow from Start to Finish Release. Used for new releases.
___


### Example Workflow from Start to Finish Publish. Used when you are unable to complete a feature or you are working in collaboration
___

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


## <a name="deployment"></a>Deployment Information

### Assumptions

- You have access to the Google App Engine (GAE) and Github (GH) projects

### Install the Google Cloud SDK

- Follow the instructions on the [sdk instructions page](https://cloud.google.com/sdk/)
- Be sure to restart your terminal
- `gcloud auth login`
- oAuth your Google account that has access to the project

### Initialize/Configure the `gcloud` CLI

- `gcloud init PROJECT_ID` this is `stone-timing-557` for the production app. Thank Google for the awesome naming.
- For safety, open up the `.glcoud` file in the `stone-timing-557/` dir and remove the line `project = stone-timing-557`
  - this is to ensure that you always specify which project you are pushing your code to. You do not want to push staging code to production.
- `gcloud components update app` to add the neccessary gcloud CLI components

### Add GH to the Mix

- `cd stone-timing-557/default/`
- `git remote add github git@github.com:gp48maz1/GiftBox.git`
  - this assumes ssh; you could use `https://github.com/gp48maz1/GiftBox.git` instead of `git@...` for https if you prefer
- `git remote -v` and you should see origin (GAE) and GH remotes listed.
- `git fetch github`
- `git checkout develop` to checkout and track the remote staging branch

### Follow the Branching Procedures

Before you deploy anything, make sure you are following the [Give Token branching strategy](#branching).



## Most Important Caveat!

When deploying using the following procedures, *be absolutely sure* that you are on the most up-to-date version of correct branch:

#### `develop` -> staging site

#### `master` -> production


### <a name="deploy-staging"></a>Deploy to Staging

*assumptions: you have merged your topic branch into staging, pushed staging to the GH remote, and you are at the project root (i.e. `stone-timing-557/default/`)*

- `git checkout develop`
- `git pull github develop`
- `gcloud preview app deploy app.yaml --project t-sunlight-757 --version 1`

### <a name="deploy-production"></a>Deploy to Production
*assumptions: you have merged your pull request into master, pulled the GH master to your local machine, and you are at the project root (i.e. `stone-timing-557/default/`)*

- `git checkout master`
- `git pull github master`
- `gcloud preview app deploy app.yaml --project stone-timing-557 --version 1`

*protip: you could alias those two deployment commands in your shell of choice to reduce the typing*

## <a name="testing"></a>Testing

Presuming you have set up [Composer](#composer), then PHPUnit will be available
in your /vendor/bin directory. To run all the tests, just reference the
configuration file:

    phpunit --bootstrap src/tests/autoload.php -c tests.xml

To also investigate the code coverage of the tests, you'll need the
[Xdebug PHP extension](http://xdebug.org/docs/install).
Make sure you put any unit tests in the tests directory and name them like
whateverTest.php.

# GMP was here
