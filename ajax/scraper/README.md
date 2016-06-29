## Setting up the Python scraper

### Install Python 3.5.x

- Go to [https://www.python.org/downloads/](https://www.python.org/downloads/) and download the latest version of Python (as of June 29, 2016, it is Python 3.5.2)
- Follow the instructions on the GUI and wait until installation is complete
- Check that Python 3.5.x is installed by typing in `python3` on Terminal - you should get something like this:

```sh
Shreys-MBP:~ shreydesai$ python3
Python 3.5.2 (v3.5.2:4def2a2901a5, Jun 26 2016, 10:47:25)
[GCC 4.2.1 (Apple Inc. build 5666) (dot 3)] on darwin
Type "help", "copyright", "credits" or "license" for more information.
>>>
```

### Run the setup script

- Run `setup.sh` to set up the virtual environment and download the dependencies for the scraper
- Once that has completed, double check that there is a folder called `venv` in the `/ajax/scraper` directory
- To ensure everything is correctly set up, run the test (`test_linkedin.py`) by executing the following:

```sh
source venv/bin/activate
python3 test_linkedin.py
deactivate
```
