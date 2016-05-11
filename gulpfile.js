/* @preserve
 *
 * Author:  Jaume Sala
 * Website: jaumesala.net
 *
 */

var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

/*
 |--------------------------------------------------------------------------
 | Global variables
 |--------------------------------------------------------------------------
 */

var publicPath      = "public";
var vendorPath      = 'vendor/';
var bowerPath       = vendorPath + 'bower_components/';
var bowerRelative   = '../../../' + bowerPath;
var nodePath        = 'node_modules/';
var nodeRelative   = '../../../' + nodePath;
var min             = elixir.config.production ? '.min' : '';


elixir.config.publicPath                        = publicPath;
elixir.config.css.autoprefix.options.browsers   = ['last 2 versions', 'ie 8', 'ie 9'];

/*
 |--------------------------------------------------------------------------
 | Bower components array (plugins.js)
 |--------------------------------------------------------------------------
 */

var components = [

    bowerRelative + 'bootstrap-sass/assets/javascripts/bootstrap.js',
    bowerRelative + 'underscore/underscore.js',
    bowerRelative + 'chroma-js/chroma.js',
    bowerRelative + 'AdminLTE/plugins/iCheck/icheck.js',
    bowerRelative + 'AdminLTE/plugins/slimScroll/jquery.slimscroll.js',
    bowerRelative + 'AdminLTE/plugins/select2/select2.full.js',
    bowerRelative + 'AdminLTE/plugins/bootstrap-slider/bootstrap-slider.js',
    bowerRelative + 'AdminLTE/plugins/slimScroll/jquery.slimscroll.js',
    bowerRelative + 'AdminLTE/plugins/colorpicker/bootstrap-colorpicker.js',
    bowerRelative + 'AdminLTE/dist/js/app.js',
    // nodeRelative + 'vue/dist/vue.js',
    // nodeRelative + 'vue-resource/dist/vue-resource.js',
    // bowerRelative + 'imagesloaded/imagesloaded.pkgd.js',
    // bowerRelative + 'jquery-form/jquery.form.js',
    // bowerRelative + 'jquery-validation/dist/jquery.validate.js',
    // bowerRelative + 'jquery.easing/js/jquery.easing.js',
    // bowerRelative + 'slick.js/slick/slick.js',
];

var componentsPublic = [

    bowerRelative + 'bootstrap-sass/assets/javascripts/bootstrap.js',
    'admin/components/mapView.js',
    bowerRelative + 'underscore/underscore.js',
    bowerRelative + 'chroma-js/chroma.js',
];


/*
 |--------------------------------------------------------------------------
 | Copy array
 |--------------------------------------------------------------------------
 */
var copyToPublic = [

    // JQuery
    [   bowerPath + 'jquery/jquery.js',
        publicPath + '/' + elixir.config.js.outputFolder +'/vendor/jquery.js'],
    [   bowerPath + 'jquery/jquery.min.js',
        publicPath + '/' + elixir.config.js.outputFolder +'/vendor/jquery.min.js'],

    // JQuery UI
    [   bowerPath + 'jquery-ui/jquery-ui.js',
        publicPath + '/' + elixir.config.js.outputFolder +'/vendor/jquery-ui.js'],
    [   bowerPath + 'jquery-ui/jquery-ui.min.js',
        publicPath + '/' + elixir.config.js.outputFolder +'/vendor/jquery-ui.min.js'],

    // Modernizr
    [   elixir.config.assetsPath + '/vendor/modernizr/modernizr-2.8.3.min.js',
        publicPath + '/' + elixir.config.js.outputFolder + '/vendor/modernizr-2.8.3.min.js'],

    // Bootstrap fonts
    [   bowerPath + 'bootstrap-sass/assets/fonts/bootstrap',
        elixir.config.publicPath + '/fonts/bootstrap'],

    // Font-awesome fonts
    [   bowerPath + 'font-awesome/fonts',
        elixir.config.publicPath + '/fonts/font-awesome'],

    // Project fonts
    [   elixir.config.assetsPath + '/fonts',
        elixir.config.publicPath + '/fonts'],

    // Plugin iCheck images
    [   bowerPath + 'AdminLTE/plugins/iCheck/square/blue.png',
        elixir.config.publicPath + '/img/admin/plugins/iCheck/blue.png'],
    [   bowerPath + 'AdminLTE/plugins/iCheck/square/blue@2x.png',
        elixir.config.publicPath + '/img/admin/plugins/iCheck/blue@2x.png'],

    // Plugin colorpicker
    [   bowerPath + 'AdminLTE/plugins/colorpicker/img',
        elixir.config.publicPath + '/img/admin/plugins/colorpicker']

];

/*
 |--------------------------------------------------------------------------
 | Main default task
 |--------------------------------------------------------------------------
 */
elixir(function(mix) {
    mix

        /*
         |--------------------------------------------------------------------------
         | Admin files
         |--------------------------------------------------------------------------
         */

        // admin/app.scss
        .sass('admin/app.scss', publicPath + '/' + elixir.config.css.outputFolder + '/admin/app' + min + '.css')

        // admin/app/app.js
        .scriptsIn(
            elixir.config.assetsPath + '/js/admin',
            publicPath + '/' + elixir.config.js.outputFolder + '/admin/app' + min + '.js'
        )

        //plugins.js
        .scripts(
            components,
            publicPath + '/' + elixir.config.js.outputFolder + '/admin/plugins' + min + '.js',
            elixir.config.assetsPath + '/js'
        )


        /*
         |--------------------------------------------------------------------------
         | Public files
         |--------------------------------------------------------------------------
         */

        // public/app.scss
        .sass('public/app.scss', publicPath + '/' + elixir.config.css.outputFolder + '/public/app' + min + '.css')

        // public/app/app.js
        .scriptsIn(
            elixir.config.assetsPath + '/js/public',
            publicPath + '/' + elixir.config.js.outputFolder + '/public/app' + min + '.js'
        )

        //plugins.js
        .scripts(
            componentsPublic,
            publicPath + '/' + elixir.config.js.outputFolder + '/public/plugins' + min + '.js',
            elixir.config.assetsPath + '/js'
        )


        // copy files
        for (var i = 0, len = copyToPublic.length; i < len; i++) {
            mix.copy(
                copyToPublic[i][0],
                copyToPublic[i][1]
            );
        }

});
