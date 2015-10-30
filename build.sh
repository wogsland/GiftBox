#!/bin/bash
# simple shell script to build project

# run unit tests
./vendor/bin/phpunit --bootstrap src/tests/autoload.php -c tests.xml

# see what's changed
git status

# build polymer
polybuild --maximum-crush recruiting_token.php
mv recruiting_token.build.js js/recruiting_token.min.js
sed -i '' -e 's/recruiting_token\.build\.js/\/js\/recruiting_token\.min\.js/g' recruiting_token.build.html
sed -i '' -e 's/\"fonts\//\"\/fonts\//g' recruiting_token.build.html
echo "Polybuild finished."

# push it up to gcloud
if [ "$#" -gt 0 ]
then
  gcloud preview app deploy app.yaml --project t-sunlight-757 --version $1
fi
