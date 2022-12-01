import template from './sw-cms-el-config-designer.html.twig';
import Criteria from 'src/core/data/criteria.data';

Shopware.Component.register('sw-cms-el-config-designer', {
    template,

    inject: ['repositoryFactory'],

    mixins: [
        'cms-element'
    ],

    computed: {
        productRepository() {
            return this.repositoryFactory.create('product');
        },

        productSelectContext() {
            const context = Object.assign({}, Shopware.Context.api);
            context.inheritance = true;

            return context;
        },

        productCriteria() {
            const criteria = new Criteria(1, 25);
            return criteria;
        },

        isProductPage() {
            return this.cmsPageState?.currentPage?.type === 'product_detail';
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('designer');

            console.log('created designer config')

            if (!this.isProductPage || this.element?.translated?.config?.product) {
                return;
            }

            if (this.element.config.product.source && this.element.config.product.value) {
                return;
            }

            this.element.config.product.source = 'mapped';
            this.element.config.product.value = 'product.id';
        },

        onProductChange(productId) {
            if (!productId) {
                this.element.config.product.value = null;
                //this.$set(this.element.data, 'productId', null);
                // this.$set(this.element.data, 'product', null);
            } else {
                const criteria = new Criteria(1, 25);

                this.productRepository.get(productId, this.productSelectContext, criteria).then((product) => {
                    this.element.config.product.value = productId;
                    //this.$set(this.element.data, 'productId', productId);
                    //this.$set(this.element.data, 'product', product);
                });
            }

            this.$emit('element-update', this.element);
        },
    },
});