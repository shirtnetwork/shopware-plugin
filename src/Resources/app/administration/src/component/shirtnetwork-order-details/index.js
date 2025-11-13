import template from './shirtnetwork-order-details.html.twig';
import './shirtnetwork-order-details.scss';
import { io } from "socket.io-client";

const EPS_TOOL_HOST = 'https://localhost:9083'

Shopware.Component.register('shirtnetwork-order-details', {
    inject: [
        'ShirtnetworkApiService'
    ],
    template: template,
    props: {
        title: {
            type: String,
            required: true,
            default: ''
        },
        order: {
            type: Object,
            required: true,
            default: {}
        }
    },
    data() {
        return {
            items: [],
            isLoading: false,
            showViewModal: false,
            selectedModalView: null,
            showDetailsModal: false,
            selectedItem: null,
            epsToolConnected: false,
            gridColumns: [
                {
                    property: 'lineItem.quantity',
                    label: 'shirtnetwork-order.details.columnProductQuantity',
                    allowResize: false,
                    primary: true,
                    inlineEdit: false,
                    width: '80px'
                },
                {
                    property: 'lineItem.label',
                    label: 'shirtnetwork-order.details.columnProductName',
                    allowResize: false,
                    inlineEdit: false,
                    width: '200px'
                },
                {
                    property: 'infos.views',
                    dataIndex: 'views',
                    label: 'shirtnetwork-order.details.columnViewPictures',
                    allowResize: true,
                    inlineEdit: false,
                    width: '200px'
                }
            ]
        };
    },
    mounted() {
        this.isLoading = true;
        this.ShirtnetworkApiService.getOrderConfigs(this.order.id).then(result => {
            this.isLoading = false
            this.items = result
            console.log(this.items)
        })
        this.connectEpsTool()

    },
    methods: {
        viewPictureClick(view) {
            this.selectedModalView = view.picture;
            this.showViewModal = true;
        },
        viewModalClose() {
            this.selectedModalView = null;
            this.showViewModal = false;
        },
        contextMenuShowDetails(item){
            this.selectedItem = item
            this.showDetailsModal = true
            console.log(this, item)
        },
        detailsModalClose() {
            this.selectedItem = null;
            this.showDetailsModal = false;
        },
        connectEpsTool() {
            this.epsToolSocket = io(EPS_TOOL_HOST, {
                reconnectionDelayMax : 2000,
                forceNew : true
            });

            this.epsToolSocket.on("connect", () => {
                this.epsToolConnected = true;
            });

            this.epsToolSocket.on("connect_error", this.socketError );
            this.epsToolSocket.on("error", this.socketError );
            this.epsToolSocket.on("connect_timeout", this.socketError );
            this.epsToolSocket.on("disconnect", this.socketError );
        },

        printEPS() {
            this.epsToolSocket.emit("printOrder", {
                orderNumber: this.order.orderNumber,
                project: "[{$oViewConf->getShirtnetworkModuleSetting('sShirtnetworkEpsToolProject')}]",
                notShowLinks: true
            });
        },

        socketError () {
            this.epsToolConnected = true;
        },

        checkEpsToolConnection () {
            window.open(EPS_TOOL_HOST+"/socket.io/1/", "_blank", "toolbar=no,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=600");
        }
    }
});
