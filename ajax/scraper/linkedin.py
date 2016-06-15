from bs4 import BeautifulSoup
import requests
import json
import sys
import re

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
            except KeyError:
                self.company["legacyLogo"] = ""

            try:
                self.company["heroImage"] = json["heroImage"]
            except KeyError:
                self.company["heroImage"] = ""

            return self.company
        return None

if __name__ == "__main__":
    company_name = sys.argv[1]
    scraper = LinkedInScraper(company_name)
    data = scraper.get_company_data()
    data_json = json.dumps(data)
    print(data_json)
