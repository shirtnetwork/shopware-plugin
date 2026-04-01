Shopware.Component.extend('landing-page-entity-single-select', 'sw-entity-single-select', {
    props: {
        criteria: {
            type: Object,
            required: false,
            default(props) {
                const criteria = new Shopware.Data.Criteria(1, props.resultLimit);
                criteria.addAssociation('cmsPage');
                criteria.addFilter(Shopware.Data.Criteria.equals('cmsPage.type', 'landingpage'));
                return criteria;
            }
        },
    }
});