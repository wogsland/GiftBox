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

- `git pull github master`
- `git checkout -b feature/233-example-branch-name`
- Exhibit your brilliance
- `git add [filename]`
- `git commit -am "Add great new functionality to users per 223"`
- `git push github feature/233-example-branch-name`


### Merging with Staging

to check your code on a production-like environment

- `git checkout staging`
- `git merge --no-ff bug/5-emperor-has-no-clothes`
- `git push github staging`
- deploy to staging site

### Sending a Pull Request

once satisfied that your code is production-ready on the staging site

- `git checkout feature/33-cat-videoz`
- `git push github feature/33-cat-videoz`
- On GH either find your branch and click "create pull request" or go to the PR page and find your branch

Alternatively, you could use the [hub gem](https://github.com/github/hub) to create PRs from the command line.

###  Pushing Code Live

once the PR has been approved and merged

- `git pull github master`
- Push code to production site, as described in the deployment procedures


### Example Workflow from Start to Finish
___

- `git pull github master`
- `git checkout -b feature/233-example-branch-name`
- Exhibit your brilliance
- `git commit -am "Add great new functionality to users per 223"`
- `git push github feature/233-example-branch-name`
- `git checkout staging`
- `git merge --no-ff feature/233-example-branch-name`
- `git push github staging`
- [Deploy to staging site](#deploy-staging)
- QA on the staging site
- `git checkout feature/233-example-branch-name`
- `git push github feature/233-example-branch-name`
- On GH either find your branch and click "create pull request" or go to the PR page and find your branch
- `git pull github master`
- [Push code to production site](#deploy-production)
- profit


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
- `git checkout staging` to checkout and track the remote staging branch

### Follow the Branching Procedures

Before you deploy anything, make sure you are following the [Give Token branching strategy](#branching).



## Most Important Caveat!

When deploying using the following procedures, *be absolutely sure* that you are on the most up-to-date version of correct branch:

#### `staging` -> staging site

#### `master` -> production


### <a name="deploy-staging"></a>Deploy to Staging

*assumptions: you have merged your topic branch into staging, pushed staging to the GH remote, and you are at the project root (i.e. `stone-timing-557/default/`)*

- `git checkout staging`
- `git pull github staging`
- `gcloud preview app deploy ./ --project t-sunlight-757`

### <a name="deploy-production"></a>Deploy to Production
*assumptions: you have merged your pull request into master, pulled the GH master to your local machine, and you are at the project root (i.e. `stone-timing-557/default/`)*

- `git checkout master`
- `git pull github master`
- `gcloud preview app deploy ./ --project stone-timing-557`

*protip: you could alias those two deployment commands in your shell of choice to reduce the typing*

# GMP was here

