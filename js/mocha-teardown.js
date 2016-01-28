// require the things we need
console.log('Tearing down...');
var fs = require('fs');

// include jQuery
var tempDir = 'js/temp';
var jqueryLocalPath = tempDir+'/jquery.min.js';
fs.unlink(jqueryLocalPath);
fs.rmdir(tempDir);
console.log('done');
