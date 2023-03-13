import template from './sw-cms-el-designer-logo.html.twig';
import './sw-cms-el-designer-logo.scss';

const { Component, Mixin, Filter } = Shopware;

Component.register('sw-cms-el-designer-logo', {
    template,

    inject: [
        'ShirtnetworkApiService'
    ],

    mixins: [
        Mixin.getByName('cms-element')
    ],

    data() {
        return {
            logo: null,
        };
    },

    computed: {

        displaySkeleton() {
            return !this.element?.data?.logoId;
        },

        mediaUrl() {
            if (this.logo) {
                return '//api.shirtnetwork.de/out/logos/' + this.logo.category.supplier + '/' + (this.logo.svg || this.logo.picture);
            }
        },

        displayModeClass() {
            if (this.element.config.displayMode.value === 'standard') {
                return null;
            }

            return `is--${this.element.config.displayMode.value}`;
        },

        verticalAlignStyle() {
            if (!this.element.config?.verticalAlign?.value) {
                return null;
            }

            return `align-content: ${this.element.config.verticalAlign.value};`;
        },

    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('designer-logo');
            this.initElementData('designer-logo');

            if (this.element.data.logoId) {
                this.loadLogo(this.element.data.logoId);
            }else{
                this.logo = {
                    category: {
                        supplier: '94515'
                    },
                    svg: 'ea441477ce790d5c05ae15711e0daf53.svg'
                }
            }
        },
        loadLogo(logoId) {
            this.ShirtnetworkApiService.getLogoById(logoId).then((response) => {
                this.logo = response;
            });
        }
    },
});
