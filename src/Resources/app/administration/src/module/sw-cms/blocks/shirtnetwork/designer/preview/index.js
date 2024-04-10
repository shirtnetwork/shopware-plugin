import template from './sw-cms-preview-designer.html.twig';
import './sw-cms-preview-designer.scss';

Shopware.Component.register('sw-cms-preview-designer', {
    template,
    computed: {
        assetFilter() {
            return Shopware.Filter.getByName('asset');
        },
    }
});