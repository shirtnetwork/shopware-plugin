import Criteria from 'src/core/data/criteria.data';
import template from './sw-cms-el-config-designer-logo.html.twig';
import './sw-cms-el-config-designer-logo.scss';

const { Component, Mixin } = Shopware;

Component.register('sw-cms-el-config-designer-logo', {
    template,

    inject: ['ShirtnetworkApiService'],

    mixins: [
        Mixin.getByName('cms-element'),
    ],


    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('designer-logo');
        },
    },
});
