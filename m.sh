# run Mocha unit tests
#node js/mocha-setup.js
npm install jquery
MOCHA="$(mocha --version)"
echo "Running JavaScript tests with Mocha $MOCHA"
cd js
mocha
cd ..
#node js/mocha-teardown.js
npm uninstall jquery
echo ""
