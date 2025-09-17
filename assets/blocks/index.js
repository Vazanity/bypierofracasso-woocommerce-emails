(function() {
  const registry = window.wc && window.wc.wcBlocksRegistry ? window.wc.wcBlocksRegistry : {};
  const registerPaymentMethod = registry.registerPaymentMethod;
  if (typeof registerPaymentMethod !== 'function') {
    return;
  }

  registerPaymentMethod({
    name: 'pfp_invoice',
    canMakePayment: () => true,
    edit: () => null,
    content: () => null,
    label: window.pfpInvoiceLabel || 'Invoice (Swiss QR)',
    ariaLabel: window.pfpInvoiceLabel || 'Invoice (Swiss QR)',
    supports: { features: [] }
  });
})();
