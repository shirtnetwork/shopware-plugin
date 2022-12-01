import './component'
import './preview'

Shopware.Service('cmsService').registerCmsBlock({
    name: 'designer-description',
    category: 'commerce',
    label: 'Shirtnetwork Designer Produktbeschreibung',
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