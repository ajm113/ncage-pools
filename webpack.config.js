'use strict';

const path = require('path');
module.exports = {
  entry: './resources/assets/js/entry.jsx',
  devtool: "eval-source-map",
  output: {
    path: path.resolve('./public/'),
    filename: 'js/bundle.js'
  },
  module: {
    rules: [
        {
          test: /\.scss$/,
          use: [{
              loader: "style-loader" // creates style nodes from JS strings
          }, {
              loader: "css-loader" // translates CSS into CommonJS
          }, {
              loader: "sass-loader" // compiles Sass to CSS
          }]
        },
        {
            test: [/\.jsx$/, /\.js$/],
            use: [{
                loader: 'babel-loader'
            }]
        },
        {
            test: /\.(png|woff|woff2|eot|ttf|svg)$/,
            use: [{
                loader: 'url-loader',
                options: {
                    limit: 100000
                }
            }]
        }
    ]
  }
}
