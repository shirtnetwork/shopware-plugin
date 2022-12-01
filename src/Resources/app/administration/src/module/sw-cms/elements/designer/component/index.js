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
            //return `https://www.dailymotion.com/embed/video/${this.element.config.dailyUrl.value}`;
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