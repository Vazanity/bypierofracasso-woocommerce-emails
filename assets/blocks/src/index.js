import { createElement } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const localized = window.pfpInvoiceData || {};
const { getSetting } = window.wc?.wcSettings || {};
const currency = getSetting ? getSetting('currency', { code: 'CHF' }) : { code: 'CHF' };

const Icon = () => {
    if (localized.icon) {
        return createElement('img', { src: localized.icon, alt: '', loading: 'lazy' });
    }
    return createElement(
        'svg',
        { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: 24, height: 24, 'aria-hidden': true },
        createElement('rect', { fill: '#777', width: 24, height: 24 }),
        createElement('path', { fill: '#fff', d: 'M4 5h16v2H4zm0 4h16v2H4zm0 4h10v2H4zm0 4h10v2H4z' })
    );
};

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
    icons: [ createElement(Icon) ],
});
}
