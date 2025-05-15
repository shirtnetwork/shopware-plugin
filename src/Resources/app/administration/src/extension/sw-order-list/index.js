import './sw-order-list.scss'
import template from './sw-order-list.html.twig'
const { Criteria } = Shopware.Data;

Shopware.Component.override('sw-order-list', {
    template,
    computed: {
        orderCriteria() {
            const criteria = this.$super('orderCriteria');
            criteria.addAssociation('lineItems');
            criteria.addAggregation(
                Criteria.sum('shirtnetwork_quantity', 'customFields.shirtnetwork.quantity')
            );
            criteria.addAggregation(
                Criteria.sum('shirtnetwork_sum', 'customFields.shirtnetwork.sum')
            );
            return criteria;
        }
    },
    methods: {
        getOrderColumns() {
            const columns = this.$super('getOrderColumns');
            columns.push({
                property: 'shirtnetworkProvision',
                label: 'Shirtnetwork Provision',
                width: '150px',
                allowResize: true,
                primary: false,
                inlineEdit: false
            });
            return columns;
        }
    }
});
