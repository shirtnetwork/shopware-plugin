import './component';
import './preview';

Shopware.Service('cmsService').registerCmsBlock({
    name: 'designer-logo-listing',
    label: 'sw-cms.blocks.shirtnetwork.designerLogoListing.label',
    category: 'shirtnetwork',
    component: 'sw-cms-block-designer-logo-listing',
    previewComponent: 'sw-cms-preview-designer-logo-listing',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed',
    },
    slots: {
        content: 'designer-logo-listing',
    },
});
