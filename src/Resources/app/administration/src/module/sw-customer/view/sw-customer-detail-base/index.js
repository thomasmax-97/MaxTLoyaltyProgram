import template from './sw-customer-detail-base.html.twig';
import deDE from '../snippet/de-DE.json';
import enGB from '../snippet/en-GB.json';

const {Component} = Shopware;

Component.override('sw-customer-detail-base', {
    template,
    inject: ['maxtLoyaltyApiService'],

    snippets: {
        'de-DE': deDE,
        'en-GB': enGB,
    },

    data() {
        return {
            loyaltyPoints: null,
        };
    },
    created() {
        let apiRoute = `/loyalty-points/${this.customer.id}`;

        this.maxtLoyaltyApiService
            .fetch(apiRoute)
            .then((response) => {
                // Assign the response to the 'loyaltyPoints'
                this.loyaltyPoints = response;
                console.log(response);
            })
            .catch((error) => {
                console.error('Error fetching loyalty points:', error);
            });
    },
});
