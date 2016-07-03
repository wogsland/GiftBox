var fs = require('fs');
var path = require('path');
var target = path.join(__dirname, 'js', 'gulp', 'tasks');

/**
 * Recursively walks through the js/gulp/tasks directory
 * and synchronously finds *.js to include in the Gulp path
 */
function walk(target) {
  fs.readdirSync(target).forEach(function(file) {
    let trail = target + '/' + file;
    let stats = fs.statSync(trail);
    if (stats.isDirectory()) walk(trail);
    if (stats.isFile() && trail.includes('.js')) {
      var split = function(string) {
        if (string.includes(__dirname)) {
          string = string.replace(__dirname, '.');
          string = string.replace('.js', '');
          require(string);
        }
      }(trail);
    }
  });
}

walk(path.join(__dirname, 'js', 'gulp', 'tasks'));
