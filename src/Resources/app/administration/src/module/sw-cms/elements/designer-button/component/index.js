import template from './sw-cms-el-designer-button.html.twig';
import './sw-cms-el-designer-button.scss';

Shopware.Component.register('sw-cms-el-designer-button', {
    template,

    mixins: [
        'cms-element'
    ],

    created() {
        this.createdComponent();
    },

    computed: {
        buttonLabel() {
            return this.element.config.label.value;
        }
    },

    methods: {
        createdComponent() {
            this.initElementConfig('designer-button');
            this.initElementData('designer-button');
        }
    }


});