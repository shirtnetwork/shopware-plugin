// Import all necessary Storefront plugins and scss files
import ShirnetworkPlugin from './shirtnetwork-plugin/shirtnetwork-plugin.plugin';
import ShirtnetworkDescriptionPlugin from './shirtnetwork-description-plugin/shirtnetwork-description-plugin.plugin';

// Register them via the existing PluginManager
const PluginManager = window.PluginManager;
PluginManager.register('ShirtnetworkPlugin', ShirnetworkPlugin, '[data-shirtnetwork-plugin]');
PluginManager.register('ShirtnetworkDescriptionPlugin', ShirtnetworkDescriptionPlugin, '[data-shirtnetwork-description-plugin]');
