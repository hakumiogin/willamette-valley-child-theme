const path = require("path");
const { merge } = require("webpack-merge");

const env = require("./utils/env");
const config = require("../config/app");

module.exports = merge(
  {

    /**
		 * Project paths.
		 *
		 * @type {Object}
		 */
    paths: {
      root: path.resolve(__dirname, "../"),
      public: path.resolve(__dirname, "../public"),
      sass: path.resolve(__dirname, "../resources/assets/sass"),
      fonts: path.resolve(__dirname, "../resources/assets/fonts"),
      images: path.resolve(__dirname, "../resources/assets/images"),
      javascript: path.resolve(__dirname, "../resources/assets/js"),
      views: path.resolve(__dirname, "../resources/assets/views"),
      relative: "../",
      external: /node_modules|bower_components/
    },

    /**
		 * Collection of application front-end assets.
		 *
		 * @type {Array}
		 */
    assets: [],

    /**
		 * List of filename schemas for different
		 * application assets.
		 *
		 * @type {Object}
		 */
    outputs: {
      css: {
        filename: env("FILENAME_CSS", "css/[name].css")
      },

      font: {
        filename: env("FILENAME_FONT", "fonts/[name].[ext]")
      },

      image: {
        filename: env("FILENAME_IMAGE", "images/[path][name].[ext]")
      },

      javascript: {
        filename: env("FILENAME_JAVASCRIPT", "js/[name].js")
      },

      chunk: {
        filename: env("FILENAME_JAVASCRIPT", "js/[name].[contenthash].js")
      },

      external: {
        image: {
          filename: env("FILENAME_EXTERNAL_IMAGE", "images/[name].[ext]")
        },
        font: {
          filename: env("FILENAME_EXTERNAL_FONT", "fonts/[name].[ext]")
        }
      }

    },

    /**
		 * List of libraries which will be provided
		 * within application scripts as external.
		 *
		 * @type {Object}
		 */
    externals: {
      //jquery: 'jQuery',
      "react": "React",
      "react-dom": "ReactDOM"
    },

    /**
		 * List of custom modules resolving.
		 *
		 * @type {Object}
		 */
    resolve: {
      alias: {
        vue$: "vue/dist/vue.esm.js",
        js: path.resolve(__dirname, "../resources/assets/js"),
        scss: path.resolve(__dirname, "../resources/assets/sass"),
        sass: path.resolve(__dirname, "../resources/assets/sass"),

        // Symbolic links
        "@": path.resolve(__dirname, "../resources/assets/js/components"),
        "~/scss": path.resolve(__dirname, "../resources/assets/sass"),
        "~/sass": path.resolve(__dirname, "../resources/assets/sass"),
        "~/images": path.resolve(__dirname, "../resources/assets/images"),
        "~/js": path.resolve(__dirname, "../resources/assets/js"),
        "~/gutenberg": path.resolve(__dirname, "../resources/assets/js/gutenberg"),
        "~/common": path.resolve(__dirname, "../resources/assets/js/gutenberg/components/common"),
        "~/views": path.resolve(__dirname, "../resources/assets/views"),
        "~/vendor": path.resolve(__dirname, "../vendor"),
      },
      extensions: ["*", ".js", ".vue", ".json", ".scss"]
    },

    /**
		 * Settings of other build features.
		 *
		 * @type {Object}
		 */
    settings: {
      sourceMaps: env("SOURCEMAPS", true),
      styleLint: {
        context: "resources/assets",
        extends: ["stylelint-config-standard"],

      },
      autoprefixer: {
        browsers: ["last 2 versions", "> 1%"]
      },
      browserSync: {
        proxy: env("BROWSERSYNC_PROXY", "http://" + env("VIRTUAL_HOST", "localhost") ),
        reloadDelay: env("BROWSERSYNC_DELAY", 500),
        host: env("BROWSERSYNC_HOST", "0.0.0.0"),
        https: env("BROWSERSYNC_HTTPS", false),
        open: env("BROWSERSYNC_OPEN", false),
        port: env("BROWSERSYNC_PORT", 3000),
        files: [
          "*.php",
          "**/*.php",
          "resources/templates/**/*.php",
          "resources/assets/js/**/*.js",
          "resources/assets/js/**/*.json",
          "resources/assets/views/**/*.{vue,sass,scss}",
          "resources/assets/sass/**/*.{sass,scss}",
          "resources/assets/images/**/*.{jpg,jpeg,png,gif,svg}",
          "resources/assets/fonts/**/*.{eot,otf,ttf,woff,woff2,svg}"
        ]
      }
    }
  },
  config
);
