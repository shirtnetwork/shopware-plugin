import StoreApiClient from 'src/service/store-api-client.service';

export default class AsyncClient {

    constructor() {
        this.client = new StoreApiClient();
    }

    async post(url, data){
        const result = await this.toPromise(this.client.post(url, data, this.callback))
        return result
    }

    async get(url){
        return this.toPromise(this.client.get(url, this.callback))
    }

    toPromise (request) {
        return new Promise(function (resolve, reject) {
            // Setup our listener to process compeleted requests
            request.onreadystatechange = function () {

                // Only run if the request is complete
                if (request.readyState !== 4) return;

                // Process the response
                if (request.status >= 200 && request.status < 300) {
                    // If successful
                    resolve(request.responseText);
                } else {
                    // If failed
                    reject({
                        status: request.status,
                        statusText: request.statusText
                    });
                }

            };

        });
    }

    callback (){ }

}
