import './component'
import './config'
import './preview'

const Criteria = Shopware.Data.Criteria;
const criteria = new Criteria(1, 25);
criteria.addAssociation('properties');

Shopware.Service('cmsService').registerCmsElement({
    name: 'designer-button',
    label: 'sw-cms.elements.customDesignerButtonElement.label',
    component: 'sw-cms-el-designer-button',
    configComponent: 'sw-cms-el-config-designer-button',
    previewComponent: 'sw-cms-el-preview-designer-button',
    defaultConfig: {
        label: {
            source: 'static',
            value: 'Create your own'
        },
        buttonClass: {
            source: 'static',
            value: ''
        },
        product: {
            source: 'static',
            value: null,
            required: false,
            entity: {
                name: 'product',
                criteria: criteria,
            },
        },
    },
    collect: Shopware.Service('cmsService').getCollectFunction(),
});