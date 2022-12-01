import template from './sw-cms-el-designer-description.html.twig';
import './sw-cms-el-designer-description.scss';

Shopware.Component.register('sw-cms-el-designer-description', {
    template,

    mixins: [
        'cms-element'
    ],

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('designer-description');
        }
    }


});