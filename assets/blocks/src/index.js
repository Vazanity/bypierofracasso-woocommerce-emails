import { createElement } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const localized = window.pfpInvoiceData || {};
const { getSetting } = window.wc?.wcSettings || {};
const currency = getSetting ? getSetting('currency', { code: 'CHF' }) : { code: 'CHF' };

const canMakePayment = ( { billingData = {}, shippingData = {} } = {} ) => {
    if (currency.code !== 'CHF') {
        return false;
    }
    if (localized.onlyChLi) {
        const country = billingData.country || shippingData.country;
        if (country && ![ 'CH', 'LI' ].includes(country)) {
            return false;
        }
    }
    return true;
};

const { registerPaymentMethod } = window.wc?.wcBlocksRegistry || {};

if (registerPaymentMethod) {
registerPaymentMethod({
    name: 'pfp_invoice',
    title: __( 'Rechnung (Swiss QR)', 'piero-fracasso-emails' ),
    ariaLabel: __( 'Rechnung (Swiss QR)', 'piero-fracasso-emails' ),
    canMakePayment,
    content: createElement('div', null),
    edit: createElement('div', null),
});
}
