// require the thing we need
var assert = require('assert');
var fs = require('fs');
var vm = require('vm');
var $ = require('jquery');

// include jQuery
/*var jqueryLocalPath = 'temp/jquery.min.js';
var jqueryCode = fs.readFileSync(jqueryLocalPath);
vm.runInThisContext(jqueryCode);*/

// includes minified & uglified version, assuming mocha is run in repo root dir
var path = '../public/js/account.min.js';
var code = fs.readFileSync(path);
vm.runInThisContext(code);

describe('getSession', function() {
  it('should return the empty string because it fails', function () {
      assert.equal('', getSession());
  });
});
