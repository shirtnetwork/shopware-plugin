import template from './sw-cms-designer-logo-preview.html.twig';
import './sw-cms-designer-logo-preview.scss';

const { Component } = Shopware;

Component.register('sw-cms-designer-logo-preview', {
    template,

    props: {
        hideText: {
            type: Boolean,
            default: false,
            required: false,
        },
    },
});
