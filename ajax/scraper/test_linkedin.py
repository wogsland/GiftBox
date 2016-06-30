from unittest import TestCase, main
from linkedin import LinkedInScraper
import os
import shutil

class TestLinkedInScraper(TestCase):
    def setUp(self):
        base_url = "https://www.linkedin.com/company/"
        self.c1 = LinkedInScraper(base_url + "google").get_company_data()
        self.c2 = LinkedInScraper(base_url + "asdfasdf").get_company_data()
        self.c3 = LinkedInScraper(base_url + "1284ljd").get_company_data()

    def test_company_1(self):
        self.assertTrue(len(self.c1["name"]) > 0)
        self.assertTrue(len(self.c1["description"]) > 0)
        self.assertTrue(len(self.c1["heroImage"]) > 0)
        self.assertTrue(len(self.c1["legacyLogo"]) > 0)

    def test_company_2(self):
        self.assertTrue(len(self.c2["name"]) != 0)
        self.assertTrue(len(self.c2["description"]) == 0)
        self.assertTrue(len(self.c2["heroImage"]) == 0)
        self.assertTrue(len(self.c2["legacyLogo"]) == 0)

    def test_company_3(self):
        self.assertIsNone(self.c3)

    def tearDown(self):
        to_delete = ["__pycache__", "heroImage.png", "legacyLogo.png"]
        for f in os.listdir():
            if f in to_delete:
                if f == "__pycache__":
                    shutil.rmtree(f)
                else:
                    os.remove(f)

if __name__ == "__main__":
    main()
