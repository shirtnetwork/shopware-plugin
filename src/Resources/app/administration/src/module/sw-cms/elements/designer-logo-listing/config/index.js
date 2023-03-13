import template from './sw-cms-el-config-designer-logo-listing.html.twig';
import './sw-cms-el-config-designer-logo-listing.scss';

const { Component, Mixin } = Shopware;

Component.register('sw-cms-el-config-designer-logo-listing', {
    template,

    mixins: [
        Mixin.getByName('cms-element'),
    ],

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('designer-logo-listing');
        },
    },
});
