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
            allProducts: null,
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
            ],
            storeKey: 'grid.filter.shirtnetworksync',
            filterCriteria: null,
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

    computed: {
        filteredProducts() {
            let filteredProducts = this.allProducts
            if (filteredProducts && this.filterCriteria) {
                filteredProducts = filteredProducts.filter(product => {
                    let filterResult = true;
                    this.filterCriteria.forEach(criteria => {
                        if (criteria.type === 'contains') {
                            if (!product[criteria.field].toString().toLowerCase().includes(criteria.value.toString().toLowerCase())) {
                                filterResult = false;
                            }
                        } else if (criteria.type === 'equals') {
                            if (!product[criteria.field].toString().toLowerCase() === criteria.value.toString().toLowerCase()) {
                                filterResult = false;
                            }
                        }
                    })
                    return filterResult;
                })
            }
            return filteredProducts;
        },
        products() {
            const offset = (this.pagination.page - 1) * this.pagination.limit;
            return this.filteredProducts?.slice(offset, offset + this.pagination.limit)

        },
        totalProducts() {
            return this.filteredProducts?.length || 0;
        },
        listFilters() {
            return [
                {
                    name: 'name',
                    label: this.$tc('shirtnetwork-sync.list.filterName'),
                    type: 'string-filter',
                    value: '',
                    property: 'name'
                },
                {
                    name: 'artNr',
                    label: this.$tc('shirtnetwork-sync.list.filterArtNr'),
                    type: 'string-filter',
                    value: '',
                    property: 'artNr'
                },
            ]
        },
        defaultFilters() {
            return this.listFilters.map(f => f.name)
        },
        activeFilterNumber() {
            return this.filterCriteria?.length;
        }
    },

    methods: {
        async createdComponent() {
            const filters = await Shopware.Service('filterService').getStoredFilters(this.storeKey)
            if (filters) {
                const criterias = [];
                for(const filter of Object.values(filters)) {
                    criterias.push(...filter.criteria)
                }
                this.filterCriteria = criterias
            }

            //this.filterCriteria = await Shopware.Service('filterService').mergeWithStoredFilters(this.storeKey, this.filterCriteria)
            return this.loadProducts();
            //this.isLoading = true
            //this.ShirtnetworkApiService.countSyncProducts(this.salesChannelId).then(count => {
            //    this.pagination.total = count
                //this.loadProducts()
            //})
            //return Promise.resolve();
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
            this.allProducts = null;
            this.loadProducts()
        },
        async loadProducts(){
            if (!this.salesChannelId) {
                this.allProducts = null;
                return;
            }

            if (!this.allProducts) {
                this.isLoading = true
                this.allProducts = await this.ShirtnetworkApiService.getSyncProducts(this.salesChannelId);
                this.isLoading = false
            }

        },
        updateFilter(criteria) {
            this.filterCriteria = criteria;
        }
    }
});
