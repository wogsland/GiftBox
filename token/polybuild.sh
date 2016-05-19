#!/bin/bash
# simple shell script to build project

if [ "$#" -gt 0 ]
then
  if [ "$1" = "1A" ]
  then
    mv token/1A/recruiting_token.php .
    mv token/1A/recruiting-token.js js/
    rm token/1A/recruiting_token.build.html
    rm token/1A/recruiting_token.min.js
  fi
  if [ "$1" = "1B" ]
  then
    mv token/1B/recruiting_token.php .
    mv token/1B/recruiting-token.js js/
    rm token/1B/recruiting_token.build.html
    rm token/1B/recruiting_token.min.js
  fi

  # build polymer
  npm run polybuild
  echo "Polybuild finished."
  echo ""

  # see what's changed
  git status

  if [ "$1" = "1A" ]
  then
    mv recruiting_token.php token/1A/
    mv js/recruiting-token.js token/1A/
    mv recruiting_token.build.html token/1A/
    mv public/js/dist/recruiting_token.min.js token/1A/
  fi
  if [ "$1" = "1B" ]
  then
    mv recruiting_token.php token/1B/
    mv js/recruiting-token.js token/1B/
    mv recruiting_token.build.html token/1B/
    mv public/js/dist/recruiting_token.min.js token/1B/
  fi
fi
