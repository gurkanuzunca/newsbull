/**
 * Plugins for frontend.
 */
module.exports = {
  output: {
    path: "assets",
    script: "compiled.js",
    style: "compiled.css"
  },
  
  path: "./",
  scripts: [],
  styles: [],

  pluginPath: "bower",
  plugins: [{
    package: "jquery",
    version: "2.0.*",
    scripts: ['jquery.min.js']
  }, {
    package: "bootstrap",
    version: "3.*",
    scripts: ['dist/js/bootstrap.min.js'],
    styles: ['dist/css/bootstrap.min.css']
  }, {
    package: "font-awesome",
    version: "4.*",
    styles: ['css/font-awesome.min.css']
  }, {
    package: "slick-carousel",
    version: "*",
    scripts: ['slick/slick.js'],
    styles: ['slick/slick.css']
  }]
};