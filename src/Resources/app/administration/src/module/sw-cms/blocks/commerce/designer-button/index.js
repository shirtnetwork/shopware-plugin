import './component'
import './preview'

Shopware.Service('cmsService').registerCmsBlock({
    name: 'designer-button',
    category: 'shirtnetwork',
    label: 'Shirtnetwork Designer Button',
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