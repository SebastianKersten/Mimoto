var config = require('./');

module.exports = {

  cssName: 'mimoto.aimless.css',
  src: "../**/*.scss",
  dest: config.dest + "/css",
  settings: {
    outputStyle: 'compressed',
    indentedSyntax: true // Enable .sass syntax!
  }

};
