import { createApp, h, ref } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import PolarisVue from '@ownego/polaris-vue'
import axios from 'axios'
import '@ownego/polaris-vue/dist/style.css'
import '../css/app.css'
import * as ShopifyCreateApp from '@shopify/app-bridge'
import { getSessionToken } from '@shopify/app-bridge/utilities'
import AppLayout from './Shared/AppLayout.vue'


const shopifyApp = ShopifyCreateApp.createApp({
    apiKey: document.getElementById('apiKey').value,
    host: document.getElementById('host').value,
    shopOrigin: document.getElementById('shopOrigin').value,
    forceRedirect: true
})

async function retrieveToken(app) {
    window.sessionToken = await getSessionToken(app)
    // Set the Authorization header after obtaining the token
    axios.defaults.headers.common.Authorization = `Bearer ${window.sessionToken}`
    // app.setHeaders({ Authorization: `Bearer ${window.sessionToken}` })
}

function keepRetrievingToken(app) {
    setInterval(() => {
        retrieveToken(app)
    }, 2000)
}

keepRetrievingToken(shopifyApp)

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        const page = pages[`./Pages/${name}.vue`]
        page.default.layout = page.default.layout || AppLayout
        return page
    },
    setup({ el, App, props, plugin }) {
        const shopifyAppRef = ref(shopifyApp)
        createApp({
            render: () => h(App, props),
            // modules: {
            //     setting
            // }
        }).provide('appBridge', shopifyApp)
            .use(plugin)
            .use(PolarisVue)
            .mount(el)
        retrieveToken(shopifyAppRef.value)
    }
})
