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
    var path = 'create_common.js';
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
});
