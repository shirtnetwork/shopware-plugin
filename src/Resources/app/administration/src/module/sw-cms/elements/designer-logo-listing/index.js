import './component';
import './config';
import './preview';

Shopware.Service('cmsService').registerCmsElement({
    name: 'designer-logo-listing',
    label: 'sw-cms.elements.designerLogoListing.label',
    hidden: true,
    removable: false,
    component: 'sw-cms-el-designer-logo-listing',
    previewComponent: 'sw-cms-el-preview-designer-logo-listing',
    configComponent: 'sw-cms-el-config-designer-logo-listing',
    defaultConfig: {
        boxLayout: {
            source: 'static',
            value: 'standard',
        }
    },
});
