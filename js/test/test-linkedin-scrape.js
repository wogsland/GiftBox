var assert = require('assert');
var fs = require('fs');
var vm = require('vm');
var jsdom = require('mocha-jsdom');
var chai = require('chai');
var sinon = require('sinon');

describe('scraper.js', function() {

  // jquery setup
  jsdom();
  before(function() {
    $ = require('jquery');
  });

  // set up document
  var doc = require('jsdom').jsdom;
  var clock = sinon.useFakeTimers();

  document = doc(fs.readFileSync('/Library/Webserver/Documents/GiftBox/create_company.php'));

  // includes file to test
  var path = '/Library/Webserver/Documents/GiftBox/js/scraper.js';
  var code = fs.readFileSync(path);
  //vm.runInThisContext(code);

  /*
  describe('running', function() {
    it('should run javascript with jquery', function() {
      assert.equal(false, vm.runInThisContext(code));
    });
  });
  */

  beforeEach(function() {
    clock.restore();
  });

  describe('defaults', function() {
    it('should not have the add button open by default', function() {
      chai.expect($('#linkedin-add-button').is(':visible')).eql(false);
    });

    it('should not have the progress bar open by deafult', function() {
      chai.expect($('#linkedin-progress').is(':visible')).eql(false);
    })
  })

  describe('modal core', function() {
    it('should open when linkedin button is pressed', function() {
      $('#linkedin-scrape-button').trigger('click');
      chai.expect($('#linkedin-dialog').attr('aria-hidden')).to.be.undefined;
    });

    it('should have no pre-existing text present', function() {
      chai.expect($('#input').val()).to.be.undefined;
    });

    it('should have red text when company is not found', function() {
      $('#input').val('https://www.linkedin.com/company/alksdjflaskdjf');
      $('#linkedin-submit-button').trigger('click');
      chai.expect($('label').css('color')).to.undefined;
    });

    it('should have green text when company is found', function() {
      $('#input').val('https://www.linkedin.com/company/sizzle');
      $('#linkedin-submit-button').click();
      chai.expect($('label').css('color')).to.be.undefined;
    });

    it('should reset when company is found and cancelled', function() {
      $('#linkedin-scrape-button').trigger('click');
      $('#input').val('https://www.linkedin.com/company/sizzle');
      $('#linkedin-cancel-button').trigger('click');
      $('#linkedin-scrape-button').trigger('click');
      chai.expect($('#input').val()).to.be.undefined;
    });
  });

  describe('progress bar', function() {
    it('should not be there by default', function() {
      chai.expect($('#linkedin-progress').is(':visible')).eql(false);
    });
  })

  describe('token information', function() {
    it('should have a populated name field', function() {
      $('#company').val('Sizzle');
      chai.expect($('#company').val());
    });

    it('should have a populated description field', function() {
      $('#company-description').val('Description');
      chai.expect($('#company-description').val());
    });

    it('should have no images in the image field', function() {
      let elem = $('.thumbnail-container');
      chai.expect(elem.children().length).to.eql(0);
    });
  });
});
