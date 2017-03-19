/**
 * Plugins for backend.
 */
module.exports = {
  output: {
    path: "assets",
    script: "compiled.js",
    style: "compiled.css"
  },
  
  path: "./",
  scripts: [
    "plugin/custom/bootstrap.filestyle.min.js",
    "plugin/custom/jquery.maskMoney.min.js",
    "plugin/custom/jquery-ui.min.js",
    "plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"
  ],
  styles: [
    "plugin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
  ],

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
    package: "fancybox",
    version: "*",
    scripts: ['source/jquery.fancybox.pack.js'],
    styles: ['source/jquery.fancybox.css']
  }]
};