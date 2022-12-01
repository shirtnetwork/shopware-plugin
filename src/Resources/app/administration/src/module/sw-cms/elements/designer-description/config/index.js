import template from './sw-cms-el-config-designer-description.html.twig';

Shopware.Component.register('sw-cms-el-config-designer-description', {
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
        },
    },
});