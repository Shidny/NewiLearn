// import 'bootstrap';
import {createApp} from 'vue';
// import BootstrapVue3 from 'bootstrap-vue-3'
// import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'

import app from '../components/link_form_vue.vue';
const apps = createApp(app)
apps.config.globalProperties.partner_upload = false
apps.config.productionTip = false
// apps.use(BootstrapVue3);
apps.mount('#link_form_vue');