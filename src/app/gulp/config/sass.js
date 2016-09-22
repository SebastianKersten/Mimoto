var config = require('./');

module.exports = {

  cssName: 'mimoto.aimless.css',
  src: config.src + "scss/**/*.{sass,scss}",
  dest: config.dest + "/css",
  settings: {
    outputStyle: 'compressed',
    indentedSyntax: true, // Enable .sass syntax!
    imagePath: 'images' // Used by the image-url helper
  }

};
