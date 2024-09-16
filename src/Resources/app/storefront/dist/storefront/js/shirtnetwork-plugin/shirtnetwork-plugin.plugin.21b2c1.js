"use strict";(self.webpackChunk=self.webpackChunk||[]).push([["shirtnetwork-plugin.plugin"],{857:t=>{var e=function(t){var e;return!!t&&"object"==typeof t&&"[object RegExp]"!==(e=Object.prototype.toString.call(t))&&"[object Date]"!==e&&t.$$typeof!==s},s="function"==typeof Symbol&&Symbol.for?Symbol.for("react.element"):60103;function r(t,e){return!1!==e.clone&&e.isMergeableObject(t)?a(Array.isArray(t)?[]:{},t,e):t}function i(t,e,s){return t.concat(e).map(function(t){return r(t,s)})}function n(t){return Object.keys(t).concat(Object.getOwnPropertySymbols?Object.getOwnPropertySymbols(t).filter(function(e){return Object.propertyIsEnumerable.call(t,e)}):[])}function o(t,e){try{return e in t}catch(t){return!1}}function a(t,s,c){(c=c||{}).arrayMerge=c.arrayMerge||i,c.isMergeableObject=c.isMergeableObject||e,c.cloneUnlessOtherwiseSpecified=r;var l,d,u=Array.isArray(s);return u!==Array.isArray(t)?r(s,c):u?c.arrayMerge(t,s,c):(d={},(l=c).isMergeableObject(t)&&n(t).forEach(function(e){d[e]=r(t[e],l)}),n(s).forEach(function(e){(!o(t,e)||Object.hasOwnProperty.call(t,e)&&Object.propertyIsEnumerable.call(t,e))&&(o(t,e)&&l.isMergeableObject(s[e])?d[e]=(function(t,e){if(!e.customMerge)return a;var s=e.customMerge(t);return"function"==typeof s?s:a})(e,l)(t[e],s[e],l):d[e]=r(s[e],l))}),d)}a.all=function(t,e){if(!Array.isArray(t))throw Error("first argument should be an array");return t.reduce(function(t,s){return a(t,s,e)},{})},t.exports=a},215:(t,e,s)=>{s.r(e),s.d(e,{default:()=>T});var r=s(293),i=s(49);class n{static isTouchDevice(){return"ontouchstart"in document.documentElement}static isIOSDevice(){return n.isIPhoneDevice()||n.isIPadDevice()}static isNativeWindowsBrowser(){return n.isIEBrowser()||n.isEdgeBrowser()}static isIPhoneDevice(){return!!navigator.userAgent.match(/iPhone/i)}static isIPadDevice(){return!!navigator.userAgent.match(/iPad/i)}static isIEBrowser(){return -1!==navigator.userAgent.toLowerCase().indexOf("msie")||!!navigator.userAgent.match(/Trident.*rv:\d+\./)}static isEdgeBrowser(){return!!navigator.userAgent.match(/Edge\/\d+/i)}static getList(){return{"is-touch":n.isTouchDevice(),"is-ios":n.isIOSDevice(),"is-native-windows":n.isNativeWindowsBrowser(),"is-iphone":n.isIPhoneDevice(),"is-ipad":n.isIPadDevice(),"is-ie":n.isIEBrowser(),"is-edge":n.isEdgeBrowser()}}}class o{static iterate(t,e){if(t instanceof Map||Array.isArray(t))return t.forEach(e);if(t instanceof FormData){for(var s of t.entries())e(s[1],s[0]);return}if(t instanceof NodeList)return t.forEach(e);if(t instanceof HTMLCollection)return Array.from(t).forEach(e);if(t instanceof Object)return Object.keys(t).forEach(s=>{e(t[s],s)});throw Error("The element type ".concat(typeof t," is not iterable!"))}}let a="modal-backdrop",c="modal-backdrop-open",l="no-scroll",d={ON_CLICK:"backdrop/onclick"};class u{create(t){this._removeExistingBackdrops(),document.body.insertAdjacentHTML("beforeend",this._getTemplate());let e=document.body.lastChild;document.documentElement.classList.add(l),setTimeout(function(){e.classList.add(c),"function"==typeof t&&t()},75),this._dispatchEvents()}remove(){let t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:350,e=this._getBackdrops();o.iterate(e,t=>t.classList.remove(c)),setTimeout(this._removeExistingBackdrops.bind(this),t),document.documentElement.classList.remove(l)}_dispatchEvents(){let t=n.isTouchDevice()?"touchstart":"click";document.addEventListener(t,function(t){t.target.classList.contains(a)&&document.dispatchEvent(new CustomEvent(d.ON_CLICK))})}_getBackdrops(){return document.querySelectorAll(".".concat(a))}_removeExistingBackdrops(){if(!1===this._exists())return;let t=this._getBackdrops();o.iterate(t,t=>t.remove())}_exists(){return document.querySelectorAll(".".concat(a)).length>0}_getTemplate(){return'<div class="'.concat(a,'"></div>')}constructor(){return u.instance||(u.instance=this),u.instance}}let h=Object.freeze(new u);class p{static create(){let t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;h.create(t)}static remove(){let t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:350;h.remove(t)}static SELECTOR_CLASS(){return a}}let m="js-pseudo-modal";class g{open(t){let e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:350;this._hideExistingModal(),this._create(),setTimeout(this._open.bind(this,t),e)}close(){let t=this.getModal();this._modalInstance=bootstrap.Modal.getInstance(t),this._modalInstance.hide()}getModal(){return this._modal||this._create(),this._modal}updatePosition(){this._modalInstance.handleUpdate()}updateContent(t,e){this._content=t,this._setModalContent(t),this.updatePosition(),"function"==typeof e&&e.bind(this)()}_hideExistingModal(){try{let t=i.Z.querySelector(document,".".concat(m," .modal"),!1);if(!t)return;let e=bootstrap.Modal.getInstance(t);if(!e)return;e.hide()}catch(t){console.warn("[PseudoModalUtil] Unable to hide existing pseudo modal before opening pseudo modal: ".concat(t.message))}}_open(t){this.getModal(),this._modal.addEventListener("hidden.bs.modal",this._modalWrapper.remove),this._modal.addEventListener("shown.bs.modal",t),this._modalInstance.show()}_create(){this._modalMarkupEl=i.Z.querySelector(document,this._templateSelector),this._createModalWrapper(),this._modalWrapper.innerHTML=this._content,this._modal=this._createModalMarkup(),this._modalInstance=new bootstrap.Modal(this._modal,{backdrop:this._useBackdrop}),document.body.insertAdjacentElement("beforeend",this._modalWrapper)}_createModalWrapper(){this._modalWrapper=i.Z.querySelector(document,".".concat(m),!1),this._modalWrapper||(this._modalWrapper=document.createElement("div"),this._modalWrapper.classList.add(m))}_createModalMarkup(){let t=i.Z.querySelector(this._modalWrapper,".modal",!1);if(t)return t;let e=this._modalWrapper.innerHTML;return this._modalWrapper.innerHTML=this._modalMarkupEl.innerHTML,this._setModalContent(e),i.Z.querySelector(this._modalWrapper,".modal")}_setModalTitle(){let t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";try{i.Z.querySelector(this._modalWrapper,this._templateTitleSelector).innerHTML=t}catch(t){}}_setModalContent(t){let e=i.Z.querySelector(this._modalWrapper,this._templateContentSelector);e.innerHTML=t;try{let t=i.Z.querySelector(e,this._templateTitleSelector);t&&(this._setModalTitle(t.innerHTML),t.parentNode.removeChild(t))}catch(t){}}constructor(t,e=!0,s=".".concat("js-pseudo-modal-template"),r=".".concat("js-pseudo-modal-template-content-element"),i=".".concat("js-pseudo-modal-template-title-element")){this._content=t,this._useBackdrop=e,this._templateSelector=s,this._templateContentSelector=r,this._templateTitleSelector=i}}var f=s(107);let v="loader",b={BEFORE:"before",INNER:"inner"};class _{create(){if(!this.exists()){if(this.position===b.INNER){this.parent.innerHTML=_.getTemplate();return}this.parent.insertAdjacentHTML(this._getPosition(),_.getTemplate())}}remove(){let t=this.parent.querySelectorAll(".".concat(v));o.iterate(t,t=>t.remove())}exists(){return this.parent.querySelectorAll(".".concat(v)).length>0}_getPosition(){return this.position===b.BEFORE?"afterbegin":"beforeend"}static getTemplate(){return'<div class="'.concat(v,'" role="status">\n                    <span class="').concat("visually-hidden",'">Loading...</span>\n                </div>')}static SELECTOR_CLASS(){return v}constructor(t,e=b.BEFORE){this.parent=t instanceof Element?t:document.body.querySelector(t),this.position=e}}let y=Object.freeze(new class extends _{create(){let t=!(arguments.length>0)||void 0===arguments[0]||arguments[0];!this.exists()&&t&&(p.create(),document.querySelector(".".concat(p.SELECTOR_CLASS())).insertAdjacentHTML("beforeend",_.getTemplate()))}remove(){let t=!(arguments.length>0)||void 0===arguments[0]||arguments[0];super.remove(),t&&p.remove()}constructor(){super(document.body)}});class w{static create(){let t=!(arguments.length>0)||void 0===arguments[0]||arguments[0];y.create(t)}static remove(){let t=!(arguments.length>0)||void 0===arguments[0]||arguments[0];y.remove(t)}}class E{async post(t,e){return await this.toPromise(this.client.post(t,e,this.callback))}async get(t){return this.toPromise(this.client.get(t,this.callback))}toPromise(t){return new Promise(function(e,s){t.onreadystatechange=function(){4===t.readyState&&(t.status>=200&&t.status<300?e(t.responseText):s({status:t.status,statusText:t.statusText}))}})}callback(){}constructor(t){this.client=new f.Z;let e=this.client._createPreparedRequest.bind(this.client);this.client._createPreparedRequest=function(s,r,i){let n=e(s,r,i);return n.setRequestHeader("sw-access-key",t),n}}}let S=t=>new Promise((e,s)=>{let r=document.createElement("script");r.src=t,r.async=!0,r.onerror=s,r.onload=r.onreadystatechange=function(){let t=this.readyState;t&&"loaded"!==t&&"complete"!==t||(r.onload=r.onreadystatechange=null,e())},document.head.appendChild(r)});class T extends r.Z{init(){w.create(),this._httpClient=new f.Z,this.client=new E(this.options.swAccessKey),this.cartItems=[],this.cache={},this.stockCache={},this.baseSkuScheme=this.options.baseSkuScheme||"{PRODUCT_SKU}",this.skuScheme=this.options.skuScheme||"{PRODUCT_SKU}-{VARIANT_SKU}-{SIZE_SKU}",this.pages=this.options.pages||{},S("//cdn.shirtnetwork.de/client/shirtnetwork-client.js").then(()=>this.boot())}async boot(){let t=function t(e,s){if(null==e)return s;for(var r in s)s[r].constructor===Object?e[r]=t(e[r],s[r]):void 0===e[r]&&(e[r]=s[r]);return e}(this.options,{settings:{container:this.el.id,shop:{cart:{link:"/checkout/cart",data:{},handler:this.getCheckoutData.bind(this),addItem:this.addItemToCart.bind(this),submit:this.submitCart.bind(this),init:()=>{},showAfterSalesModal:!1},infos:{handler:this.getShopInfos.bind(this)},stock:{handler:this.getStockInfos.bind(this)}}}}),e=this.instance=await ShirtnetworkClient.init(t);this.options.translations&&e.$store.dispatch("setTranslation",{lang:this.options.language.split("-")[0].toLowerCase(),translation:this.options.translations}),e.$store.dispatch("setLanguage",this.options.language),e.$store.dispatch("observe",{event:"navigate",callback:this.navigate.bind(this)}),setTimeout(()=>w.remove(),1500)}async addItemToCart(t,e,s){this.cartItems.push({type:"product",referencedId:s.oxid,quantity:Number.parseInt(s.amount),payload:{shirtnetwork:t}})}async getShopInfos(t){return await this.getProduct(t)}async getStockInfos(t){let e=this.resolveBaseSku(t.psku,t.vsku,t.ssku);if(this.stockCache[e]){var s;return(s=this.stockCache[e])!==null&&void 0!==s?s:[]}if(e){let t=JSON.parse(await this.client.get("/shirtnetwork/designer-stock-infos/"+e));return this.stockCache[e]=t,null!=t?t:[]}return[]}async getCheckoutData(t){let e;let s=await this.getProduct(t);if(t.sskus)for(let s of(e=[],t.sskus)){let r=await this.getProduct(Object.assign({},t,{ssku:s.sku}));r&&e.push({oxid:r.id,id:r.id,amount:s.amount,size:s.size})}return{aid:s?s.id:void 0,sizes:e.length?e:void 0}}async getProduct(t){let e=this.resolveSku(t.psku,t.vsku,t.ssku);if(!e)return{};{if(this.cache[e])return this.cache[e];let s=JSON.parse(await this.client.post("/store-api/product",JSON.stringify({filter:[{type:"equals",field:"productNumber",value:this.resolveSku(t.psku,t.vsku,t.ssku)}]}),!0));return console.log("after getProduct",s),this.cache[e]=s.elements&&s.elements.length?s.elements[0]:{},this.cache[e]}}async submitCart(){let t=await this.client.post("/shirtnetwork/add-to-cart",JSON.stringify({lineItems:this.cartItems}));return this.cartItems=[],this.instance.$store.dispatch("setIsNavigatingToCart",!0),this.openOffCanvas(),t}navigate(t){this.pages[t]&&(w.create(),this._httpClient.get(this.pages[t],t=>{w.remove(),new g(t).open()}))}openOffCanvas(){for(let t of window.PluginManager.getPluginInstances("OffCanvasCart"))t.openOffCanvas(window.router["frontend.cart.offcanvas"],!1)}resolveSku(t,e,s){return this.resolveByScheme(t,e,s,this.skuScheme)}resolveBaseSku(t,e,s){return this.resolveByScheme(t,e,s,this.baseSkuScheme)}resolveByScheme(t,e,s,r){return -1===r.indexOf("${")?r.replace("{PRODUCT_SKU}",t).replace("{VARIANT_SKU}",e).replace("{SIZE_SKU}",s):Function('const product = "'.concat(t,'"; const variant = "').concat(e,'"; const size = "').concat(s,'"; return `').concat(new String(r),"`;"))()}}T.options={version:"1.6.4"}},49:(t,e,s)=>{s.d(e,{Z:()=>i});var r=s(140);class i{static isNode(t){return"object"==typeof t&&null!==t&&(t===document||t===window||t instanceof Node)}static hasAttribute(t,e){if(!i.isNode(t))throw Error("The element must be a valid HTML Node!");return"function"==typeof t.hasAttribute&&t.hasAttribute(e)}static getAttribute(t,e){let s=!(arguments.length>2)||void 0===arguments[2]||arguments[2];if(s&&!1===i.hasAttribute(t,e))throw Error('The required property "'.concat(e,'" does not exist!'));if("function"!=typeof t.getAttribute){if(s)throw Error("This node doesn't support the getAttribute function!");return}return t.getAttribute(e)}static getDataAttribute(t,e){let s=!(arguments.length>2)||void 0===arguments[2]||arguments[2],n=e.replace(/^data(|-)/,""),o=r.Z.toLowerCamelCase(n,"-");if(!i.isNode(t)){if(s)throw Error("The passed node is not a valid HTML Node!");return}if(void 0===t.dataset){if(s)throw Error("This node doesn't support the dataset attribute!");return}let a=t.dataset[o];if(void 0===a){if(s)throw Error('The required data attribute "'.concat(e,'" does not exist on ').concat(t,"!"));return a}return r.Z.parsePrimitive(a)}static querySelector(t,e){let s=!(arguments.length>2)||void 0===arguments[2]||arguments[2];if(s&&!i.isNode(t))throw Error("The parent node is not a valid HTML Node!");let r=t.querySelector(e)||!1;if(s&&!1===r)throw Error('The required element "'.concat(e,'" does not exist in parent node!'));return r}static querySelectorAll(t,e){let s=!(arguments.length>2)||void 0===arguments[2]||arguments[2];if(s&&!i.isNode(t))throw Error("The parent node is not a valid HTML Node!");let r=t.querySelectorAll(e);if(0===r.length&&(r=!1),s&&!1===r)throw Error('At least one item of "'.concat(e,'" must exist in parent node!'));return r}static getFocusableElements(){let t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:document.body;return t.querySelectorAll('\n            input:not([tabindex^="-"]):not([disabled]):not([type="hidden"]),\n            select:not([tabindex^="-"]):not([disabled]),\n            textarea:not([tabindex^="-"]):not([disabled]),\n            button:not([tabindex^="-"]):not([disabled]),\n            a[href]:not([tabindex^="-"]):not([disabled]),\n            [tabindex]:not([tabindex^="-"]):not([disabled])\n        ')}static getFirstFocusableElement(){let t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:document.body;return this.getFocusableElements(t)[0]}static getLastFocusableElement(){let t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:document,e=this.getFocusableElements(t);return e[e.length-1]}}},140:(t,e,s)=>{s.d(e,{Z:()=>r});class r{static ucFirst(t){return t.charAt(0).toUpperCase()+t.slice(1)}static lcFirst(t){return t.charAt(0).toLowerCase()+t.slice(1)}static toDashCase(t){return t.replace(/([A-Z])/g,"-$1").replace(/^-/,"").toLowerCase()}static toLowerCamelCase(t,e){let s=r.toUpperCamelCase(t,e);return r.lcFirst(s)}static toUpperCamelCase(t,e){return e?t.split(e).map(t=>r.ucFirst(t.toLowerCase())).join(""):r.ucFirst(t.toLowerCase())}static parsePrimitive(t){try{return/^\d+(.|,)\d+$/.test(t)&&(t=t.replace(",",".")),JSON.parse(t)}catch(e){return t.toString()}}}},293:(t,e,s)=>{s.d(e,{Z:()=>c});var r=s(857),i=s.n(r),n=s(49),o=s(140);class a{publish(t){let e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},s=arguments.length>2&&void 0!==arguments[2]&&arguments[2],r=new CustomEvent(t,{detail:e,cancelable:s});return this.el.dispatchEvent(r),r}subscribe(t,e){let s=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{},r=this,i=t.split("."),n=s.scope?e.bind(s.scope):e;if(s.once&&!0===s.once){let e=n;n=function(s){r.unsubscribe(t),e(s)}}return this.el.addEventListener(i[0],n),this.listeners.push({splitEventName:i,opts:s,cb:n}),!0}unsubscribe(t){let e=t.split(".");return this.listeners=this.listeners.reduce((t,s)=>([...s.splitEventName].sort().toString()===e.sort().toString()?this.el.removeEventListener(s.splitEventName[0],s.cb):t.push(s),t),[]),!0}reset(){return this.listeners.forEach(t=>{this.el.removeEventListener(t.splitEventName[0],t.cb)}),this.listeners=[],!0}get el(){return this._el}set el(t){this._el=t}get listeners(){return this._listeners}set listeners(t){this._listeners=t}constructor(t=document){this._el=t,t.$emitter=this,this._listeners=[]}}class c{init(){throw Error('The "init" method for the plugin "'.concat(this._pluginName,'" is not defined.'))}update(){}_init(){this._initialized||(this.init(),this._initialized=!0)}_update(){this._initialized&&this.update()}_mergeOptions(t){let e=o.Z.toDashCase(this._pluginName),s=n.Z.getDataAttribute(this.el,"data-".concat(e,"-config"),!1),r=n.Z.getAttribute(this.el,"data-".concat(e,"-options"),!1),a=[this.constructor.options,this.options,t];s&&a.push(window.PluginConfigManager.get(this._pluginName,s));try{r&&a.push(JSON.parse(r))}catch(t){throw console.error(this.el),Error('The data attribute "data-'.concat(e,'-options" could not be parsed to json: ').concat(t.message))}return i().all(a.filter(t=>t instanceof Object&&!(t instanceof Array)).map(t=>t||{}))}_registerInstance(){window.PluginManager.getPluginInstancesFromElement(this.el).set(this._pluginName,this),window.PluginManager.getPlugin(this._pluginName,!1).get("instances").push(this)}_getPluginName(t){return t||(t=this.constructor.name),t}constructor(t,e={},s=!1){if(!n.Z.isNode(t))throw Error("There is no valid element given.");this.el=t,this.$emitter=new a(this.el),this._pluginName=this._getPluginName(s),this.options=this._mergeOptions(e),this._initialized=!1,this._registerInstance(),this._init()}}},107:(t,e,s)=>{s.d(e,{Z:()=>r});class r{get(t,e){let s=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"application/json",r=this._createPreparedRequest("GET",t,s);return this._sendRequest(r,null,e)}post(t,e,s){let r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"application/json";r=this._getContentType(e,r);let i=this._createPreparedRequest("POST",t,r);return this._sendRequest(i,e,s)}delete(t,e,s){let r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"application/json";r=this._getContentType(e,r);let i=this._createPreparedRequest("DELETE",t,r);return this._sendRequest(i,e,s)}patch(t,e,s){let r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"application/json";r=this._getContentType(e,r);let i=this._createPreparedRequest("PATCH",t,r);return this._sendRequest(i,e,s)}abort(){if(this._request)return this._request.abort()}setErrorHandlingInternal(t){this._errorHandlingInternal=t}_registerOnLoaded(t,e){e&&(!0===this._errorHandlingInternal?(t.addEventListener("load",()=>{e(t.responseText,t)}),t.addEventListener("abort",()=>{console.warn("the request to ".concat(t.responseURL," was aborted"))}),t.addEventListener("error",()=>{console.warn("the request to ".concat(t.responseURL," failed with status ").concat(t.status))}),t.addEventListener("timeout",()=>{console.warn("the request to ".concat(t.responseURL," timed out"))})):t.addEventListener("loadend",()=>{e(t.responseText,t)}))}_sendRequest(t,e,s){return this._registerOnLoaded(t,s),t.send(e),t}_getContentType(t,e){return t instanceof FormData&&(e=!1),e}_createPreparedRequest(t,e,s){return this._request=new XMLHttpRequest,this._request.open(t,e),this._request.setRequestHeader("X-Requested-With","XMLHttpRequest"),s&&this._request.setRequestHeader("Content-type",s),this._request}constructor(){this._request=null,this._errorHandlingInternal=!1}}}}]);