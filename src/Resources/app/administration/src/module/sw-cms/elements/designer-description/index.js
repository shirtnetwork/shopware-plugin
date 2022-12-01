import './component'
import './config'
import './preview'

Shopware.Service('cmsService').registerCmsElement({
    name: 'designer-description',
    label: 'sw-cms.elements.customDesignerDescriptionElement.label',
    component: 'sw-cms-el-designer-description',
    configComponent: 'sw-cms-el-config-designer-description',
    previewComponent: 'sw-cms-el-preview-designer-description',
});