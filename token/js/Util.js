Sizzle.Util = {

  /**
   * Checks if data is defined, not null and not the empty string
   *
   * @param {mixed} data The data to check
   * @return {boolean} If data exists
   */
  'dataExists': function (data) {
    return data !== undefined && data !== null && '' !== data;
  },

  /**
   * Determines whether an element is present and visible on the page
   * @param {HTMLElement} section_el
   * @returns {boolean}
   */
  'elementIsPresent': function(section_el) {
    return (section_el !== null) && (section_el.style.display !== 'none');
  },

  /**
   * Returns the host for referencing assets based on environment
   *
   * @return {string} The host for referencing assets
   */
  'getAssetHost': function() {
    switch (window.location.hostname) {
      default:
      return '/uploads';
    }
  },

  /**
   * Gets the location of the ith occurance of m in str
   *
   * @param {string} string to search
   * @param {string} string to find
   * @param {int} which occurance to find
   * @return {int} wher it occurred
   */
  'getPosition': function (str, m, i) {
     return str.split(m, i).join(m).length;
  },

  /**
   * Returns the URL path broken into pieces
   *
   * @return {array} The URL path broken into pieces
   */
  'getUrlPath': function() {
    var vars = {};
    i = 0;
    var parts = window.location.href.replace(/\/([a-zA-Z0-9]*)/gi, function(value) {
      vars[i] = value;
      i++;
    });
    return vars;
  },

  /**
   * Takes a number and adds commas to it every third digit
   *
   * @param {number} x The number to add commas to
   * @return {string} The number with commas added
   */
  'numberWithCommas': function(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  },
};
