var config = require('./');

module.exports = {

  cssName: 'mimoto.aimless.css',
  src: ["src/**/*.{sass,scss}"],
  dest: config.dest + "/css",
  settings: {
    outputStyle: 'compressed',
    includePaths: ['node_modules/foundation-sites/scss', 'node_modules'],
    indentedSyntax: true // Enable .sass syntax!
  }

};
