import template from './shirtnetwork-order-details-modal.html.twig';
import './shirtnetwork-order-details-modal.scss';

Shopware.Component.register('shirtnetwork-order-details-modal', {
    template: template,
    props: {
        title: {
            type: String,
            required: true,
            default: ''
        },
        item: {
            type: Object,
            required: true,
            default: {}
        }
    },
    data() {
        return {
            activeTab: ''
        };
    },
    mounted() {
        this.activeTab = this.item.infos.views[0].view.key
    },
    computed: {
        activeView: function() {
            return this.item ? this.item.infos.views.find(v => v.view.key === this.activeTab) : undefined
        },
        activeObjects: function() {
            return this.item ? this.item.infos.objects.filter(o => o.view === this.activeTab) : undefined
        }
    },
    methods: {
        tabChanged: function(tab) {
            this.activeTab = tab.name
            console.log(this.activeTab)
        },
        formatDimension: function(d) {
            return Number(d).toLocaleString()
        },
        getViewObjectCount: function(view){
            return this.item ? this.item.infos.objects.filter(o => o.view === view).length : undefined
        },
        hasFills: function(o) {
            return o.fills && o.fills.filter(f => f).length > 0
        }
    }
});
