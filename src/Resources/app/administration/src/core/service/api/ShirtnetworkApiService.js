class ShirtnetworkApiService  extends Shopware.Classes.ApiService
{
    constructor(httpClient, loginService, apiEndpoint = 'shirtnetwork', contentType = 'application/vnd.api+json') {
        super(httpClient, loginService, apiEndpoint, contentType);
    }

    getOrderConfigs(order) {
        const apiRoute = `${this.getApiBasePath()}/orderconfigs/${order}`
        return this.getRequest(apiRoute)
    }

    countSyncProducts(salesChannelId) {
        const apiRoute = `${this.getApiBasePath()}/countsyncproducts`+'/'+(salesChannelId || '')
        return this.getRequest(apiRoute)
    }

    getSyncProducts(start,num,salesChannelId) {
        const apiRoute = `${this.getApiBasePath()}/getsyncproducts/`+(start || 0)+'/'+(num || 25)+'/'+(salesChannelId || '')
        return this.getRequest(apiRoute)
    }


    syncProducts(payload,salesChannelId) {
        const apiRoute = `${this.getApiBasePath()}/syncproducts`+'/'+(salesChannelId || '')
        return this.httpClient.post(
            apiRoute,payload,
            {
                headers: this.getBasicHeaders()
            }
        ).then((response) => {
            return Shopware.Classes.ApiService.handleResponse(response);
        });
    }

    getRequest(apiRoute) {
        return this.httpClient.get(
            apiRoute,
            {
                headers: this.getBasicHeaders()
            }
        ).then((response) => {
            return Shopware.Classes.ApiService.handleResponse(response);
        });
    }
}
export default ShirtnetworkApiService;
