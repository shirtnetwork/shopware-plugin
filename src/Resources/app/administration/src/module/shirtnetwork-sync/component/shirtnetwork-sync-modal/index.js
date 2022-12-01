import './shirtnetwork-sync-modal.scss';
import template from './shirtnetwork-sync-modal.html.twig';

const { Component } = Shopware;
const { EntityCollection } = Shopware.Data;

Component.register('shirtnetwork-sync-modal', {
    template,

    inject: [
        'ShirtnetworkApiService',
        'systemConfigApiService',
        'repositoryFactory'
    ],

    props: {
        selection: {
            type: Array,
            required: false,
            default: []
        },
        salesChannelId: {
            type: String,
            required: false,
            default: null
        }
    },

    data() {
        return {
            variantExpressionForListings: false,
            categories: null,
            isLoading: false,
            pluginConfig: undefined,
            progress: 0,
            isCanceled: false
        };
    },

    computed: {
        selectContext(){
            return Shopware.Context.api
        },
        salesChannelRepository() {
            return this.repositoryFactory.create('sales_channel');
        },
        categoriesRepository() {
            return this.repositoryFactory.create('category');
        },
        selectionCount(){
            return this.selection ? this.selection.length : 0
        },
        selectedSalesChannels: {
            get(){
                return this.pluginConfig ? this.pluginConfig['ShirtnetworkPlugin.config.syncsaleschannels'] : undefined
            },
            set(val){
                this.pluginConfig['ShirtnetworkPlugin.config.syncsaleschannels'] = val
            }
        },
        selectedVariantPropertyGroup: {
            get(){
                return this.pluginConfig ? this.pluginConfig['ShirtnetworkPlugin.config.syncvariantpropertygroup'] : undefined
            },
            set(val){
                this.pluginConfig['ShirtnetworkPlugin.config.syncvariantpropertygroup'] = val
            }
        },
        selectedSizePropertyGroup: {
            get(){
                return this.pluginConfig ? this.pluginConfig['ShirtnetworkPlugin.config.syncsizepropertygroup'] : undefined
            },
            set(val){
                this.pluginConfig['ShirtnetworkPlugin.config.syncsizepropertygroup'] = val
            }
        },
        selectedTax: {
            get(){
                return this.pluginConfig ? this.pluginConfig['ShirtnetworkPlugin.config.synctax'] : undefined
            },
            set(val){
                this.pluginConfig['ShirtnetworkPlugin.config.synctax'] = val
            }
        },
        variantExpressionForListings: {
            get(){
                return this.pluginConfig ? this.pluginConfig['ShirtnetworkPlugin.config.syncvariantexpressionforlistings'] : undefined
            },
            set(val){
                this.pluginConfig['ShirtnetworkPlugin.config.syncvariantexpressionforlistings'] = val
            }
        }
    },

    created() {
        this.createdComponent()
    },

    methods: {
        async createdComponent() {
            this.categories = new EntityCollection(
                this.categoriesRepository.route,
                this.categoriesRepository.entityName,
                this.selectContext
            );
            const basePluginConfig = await this.systemConfigApiService.getValues('ShirtnetworkPlugin.config')
            const salesChannelPluginConfig = this.salesChannelId ? await this.systemConfigApiService.getValues('ShirtnetworkPlugin.config', this.salesChannelId) : {}
            this.pluginConfig = Object.assign({}, basePluginConfig, salesChannelPluginConfig)
            console.log(this.pluginConfig)
            return Promise.resolve();
        },
        async syncProducts(){
            this.isLoading = true;
            let processed = 0
            const products = Object.keys(this.selection)
            for(const pid of products) {
                await this.ShirtnetworkApiService.syncProducts({
                    products: [pid],
                    salesChannels: this.selectedSalesChannels,
                    categories: this.categories.getIds(),
                    variantPropertyGroup: this.selectedVariantPropertyGroup,
                    sizePropertyGroup: this.selectedSizePropertyGroup,
                    tax: this.selectedTax,
                    variantExpressionForListings: this.variantExpressionForListings
                }, this.salesChannelId).catch(err => {
                    console.log(err)
                })

                if (this.isCanceled){
                    this.isCanceled = false
                    break
                }

                processed++
                this.progress = Math.round((processed / products.length) * 100)
            }

            this.isLoading = false
            this.closeModal()
        },
        setSalesChannels(channels){
           this.selectedSalesChannels = channels
        },
        closeModal(){
            this.$emit('modal-close')
        },
        cancel() {
            this.isCanceled = true
        }
    }
});
