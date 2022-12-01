const Application = Shopware.Application;
import ShirtnetworkApiService from '../core/service/api/ShirtnetworkApiService';

Shopware.Service().register('ShirtnetworkApiService', (container) => {
    const initContainer = Application.getContainer('init');
    return new ShirtnetworkApiService(initContainer.httpClient, container.loginService);
});
