var assert = require('assert');
var fs = require('fs');
var vm = require('vm');
var jsdom = require('mocha-jsdom'); // This is necessary for testing jQuery in Mocha

describe('mocha tests', function () {

    jsdom();

    before(function () {
        $ = require('jquery');
    });

    // includes file to test
    var path = 'contact.js';
    var code = fs.readFileSync(path);
    vm.runInThisContext(code);

    describe('sendMessage', function() {

    });
});
