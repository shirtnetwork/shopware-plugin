import template from './sw-order-document-settings-routing-slip-modal.html.twig';

const { Component } = Shopware;

Component.extend('sw-order-document-settings-routing-slip-modal', 'sw-order-document-settings-modal', {
    template,

    data() {
        return {
            documentConfig: {
                custom: {

                },
                documentNumber: 0,
                documentComment: '',
                documentDate: ''
            }
        };
    },

    created() {
        this.createdComponent();
    },

    methods: {
        onCreateDocument(additionalAction = false) {
            if (this.documentNumberPreview === this.documentConfig.documentNumber) {
                this.numberRangeService.reserve(
                    `document_${this.currentDocumentType.technicalName}`,
                    this.order.salesChannelId,
                    false
                ).then((response) => {
                    this.documentConfig.custom.routingSlipNumber = response.number;
                    this.callDocumentCreate(additionalAction);
                });
            } else {
                this.documentConfig.custom.routingSlipNumber = this.documentConfig.documentNumber;
                this.callDocumentCreate(additionalAction);
            }
        },

        onPreview() {
            this.documentConfig.custom.routingSlipNumber = this.documentConfig.documentNumber;
            this.$super('onPreview');
        }
    }
});
