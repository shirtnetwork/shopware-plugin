(()=>{var e={},r={};function t(n){var o=r[n];if(void 0!==o)return o.exports;var i=r[n]={exports:{}};return e[n](i,i.exports,t),i.exports}t.m=e,(()=>{t.n=e=>{var r=e&&e.__esModule?()=>e.default:()=>e;return t.d(r,{a:r}),r}})(),(()=>{t.d=(e,r)=>{for(var n in r)t.o(r,n)&&!t.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:r[n]})}})(),(()=>{t.f={},t.e=e=>Promise.all(Object.keys(t.f).reduce((r,n)=>(t.f[n](e,r),r),[]))})(),(()=>{t.u=e=>"./js/shirtnetwork-plugin/"+e+".js"})(),(()=>{t.miniCssF=e=>{}})(),(()=>{t.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||Function("return this")()}catch(e){if("object"==typeof window)return window}}()})(),(()=>{t.o=(e,r)=>Object.prototype.hasOwnProperty.call(e,r)})(),(()=>{var e={};t.l=(r,n,o,i)=>{if(e[r]){e[r].push(n);return}if(void 0!==o)for(var a,s,u=document.getElementsByTagName("script"),l=0;l<u.length;l++){var c=u[l];if(c.getAttribute("src")==r){a=c;break}}a||(s=!0,(a=document.createElement("script")).charset="utf-8",a.timeout=120,t.nc&&a.setAttribute("nonce",t.nc),a.src=r),e[r]=[n];var p=(t,n)=>{a.onerror=a.onload=null,clearTimeout(d);var o=e[r];if(delete e[r],a.parentNode&&a.parentNode.removeChild(a),o&&o.forEach(e=>e(n)),t)return t(n)},d=setTimeout(p.bind(null,void 0,{type:"timeout",target:a}),12e4);a.onerror=p.bind(null,a.onerror),a.onload=p.bind(null,a.onload),s&&document.head.appendChild(a)}})(),(()=>{t.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}})(),(()=>{t.g.importScripts&&(e=t.g.location+"");var e,r=t.g.document;if(!e&&r&&(r.currentScript&&(e=r.currentScript.src),!e)){var n=r.getElementsByTagName("script");if(n.length)for(var o=n.length-1;o>-1&&!e;)e=n[o--].src}if(!e)throw Error("Automatic publicPath is not supported in this browser");e=e.replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/"),t.p=e+"../../"})(),(()=>{var e={"shirtnetwork-plugin":0};t.f.j=(r,n)=>{var o=t.o(e,r)?e[r]:void 0;if(0!==o){if(o)n.push(o[2]);else{var i=new Promise((t,n)=>o=e[r]=[t,n]);n.push(o[2]=i);var a=t.p+t.u(r),s=Error();t.l(a,n=>{if(t.o(e,r)&&(0!==(o=e[r])&&(e[r]=void 0),o)){var i=n&&("load"===n.type?"missing":n.type),a=n&&n.target&&n.target.src;s.message="Loading chunk "+r+" failed.\n("+i+": "+a+")",s.name="ChunkLoadError",s.type=i,s.request=a,o[1](s)}},"chunk-"+r,r)}}};var r=(r,n)=>{var o,i,[a,s,u]=n,l=0;if(a.some(r=>0!==e[r])){for(o in s)t.o(s,o)&&(t.m[o]=s[o]);u&&u(t)}for(r&&r(n);l<a.length;l++)i=a[l],t.o(e,i)&&e[i]&&e[i][0](),e[i]=0},n=self.webpackChunk=self.webpackChunk||[];n.forEach(r.bind(null,0)),n.push=r.bind(null,n.push.bind(n))})();let n=window.PluginManager;n.register("ShirtnetworkPlugin",()=>t.e("extension2190268663_ShirtnetworkPlugin_src_Resources_app_storefront_src_shirtnetwork-plugin_s-5bdb78").then(t.bind(t,992)),"[data-shirtnetwork-plugin]"),n.register("ShirtnetworkDescriptionPlugin",()=>t.e("extension2190268663_ShirtnetworkPlugin_src_Resources_app_storefront_src_shirtnetwork-descript-1b90d9").then(t.bind(t,850)),"[data-shirtnetwork-description-plugin]")})();