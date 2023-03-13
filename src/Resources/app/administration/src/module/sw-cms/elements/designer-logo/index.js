import './component';
import './config';
import './preview';

const Criteria = Shopware.Data.Criteria;
const criteria = new Criteria(1, 25);
criteria.addAssociation('cover');

Shopware.Service('cmsService').registerCmsElement({
    name: 'designer-logo',
    label: 'sw-cms.elements.designerLogo.label',
    component: 'sw-cms-el-designer-logo',
    previewComponent: 'sw-cms-el-preview-designer-logo',
    configComponent: 'sw-cms-el-config-designer-logo',
    defaultConfig: {
        logoId: {
            source: 'static',
            value: null,
            required: false
        },
        boxLayout: {
            source: 'static',
            value: 'standard',
        },
        displayMode: {
            source: 'static',
            value: 'standard',
        },
        verticalAlign: {
            source: 'static',
            value: null,
        },
    },
    defaultData: {
        boxLayout: 'standard',
        logo: null,
    }
});
