import Plugin from 'src/plugin-system/plugin.class';
import HttpClient from 'src/service/http-client.service';
import DomAccess from 'src/helper/dom-access.helper';

export default class ShirtnetworkDescriptionPlugin extends Plugin {

    init() {
        document.body.addEventListener('designerBooted', this.designerBooted.bind(this))
    }

    designerBooted(event) {
        this._httpClient = new HttpClient();
        this._domParser = new DOMParser();
        this.instance = event.detail
        this.instance.$store.watch(function(state, getters){ return getters.localVars; }, () => this.reloadDescription(), {deep: true})
    }

    async reloadDescription(){
        const product = this.instance.$store.getters.localVar('shopProductInfos')
        if (product) {
            // document.getElementById('designer-description-description-content').innerHTML = product.translated.description
            this._httpClient.get(`/shirtnetwork/detail/${product.id}`, response => {
                const html = this._domParser.parseFromString(response, 'text/html')
                const element = DomAccess.querySelector(html, '.product-detail-tabs');
                this.el.innerHTML = element.innerHTML;
                //document.getElementById('designer-description-reviews-content').innerHTML = response
                window.PluginManager.initializePlugins()
            });
        }else{
            this.el.innerHTML = ''
            // document.getElementById('designer-description-description-content').innerHTML = ''
            // document.getElementById('designer-description-reviews-content').innerHTML = ''
        }
    }

}
