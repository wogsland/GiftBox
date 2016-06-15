from unittest import TestCase, main
from linkedin import LinkedInScraper

class TestLinkedInScraper(TestCase):
    def setUp(self):
        self.c1 = LinkedInScraper("google").get_company_data()
        self.c2 = LinkedInScraper("asdfasdf").get_company_data()
        self.c3 = LinkedInScraper("1284ljd").get_company_data()

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

if __name__ == "__main__":
    main()
