import template from './sw-cms-el-config-designer-button.html.twig';
const { Criteria } = Shopware.Data;

Shopware.Component.register('sw-cms-el-config-designer-button', {
    template,

    mixins: [
        'cms-element'
    ],

    inject: ['repositoryFactory'],

    created() {
        this.createdComponent();
    },

    computed: {
        buttonLabel: {
            get() {
                return this.element.config.label.value;
            },

            set(value) {
                this.element.config.label.value = value;
            }
        },
        buttonClass: {
            get() {
                return this.element.config.buttonClass.value;
            },

            set(value) {
                this.element.config.buttonClass.value = value;
            }
        },
        productRepository() {
            return this.repositoryFactory.create('product');
        },

        productSelectContext() {
            return {
                ...Shopware.Context.api,
                inheritance: true,
            };
        },

        productCriteria() {
            const criteria = new Criteria(1, 25);
            criteria.addAssociation('options.group');

            return criteria;
        },

        selectedProductCriteria() {
            const criteria = new Criteria(1, 25);
            criteria.addAssociation('properties');

            return criteria;
        },

        isProductPage() {
            return this.cmsPageState?.currentPage?.type === 'product_detail';
        },
    },

    methods: {
        createdComponent() {
            this.initElementConfig('designer-button');
        },

        onElementUpdate(value) {
            this.element.config.label.value = value;

            this.$emit('element-update', this.element);
        },

        onProductChange(productId) {
            if (!productId) {
                this.element.config.product.value = null;
                this.$set(this.element.data, 'productId', null);
                this.$set(this.element.data, 'product', null);
            } else {
                this.productRepository.get(
                    productId,
                    this.productSelectContext,
                    this.selectedProductCriteria,
                ).then((product) => {
                    this.element.config.product.value = productId;
                    this.$set(this.element.data, 'productId', productId);
                    this.$set(this.element.data, 'product', product);
                });
            }

            this.$emit('element-update', this.element);
        },
    },
});