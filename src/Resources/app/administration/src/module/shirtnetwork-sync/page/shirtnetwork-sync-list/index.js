import template from './shirtnetwork-sync-list.html.twig';
import './shirtnetwork-sync-list.scss';

const { Component } = Shopware;

Component.register('shirtnetwork-sync-list', {
    template,

    inject: [
        'ShirtnetworkApiService',
        'repositoryFactory'
    ],

    data() {
        return {
            products: null,
            isLoading: false,
            showBulkSyncModal: false,
            salesChannelId: null,
            total: 0,
            pagination: {
                page: 1,
                limit: 25,
                total: 0
            },
            selectionCount: 0,
            selection: [],
            gridColumns: [
                {
                    property: 'id',
                    label: 'shirtnetwork-sync.list.columnId',
                    allowResize: false,
                    primary: true,
                    inlineEdit: false,
                    width: '80px'
                },
                {
                    property: 'active',
                    label: 'shirtnetwork-sync.list.columnActive',
                    allowResize: false,
                    primary: true,
                    inlineEdit: false,
                    width: '80px'
                },
                {
                    property: 'name',
                    label: 'shirtnetwork-sync.list.columnName',
                    allowResize: false,
                    inlineEdit: false,
                    width: '200px'
                },
                {
                    property: 'artNr',
                    label: 'shirtnetwork-sync.list.columnSku',
                    allowResize: true,
                    inlineEdit: false,
                    width: '100px'
                },
                {
                    property: 'price',
                    label: 'shirtnetwork-sync.list.columnPrice',
                    allowResize: true,
                    inlineEdit: false,
                    width: '100px'
                },
                {
                    property: 'description',
                    label: 'shirtnetwork-sync.list.columnDescription',
                    allowResize: true,
                    inlineEdit: false,
                    width: '200px'
                },
            ]
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },

    created() {
        this.createdComponent()
    },

    watch: {
        pagination: {
            handler: function (){
                this.loadProducts()
            },
            deep: true
        }
    },

    methods: {
        createdComponent() {
            this.isLoading = true
            this.ShirtnetworkApiService.countSyncProducts(this.salesChannelId).then(count => {
                this.pagination.total = count
                //this.loadProducts()
            })
            return Promise.resolve();
        },
        contextMenuSyncProduct(item){
            console.log(this, item)
        },
        selectionChange(selection, selectionCount){
            this.selectionCount = selectionCount
            this.selection = selection
        },
        paginationChange(pagination){
          this.pagination = Object.assign(this.pagination,pagination)
        },
        salesChannelChange(salesChannelId){
            this.$refs.shirtnetworkSyncListGrid.resetSelection()
            this.salesChannelId = salesChannelId
            this.loadProducts()
        },
        loadProducts(){
            this.isLoading = true
            this.ShirtnetworkApiService.getSyncProducts((this.pagination.page-1)*this.pagination.limit, this.pagination.limit, this.salesChannelId).then(result => {
                this.isLoading = false
                this.products = result
            })
        }
    }
});
