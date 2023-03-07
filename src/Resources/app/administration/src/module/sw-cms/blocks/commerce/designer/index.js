import './component'
import './preview'

Shopware.Service('cmsService').registerCmsBlock({
    name: 'designer',
    category: 'shirtnetwork',
    label: 'Shirtnetwork Designer',
    component: 'sw-cms-block-designer',
    previewComponent: 'sw-cms-preview-designer',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed'
    },
    slots: {
        content: 'designer'
    }
});