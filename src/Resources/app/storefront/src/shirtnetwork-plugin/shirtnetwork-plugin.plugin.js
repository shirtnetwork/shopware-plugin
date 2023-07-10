import Plugin from 'src/plugin-system/plugin.class';
import PseudoModalUtil from 'src/utility/modal-extension/pseudo-modal.util';
import HttpClient from 'src/service/http-client.service';
import PageLoadingIndicatorUtil from 'src/utility/loading-indicator/page-loading-indicator.util';

import AsyncClient from '../helpers/client';
import getScript from '../helpers/getscript';
import mergeDefaults from '../helpers/mergedefaults';

export default class ShirtnetworkPlugin extends Plugin {
    static options = {
        /**
         * designer version to use
         * @type string
         */
        version: '1.6.4'
    };

    init() {
        PageLoadingIndicatorUtil.create();
        this._httpClient = new HttpClient();
        this.client = new AsyncClient(this.options.swAccessKey)
        this.cartItems = []
        this.cache = {}
        this.skuScheme = this.options.skuScheme || '{PRODUCT_SKU}-{VARIANT_SKU}-{SIZE_SKU}'
        this.pages = this.options.pages || {}

        getScript('//cdn.shirtnetwork.de/client/shirtnetwork-client.js').then(() => this.boot())
    }

    async boot() {
        const config = mergeDefaults(this.options, {
            settings: {
                container: this.el.id,
                shop: {
                    cart: {
                        link: '/checkout/cart', //window.router['frontend.checkout.cart.page'],
                        data: {},
                        handler: this.getCheckoutData.bind(this),
                        addItem: this.addItemToCart.bind(this),
                        submit: this.submitCart.bind(this),
                        init: () => {},
                        showAfterSalesModal: false
                    },
                    infos: {
                        handler: this.getShopInfos.bind(this)
                    },
                    stock: {
                        handler: this.getStockInfos.bind(this)
                    }
                }
            }
        })

        const instance = this.instance = await ShirtnetworkClient.init(config);
        instance.$store.dispatch('observe', {event: 'navigate', callback: this.navigate.bind(this)})
        setTimeout(() => PageLoadingIndicatorUtil.remove(), 1500);
    }

    async addItemToCart(config, data, selection){
        this.cartItems.push({
            type: 'product',
            referencedId: selection.oxid,
            quantity: Number.parseInt(selection.amount),
            payload: {
                shirtnetwork: config
            }
        })
    }

    async getShopInfos(data) {
        return await this.getProduct(data)
    }

    async getStockInfos(data) {
        const resolvedSku = this.resolveSku(data.psku, data.vsku, data.ssku)

        if (resolvedSku) {
            const result = JSON.parse(await this.client.post('/store-api/product', JSON.stringify({
                associations: {
                    children: {}
                },
                filter: [{
                    "type": "equals",
                    "field": "children.productNumber",
                    "value": resolvedSku
                }]
            }), true))

            if (result.elements.length) {
                const product = result.elements[0]
                const children = product.children
                const stockInfo = children.map(child => {
                    const size = child.extensions.shirtnetwork.sku.sartnr
                    const variant = child.extensions.shirtnetwork.sku.vartnr
                    const stock = child.isCloseout ? child.availableStock : 999999
                    return {
                        size, variant, stock
                    }
                })
                return stockInfo
            }
        }

        return []
    }

    async getCheckoutData(data) {
        const product = await this.getProduct(data)
        let sizes = undefined
        if (data.sskus) {
            sizes = []
            for(const s of data.sskus) {
                const size = await this.getProduct(Object.assign({}, data, {ssku: s.sku}))
                size && sizes.push({oxid: size.id, id: size.id, amount: s.amount, size: s.size})
            }
        }
        return {
            aid: product ? product.id : undefined,
            sizes: sizes.length ? sizes : undefined,
        }
    }

    async getProduct(data) {
        const resolvedSku = this.resolveSku(data.psku, data.vsku, data.ssku)
        if (resolvedSku) {
            if (this.cache[resolvedSku]) {
                return this.cache[resolvedSku]
            }

            const result = JSON.parse(await this.client.post('/store-api/product', JSON.stringify({
                filter: [{
                    "type": "equals",
                    "field": "productNumber",
                    "value": this.resolveSku(data.psku, data.vsku, data.ssku)
                }],
                associations: {
                    properties: {
                        associations: {
                            group: {}
                        }
                    }
                }
            }), true))
            console.log('after getProduct', result)
            this.cache[resolvedSku] = result.elements && result.elements.length ? result.elements[0] : {}
            return this.cache[resolvedSku]
        }else{
            return {}
        }
    }

    async submitCart() {
        const result = await this.client.post('/shirtnetwork/add-to-cart', JSON.stringify(
          {
              lineItems: this.cartItems
          }
        ))
        this.cartItems = []
        this.instance.$store.dispatch('setIsNavigatingToCart', true)
        this.openOffCanvas()
        return result;
    }

    navigate(to) {
        if (this.pages[to]) {
            PageLoadingIndicatorUtil.create();
            this._httpClient.get(this.pages[to], response => {
                PageLoadingIndicatorUtil.remove();
                const pseudoModal = new PseudoModalUtil(response);
                pseudoModal.open();
            });
        }
    }

    openOffCanvas() {
        const offCanvasCartInstances = window.PluginManager.getPluginInstances('OffCanvasCart');
        for(const inst of offCanvasCartInstances) {
            inst.openOffCanvas(window.router['frontend.cart.offcanvas'], false);
        }
    }

    resolveSku(product, variant, size) {
        return this.skuScheme
            .replace('{PRODUCT_SKU}', product)
            .replace('{VARIANT_SKU}', variant)
            .replace('{SIZE_SKU}', size)
    }

}
