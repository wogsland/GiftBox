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
token/polybuild.sh both
echo ""

# minify css
npm run css
echo "CSS minified"
echo ""

# minify javascript
npm run js
npm run json
echo "JavaScript minified"
echo ""

# update public components - this needs tweeking
rm -rf public/components
cp -r components public/components
echo "Components updated"
echo ""

# run Mocha unit tests
echo "Running JavaScript tests"
npm run test
echo ""

# run python scraper tests
echo "Running Python scraper tests"
source ajax/scraper/venv/bin/activate
python3.4 -B ajax/scraper/test_linkedin.py
deactivate
echo ""

# see what's changed
git status
