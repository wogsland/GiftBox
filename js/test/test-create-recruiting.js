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

describe('isVimeo', function() {
    it('should return false for non-Vimeo URL', function () {
        url = 'https://google.com';
        assert.equal(false, isVimeo(url));
    });
    it('should return true for Vimeo URL', function () {
        url = 'https://vimeo.com/12345';
        assert.equal(true, isVimeo(url));
    });
});

describe('isYouTube', function() {
    it('should return false for non-YouTube URL', function () {
        url = 'https://google.com';
        assert.equal(false, isYouTube(url));
    });
    it('should return true for YouTube URL', function () {
        url = 'https://www.youtube.com/watch?v=w3ugHP-yZXw';
        assert.equal(true, isYouTube(url));
    });
});

describe('youTubeId', function() {
    it('should return null for non-YouTube URL', function () {
        url = 'https://google.com';
        assert.equal(null, youTubeId(url));
    });
    it('should return id for YouTube URL', function () {
        id = 'w3ugHP-yZXw';
        url = 'https://www.youtube.com/watch?v='+id;
        assert.equal(id, youTubeId(url));
    });
});

describe('vimeoId', function() {
    it('should return null for non-Vimeo URL', function () {
        url = 'https://google.com';
        assert.equal(null, vimeoId(url));
    });
    it('should return id for Vimeo URL', function () {
        id = '12345';
        url = 'https://vimeo.com/'+id;
        assert.equal(id, vimeoId(url));
    });
});

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
