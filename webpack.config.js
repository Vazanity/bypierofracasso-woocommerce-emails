const path = require('path');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');

module.exports = {
    entry: {
        index: path.resolve(__dirname, 'assets/blocks/src/index.js'),
    },
    output: {
        path: path.resolve(__dirname, 'assets/blocks/build'),
        filename: '[name].js',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [ [ '@babel/preset-env', { modules: false } ] ],
                    },
                },
            },
        ],
    },
    plugins: [
        new DependencyExtractionWebpackPlugin(),
    ],
    devtool: false,
};
