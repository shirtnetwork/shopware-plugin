import './component'
import './config'
import './preview'

const Criteria = Shopware.Data.Criteria;
const criteria = new Criteria(1, 25);

Shopware.Service('cmsService').registerCmsElement({
    name: 'designer',
    label: 'sw-cms.elements.customDesignerElement.label',
    component: 'sw-cms-el-designer',
    configComponent: 'sw-cms-el-config-designer',
    previewComponent: 'sw-cms-el-preview-designer',
    defaultConfig: {
        product: {
            source: 'static',
            value: null,
            required: false,
            entity: {
                name: 'product',
                criteria: criteria,
            },
        }
    },
    defaultData: {
        product: null
    },
    collect: Shopware.Service('cmsService').getCollectFunction(),
});