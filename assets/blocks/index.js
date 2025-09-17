(function () {
  const registerPaymentMethod =
    window?.wc?.blocksRegistry?.registerPaymentMethod ||
    window?.wc?.wcBlocksRegistry?.registerPaymentMethod ||
    window?.wc?.blocksCheckout?.registerPaymentMethod;

  const { createElement } = window.wp?.element || {};
  const { __ } = window.wp?.i18n || {};
  const { decodeEntities } = window.wp?.htmlEntities || {};

  if (typeof registerPaymentMethod !== 'function' || typeof createElement !== 'function') {
    return;
  }

  const name = 'pfp_invoice';
  const labelText = __
    ? __('Invoice (Swiss QR)', 'bypierofracasso-woocommerce-emails')
    : 'Invoice (Swiss QR)';
  const contentText = __
    ? __('You will receive a QR invoice as PDF after placing the order.', 'bypierofracasso-woocommerce-emails')
    : 'You will receive a QR invoice as PDF after placing the order.';
  const ariaLabel = typeof decodeEntities === 'function' ? decodeEntities(labelText) : labelText;

  const Label = ({ PaymentMethodLabel }) => {
    if (PaymentMethodLabel) {
      return createElement(PaymentMethodLabel, {
        text: labelText,
      });
    }

    return createElement('span', null, labelText);
  };

  const Content = () =>
    createElement('div', null, contentText);

  registerPaymentMethod({
    name,
    label: Label,
    ariaLabel,
    content: Content,
    edit: Content,
    canMakePayment: () => true,
    supports: {
      features: ['products'],
    },
  });
})();
