#!/bin/bash
# sets up dependencies for python scraper

GREEN='\033[1;32m'
NC='\033[0m' # No Color

printf "\n${GREEN}Installing virtual environment${NC}\n"
pip install virtualenv

printf "\n${GREEN}Creating virtual environment${NC}\n"
virtualenv -p python3 venv

printf "\n${GREEN}Activating virtual environment${NC}\n"
source venv/bin/activate

printf "\n${GREEN}Installing scraper dependencies${NC}\n"
pip install -r requirements.txt
