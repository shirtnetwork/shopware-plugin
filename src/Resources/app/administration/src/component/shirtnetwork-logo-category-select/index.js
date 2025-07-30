import template from './shirtnetwork-logo-category-select.html.twig';
import './shirtnetwork-logo-category-select.scss';

Shopware.Component.register('shirtnetwork-logo-category-select', {
    template: template,
    inject: [
        'ShirtnetworkApiService'
    ],
    model: {
        prop: 'value',
        event: 'change',
    },
    props: {
        value: {
            required: true,
            type: Object
        }
    },
    data() {
        return {
            currentSalesChannelId: null,
            selectedCategory: null,
            categoryOptions: []
        };
    },
    created() {
        this.createdComponent()
    },
    computed: {
        currentValue: {
            get() {
                return this.value;
            },
            set(newValue) {
                this.$emit('change', newValue);
                console.log('change', newValue);
            },
        },
        parsedValue() {
            try{
                return this.value ? JSON.parse(this.value) : {};
            }catch (e) {
                return {};
            }
        }
    },
    methods: {
        createdComponent() {

        },
        onSalesChannelChanged(salesChannelId) {
            this.currentSalesChannelId = salesChannelId;
            this.$emit('on-change-sales-channel', salesChannelId);
            this.loadLogoCategories(salesChannelId);
        },
        loadLogoCategories(salesChannelId) {
            this.ShirtnetworkApiService.getLogoCategories(salesChannelId).then((categories) => {
                this.categoryOptions = categories
                this.selectedCategory = this.parsedValue[this.currentSalesChannelId];
            })
        },
        onCategoryChanged(category) {
            const parsed = Object.assign({}, this.parsedValue);
            parsed[this.currentSalesChannelId] = category;
            const newValue = JSON.stringify(parsed);
            this.currentValue = newValue;
            this.$emit('change', newValue);
        }
    }
});
