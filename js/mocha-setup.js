// require the things we need
console.log('Setting Up...');
var fs = require('fs');
var http = require('http');
var vm = require('vm');

// include jQuery
var tempDir = 'js/temp';
var jqueryPath = 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js';
var jqueryLocalPath = tempDir+'/jquery.min.js';
fs.mkdir(tempDir);
var jqueryFile = fs.createWriteStream(jqueryLocalPath);
var request = http.get(jqueryPath, function(response) {
  response.pipe(jqueryFile);
}).on('error', function(e) {
  console.log('Error is');
  console.log(e);
});
var jqueryCode = fs.readFileSync(jqueryLocalPath);
vm.runInThisContext(jqueryCode);
console.log('done');
