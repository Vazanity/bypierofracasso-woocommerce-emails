import { registerPaymentMethod } from '@woocommerce/blocks-registry';
import { __ } from '@wordpress/i18n';
import { createElement } from '@wordpress/element';

const name = 'pfp_invoice';

const Content = () =>
  createElement(
    'div',
    null,
    __('You will receive a QR invoice as PDF after placing the order.', 'bypierofracasso-woocommerce-emails')
  );

registerPaymentMethod({
  name,
  label: __('Invoice (Swiss QR)', 'bypierofracasso-woocommerce-emails'),
  ariaLabel: __('Invoice (Swiss QR)', 'bypierofracasso-woocommerce-emails'),
  content: createElement(Content),
  edit: createElement(Content),
  canMakePayment: () => true,
  supports: { features: ['products'] },
});
