(window.webpackJsonp=window.webpackJsonp||[]).push([["shirtnetwork-plugin"],{YkKs:function(t,e,n){"use strict";n.r(e);var r=n("FGIj"),i=n("2Jwc"),o=n("k8s9"),a=n("3xtq");function s(t,e,n,r,i,o,a){try{var s=t[o](a),u=s.value}catch(t){return void n(t)}s.done?e(u):Promise.resolve(u).then(r,i)}function u(t){return function(){var e=this,n=arguments;return new Promise((function(r,i){var o=t.apply(e,n);function a(t){s(o,r,i,a,u,"next",t)}function u(t){s(o,r,i,a,u,"throw",t)}a(void 0)}))}}function c(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}var l=function(){function t(e){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),this.client=new o.a;var n=this.client._createPreparedRequest.bind(this.client);this.client._createPreparedRequest=function(t,r,i){var o=n(t,r,i);return o.setRequestHeader("sw-access-key",e),o}}var e,n,r,i,a;return e=t,(n=[{key:"post",value:(a=u(regeneratorRuntime.mark((function t(e,n){var r;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,this.toPromise(this.client.post(e,n,this.callback));case 2:return r=t.sent,t.abrupt("return",r);case 4:case"end":return t.stop()}}),t,this)}))),function(t,e){return a.apply(this,arguments)})},{key:"get",value:(i=u(regeneratorRuntime.mark((function t(e){return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.abrupt("return",this.toPromise(this.client.get(e,this.callback)));case 1:case"end":return t.stop()}}),t,this)}))),function(t){return i.apply(this,arguments)})},{key:"toPromise",value:function(t){return new Promise((function(e,n){t.onreadystatechange=function(){4===t.readyState&&(t.status>=200&&t.status<300?e(t.responseText):n({status:t.status,statusText:t.statusText}))}}))}},{key:"callback",value:function(){}}])&&c(e.prototype,n),r&&c(e,r),t}(),p=function(t){return new Promise((function(e,n){var r=document.createElement("script");r.src=t,r.async=!0,r.onerror=n,r.onload=r.onreadystatechange=function(){var t=this.readyState;t&&"loaded"!==t&&"complete"!==t||(r.onload=r.onreadystatechange=null,e())},document.head.appendChild(r)}))};function f(t,e){if(null==t)return e;for(var n in e)e[n].constructor===Object?t[n]=f(t[n],e[n]):void 0===t[n]&&(t[n]=e[n]);return t}function h(t){return(h="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function d(){return(d=Object.assign||function(t){for(var e=1;e<arguments.length;e++){var n=arguments[e];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(t[r]=n[r])}return t}).apply(this,arguments)}function v(t,e,n,r,i,o,a){try{var s=t[o](a),u=s.value}catch(t){return void n(t)}s.done?e(u):Promise.resolve(u).then(r,i)}function y(t){return function(){var e=this,n=arguments;return new Promise((function(r,i){var o=t.apply(e,n);function a(t){v(o,r,i,a,s,"next",t)}function s(t){v(o,r,i,a,s,"throw",t)}a(void 0)}))}}function m(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function b(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}function g(t,e){return!e||"object"!==h(e)&&"function"!=typeof e?function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}(t):e}function k(t){return(k=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function w(t,e){return(w=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}var S,x,P,O=function(t){function e(){return m(this,e),g(this,k(e).apply(this,arguments))}var n,r,s,u,c,h,v,S,x,P;return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&w(t,e)}(e,t),n=e,(r=[{key:"init",value:function(){var t=this;a.a.create(),this._httpClient=new o.a,this.client=new l(this.options.swAccessKey),this.cartItems=[],this.cache={},this.skuScheme=this.options.skuScheme||"{PRODUCT_SKU}-{VARIANT_SKU}-{SIZE_SKU}",this.pages=this.options.pages||{},p("//cdn.shirtnetwork.de/client/shirtnetwork-client.js").then((function(){return t.boot()}))}},{key:"boot",value:(P=y(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e=f(this.options,{settings:{container:this.el.id,shop:{cart:{link:window.router["frontend.checkout.cart.page"],data:{},handler:this.getCheckoutData.bind(this),addItem:this.addItemToCart.bind(this),submit:this.submitCart.bind(this),init:function(){},showAfterSalesModal:!1},infos:{handler:this.getShopInfos.bind(this)},stock:{handler:this.getStockInfos.bind(this)}}}}),t.next=3,ShirtnetworkClient.init(e);case 3:(this.instance=t.sent).$store.dispatch("observe",{event:"navigate",callback:this.navigate.bind(this)}),setTimeout((function(){return a.a.remove()}),1500);case 6:case"end":return t.stop()}}),t,this)}))),function(){return P.apply(this,arguments)})},{key:"addItemToCart",value:(x=y(regeneratorRuntime.mark((function t(e,n,r){return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.cartItems.push({type:"product",referencedId:r.oxid,quantity:Number.parseInt(r.amount),payload:{shirtnetwork:e}});case 1:case"end":return t.stop()}}),t,this)}))),function(t,e,n){return x.apply(this,arguments)})},{key:"getShopInfos",value:(S=y(regeneratorRuntime.mark((function t(e){return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,this.getProduct(e);case 2:return t.abrupt("return",t.sent);case 3:case"end":return t.stop()}}),t,this)}))),function(t){return S.apply(this,arguments)})},{key:"getStockInfos",value:(v=y(regeneratorRuntime.mark((function t(e){var n,r,i,o,a;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!(n=this.resolveSku(e.psku,e.vsku,e.ssku))){t.next=12;break}return t.t0=JSON,t.next=5,this.client.post("/store-api/product",JSON.stringify({associations:{children:{}},filter:[{type:"equals",field:"children.productNumber",value:n}]}),!0);case 5:if(t.t1=t.sent,!(r=t.t0.parse.call(t.t0,t.t1)).elements.length){t.next=12;break}return i=r.elements[0],o=i.children,a=o.map((function(t){return{size:t.extensions.shirtnetwork.sku.sartnr,variant:t.extensions.shirtnetwork.sku.vartnr,stock:t.isCloseout?t.availableStock:999999}})),t.abrupt("return",a);case 12:return t.abrupt("return",[]);case 13:case"end":return t.stop()}}),t,this)}))),function(t){return v.apply(this,arguments)})},{key:"getCheckoutData",value:(h=y(regeneratorRuntime.mark((function t(e){var n,r,i,o,a,s,u,c,l;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,this.getProduct(e);case 2:if(n=t.sent,r=void 0,!e.sskus){t.next=34;break}r=[],i=!0,o=!1,a=void 0,t.prev=9,s=e.sskus[Symbol.iterator]();case 11:if(i=(u=s.next()).done){t.next=20;break}return c=u.value,t.next=15,this.getProduct(d({},e,{ssku:c.sku}));case 15:(l=t.sent)&&r.push({oxid:l.id,id:l.id,amount:c.amount,size:c.size});case 17:i=!0,t.next=11;break;case 20:t.next=26;break;case 22:t.prev=22,t.t0=t.catch(9),o=!0,a=t.t0;case 26:t.prev=26,t.prev=27,i||null==s.return||s.return();case 29:if(t.prev=29,!o){t.next=32;break}throw a;case 32:return t.finish(29);case 33:return t.finish(26);case 34:return t.abrupt("return",{aid:n?n.id:void 0,sizes:r.length?r:void 0});case 35:case"end":return t.stop()}}),t,this,[[9,22,26,34],[27,,29,33]])}))),function(t){return h.apply(this,arguments)})},{key:"getProduct",value:(c=y(regeneratorRuntime.mark((function t(e){var n,r;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!(n=this.resolveSku(e.psku,e.vsku,e.ssku))){t.next=14;break}if(!this.cache[n]){t.next=4;break}return t.abrupt("return",this.cache[n]);case 4:return t.t0=JSON,t.next=7,this.client.post("/store-api/product",JSON.stringify({filter:[{type:"equals",field:"productNumber",value:this.resolveSku(e.psku,e.vsku,e.ssku)}]}),!0);case 7:return t.t1=t.sent,r=t.t0.parse.call(t.t0,t.t1),console.log("after getProduct",r),this.cache[n]=r.elements&&r.elements.length?r.elements[0]:{},t.abrupt("return",this.cache[n]);case 14:return t.abrupt("return",{});case 15:case"end":return t.stop()}}),t,this)}))),function(t){return c.apply(this,arguments)})},{key:"submitCart",value:(u=y(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,this.client.post("/shirtnetwork/add-to-cart",JSON.stringify({lineItems:this.cartItems}));case 2:return e=t.sent,this.cartItems=[],this.instance.$store.dispatch("setIsNavigatingToCart",!0),this.openOffCanvas(),t.abrupt("return",e);case 7:case"end":return t.stop()}}),t,this)}))),function(){return u.apply(this,arguments)})},{key:"navigate",value:function(t){this.pages[t]&&(a.a.create(),this._httpClient.get(this.pages[t],(function(t){a.a.remove(),new i.a(t).open()})))}},{key:"openOffCanvas",value:function(){var t=window.PluginManager.getPluginInstances("OffCanvasCart"),e=!0,n=!1,r=void 0;try{for(var i,o=t[Symbol.iterator]();!(e=(i=o.next()).done);e=!0)i.value.openOffCanvas(window.router["frontend.cart.offcanvas"],!1)}catch(t){n=!0,r=t}finally{try{e||null==o.return||o.return()}finally{if(n)throw r}}}},{key:"resolveSku",value:function(t,e,n){return this.skuScheme.replace("{PRODUCT_SKU}",t).replace("{VARIANT_SKU}",e).replace("{SIZE_SKU}",n)}}])&&b(n.prototype,r),s&&b(n,s),e}(r.a);function R(t){return(R="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function I(t,e,n,r,i,o,a){try{var s=t[o](a),u=s.value}catch(t){return void n(t)}s.done?e(u):Promise.resolve(u).then(r,i)}function _(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function C(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}function j(t,e){return!e||"object"!==R(e)&&"function"!=typeof e?function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}(t):e}function T(t){return(T=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function E(t,e){return(E=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}P={version:"1.6.4"},(x="options")in(S=O)?Object.defineProperty(S,x,{value:P,enumerable:!0,configurable:!0,writable:!0}):S[x]=P;var N=function(t){function e(){return _(this,e),j(this,T(e).apply(this,arguments))}var n,r,i,a,s;return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&E(t,e)}(e,t),n=e,(r=[{key:"init",value:function(){document.body.addEventListener("designerBooted",this.designerBooted.bind(this))}},{key:"designerBooted",value:function(t){var e=this;this._httpClient=new o.a,this.instance=t.detail,this.instance.$store.watch((function(t,e){return e.localVars}),(function(){return e.reloadDescription()}),{deep:!0})}},{key:"reloadDescription",value:(a=regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:(e=this.instance.$store.getters.localVar("shopProductInfos"))&&e.translated?(document.getElementById("designer-description-description-content").innerHTML=e.translated.description,this._httpClient.get("/product/".concat(e.parentId?e.parentId:e.id,"/reviews"),(function(t){document.getElementById("designer-description-reviews-content").innerHTML=t,window.PluginManager.initializePlugins()}))):(document.getElementById("designer-description-description-content").innerHTML="",document.getElementById("designer-description-reviews-content").innerHTML="");case 2:case"end":return t.stop()}}),t,this)})),s=function(){var t=this,e=arguments;return new Promise((function(n,r){var i=a.apply(t,e);function o(t){I(i,n,r,o,s,"next",t)}function s(t){I(i,n,r,o,s,"throw",t)}o(void 0)}))},function(){return s.apply(this,arguments)})}])&&C(n.prototype,r),i&&C(n,i),e}(r.a),K=window.PluginManager;K.register("ShirtnetworkPlugin",O,"[data-shirtnetwork-plugin]"),K.register("ShirtnetworkDescriptionPlugin",N,"[data-shirtnetwork-description-plugin]")}},[["YkKs","runtime","vendor-node","vendor-shared"]]]);