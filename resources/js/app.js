import "../css/app.css";
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy-js';
import VueApexCharts from "vue3-apexcharts";
import layout from "./Pages/layout.vue";

createInertiaApp({
  title: title => `${title ? `${title} |` : "SINVENTO"}`,
  progress: {
    color: "#181818",
  },
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = name.includes(["login"]) ? undefined : page.default.layout || layout
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(VueApexCharts)
      .mount(el)
  },
})