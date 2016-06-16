#!/bin/sh
# moves scraped images to /public/uploads

EXTENSION=".png"

if [ "$#" -gt 0 ]
then
  mv $1 $2
  mv $2 ../../public/uploads
fi

echo true
