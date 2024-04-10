import template from './sw-cms-el-preview-designer.html.twig';
import './sw-cms-el-preview-designer.scss';

Shopware.Component.register('sw-cms-el-preview-designer', {
    template,
    computed: {
        assetFilter() {
            return Shopware.Filter.getByName('asset');
        },
    },
});