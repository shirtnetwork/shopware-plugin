import Plugin from 'src/plugin-system/plugin.class';
import HttpClient from 'src/service/http-client.service';
import PluginManager from 'src/plugin-system/plugin.manager';

export default class ShirtnetworkDescriptionPlugin extends Plugin {

    init() {
        document.body.addEventListener('designerBooted', this.designerBooted.bind(this))
    }

    designerBooted(event) {
        this._httpClient = new HttpClient();
        this.instance = event.detail
        this.instance.$store.watch(function(state, getters){ return getters.localVars; }, () => this.reloadDescription(), {deep: true})
    }

    async reloadDescription(){
        const product = this.instance.$store.getters.localVar('shopProductInfos')
        console.log('reloadDescription', product.id)
        if (product && product.translated) {
            document.getElementById('designer-description-description-content').innerHTML = product.translated.description
            this._httpClient.get(`/product/${product.id}/reviews`, response => {
                document.getElementById('designer-description-reviews-content').innerHTML = response
                PluginManager.initializePlugins()
            });
        }else{
            document.getElementById('designer-description-description-content').innerHTML = ''
            document.getElementById('designer-description-reviews-content').innerHTML = ''
        }
    }

}
