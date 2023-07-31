import MaxtLoyaltyApiService from './api/maxt-loyalty.api-service';

const { Application } = Shopware;

Application.addServiceProvider('maxtLoyaltyApiService', (container) => {
    const initContainer = Application.getContainer('init');
    return new MaxtLoyaltyApiService(initContainer.httpClient, container.loginService);
});
