const PluginManager = window.PluginManager;
PluginManager.register('ShirtnetworkPlugin', () => import('./shirtnetwork-plugin/shirtnetwork-plugin.plugin'), '[data-shirtnetwork-plugin]');
PluginManager.register('ShirtnetworkDescriptionPlugin', () => import('./shirtnetwork-description-plugin/shirtnetwork-description-plugin.plugin'), '[data-shirtnetwork-description-plugin]');
