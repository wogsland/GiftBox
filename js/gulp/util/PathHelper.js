var path = require('path');

/**
 * Quick reference of CSS and JS assets without needing
 * to repeat the full path.
 *
 * @param cssDir {string} The path to the css source directory.
 * @param jsDir {string} The path to the javascript source directory.
 * @param vendorDir {string} The name of the vendor subdirectory
 *        (assumed to match between css and js)
 *
 * @constructor
 */
function PathHelper(cssDir, jsDir, vendorDir){
    this._cssDir = cssDir;
    this._jsDir = jsDir;
    this._vendor = vendorDir;
}

PathHelper.create = function() {
    var instance = Object.create(this.prototype);
    this.apply(instance, arguments);
    return instance;
};

PathHelper.prototype = {
    js: function (name) {
        return this._getPath(name, this._jsDir, 'js');
    },
    vendor_js: function (name) {
        return this.js(path.join(this._vendor, name));
    },
    controller: function(name) {
        return this.js(path.join('controllers', name));
    },
    component: function(name) {
        return this.js(path.join('components', name));
    },

    css: function (name) {
        return this._getPath(name, this._cssDir, 'css');
    },
    vendor_css: function (name) {
        return this.css(path.join(this._vendor, name));
    },
    styl: function (name) {
        return this._getPath(name, this._cssDir, 'styl');
    },
    _getPath: function(name, directory, ext) {
        return path.join(directory, name + '.' + ext);
    }
};

module.exports = PathHelper;
