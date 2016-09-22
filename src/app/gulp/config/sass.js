var config = require('./');

module.exports = {

  destName: 'app.min.css',
  src: config.src + "scss/**/*.{sass,scss}",
  dest: config.dest + "/css",
  settings: {
    outputStyle: 'compressed',
    indentedSyntax: true, // Enable .sass syntax!
    imagePath: 'images' // Used by the image-url helper
  }

};
