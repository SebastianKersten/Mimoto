var config = require('./');

module.exports = {

  cssName: 'mimoto.aimless.css',
  src: ["../**/*.scss", "!node_modules/**"],
  dest: config.dest + "/css",
  settings: {
    outputStyle: 'compressed',
    indentedSyntax: true // Enable .sass syntax!
  }

};
