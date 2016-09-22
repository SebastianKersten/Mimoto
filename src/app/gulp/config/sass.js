module.exports = {

  destName: 'app.min.css',
  src: "./scss/**/*.{sass,scss}",
  dest: "../../web/static/css",
  settings: {
    outputStyle: 'compressed',
    indentedSyntax: true, // Enable .sass syntax!
    imagePath: 'images' // Used by the image-url helper
  }

};
