from bs4 import BeautifulSoup
from urllib.request import urlretrieve
import requests
import json
import sys
import re
import os

class LinkedInScraper(object):
    def __init__(self, name):
        self.name = name
        self.url = "https://linkedin.com/company/" + self.name
        self.media_prefix = "https://media.licdn.com/media/"
        self.company = {}

    def get_source(self):
        headers = {"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36"}
        response = requests.get(self.url, headers=headers)
        html = response.content.decode("utf-8")
        return html

    def parse_html(self):
        source = self.get_source()
        soup = BeautifulSoup(source, "html.parser")
        soup.encode("utf-8")
        result = soup.find_all("code", {"id":"stream-feed-embed-id-content"})
        return result

    def convert_json(self):
        parsed_html = self.parse_html()
        if len(parsed_html) != 0:
            raw_html = str(parsed_html[0])

            raw_html = raw_html.replace("<!--", "")
            raw_html = raw_html.replace("-->", "")
            raw_html = re.sub("(</?code>)", "", raw_html)
            raw_html = re.sub("(</?code.*?>)", "", raw_html)

            for char in raw_html:
                if char == "\n" or char == "\r":
                    raw_html = raw_html.replace(char, "")
                elif char == "’":
                    raw_html = raw_html.replace(char, "'")

            return json.loads(raw_html)
        return None

    def get_company_data(self):
        json = self.convert_json()
        if json != None:
            try:
                self.company["name"] = json["companyName"]
            except KeyError:
                self.company["name"] = ""

            try:
                self.company["description"] = json["description"]
            except KeyError:
                self.company["description"] = ""

            try:
                self.company["legacyLogo"] = json["legacySquareLogo"]
                if "description" in self.company.keys():
                    legacy_url = self.media_prefix + self.company["legacyLogo"]
                    urlretrieve(legacy_url, "legacyLogo.png")
            except KeyError:
                self.company["legacyLogo"] = ""

            try:
                self.company["heroImage"] = json["heroImage"]
                if "description" in self.company.keys():
                    hero_image_url = self.media_prefix + self.company["heroImage"]
                    urlretrieve(hero_image_url, "heroImage.png")
            except KeyError:
                self.company["heroImage"] = ""

            return self.company
        return None

if __name__ == "__main__":
    #company_name = sys.argv[1]
    #scraper = LinkedInScraper(company_name)
    #data = scraper.get_company_data()
    #data_json = json.dumps(data)
    #print(data_json)

    os.chdir("../../public")
    target = "temp.json"
    files = os.listdir()
    if target in files:
        f = open("temp.json", "r")
        data = json.load(f)
        print(data["url"])

        '''
        if len(files) != refreshed:
            for f in refreshed:
                if f not in files:
                    print("Detected %s" % f)
                    files.append(f)
            for f in files:
                if f not in refreshed:
                    print("Removed %s" % f)
                    files.remove(f)
        '''
