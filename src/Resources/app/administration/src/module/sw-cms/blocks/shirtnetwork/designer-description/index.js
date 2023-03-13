import './component'
import './preview'

Shopware.Service('cmsService').registerCmsBlock({
    name: 'designer-description',
    category: 'shirtnetwork',
    label: 'sw-cms.blocks.shirtnetwork.designerDescription.label',
    component: 'sw-cms-block-designer-description',
    previewComponent: 'sw-cms-preview-designer-description',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed'
    },
    slots: {
        content: 'designer-description'
    }
});