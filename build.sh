#!/bin/bash
# simple shell script to build project

if [ "$#" -gt 0 -a "$1" = "-h" ]
then
  echo ""
  echo "NAME"
  echo "     build -- builds S!zzle project"
  echo ""
  echo "SYNOPSIS"
  echo "     ./build.sh [-h] [project]"
  echo ""
  echo "DESCRIPTION"
  echo "     This tool is for building & pushing the S!zzle project. Choosing the project option master or staging."
  echo ""
  echo "     The following options are available:"
  echo ""
  echo "     -h     Print this help screen"
  echo ""
  exit
fi

# run PHP unit tests
./vendor/bin/phpunit --bootstrap src/tests/autoload.php -c tests.xml
echo ""

# build polymer
polybuild --maximum-crush recruiting_token.php
mv recruiting_token.build.js public/js/recruiting_token.min.js
sed -i '' -e 's/recruiting_token\.build\.js/\/js\/recruiting_token\.min\.js/g' recruiting_token.build.html
sed -i '' -e 's/\"fonts\//\"\/fonts\//g' recruiting_token.build.html
echo "Polybuild finished."
echo ""

# gulp tasks
npm run css

# minify css
yuicompressor css/colorbox.css -o public/css/colorbox.min.css
yuicompressor css/magnific-popup.css -o public/css/magnific-popup.min.css
yuicompressor css/create_recruiting.css -o public/css/create_recruiting.min.css
yuicompressor css/datatables.css -o public/css/datatables.min.css
yuicompressor css/at-at.css -o public/css/at-at.min.css
yuicompressor css/ball-robot.css -o public/css/ball-robot.min.css
echo "CSS minified"
echo ""

# minify javascript
yuicompressor js/smoothscroll.js -o public/js/smoothscroll.min.js
yuicompressor js/wow.js -o public/js/wow.min.js
yuicompressor js/create_common.js -o public/js/create_common.min.js
yuicompressor js/create_recruiting.js -o public/js/create_recruiting.min.js
yuicompressor js/custom.js -o public/js/custom.min.js
yuicompressor js/account.js -o public/js/account.min.js
yuicompressor js/pricing.js -o public/js/pricing.min.js
yuicompressor js/matchMedia.js -o public/js/matchMedia.min.js
yuicompressor js/contact.js -o public/js/contact.min.js
yuicompressor js/login.js -o public/js/login.min.js
yuicompressor js/signup.js -o public/js/signup.min.js
json-minify js/api-v1.json > public/js/api-v1.json
echo "JavaScript minified"
echo ""

# update public components - this needs tweeking
rm -rf public/components
cp -r components public/components
echo "Components updated"
echo ""

# run Mocha unit tests
MOCHA="$(mocha --version)"
echo "Running JavaScript tests with Mocha $MOCHA"
cd js
mocha
cd ..
echo ""

# see what's changed
git status

# push it up to github
if [ "$#" -gt 0 ]
then
  echo ""
  case $1 in
#    "master") do nothing
    "staging") git push github develop ;;
#    *) do nothing ;;
  esac
fi
