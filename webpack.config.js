const path = require('path');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const {
    defaultRequestToExternal,
    defaultRequestToHandle,
} = require('@wordpress/dependency-extraction-webpack-plugin/lib/util');

const plugins = defaultConfig.plugins
    .filter((plugin) => plugin.constructor.name !== 'DependencyExtractionWebpackPlugin')
    .concat(
        new DependencyExtractionWebpackPlugin({
            requestToExternal: (request) => {
                if (request === '@woocommerce/blocks-registry') {
                    return ['wc', 'blocksRegistry'];
                }

                return defaultRequestToExternal(request);
            },
            requestToHandle: (request) => {
                if (request === '@woocommerce/blocks-registry') {
                    return 'wc-blocks-registry';
                }

                return defaultRequestToHandle(request);
            },
        })
    );

module.exports = {
    ...defaultConfig,
    entry: {
        index: path.resolve(__dirname, 'assets/blocks/index.js'),
    },
    output: {
        ...defaultConfig.output,
        path: path.resolve(__dirname, 'assets/blocks/build'),
    },
    plugins,
};
