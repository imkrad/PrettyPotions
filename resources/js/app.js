import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3';
import BootstrapVueNext from 'bootstrap-vue-next';
import VueApexCharts from "vue3-apexcharts";

import Layout from '@/Shared/Layout/Index.vue';

createInertiaApp({
    resolve: name => {
        let page = require(`./Pages/${name}`).default;
        if (page.layout === undefined) {
            page.layout = Layout;
        }
        return page;
    },
    setup({ el, App, props, plugin}) {
        createApp({
                render: () => h(App, props)
            })
            .use(plugin)
            .use(BootstrapVueNext)
            .use(VueApexCharts)
            .component("Link", Link)
            .component("Head", Head)
            .mount(el)
    },
    title: title => title ? `Pretty Potions | ${title}` : 'Pretty Potions'
})

