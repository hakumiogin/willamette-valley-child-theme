const config = require("../app.config");

/**
 * Internal application javascript files.
 * Supports ES6 by compiling scripts with Babel.
 */
module.exports = {
  test: /\.js$/,
  include: [config.paths.javascript, config.paths.views],
  loader: [
    {
      loader: "babel-loader",
      query: {
        presets: ['@babel/preset-env', '@babel/preset-react']
      },
    }, "eslint-loader"
  ],
}





//   test: /\.js$/,
//   exclude: /node_modules/,
//   use: {
//     loader: 'babel-loader',
//     options: {
//       presets: [
//         '@babel/preset-env',
//         [
//           '@babel/preset-react',
//           {
//             "pragma": "React.createElement",
//             "pragmaFrag": "React.Fragment",
//           }
//         ]
//       ]
//     }
//   }
// }
