#!/bin/sh
# runs the python scrapers

if [ "$#" -gt 0 ]
then
  source venv/bin/activate
  python3 linkedin.py $1
  deactivate
else
  exit 1
fi
