( function() {
  const { __ } = window.wp?.i18n || {};
  const reg = window?.wc?.wcBlocksRegistry?.registerPaymentMethod
    || ( window?.wc?.blocksCheckout && window.wc.blocksCheckout.registerPaymentMethod );
  if ( ! reg ) {
    return;
  }
  reg( {
    name: 'pfp_invoice',
    canMakePayment: () => true,
    edit: () => null,
    content: () => null,
    ariaLabel: __ ? __( 'Invoice (Swiss QR)', 'bypierofracasso-woocommerce-emails' ) : 'Invoice (Swiss QR)',
    label: __ ? __( 'Invoice (Swiss QR)', 'bypierofracasso-woocommerce-emails' ) : 'Invoice (Swiss QR)',
    supports: { features: [] }
  } );
} )();
