// CONFIG SETTINGS
const defaultConfig               = require("@wordpress/scripts/config/webpack.config");
const config                      = require("./app.config");

// UTILS
// const path                        = require("path");
const isDev                       = require("isdev");
const webpack                     = require("webpack");
// const autoprefixer                = require("autoprefixer");
const env                         = require("./utils/env");

// PLUGINS
const CopyPlugin                  = require("copy-webpack-plugin");
const CleanWebpackPlugin          = require('clean-webpack-plugin');
const CompressionPlugin           = require('compression-webpack-plugin');
const TerserPlugin                = require('terser-webpack-plugin');
const MiniCssExtractPlugin        = require("mini-css-extract-plugin");
const { default: ImageminPlugin } = require("imagemin-webpack-plugin");
// const { VueLoaderPlugin }         = require("vue-loader");
const glob                        = require("glob");

// RULES
// const vueRule                     = require("./rules/vue");
const sassRule                    = require("./rules/sass");
const fontsRule                   = require("./rules/fonts");
const imagesRule                  = require("./rules/images");
const javascriptRule              = require("./rules/javascript");
const externalFontsRule           = require("./rules/external.fonts");
const externalImagesRule          = require("./rules/external.images");

const mapFilenamesToEntries = pattern => glob
  .sync(pattern)
  .reduce((entries, filename) => {
    const [, name] = filename.match(/(?<x>[^/]+)\.scss$/)
    return { ...entries, [name]: filename }
  }, {})

const isPlatform = env("PLATFORM_OUTPUT_DIR", false) !== false;

process.traceDeprecation = true

module.exports = {
  // Extend default wordpress webpack config
  ...defaultConfig,
  mode: isDev ? "development" : "production",

  /**
   * Should the source map be generated?
   *
   * @type {string|undefined}
   */
  devtool: isDev && config.settings.sourceMaps ? "source-map" : false,

  /**
   * Application entry files for building.
   *
   * @type {Object}
   */
  entry: {
    ...config.entry,
    // Files found here will be outputted to their own css file.
    ...mapFilenamesToEntries(config.paths.sass + "/@slug/*.scss")
  },

  /**
   * Output settings for application scripts.
   *
   * @type {Object}
   */
  output: {
    path: config.paths.public,
    publicPath: "/" + env('WP_CONTENT') + "/themes/" + env('WP_THEME') + "/public/",
    filename: config.outputs.javascript.filename,
    chunkFilename: config.outputs.chunk.filename
  },

  /**
   * External objects which should be accessible inside application scripts.
   *
   * @type {Object}
   */
  externals: config.externals,

  /**
   * Custom modules resolving settings.
   *
   * @type {Object}
   */
  resolve: config.resolve,
  resolveLoader: config.resolveLoader,

  /**
   * Performance settings to speed up build times.
   *
   * @type {Object}
   */
  performance: {
    hints: 'warning'
  },

  /**
   * Build rules to handle application asset files.
   *
   * @type {Object}
   */
  module: {
    ...defaultConfig.module,
    rules: [
      //...defaultConfig.module.rules,
      // vueRule,
      sassRule,
      fontsRule,
      imagesRule,
      javascriptRule,
      externalFontsRule,
      externalImagesRule
    ]
  },

  optimization: {
    minimize: !isDev,
    minimizer: [new TerserPlugin()]
  },

  watch: isDev && !isPlatform,
  watchOptions: {
      poll: true,
      ignored: /node_modules/
      },

  /**
   * Common plugins which should run on every build./
   *
   * @type {Array}
   */
  plugins: [
    // new VueLoaderPlugin(),
    ...defaultConfig.plugins,
    new webpack.LoaderOptionsPlugin({ minimize: !isDev }),
    new MiniCssExtractPlugin(config.outputs.css),
    new CleanWebpackPlugin(config.paths.public, {
      root: config.paths.root
    }),
    new CopyPlugin([
      {
        context: config.paths.images,
        from: {
          glob: `${config.paths.images}/**/*`,
          flatten: true,
          dot: false
        },
        to: config.outputs.image.filename
      }
    ]),
    new webpack.ProvidePlugin({
      // other modules
      introJs: ['intro.js'],
      'window.jQuery': 'jquery'
    })
  ]
};

/**
 * Adds Stylelint plugin if
 * linting is configured.
 */
if ( config.settings.styleLint ) {
  if ( isDev && ! isPlatform ) {
    const StyleLintPlugin             = require("stylelint-webpack-plugin");
    module.exports.plugins.push(new StyleLintPlugin(config.settings.styleLint));
  }
}

/**
 * Adds optimizing plugins when
 * generating production build.
 */
if (isDev) {
  
  /**
   * Adds BrowserSync plugin when
   * settings are configured.
   */
  if ( config.settings.browserSync && !isPlatform ) {
    const BrowserSyncPlugin           = require("browser-sync-webpack-plugin");
    module.exports.plugins.push(
      new BrowserSyncPlugin(config.settings.browserSync, {
        // Prevent BrowserSync from reloading the page
        // and let Webpack Dev Server take care of this.
        reload: false
      })
    );
  }
}else{
  module.exports.plugins.push(
    new CompressionPlugin()
  );

  module.exports.plugins.push(
    new webpack.DefinePlugin({
      "process.env": {
        NODE_ENV: '"production"'
      }
    })
  );

  // module.exports.plugins.push(
  //   new webpack.optimize.UglifyJsPlugin({
  //     comments: isDev,
  //     compress: { warnings: false },
  //     sourceMap: isDev
  //   })
  // );

  module.exports.plugins.push(
    new ImageminPlugin({
      test: /\.(?<ext>jpe?g|png|gif|svg)$/i,
      optipng: { optimizationLevel: 7 },
      gifsicle: { optimizationLevel: 3 },
      pngquant: { quality: "65-90", speed: 4 },
      svgo: { removeUnknownsAndDefaults: false, cleanupIDs: false }
    })
  );
}
