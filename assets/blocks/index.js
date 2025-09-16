(function () {
    var wc = window.wc || {};
    var registry = wc.wcBlocksRegistry || {};
    var registerPaymentMethod = registry.registerPaymentMethod;
    var __ = window.wp && window.wp.i18n && typeof window.wp.i18n.__ === 'function'
        ? window.wp.i18n.__
        : function (text) {
            return text;
        };

    if (typeof registerPaymentMethod !== 'function') {
        return;
    }

    registerPaymentMethod({
        name: 'pfp_invoice',
        title: __('Rechnung (Swiss QR)', 'piero-fracasso-emails'),
        description: __('Pay via Swiss QR invoice.', 'piero-fracasso-emails'),
    });
})();
