var assert = require('assert');
var fs = require('fs');
var vm = require('vm');
var jsdom = require('mocha-jsdom'); // This is necessary for testing jQuery in Mocha

describe('recruiting-token.js', function () {

    // setup jquery
    jsdom();
    before(function () {
        $ = require('jquery');
    });

    // set up the document
    var doc = require('jsdom').jsdom;
    document = doc(fs.readFileSync('../token/1A/recruiting_token.php'));

    // includes file to test
    var path = '../token/1A/recruiting-token.js';
    var code = fs.readFileSync(path);
    //vm.runInThisContext(code);

    describe('running', function () {
        it('this test is here to run the JavaScript with jQuery', function () {
            assert.notEqual(true, vm.runInThisContext(code));
        });
    });

    describe('numberWithCommas', function () {
        it('should return number less than 1000 unchanged', function () {
            numberBefore = Math.floor((Math.random() * 1000));
            assert.equal(numberBefore, numberWithCommas(numberBefore));
        });
        it('should return 123456 as 123,456', function () {
            numberBefore = 123456;
            assert.equal('123,456', numberWithCommas(numberBefore));
        });
        it('should return 1234561234567 as 1,234,561,234,567', function () {
            numberBefore = 1234561234567;
            assert.equal('1,234,561,234,567', numberWithCommas(numberBefore));
        });
    });

    describe('dataExists', function () {
        it('should return false for no param', function () {
            assert.equal(false, dataExists());
        });
        it('should return false for empty string', function () {
            assert.equal(false, dataExists(''));
        });
        it('should return false for null', function () {
            thisVariableIsNull = null;
            assert.equal(false, dataExists(thisVariableIsNull));
        });
        it('should return true for defined variable', function () {
            thisVariableIsDefined = 'see';
            assert.equal(true, dataExists(thisVariableIsDefined));
        });
    });

    describe('getAssetHost', function () {
        it('should return uploads', function () {
            assert.equal('/uploads', getAssetHost());
        });
    });

});
