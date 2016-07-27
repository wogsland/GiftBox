#!/bin/bash
# simple shell script to build project

GREEN='\033[1;32m'
NC='\033[0m' # No Color

setup_1A() {
  mv token/recruiting_token.php .
  mv token/1A/recruiting-token.js js/
  rm token/1A/recruiting_token.build.html
  rm token/1A/recruiting_token.min.js
}

setup_1B() {
  mv token/recruiting_token.php .
  mv token/1B/recruiting-token.js js/
  rm token/1B/recruiting_token.build.html
  rm token/1B/recruiting_token.min.js
}

cleanup_1A() {
  mv recruiting_token.php token/
  mv js/recruiting-token.js token/1A/
  sed -i '' -e 's/recruiting_token\.min\.js\?/recruiting_token\.min\.js\?t\=1A\&/g' recruiting_token.build.html
  mv recruiting_token.build.html token/1A/
  mv public/js/dist/recruiting_token.min.js token/1A/
}

cleanup_1B() {
  mv recruiting_token.php token/
  mv js/recruiting-token.js token/1B/
  sed -i '' -e 's/recruiting_token\.min\.js\?/recruiting_token\.min\.js\?t\=1B\&/g' recruiting_token.build.html
  mv recruiting_token.build.html token/1B/
  mv public/js/dist/recruiting_token.min.js token/1B/
}

build_polymer() {
  npm run polybuild
  echo "Polybuild finished."
  echo ""
}

display_help() {
  echo "polybuild.sh - builds project files"
  echo
  echo "Usage:"
  echo "  1A - builds the 1A folder"
  echo "  1B - builds the 1B folder"
  echo "  both - builds the 1A and 1B folders"
  echo
}

display_1A_status() {
  printf "\n${GREEN}Building 1A files${NC}\n"
}

display_1B_status() {
  printf "\n${GREEN}Building 1B files${NC}\n"
}

if [ "$#" -gt 0 ]
then
  if [ "$1" = "1A" ]
  then
    display_1A_status
    setup_1A
    build_polymer
    cleanup_1A
    git status
  fi
  if [ "$1" = "1B" ]
  then
    display_1B_status
    setup_1B
    build_polymer
    cleanup_1B
    git status
  fi
  if [ "$1" = "both" ]
  then
    display_1A_status
    setup_1A
    build_polymer
    cleanup_1A

    echo

    display_1B_status
    setup_1B
    build_polymer
    cleanup_1B

    git status
  fi
else
  display_help
fi
