#!/bin/bash
# sets up dependencies for python scraper

GREEN='\033[1;32m'
NC='\033[0m' # No Color

printf "\n${GREEN}Installing virtual environment${NC}\n"
sudo yum install python34-virtualenv
sudo alternatives --set python /usr/bin/python3.4

printf "\n${GREEN}Creating virtual environment${NC}\n"
sudo virtualenv-3.4 venv

printf "\n${GREEN}Activating virtual environment${NC}\n"
source venv/bin/activate

printf "\n${GREEN}Installing scraper dependencies${NC}\n"
sudo pip install -r requirements.txt
