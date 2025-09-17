/**
 * PFP Invoice – WC Blocks frontend registration
 */
import { registerPaymentMethod } from '@woocommerce/blocks-registry';
import { getSetting } from '@woocommerce/settings';
import { __ } from '@wordpress/i18n';
import { createElement, Fragment } from '@wordpress/element';

const data = getSetting( 'pfp_invoice_data', {} );

const Label = () =>
  createElement(
    'span',
    null,
    data?.title || __( 'Invoice', 'bypierofracasso-woocommerce-emails' )
  );

const Content = () =>
  createElement(
    Fragment,
    null,
    data?.description || ''
  );

// Hard guard: if registry missing (shouldn't happen with proper deps), bail gracefully.
if ( typeof registerPaymentMethod !== 'function' ) {
  // eslint-disable-next-line no-console
  console.warn( '[PFP] wc-blocks registry missing; skipping payment method registration' );
} else {
  registerPaymentMethod( {
    name: 'pfp_invoice',
    label: createElement( Label ),
    ariaLabel: __( 'Pay by invoice', 'bypierofracasso-woocommerce-emails' ),
    canMakePayment: () => true,
    edit: createElement( Content ),
    content: createElement( Content ),
    supports: { features: [ 'products' ] },
  } );
}
