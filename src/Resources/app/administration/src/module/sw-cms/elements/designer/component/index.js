import template from './sw-cms-el-designer.html.twig';
import './sw-cms-el-designer.scss';

Shopware.Component.register('sw-cms-el-designer', {
    template,

    mixins: [
        'cms-element'
    ],

    computed: {
        designerUrl() {
            return 'https://www.shirtnetwork.de';
        },
        assetFilter() {
            return Shopware.Filter.getByName('asset');
        }
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('designer');
        }
    }


});