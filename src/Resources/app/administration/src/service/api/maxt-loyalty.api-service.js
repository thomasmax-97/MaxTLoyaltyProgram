const ApiService = Shopware.Classes.ApiService;

class MaxtLoyaltyApiService extends ApiService {
    constructor(httpClient, loginService, apiEndpoint = '') {
        super(httpClient, loginService, apiEndpoint);
    }

    fetch(apiRoute) {
        return this.httpClient.get(
            apiRoute,
            {
                headers: this.getBasicHeaders()
            }
        ).then((response) => {
            return ApiService.handleResponse(response);
        });
    }
}

export default MaxtLoyaltyApiService;
