const base = require( './node_modules/@wordpress/scripts/config/webpack.config' );
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );
const {
  defaultRequestToExternal,
  defaultRequestToHandle,
} = require( '@wordpress/dependency-extraction-webpack-plugin/lib/util' );

const plugins = ( base.plugins || [] )
  .filter( ( plugin ) => plugin.constructor.name !== 'DependencyExtractionWebpackPlugin' )
  .concat(
    new DependencyExtractionWebpackPlugin( {
      requestToExternal: ( request ) => {
        if ( request === '@woocommerce/blocks-registry' ) {
          return [ 'wc', 'wcBlocksRegistry' ];
        }
        if ( request === '@woocommerce/settings' ) {
          return [ 'wc', 'wcSettings' ];
        }

        return defaultRequestToExternal( request );
      },
      requestToHandle: ( request ) => {
        if ( request === '@woocommerce/blocks-registry' ) {
          return 'wc-blocks-registry';
        }
        if ( request === '@woocommerce/settings' ) {
          return 'wc-settings';
        }

        return defaultRequestToHandle( request );
      },
    } )
  );

module.exports = {
  ...base,
  externals: {
    ...( base.externals || {} ),
    '@wordpress/element': 'wp.element',
    '@wordpress/i18n': 'wp.i18n',
    '@woocommerce/blocks-registry': [ 'wc', 'wcBlocksRegistry' ],
    '@woocommerce/settings': [ 'wc', 'wcSettings' ],
  },
  plugins,
};
