#!/bin/bash
# simple shell script to build project

if [ "$#" -gt 0 -a "$1" = "-h" ]
then
  echo ""
  echo "NAME"
  echo "     build -- builds GiveToken project"
  echo ""
  echo "SYNOPSIS"
  echo "     ./build.sh [-h] [project]"
  echo ""
  echo "DESCRIPTION"
  echo "     This tool is for building & pushing the GiveToken project. Choosing the project option master or staging"
  echo "     will push the build to givetoken.com or t-sunlight-757.appspot.com respectively. Any other project option"
  echo "     will result in a push to <project>-dot-t-sunlight-757.appspot.com."
  echo ""
  echo "     The following options are available:"
  echo ""
  echo "     -h     Print this help screen"
  echo ""
  exit
fi

# run unit tests
./vendor/bin/phpunit --bootstrap src/tests/autoload.php -c tests.xml
echo ""

# see what's changed
git status
echo ""

# build polymer
polybuild --maximum-crush recruiting_token.php
mv recruiting_token.build.js js/recruiting_token.min.js
sed -i '' -e 's/recruiting_token\.build\.js/\/js\/recruiting_token\.min\.js/g' recruiting_token.build.html
sed -i '' -e 's/\"fonts\//\"\/fonts\//g' recruiting_token.build.html
echo "Polybuild finished."
echo ""

# minify css
yuicompressor css/styles.css -o css/styles.min.css
yuicompressor css/magnific-popup.css -o css/magnific-popup.min.css
yuicompressor css/create_recruiting.css -o css/create_recruiting.min.css
yuicompressor css/create.css -o css/create.min.css
yuicompressor css/create_and_preview.css -o css/create_and_preview.min.css
yuicompressor css/preview.css -o css/preview.min.css
yuicompressor css/users_groups.css -o css/users_groups.min.css
echo "CSS minified"
echo ""

# push it up to gcloud
if [ "$#" -gt 0 ]
then
  echo ""
  case $1 in
    "master") gcloud preview app deploy app.yaml --project stone-timing-557 --promote ;;
    "staging") gcloud preview app deploy app.yaml --project t-sunlight-757 --promote ;;
    *) gcloud preview app deploy app.yaml --project t-sunlight-757 --version $1 ;;
  esac
fi
