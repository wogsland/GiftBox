// require the things we need
var assert = require('assert');
var fs = require('fs');
var vm = require('vm');

// includes minified & uglified version, assuming mocha is run in repo root dir
var path = '../public/js/create_recruiting.min.js';
var code = fs.readFileSync(path);
vm.runInThisContext(code);

// include Autolinker.js
var path = '../public/components/Autolinker.js/dist/Autolinker.min.js';
var code = fs.readFileSync(path);
vm.runInThisContext(code);

describe('create_recruiting.js', function() {
  describe('excludedLinkify', function() {
    it('Should linkify most links, excluding asp.net', function () {
      var inputText = "Don't link asp.net but link google.com and www.kbb.com please!";
      var outputText = "Don't link asp.net but link <a href=\"http://google.com\" target=\"_blank\">google.com</a> and <a href=\"http://www.kbb.com\" target=\"_blank\">kbb.com</a> please!";
      assert.equal(outputText, excludedLinkify(inputText));
    });
    it('Should linkify most links, excluding ASP.NET', function () {
      var inputText = "Don't link ASP.NET but link example.com and customer.target.com please!";
      var outputText = "Don't link ASP.NET but link <a href=\"http://example.com\" target=\"_blank\">example.com</a> and <a href=\"http://customer.target.com\" target=\"_blank\">customer.target.com</a> please!";
      assert.equal(outputText, excludedLinkify(inputText));
    });
  });
});
