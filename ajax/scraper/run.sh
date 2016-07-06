#!/bin/sh
# runs the python scraper

if [ "$#" -gt 0 ]
then
  source venv/bin/activate
  python3.4 linkedin.py $1
  deactivate
fi
