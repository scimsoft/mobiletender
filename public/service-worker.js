if(!self.define){const e=e=>{"require"!==e&&(e+=".js");let r=Promise.resolve();return s[e]||(r=new Promise(async r=>{if("document"in self){const s=document.createElement("script");s.src=e,document.head.appendChild(s),s.onload=r}else importScripts(e),r()})),r.then(()=>{if(!s[e])throw new Error(`Module ${e} didn’t register its module`);return s[e]})},r=(r,s)=>{Promise.all(r.map(e)).then(e=>s(1===e.length?e[0]:e))},s={require:Promise.resolve(r)};self.define=(r,t,i)=>{s[r]||(s[r]=Promise.resolve().then(()=>{let s={};const o={uri:location.origin+r.slice(1)};return Promise.all(t.map(r=>{switch(r){case"exports":return s;case"module":return o;default:return e(r)}})).then(e=>{const r=i(...e);return s.default||(s.default=r),s})}))}}define("./service-worker.js",["./workbox-69b5a3b7"],(function(e){"use strict";self.addEventListener("message",e=>{e.data&&"SKIP_WAITING"===e.data.type&&self.skipWaiting()}),e.precacheAndRoute([{url:"/css/app.css",revision:"18a88f2b3cf42465f7cb9de495d950ed"},{url:"/js/app.js",revision:"f6bb4f628bf26494024ba7e0c3da66eb"},{url:"/js/app.js.LICENSE.txt",revision:"9f7f5f1373e3d69f6a3e7b487779a0f7"}],{})}));
