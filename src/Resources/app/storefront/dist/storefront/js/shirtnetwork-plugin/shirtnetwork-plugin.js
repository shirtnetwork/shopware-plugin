(()=>{var e={},r={};function t(n){var i=r[n];if(void 0!==i)return i.exports;var o=r[n]={exports:{}};return e[n](o,o.exports,t),o.exports}t.m=e,(()=>{t.n=e=>{var r=e&&e.__esModule?()=>e.default:()=>e;return t.d(r,{a:r}),r}})(),(()=>{t.d=(e,r)=>{for(var n in r)t.o(r,n)&&!t.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:r[n]})}})(),(()=>{t.f={},t.e=e=>Promise.all(Object.keys(t.f).reduce((r,n)=>(t.f[n](e,r),r),[]))})(),(()=>{t.u=e=>"./js/shirtnetwork-plugin/"+e+"."+({"shirtnetwork-plugin.plugin":"21b2c1","shirtnetwork-description-plugin.plugin":"04d0c3"})[e]+".js"})(),(()=>{t.miniCssF=e=>{}})(),(()=>{t.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||Function("return this")()}catch(e){if("object"==typeof window)return window}}()})(),(()=>{t.o=(e,r)=>Object.prototype.hasOwnProperty.call(e,r)})(),(()=>{var e={};t.l=(r,n,i,o)=>{if(e[r]){e[r].push(n);return}if(void 0!==i)for(var a,l,u=document.getElementsByTagName("script"),s=0;s<u.length;s++){var p=u[s];if(p.getAttribute("src")==r){a=p;break}}a||(l=!0,(a=document.createElement("script")).charset="utf-8",a.timeout=120,t.nc&&a.setAttribute("nonce",t.nc),a.src=r),e[r]=[n];var c=(t,n)=>{a.onerror=a.onload=null,clearTimeout(d);var i=e[r];if(delete e[r],a.parentNode&&a.parentNode.removeChild(a),i&&i.forEach(e=>e(n)),t)return t(n)},d=setTimeout(c.bind(null,void 0,{type:"timeout",target:a}),12e4);a.onerror=c.bind(null,a.onerror),a.onload=c.bind(null,a.onload),l&&document.head.appendChild(a)}})(),(()=>{t.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}})(),(()=>{t.g.importScripts&&(e=t.g.location+"");var e,r=t.g.document;if(!e&&r&&(r.currentScript&&(e=r.currentScript.src),!e)){var n=r.getElementsByTagName("script");if(n.length)for(var i=n.length-1;i>-1&&!e;)e=n[i--].src}if(!e)throw Error("Automatic publicPath is not supported in this browser");e=e.replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/"),t.p=e+"../../"})(),(()=>{var e={"shirtnetwork-plugin":0};t.f.j=(r,n)=>{var i=t.o(e,r)?e[r]:void 0;if(0!==i){if(i)n.push(i[2]);else{var o=new Promise((t,n)=>i=e[r]=[t,n]);n.push(i[2]=o);var a=t.p+t.u(r),l=Error();t.l(a,n=>{if(t.o(e,r)&&(0!==(i=e[r])&&(e[r]=void 0),i)){var o=n&&("load"===n.type?"missing":n.type),a=n&&n.target&&n.target.src;l.message="Loading chunk "+r+" failed.\n("+o+": "+a+")",l.name="ChunkLoadError",l.type=o,l.request=a,i[1](l)}},"chunk-"+r,r)}}};var r=(r,n)=>{var i,o,[a,l,u]=n,s=0;if(a.some(r=>0!==e[r])){for(i in l)t.o(l,i)&&(t.m[i]=l[i]);u&&u(t)}for(r&&r(n);s<a.length;s++)o=a[s],t.o(e,o)&&e[o]&&e[o][0](),e[o]=0},n=self.webpackChunk=self.webpackChunk||[];n.forEach(r.bind(null,0)),n.push=r.bind(null,n.push.bind(n))})();let n=window.PluginManager;n.register("ShirtnetworkPlugin",()=>t.e("shirtnetwork-plugin.plugin").then(t.bind(t,215)),"[data-shirtnetwork-plugin]"),n.register("ShirtnetworkDescriptionPlugin",()=>t.e("shirtnetwork-description-plugin.plugin").then(t.bind(t,712)),"[data-shirtnetwork-description-plugin]")})();