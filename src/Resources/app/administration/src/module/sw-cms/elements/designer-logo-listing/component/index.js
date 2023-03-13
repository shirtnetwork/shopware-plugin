import template from './sw-cms-el-designer-logo-listing.html.twig';
import './sw-cms-el-designer-logo-listing.scss';

const { Component, Mixin } = Shopware;

Component.register('sw-cms-el-designer-logo-listing', {
    template,

    mixins: [
        Mixin.getByName('cms-element'),
    ],

    data() {
        return {
            demoLogoCount: 9,
        };
    },

    computed: {
        demoLogoElement() {
            return {
                config: {
                    logo: {
                        source: 'static',
                        value: 106010,
                    },
                    boxLayout: {
                        source: 'static',
                        value: this.element.config.boxLayout.value,
                    },
                    displayMode: {
                        source: 'static',
                        value: 'standard',
                    },
                },
                data: null,
            };
        },
    },

    created() {
        this.createdComponent();
    },

    mounted() {
        this.mountedComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('designer-logo-listing');
        },

        mountedComponent() {
            const section = this.$el.closest('.sw-cms-section');

            if (!this.$el?.closest?.classList?.contains) {
                return;
            }

            if (section.classList.contains('is--sidebar')) {
                this.demoLogoCount = 6;
            }
        },
    },
});
