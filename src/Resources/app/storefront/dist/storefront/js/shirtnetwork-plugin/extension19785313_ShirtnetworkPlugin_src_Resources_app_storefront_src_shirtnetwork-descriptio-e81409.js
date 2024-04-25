"use strict";(self.webpackChunk=self.webpackChunk||[]).push([["extension19785313_ShirtnetworkPlugin_src_Resources_app_storefront_src_shirtnetwork-descriptio-e81409"],{857:e=>{var t=function(e){var t;return!!e&&"object"==typeof e&&"[object RegExp]"!==(t=Object.prototype.toString.call(e))&&"[object Date]"!==t&&e.$$typeof!==r},r="function"==typeof Symbol&&Symbol.for?Symbol.for("react.element"):60103;function i(e,t){return!1!==t.clone&&t.isMergeableObject(e)?a(Array.isArray(e)?[]:{},e,t):e}function s(e,t,r){return e.concat(t).map(function(e){return i(e,r)})}function n(e){return Object.keys(e).concat(Object.getOwnPropertySymbols?Object.getOwnPropertySymbols(e).filter(function(t){return Object.propertyIsEnumerable.call(e,t)}):[])}function o(e,t){try{return t in e}catch(e){return!1}}function a(e,r,l){(l=l||{}).arrayMerge=l.arrayMerge||s,l.isMergeableObject=l.isMergeableObject||t,l.cloneUnlessOtherwiseSpecified=i;var c,u,h=Array.isArray(r);return h!==Array.isArray(e)?i(r,l):h?l.arrayMerge(e,r,l):(u={},(c=l).isMergeableObject(e)&&n(e).forEach(function(t){u[t]=i(e[t],c)}),n(r).forEach(function(t){(!o(e,t)||Object.hasOwnProperty.call(e,t)&&Object.propertyIsEnumerable.call(e,t))&&(o(e,t)&&c.isMergeableObject(r[t])?u[t]=(function(e,t){if(!t.customMerge)return a;var r=t.customMerge(e);return"function"==typeof r?r:a})(t,c)(e[t],r[t],c):u[t]=i(r[t],c))}),u)}a.all=function(e,t){if(!Array.isArray(e))throw Error("first argument should be an array");return e.reduce(function(e,r){return a(e,r,t)},{})},e.exports=a},660:(e,t,r)=>{r.r(t),r.d(t,{default:()=>o});var i=r(293),s=r(107),n=r(49);class o extends i.Z{init(){document.body.addEventListener("designerBooted",this.designerBooted.bind(this))}designerBooted(e){this._httpClient=new s.Z,this._domParser=new DOMParser,this.instance=e.detail,this.instance.$store.watch(function(e,t){return t.localVars},()=>this.reloadDescription(),{deep:!0})}async reloadDescription(){let e=this.instance.$store.getters.localVar("shopProductInfos");e?this._httpClient.get("/shirtnetwork/detail/".concat(e.id),e=>{let t=this._domParser.parseFromString(e,"text/html"),r=n.Z.querySelector(t,".product-detail-tabs");this.el.innerHTML=r.innerHTML,window.PluginManager.initializePlugins()}):this.el.innerHTML=""}}},49:(e,t,r)=>{r.d(t,{Z:()=>s});var i=r(140);class s{static isNode(e){return"object"==typeof e&&null!==e&&(e===document||e===window||e instanceof Node)}static hasAttribute(e,t){if(!s.isNode(e))throw Error("The element must be a valid HTML Node!");return"function"==typeof e.hasAttribute&&e.hasAttribute(t)}static getAttribute(e,t){let r=!(arguments.length>2)||void 0===arguments[2]||arguments[2];if(r&&!1===s.hasAttribute(e,t))throw Error('The required property "'.concat(t,'" does not exist!'));if("function"!=typeof e.getAttribute){if(r)throw Error("This node doesn't support the getAttribute function!");return}return e.getAttribute(t)}static getDataAttribute(e,t){let r=!(arguments.length>2)||void 0===arguments[2]||arguments[2],n=t.replace(/^data(|-)/,""),o=i.Z.toLowerCamelCase(n,"-");if(!s.isNode(e)){if(r)throw Error("The passed node is not a valid HTML Node!");return}if(void 0===e.dataset){if(r)throw Error("This node doesn't support the dataset attribute!");return}let a=e.dataset[o];if(void 0===a){if(r)throw Error('The required data attribute "'.concat(t,'" does not exist on ').concat(e,"!"));return a}return i.Z.parsePrimitive(a)}static querySelector(e,t){let r=!(arguments.length>2)||void 0===arguments[2]||arguments[2];if(r&&!s.isNode(e))throw Error("The parent node is not a valid HTML Node!");let i=e.querySelector(t)||!1;if(r&&!1===i)throw Error('The required element "'.concat(t,'" does not exist in parent node!'));return i}static querySelectorAll(e,t){let r=!(arguments.length>2)||void 0===arguments[2]||arguments[2];if(r&&!s.isNode(e))throw Error("The parent node is not a valid HTML Node!");let i=e.querySelectorAll(t);if(0===i.length&&(i=!1),r&&!1===i)throw Error('At least one item of "'.concat(t,'" must exist in parent node!'));return i}}},140:(e,t,r)=>{r.d(t,{Z:()=>i});class i{static ucFirst(e){return e.charAt(0).toUpperCase()+e.slice(1)}static lcFirst(e){return e.charAt(0).toLowerCase()+e.slice(1)}static toDashCase(e){return e.replace(/([A-Z])/g,"-$1").replace(/^-/,"").toLowerCase()}static toLowerCamelCase(e,t){let r=i.toUpperCamelCase(e,t);return i.lcFirst(r)}static toUpperCamelCase(e,t){return t?e.split(t).map(e=>i.ucFirst(e.toLowerCase())).join(""):i.ucFirst(e.toLowerCase())}static parsePrimitive(e){try{return/^\d+(.|,)\d+$/.test(e)&&(e=e.replace(",",".")),JSON.parse(e)}catch(t){return e.toString()}}}},293:(e,t,r)=>{r.d(t,{Z:()=>l});var i=r(857),s=r.n(i),n=r(49),o=r(140);class a{publish(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},r=arguments.length>2&&void 0!==arguments[2]&&arguments[2],i=new CustomEvent(e,{detail:t,cancelable:r});return this.el.dispatchEvent(i),i}subscribe(e,t){let r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{},i=this,s=e.split("."),n=r.scope?t.bind(r.scope):t;if(r.once&&!0===r.once){let t=n;n=function(r){i.unsubscribe(e),t(r)}}return this.el.addEventListener(s[0],n),this.listeners.push({splitEventName:s,opts:r,cb:n}),!0}unsubscribe(e){let t=e.split(".");return this.listeners=this.listeners.reduce((e,r)=>([...r.splitEventName].sort().toString()===t.sort().toString()?this.el.removeEventListener(r.splitEventName[0],r.cb):e.push(r),e),[]),!0}reset(){return this.listeners.forEach(e=>{this.el.removeEventListener(e.splitEventName[0],e.cb)}),this.listeners=[],!0}get el(){return this._el}set el(e){this._el=e}get listeners(){return this._listeners}set listeners(e){this._listeners=e}constructor(e=document){this._el=e,e.$emitter=this,this._listeners=[]}}class l{init(){throw Error('The "init" method for the plugin "'.concat(this._pluginName,'" is not defined.'))}update(){}_init(){this._initialized||(this.init(),this._initialized=!0)}_update(){this._initialized&&this.update()}_mergeOptions(e){let t=o.Z.toDashCase(this._pluginName),r=n.Z.getDataAttribute(this.el,"data-".concat(t,"-config"),!1),i=n.Z.getAttribute(this.el,"data-".concat(t,"-options"),!1),a=[this.constructor.options,this.options,e];r&&a.push(window.PluginConfigManager.get(this._pluginName,r));try{i&&a.push(JSON.parse(i))}catch(e){throw console.error(this.el),Error('The data attribute "data-'.concat(t,'-options" could not be parsed to json: ').concat(e.message))}return s().all(a.filter(e=>e instanceof Object&&!(e instanceof Array)).map(e=>e||{}))}_registerInstance(){window.PluginManager.getPluginInstancesFromElement(this.el).set(this._pluginName,this),window.PluginManager.getPlugin(this._pluginName,!1).get("instances").push(this)}_getPluginName(e){return e||(e=this.constructor.name),e}constructor(e,t={},r=!1){if(!n.Z.isNode(e))throw Error("There is no valid element given.");this.el=e,this.$emitter=new a(this.el),this._pluginName=this._getPluginName(r),this.options=this._mergeOptions(t),this._initialized=!1,this._registerInstance(),this._init()}}},107:(e,t,r)=>{r.d(t,{Z:()=>i});class i{get(e,t){let r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"application/json",i=this._createPreparedRequest("GET",e,r);return this._sendRequest(i,null,t)}post(e,t,r){let i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"application/json";i=this._getContentType(t,i);let s=this._createPreparedRequest("POST",e,i);return this._sendRequest(s,t,r)}delete(e,t,r){let i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"application/json";i=this._getContentType(t,i);let s=this._createPreparedRequest("DELETE",e,i);return this._sendRequest(s,t,r)}patch(e,t,r){let i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"application/json";i=this._getContentType(t,i);let s=this._createPreparedRequest("PATCH",e,i);return this._sendRequest(s,t,r)}abort(){if(this._request)return this._request.abort()}_registerOnLoaded(e,t){t&&e.addEventListener("loadend",()=>{t(e.responseText,e)})}_sendRequest(e,t,r){return this._registerOnLoaded(e,r),e.send(t),e}_getContentType(e,t){return e instanceof FormData&&(t=!1),t}_createPreparedRequest(e,t,r){return this._request=new XMLHttpRequest,this._request.open(e,t),this._request.setRequestHeader("X-Requested-With","XMLHttpRequest"),r&&this._request.setRequestHeader("Content-type",r),this._request}constructor(){this._request=null}}}}]);