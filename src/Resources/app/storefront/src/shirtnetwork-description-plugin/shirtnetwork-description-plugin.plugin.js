import Plugin from 'src/plugin-system/plugin.class';
import HttpClient from 'src/service/http-client.service';

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
        if (product && product.translated) {
            document.getElementById('designer-description-description-content').innerHTML = product.translated.description

            this._httpClient.get(`/product/${product.parentId ? product.parentId : product.id}/reviews`, response => {
                document.getElementById('designer-description-reviews-content').innerHTML = response
                window.PluginManager.initializePlugins()
            });
        }else{
            document.getElementById('designer-description-description-content').innerHTML = ''
            document.getElementById('designer-description-reviews-content').innerHTML = ''
        }
    }

}
