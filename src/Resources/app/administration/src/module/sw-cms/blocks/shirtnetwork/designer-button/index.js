import './component'
import './preview'

Shopware.Service('cmsService').registerCmsBlock({
    name: 'designer-button',
    category: 'shirtnetwork',
    label: 'sw-cms.blocks.shirtnetwork.designerButton.label',
    component: 'sw-cms-block-designer-button',
    previewComponent: 'sw-cms-preview-designer-button',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed',
    },
    slots: {
        content: 'designer-button'
    }
});