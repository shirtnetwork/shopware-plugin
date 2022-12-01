import './component/shirtnetwork-sync-modal';
import './page/shirtnetwork-sync-list';

import deDE from './snippet/de-DE.json';
import enGB from './snippet/en-GB.json';

Shopware.Module.register('shirtnetwork-sync', {
    type: 'plugin',
    name: 'shirtnetwork',
    title: 'shirtnetwork-sync.general.mainMenuItemGeneral',
    description: 'shirtnetwork-sync.general.descriptionTextModule',
    color: '#fc6f38',
    icon: 'default-tools-pencil-brush',

    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },

    routes: {
        index: {
            components: {
                default: 'shirtnetwork-sync-list'
            },
            path: 'index'
        },
    },

    navigation: [{
        label: 'Shirtnetwork Sync',
        color: '#62ff80',
        path: 'shirtnetwork.sync.index',
        icon: 'default-tools-pencil-brush',
        parent: 'sw-catalogue'
    }],

    settingsItem: [{
        to: 'shirtnetwork.sync.index',
        group: 'system',
        icon: 'default-tools-pencil-brush',
    }]
});
